<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\Web\CreateMember;
use App\Models\CatPost;
use App\Models\Config;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use App\Models\YoutubeVideo;
use App\Services\Sitemap\SitemapService;
use App\Notifications\NewMemberRegistered;
use App\Support\Seo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class WebController extends Controller
{
    protected $seo;

    public function __construct()
    {
        $this->seo = new Seo;
    }

    private function config(): ?Config
    {
        return Config::where('id', 1)->first();
    }

    public function home()
    {
        $config = $this->config();

        $head = $this->seo->render(
            $config->app_name ?? 'Semear',
            $config->information ?? 'Comunidade Cristã Semear',
            route('web.home'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.home', [
            'head' => $head,
            'slides' => Slide::where('is_active', true)->orderByDesc('id')->get(),
            'artigos' => Post::where('type', 'artigo')->postson()
                ->with(['categoriaObject'])
                ->orderByDesc('publish_at')->limit(3)->get(),
            'noticias' => Post::where('type', 'noticia')->postson()
                ->with(['categoriaObject'])
                ->orderByDesc('publish_at')->limit(3)->get(),
            'eventos' => Event::where('status', 1)->orderBy('start_at')->limit(3)->get(),
            'youtubeAoVivo' => YoutubeVideo::where('status', true)->where('is_live', true)->orderByDesc('id')->first(),
            'youtubeUltimoCulto' => YoutubeVideo::where('status', true)
                ->where('type', YoutubeVideo::TYPE_CULTO)
                ->orderByDesc('publish_at')
                ->orderByDesc('id')
                ->first(),
        ]);
    }

    public function quemsomos()
    {
        $config = $this->config();

        $paginaQuemSomos = Post::where('type', 'pagina')->postson()->where('id', 5)->first();
        $head = $this->seo->render(
            'Quem Somos - '.$config->app_name,
            $config->information ?? 'Semear',
            route('web.home'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.quem-somos', [
            'head' => $head,
            'paginaQuemSomos' => $paginaQuemSomos,
        ]);
    }

    public function politica()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Política de Privacidade - '.$config->app_name,
            'Política de Privacidade - '.$config->app_name,
            route('web.politica'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.politica', [
            'head' => $head,
        ]);
    }

    public function pesquisa(Request $request)
    {
        $config = $this->config();

        $search = $request->search ?? '';

        $paginas = $search
            ? Post::where('type', 'pagina')->postson()
                ->where(fn ($query) => $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%"))
                ->limit(10)->get()
            : collect();

        $artigos = $search
            ? Post::whereIn('type', ['artigo', 'noticia'])->postson()
                ->where(fn ($query) => $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%"))
                ->limit(10)->get()
            : collect();

        $head = $this->seo->render(
            'Pesquisa por '.($search ?: $config->app_name),
            'Pesquisa - '.$config->app_name,
            route('web.blog.artigos'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.pesquisa', [
            'head' => $head,
            'search' => $search,
            'paginas' => $paginas,
            'artigos' => $artigos,
        ]);
    }

    public function pagina($slug)
    {
        $config = $this->config();

        $post = Post::where('slug', $slug)->where('type', 'pagina')->postson()->first();
        abort_unless($post, 404);

        $post->increment('views');

        $head = $this->seo->render(
            $post->title ?? $config->app_name,
            $post->title,
            route('web.pagina', ['slug' => $post->slug]),
            $post->cover() ?? $config?->getmetaimg()
        );

        return view('web.'.$config->template.'.pagina', [
            'head' => $head,
            'post' => $post,
        ]);
    }

    public function ministerios()
    {
        $config = $this->config();

        $ministerios = Ministry::where('status', 1)->orderBy('name')->get();

        $head = $this->seo->render(
            'Ministérios - '.$config->app_name,
            'Conheça os ministérios da '.$config->app_name,
            route('web.ministerios'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.ministerios', [
            'head' => $head,
            'ministerios' => $ministerios,
        ]);
    }

    public function eventos()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Eventos - '.$config->app_name,
            'Agenda de eventos da '.$config->app_name,
            route('web.eventos'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.eventos', [
            'head' => $head,
        ]);
    }

    public function pedidoOracao()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Pedido de Oração - '.$config->app_name,
            'Envie seu pedido de oração para a '.$config->app_name,
            route('web.pedido-oracao'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.pedido-oracao', [
            'head' => $head,
        ]);
    }

    public function transmissao()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Transmissão ao Vivo - '.$config->app_name,
            'Acompanhe as transmissões ao vivo da '.$config->app_name,
            route('web.cultos'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return redirect()->route('web.cultos');
    }

    public function cultosOnline()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Cultos Online - '.$config->app_name,
            'Acompanhe as transmissões ao vivo e os últimos cultos da '.$config->app_name,
            route('web.cultos'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.cultos-online', [
            'head' => $head,
        ]);
    }

    public function pregacoes()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Pregações - '.$config->app_name,
            'Assista as pregações e mensagens da '.$config->app_name,
            route('web.pregacoes'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.pregacoes', [
            'head' => $head,
        ]);
    }

    public function atendimento()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Atendimento - '.$config->app_name,
            'Nossa equipe está pronta para melhor atender as suas demandas!',
            route('web.atendimento'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.atendimento', [
            'head' => $head,
        ]);
    }

    public function sitemap()
    {
        $xml = app(SitemapService::class)->build();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    // ************************************ Blog *******************************************/

    public function artigos(Request $request)
    {
        $config = $this->config();

        $search = $request->query('search', '');
        $query = Post::where('type', 'artigo')->postson()->with(['categoriaObject', 'userObject']);

        if ($search) {
            $query->where(fn ($q) => $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('content', 'LIKE', "%{$search}%"));
        }

        $posts = $query->orderByDesc('publish_at')->paginate(6);

        $head = $this->seo->render(
            ($search ? 'Resultados para "'.$search.'" - ' : '').'Blog - '.$config->app_name,
            'Blog - '.$config->app_name,
            route('web.blog.artigos'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'categorias' => CatPost::where('type', 'artigo')->available()->get(),
            'recentes' => Post::where('type', 'artigo')->postson()->orderByDesc('publish_at')->limit(5)->get(),
            'search' => $search,
            'title' => $search ? 'Resultados para "'.$search.'"' : 'Blog',
        ]);
    }

    public function artigo($slug)
    {
        $config = $this->config();

        $post = Post::where('slug', $slug)->where('type', 'artigo')->postson()->with(['categoriaObject', 'userObject'])->first();
        abort_unless($post, 404);

        $post->increment('views');

        $relacionados = Post::where('type', 'artigo')->postson()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->orderByDesc('publish_at')->limit(3)->get();

        $head = $this->seo->render(
            $post->title.' - '.$config->app_name,
            $post->metaDescription ?: $post->title,
            route('web.blog.artigo', ['slug' => $post->slug]),
            $post->cover() ?? $config?->getmetaimg()
        );

        return view('web.'.$config->template.'.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'relacionados' => $relacionados,
            'categorias' => CatPost::where('type', 'artigo')->available()->get(),
            'recentes' => Post::where('type', 'artigo')->postson()->orderByDesc('publish_at')->limit(5)->get(),
        ]);
    }

    public function categoria($slug)
    {
        $config = $this->config();

        $categoria = CatPost::where('slug', $slug)->available()->first();
        abort_unless($categoria, 404);

        $posts = Post::where('category', $categoria->id)->where('type', $categoria->type)->postson()
            ->with(['categoriaObject', 'userObject'])
            ->orderByDesc('publish_at')->paginate(6);

        $head = $this->seo->render(
            $categoria->title.' - '.$config->app_name,
            'Publicações na categoria '.$categoria->title,
            route(($categoria->type === 'noticia' ? 'web.noticia.categoria' : 'web.blog.categoria'), ['slug' => $categoria->slug]),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.blog.categoria', [
            'head' => $head,
            'posts' => $posts,
            'categoria' => $categoria,
            'categorias' => CatPost::where('type', $categoria->type)->available()->get(),
            'recentes' => Post::where('type', $categoria->type)->postson()->orderByDesc('publish_at')->limit(5)->get(),
        ]);
    }

    public function searchBlog(Request $request)
    {
        $search = $request->query('search', $request->input('search', ''));

        return $this->artigos(Request::create(route('web.blog.searchBlog'), 'GET', ['search' => $search]));
    }

    // ********************************** Notícias *****************************************/

    public function noticias()
    {
        $config = $this->config();

        $posts = Post::where('type', 'noticia')->postson()->with(['categoriaObject', 'userObject'])
            ->orderByDesc('publish_at')->paginate(9);

        $head = $this->seo->render(
            'Notícias - '.$config->app_name,
            'Notícias - '.$config->app_name,
            route('web.noticias'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.blog.artigos', [
            'head' => $head,
            'posts' => $posts,
            'categorias' => CatPost::where('type', 'noticia')->available()->get(),
            'recentes' => Post::where('type', 'noticia')->postson()->orderByDesc('publish_at')->limit(5)->get(),
            'search' => '',
            'title' => 'Notícias',
        ]);
    }

    public function noticia($slug)
    {
        $config = $this->config();

        $post = Post::where('slug', $slug)->where('type', 'noticia')->postson()->with(['categoriaObject', 'userObject'])->first();
        abort_unless($post, 404);

        $post->increment('views');

        $relacionados = Post::where('type', 'noticia')->postson()
            ->where('id', '!=', $post->id)
            ->orderByDesc('publish_at')->limit(3)->get();

        $head = $this->seo->render(
            $post->title.' - '.$config->app_name,
            $post->metaDescription ?: $post->title,
            route('web.noticia', ['slug' => $post->slug]),
            $post->cover() ?? $config?->getmetaimg()
        );

        return view('web.'.$config->template.'.blog.artigo', [
            'head' => $head,
            'post' => $post,
            'relacionados' => $relacionados,
            'categorias' => CatPost::where('type', 'noticia')->available()->get(),
            'recentes' => Post::where('type', 'noticia')->postson()->orderByDesc('publish_at')->limit(5)->get(),
        ]);
    }

    // ********************************** Membros ******************************************/

    public function createMember()
    {
        $config = $this->config();

        $head = $this->seo->render(
            'Cadastro de Membros - '.$config->app_name,
            'Comunidade Cristã Semear, cadastro de Membros',
            route('web.create.member'),
            $config?->getmetaimg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.member.cadastro', [
            'head' => $head,
        ]);
    }

    public function createMemberSend(Request $request)
    {
        $name = trim((string) $request->name);

        if ($name === '') {
            return response()->json(['error' => 'Por favor preencha o campo <strong>Nome</strong>']);
        }

        if ($request->birthday === '') {
            return response()->json(['error' => 'Por favor preencha a <strong>Data de Nascimento</strong>']);
        }

        try {
            $birthday = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Informe uma <strong>Data de Nascimento</strong> válida (dd/mm/aaaa).']);
        }

        if (Carbon::parse($birthday)->gt(Carbon::today())) {
            return response()->json(['error' => 'Você selecionou uma <strong>Data de Nascimento</strong> inválida!']);
        }

        if (! in_array($request->gender, ['masculino', 'feminino'])) {
            return response()->json(['error' => 'Por favor informe o <strong>sexo</strong>']);
        }

        if (! filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'O campo <strong>E-mail</strong> está vazio ou não tem um formato válido!']);
        }

        if (strlen(preg_replace('/\D/', '', (string) $request->whatsapp)) < 10) {
            return response()->json(['error' => 'Por favor preencha o campo <strong>Celular / WhatsApp</strong> corretamente.']);
        }

        $isBaptized = $request->baptism === 'true';

        if ($isBaptized && $request->baptism_date) {
            try {
                $baptism_date = Carbon::createFromFormat('d/m/Y', $request->baptism_date)->format('Y-m-d');
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Informe uma <strong>Data de Batismo</strong> válida (dd/mm/aaaa).']);
            }

            if (Carbon::parse($baptism_date)->gt(Carbon::today())) {
                return response()->json(['error' => 'Você selecionou uma <strong>Data de Batismo</strong> inválida!']);
            }
        }

        if (! empty($request->bairro) || ! empty($request->cidade)) {
            return response()->json(['error' => '<strong>ERRO</strong> Você está praticando SPAM!']);
        }

        $data = [
            'name' => $name,
            'birthday' => $request->birthday,
            'civil_status' => $request->civil_status,
            'gender' => $request->gender,
            'password' => bcrypt($request->email),
            'code' => $request->email,
            'status' => 1,
            'client' => true,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'postcode' => $request->postcode,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'neighborhood' => $request->neighborhood,
            'state' => $request->state,
            'city' => $request->city,
            'baptism' => $isBaptized,
            'baptism_date' => $isBaptized && $request->baptism_date ? $request->baptism_date : null,
        ];

        $data_email = [
            'baptism_option' => $request->baptism_option,
            'period_frequenci' => $request->period_frequenci,
            'whatsapp_group' => $request->whatsapp_group,
            'whatsapp_group_accept' => $request->whatsapp_group_accept,
            'ministerio_group' => $request->ministerio_group,
            'ministerio_name' => $request->ministerio_group == 'true' ? $request->ministerio_name : null,
            'ministerio_accept' => $request->ministerio_accept,
            'ministerio_accept_name' => $request->ministerio_accept == 'true' ? $request->ministerio_accept_name : null,
            'hour_accept' => $request->hour_accept,
            'hour_accept_agend' => $request->hour_accept_agend,
        ];

        $this->storeMember($data, $data_email);

        $this->notifyAdmins($data);

        return response()->json([
            'cadastro' => 'Cadastro realizado com sucesso!',
            'email_success' => 'Email de confirmação enviado com sucesso!',
            'name' => $data['name'],
        ]);
    }

    protected function notifyAdmins(array $data): void
    {
        $admins = User::role(['super admin', 'admin', 'pastor', 'lider'])->get();

        if ($admins->isEmpty()) {
            return;
        }

        $member = User::where('email', $data['email'])->first();

        if ($member) {
            Notification::send($admins, new NewMemberRegistered($member));
        }
    }

    public function storeMember($data, $member_email)
    {
        $member = User::create($data);
        $member->assignRole('member');

        $member->member()->create([
            'user_id' => $member->id,
            'name' => $member->name,
            'gender' => $member->gender,
            'birthday' => $member->birthday ? $member->birthday->format('d/m/Y') : null,
            'civil_status' => $member->civil_status,
            'baptism' => $member->baptism,
            'baptism_date' => $member->baptism_date ? $member->baptism_date->format('d/m/Y') : null,
            'postcode' => $member->postcode,
            'street' => $member->street,
            'number' => $member->number,
            'complement' => $member->complement,
            'neighborhood' => $member->neighborhood,
            'state' => $member->state,
            'city' => $member->city,
            'whatsapp' => $member->whatsapp,
            'email' => $member->email,
            'status' => $member->status,
        ]);

        Mail::send(new CreateMember($data, $member_email));
    }
}
