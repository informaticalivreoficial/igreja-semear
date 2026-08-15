<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Member;
use App\Models\PrayerRequest;
use App\Services\ConfigService;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberAreaController extends Controller
{
    protected $configService;

    protected $seo;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->seo = new Seo;
    }

    private function member()
    {
        return Auth::user()->member;
    }

    private function template(): string
    {
        return $this->configService->getConfig()->template;
    }

    private function layoutData(string $title, string $active): array
    {
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            $title.' - '.$config->app_name,
            $title,
            url()->current(),
            $this->configService->getMetaImg()
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'cell_phone' => 'nullable|string|max:20',
            'birthday' => 'nullable|date_format:d/m/Y',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|min:6|confirmed',
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

    public function familia()
    {
        $data = $this->layoutData('Minha família', 'familia');

        $data['familia'] = $this->member()->family;

        return $this->view('familia', $data);
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

        PrayerRequest::create([
            'member_id' => $member->id,
            'name' => $member->name,
            'email' => $member->email ?? Auth::user()->email,
            'phone' => $member->cell_phone,
            'message' => $request->message,
            'status' => PrayerRequest::STATUS_PENDENTE,
        ]);

        return back()->with('toast', ['type' => 'success', 'message' => 'Pedido de oração enviado! Estamos orando por você.']);
    }

    public function contribuicoes()
    {
        $data = $this->layoutData('Minhas contribuições', 'contribuicoes');

        $data['doacoes'] = Donation::whereHas('member', function ($q) {
            $q->where('user_id', Auth::id());
        })->orderByDesc('created_at')->get();

        $data['total'] = $data['doacoes']->sum('amount');

        return $this->view('contribuicoes', $data);
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
