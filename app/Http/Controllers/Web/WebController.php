<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\Web\CreateMember;
use App\Models\CatPost;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use App\Services\ConfigService;
use App\Support\Seo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebController extends Controller
{
    protected $seo;

    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->seo = new Seo;
    }

    public function home()
    {
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            $config->app_name ?? 'Semear',
            $config->information ?? 'Comunidade Cristã Semear',
            route('web.home'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.home', [
            'head' => $head,
            'slides' => Slide::where('status', 1)->orderByDesc('id')->get(),
            'artigos' => Post::where('type', 'artigo')->postson()
                ->with(['categoriaObject'])
                ->orderByDesc('publish_at')->limit(3)->get(),
            'noticias' => Post::where('type', 'noticia')->postson()
                ->with(['categoriaObject'])
                ->orderByDesc('publish_at')->limit(3)->get(),
            'eventos' => Event::where('status', 1)->orderBy('start_at')->limit(3)->get(),
        ]);
    }

    public function quemsomos()
    {
        $config = $this->configService->getConfig();

        $paginaQuemSomos = Post::where('type', 'pagina')->postson()->where('id', 5)->first();
        $head = $this->seo->render(
            'Quem Somos - '.$config->app_name,
            $config->information ?? 'Semear',
            route('web.home'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.quem-somos', [
            'head' => $head,
            'paginaQuemSomos' => $paginaQuemSomos,
        ]);
    }

    public function politica()
    {
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            'Política de Privacidade - '.$config->app_name,
            'Política de Privacidade - '.$config->app_name,
            route('web.politica'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.politica', [
            'head' => $head,
        ]);
    }

    public function pesquisa(Request $request)
    {
        $config = $this->configService->getConfig();

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
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
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
        $config = $this->configService->getConfig();

        $post = Post::where('slug', $slug)->where('type', 'pagina')->postson()->first();
        abort_unless($post, 404);

        $post->increment('views');

        $head = $this->seo->render(
            $post->title ?? $config->app_name,
            $post->title,
            route('web.pagina', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.'.$config->template.'.pagina', [
            'head' => $head,
            'post' => $post,
        ]);
    }

    public function ministerios()
    {
        $config = $this->configService->getConfig();

        $ministerios = Ministry::where('status', 1)->orderBy('name')->get();

        $head = $this->seo->render(
            'Ministérios - '.$config->app_name,
            'Conheça os ministérios da '.$config->app_name,
            route('web.ministerios'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.ministerios', [
            'head' => $head,
            'ministerios' => $ministerios,
        ]);
    }

    public function eventos()
    {
        $config = $this->configService->getConfig();

        $eventos = Event::where('status', 1)->orderBy('start_at')->paginate(9);

        $head = $this->seo->render(
            'Eventos - '.$config->app_name,
            'Agenda de eventos da '.$config->app_name,
            route('web.eventos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.eventos', [
            'head' => $head,
            'eventos' => $eventos,
        ]);
    }

    public function pedidoOracao()
    {
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            'Pedido de Oração - '.$config->app_name,
            'Envie seu pedido de oração para a '.$config->app_name,
            route('web.pedido-oracao'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.pedido-oracao', [
            'head' => $head,
        ]);
    }

    public function transmissao()
    {
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            'Transmissão ao Vivo - '.$config->app_name,
            'Acompanhe as transmissões ao vivo da '.$config->app_name,
            route('web.transmissao'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.transmissao', [
            'head' => $head,
            'live_url' => $config->live_url,
        ]);
    }

    public function atendimento()
    {
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            'Atendimento - '.$config->app_name,
            'Nossa equipe está pronta para melhor atender as suas demandas!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.atendimento', [
            'head' => $head,
        ]);
    }

    public function sitemap()
    {
        $base = url('/');

        $items = [
            [$base.'/', Carbon::now()->toDateString(), 'daily', '1.0'],
            [$base.'/pagina/sobre-a-igreja', null, 'monthly', '0.8'],
            [$base.'/ministerios', null, 'monthly', '0.8'],
            [$base.'/pagina/cultos-e-horarios', null, 'weekly', '0.8'],
            [$base.'/pagina/pregacoes', null, 'monthly', '0.6'],
            [$base.'/pagina/galeria-de-fotos', null, 'monthly', '0.5'],
            [$base.'/pagina/localizacao', null, 'monthly', '0.6'],
            [$base.'/pagina/doacoes', null, 'monthly', '0.6'],
            [$base.'/eventos', null, 'weekly', '0.7'],
            [$base.'/blog', null, 'daily', '0.9'],
            [$base.'/noticias', null, 'daily', '0.9'],
            [$base.'/pedido-de-oracao', null, 'monthly', '0.6'],
            [$base.'/transmissao-ao-vivo', null, 'weekly', '0.7'],
            [$base.'/atendimento', null, 'monthly', '0.5'],
            [$base.'/politica-de-privacidade', null, 'yearly', '0.3'],
        ];

        $posts = Post::where('status', 1)
            ->whereIn('type', ['artigo', 'noticia'])
            ->get();

        foreach ($posts as $post) {
            $route = $post->type === 'noticia' ? 'web.noticia' : 'web.blog.artigo';
            $items[] = [
                route($route, ['slug' => $post->slug]),
                optional($post->publish_at)->toDateString(),
                $post->type === 'noticia' ? 'daily' : 'weekly',
                '0.7',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($items as [$loc, $lastmod, $freq, $priority]) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$loc}</loc>\n";
            if ($lastmod) {
                $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$freq}</changefreq>\n";
            $xml .= "    <priority>{$priority}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    // ************************************ Blog *******************************************/

    public function artigos(Request $request)
    {
        $config = $this->configService->getConfig();

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
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
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
        $config = $this->configService->getConfig();

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
            $post->cover() ?? $this->configService->getMetaImg()
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
        $config = $this->configService->getConfig();

        $categoria = CatPost::where('slug', $slug)->available()->first();
        abort_unless($categoria, 404);

        $posts = Post::where('category', $categoria->id)->where('type', $categoria->type)->postson()
            ->with(['categoriaObject', 'userObject'])
            ->orderByDesc('publish_at')->paginate(6);

        $head = $this->seo->render(
            $categoria->title.' - '.$config->app_name,
            'Publicações na categoria '.$categoria->title,
            route(($categoria->type === 'noticia' ? 'web.noticia.categoria' : 'web.blog.categoria'), ['slug' => $categoria->slug]),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
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
        $config = $this->configService->getConfig();

        $posts = Post::where('type', 'noticia')->postson()->with(['categoriaObject', 'userObject'])
            ->orderByDesc('publish_at')->paginate(9);

        $head = $this->seo->render(
            'Notícias - '.$config->app_name,
            'Notícias - '.$config->app_name,
            route('web.noticias'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
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
        $config = $this->configService->getConfig();

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
            $post->cover() ?? $this->configService->getMetaImg()
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
        $config = $this->configService->getConfig();

        $head = $this->seo->render(
            'Cadastro de Membros - '.$config->app_name,
            'Comunidade Cristã Semear, cadastro de Membros',
            route('web.create.member'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$config->template.'.membro.cadastro', [
            'head' => $head,
        ]);
    }

    public function createMemberSend(Request $request)
    {
        if ($request->name == '') {
            return response()->json(['error' => 'Por favor preencha o campo <strong>Nome</strong>']);
        }
        if ($request->birthday == '') {
            return response()->json(['error' => 'Por favor preencha a <strong>Data de Nascimento</strong>']);
        }

        $birthday = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');
        if (Carbon::parse($birthday)->gt(Carbon::parse(now())->format('Y-m-d'))) {
            return response()->json(['error' => 'Você selecionou uma <strong>Data</strong> inválida!']);
        }
        if ($request->gender == '') {
            return response()->json(['error' => 'Por favor informe o <strong>sexo</strong>']);
        }
        if (! filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'O campo <strong>Email</strong> está vazio ou não tem um formato válido!']);
        }
        if ($request->whatsapp == '') {
            return response()->json(['error' => 'Por favor preencha o campo <strong>Telefone</strong>']);
        }
        if ($request->baptism_date && $request->baptism_date != null) {
            $baptism_date = Carbon::createFromFormat('d/m/Y', $request->baptism_date)->format('Y-m-d');
            if (Carbon::parse($baptism_date)->gt(Carbon::parse(now())->format('Y-m-d'))) {
                return response()->json(['error' => 'Você selecionou uma <strong>Data</strong> inválida!']);
            }
        }
        if (! empty($request->bairro) || ! empty($request->cidade)) {
            return response()->json(['error' => '<strong>ERRO</strong> Você está praticando SPAM!']);
        }

        $data = [
            'name' => $request->name,
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
            'baptism' => $request->baptism,
            'baptism_date' => $request->baptism_date ? $request->baptism_date : null,
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

        return response()->json([
            'cadastro' => 'Cadastro realizado com sucesso!',
            'email_success' => 'Email de confirmação enviado com sucesso!',
            'name' => $data['name'],
        ]);
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
