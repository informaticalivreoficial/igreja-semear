<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Config;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Member;
use App\Models\PrayerRequest;
use App\Models\User;
use App\Notifications\NewEventRegistration;
use App\Notifications\NewPrayerRequest;
use App\Support\ImageService;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class MemberAreaController extends Controller
{
    protected $seo;

    public function __construct()
    {
        $this->seo = new Seo;
    }

    private function member()
    {
        return Auth::user()->member;
    }

    private function config(): ?Config
    {
        return Config::where('id', 1)->first();
    }

    private function template(): string
    {
        return $this->config()->template;
    }

    private function layoutData(string $title, string $active): array
    {
        $config = $this->config();

        $head = $this->seo->render(
            $title.' - '.$config->app_name,
            $title,
            url()->current(),
            $config->getmetaimg()
        );

        return [
            'configuracoes' => $config,
            'head' => $head,
            'active' => $active,
            'title' => $title,
            'member' => $this->member(),
        ];
    }

    private function view(string $view, array $data)
    {
        return view('web.'.$this->template().'.member.'.$view, $data);
    }

    public function dashboard()
    {
        $member = $this->member();

        $data = $this->layoutData('Minha conta', 'dashboard');

        $data['proximos_eventos'] = Event::where('start_at', '>=', now())->available()->orderBy('start_at')->limit(3)->get();
        $data['minhas_inscricoes'] = $member->registrations()->with('event')
            ->where('status', '!=', EventRegistration::STATUS_CANCELADA)
            ->whereHas('event', fn ($q) => $q->where('start_at', '>=', now()))
            ->orderByDesc('created_at')->limit(5)->get();
        $data['avisos'] = Announcement::where('status', true)
            ->where(function ($q) {
                $q->whereNull('publish_at')->orWhere('publish_at', '<=', now()->format('Y-m-d'));
            })
            ->orderByDesc('publish_at')->orderByDesc('created_at')->limit(3)->get();
        $data['proximos_aniversarios'] = Member::where('status', true)
            ->whereNotNull('birthday')
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN DATE_FORMAT(NOW(), '%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 14 DAY), '%m-%d')")
            ->orderByRaw("DATE_FORMAT(birthday, '%m-%d')")
            ->limit(5)->get();

        return $this->view('dashboard', $data);
    }

    public function perfil()
    {
        $data = $this->layoutData('Meu perfil', 'perfil');

        return $this->view('perfil', $data);
    }

    public function updatePerfil(Request $request)
    {
        $member = $this->member();
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'cell_phone' => 'nullable|string|regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/',
            'birthday' => 'nullable|date_format:d/m/Y|before:today',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'postcode' => 'nullable|string|max:10',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:2',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'cell_phone.regex' => 'O telefone deve estar no formato (00) 00000-0000.',
            'birthday.date_format' => 'A data de nascimento deve estar no formato dd/mm/aaaa.',
            'birthday.before' => 'A data de nascimento deve ser anterior a hoje.',
            'foto.image' => 'O arquivo deve ser uma imagem.',
            'foto.mimes' => 'A imagem deve ser JPG, PNG ou WebP.',
            'foto.max' => 'A imagem não pode ultrapassar 2MB.',
            'current_password.required_with' => 'Informe a senha atual para alterar a senha.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        if ($request->password && ! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'A senha atual não confere.']);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->cell_phone = $request->cell_phone;
        $user->birthday = $request->birthday;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatar = ImageService::storeWebp($request->file('foto'), 'users');
            $user->avatar = $avatar;
            $member->avatar = $avatar;
        }

        $user->save();

        $member->update([
            'name' => $request->name,
            'email' => $request->email,
            'cell_phone' => $request->cell_phone,
            'whatsapp' => $request->whatsapp ?: $request->cell_phone,
            'birthday' => $request->birthday,
            'postcode' => $request->postcode,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'neighborhood' => $request->neighborhood,
            'state' => $request->state,
            'city' => $request->city,
        ]);

        return back()->with('toast', ['type' => 'success', 'message' => 'Perfil atualizado com sucesso!']);
    }

    public function agenda()
    {
        $data = $this->layoutData('Agenda de eventos', 'agenda');

        $data['eventos'] = Event::where('start_at', '>=', now())->available()
            ->withCount(['registrations' => fn ($q) => $q->where('status', '!=', EventRegistration::STATUS_CANCELADA)])
            ->orderBy('start_at')->get();
        $data['inscrito_ids'] = $this->member()->registrations()
            ->where('status', '!=', EventRegistration::STATUS_CANCELADA)
            ->pluck('event_id')->all();

        return $this->view('agenda', $data);
    }

    public function inscrever(Request $request)
    {
        $request->validate(['event_id' => 'required|exists:events,id']);

        $event = Event::findOrFail($request->event_id);

        if ($event->start_at < now()) {
            return back()->with('toast', ['type' => 'error', 'message' => 'Este evento já aconteceu.']);
        }

        $registration = EventRegistration::firstOrNew([
            'event_id' => $event->id,
            'member_id' => $this->member()->id,
        ]);

        if ($registration->exists && $registration->status === EventRegistration::STATUS_CONFIRMADA) {
            return back()->with('toast', ['type' => 'info', 'message' => 'Você já está inscrito(a) neste evento.']);
        }

        $registration->fill([
            'status' => EventRegistration::STATUS_PENDENTE,
            'notes' => $request->notes,
            'created_by' => Auth::id(),
        ])->save();

        $this->notifyAdmins(new NewEventRegistration($registration));

        return back()->with('toast', ['type' => 'success', 'message' => 'Inscrição realizada com sucesso!']);
    }

    public function cancelarInscricao(EventRegistration $registration)
    {
        abort_unless($registration->member_id === $this->member()->id, 403);

        $registration->update(['status' => EventRegistration::STATUS_CANCELADA]);

        return back()->with('toast', ['type' => 'success', 'message' => 'Inscrição cancelada.']);
    }

    public function inscricoes()
    {
        $data = $this->layoutData('Minhas inscrições', 'inscricoes');

        $data['inscricoes'] = $this->member()->registrations()->with('event')
            ->orderByDesc('created_at')->get();

        return $this->view('inscricoes', $data);
    }

    public function historico()
    {
        $data = $this->layoutData('Histórico de inscrições', 'historico');

        $data['inscricoes'] = $this->member()->registrations()->with('event')
            ->where(function ($q) {
                $q->whereHas('event', fn ($e) => $e->where('start_at', '<', now()))
                    ->orWhere('status', EventRegistration::STATUS_CANCELADA);
            })
            ->orderByDesc('created_at')->get();

        return $this->view('historico', $data);
    }

    public function oracoes()
    {
        $data = $this->layoutData('Pedidos de oração', 'oracoes');

        $data['oracoes'] = $this->member()->prayerRequests()->orderByDesc('created_at')->get();

        return $this->view('oracoes', $data);
    }

    public function storeOracao(Request $request)
    {
        $request->validate(['message' => 'required|string|min:10']);

        $member = $this->member();

        $prayerRequest = PrayerRequest::create([
            'member_id' => $member->id,
            'name' => $member->name,
            'email' => $member->email ?? Auth::user()->email,
            'phone' => $member->cell_phone,
            'message' => $request->message,
            'status' => PrayerRequest::STATUS_PENDENTE,
        ]);

        $this->notifyAdmins(new NewPrayerRequest($prayerRequest));

        return back()->with('toast', ['type' => 'success', 'message' => 'Pedido de oração enviado! Estamos orando por você.']);
    }

    private function notifyAdmins(\Illuminate\Notifications\Notification $notification): void
    {
        $admins = User::role(['super admin', 'admin', 'pastor', 'lider'])->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, $notification);
        }
    }

    public function avisos()
    {
        $data = $this->layoutData('Avisos da igreja', 'avisos');

        $data['avisos'] = Announcement::where('status', true)
            ->where(function ($q) {
                $q->whereNull('publish_at')->orWhere('publish_at', '<=', now()->format('Y-m-d'));
            })
            ->orderByDesc('publish_at')->orderByDesc('created_at')->get();

        return $this->view('avisos', $data);
    }
}
