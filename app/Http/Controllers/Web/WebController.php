<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Mail\Web\CreateMember;
use Illuminate\Support\Facades\Storage;

use App\Models\{
    Post,
    CatPost,
    Newsletter,
    Parceiro,
    Slide,
    User
};
use App\Services\ConfigService;
use App\Support\Seo;
use Carbon\Carbon;

class WebController extends Controller
{
    protected $seo, $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->seo = new Seo();        
    }

    public function home()
    {  
        $head = $this->seo->render($this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        ); 

		return view('web.'.$this->configService->getConfig()->template.'.home',[
            'head' => $head
		]);
    }

    public function quemsomos()
    {
        $paginaQuemSomos = Post::where('tipo', 'pagina')->postson()->where('id', 5)->first();
        $head = $this->seo->render('Quem Somos - ' . $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.quemsomos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        return view('web.'.$this->configService->getConfig()->template.'.quem-somos',[
            'head' => $head,
            'paginaQuemSomos' => $paginaQuemSomos
        ]);
    }

    public function politica()
    {
        $head = $this->seo->render('Política de Privacidade - ' . $this->configService->getConfig()->nomedosite ?? 'Informática Livre',
            'Política de Privacidade - ' . $this->configService->getConfig()->nomedosite,
            route('web.politica'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$this->configService->getConfig()->template.'.politica',[
            'head' => $head
        ]);
    }    

    public function pesquisa(Request $request)
    {
        $search = $request->only('search');

        $paginas = Post::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('titulo', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'pagina')->postson();
                $query->orWhere('content', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'pagina')->postson();
            }
        })->postson()->limit(10)->get();

        $artigos = Post::where(function($query) use ($request){
            if($request->search){
                $query->orWhere('titulo', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'artigo')->postson();
                $query->orWhere('content', 'LIKE', "%{$request->search}%")
                    ->where('tipo', 'artigo')->postson();
            }
        })->postson()->limit(10)->get();
        
        $head = $this->seo->render('Pesquisa por ' . $request->search ?? 'Informática Livre',
            'Pesquisa - ' . $this->configService->getConfig()->nomedosite,
            route('web.blog.artigos'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );
        
        return view('web.'.$this->configService->getConfig()->template.'.pesquisa',[
            'head' => $head,
            'paginas' => $paginas,
            'artigos' => $artigos
        ]);
    }

    public function pagina($slug)
    {
        $clientesCount = User::where('client', 1)->count();
        $post = Post::where('slug', $slug)->where('tipo', 'pagina')->postson()->first();        
        $post->views = $post->views + 1;
        $post->save();

        $head = $this->seo->render($post->titulo ?? 'Informática Livre',
            $post->titulo,
            route('web.pagina', ['slug' => $post->slug]),
            $post->cover() ?? $this->configService->getMetaImg()
        );

        return view('web.'.$this->configService->getConfig()->template.'.pagina', [
            'head' => $head,
            'post' => $post,
            'clientesCount' => $clientesCount
        ]);
    }    
    
    public function atendimento()
    {
        $head = $this->seo->render('Atendimento - ' . $this->configService->getConfig()->nomedosite,
            'Nossa equipe está pronta para melhor atender as demandas de nossos clientes!',
            route('web.atendimento'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );        

        return view('web.'.$this->configService->getConfig()->template.'.atendimento', [
            'head' => $head            
        ]);
    }

    public function sitemap()
    {
        $url = $this->configService->getConfig()->sitemap;
        $data = file_get_contents($url);
        return response($data, 200, ['Content-Type' => 'application/xml']);
    }

    public function createMember()
    {
        $head = $this->seo->render('Cadastro de Membros - ' . $this->configService->getConfig()->app_name,
            'Comunidade Cristã Semear, cadastro de Membros',
            route('web.create.member'),
            $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.'.$this->configService->getConfig()->template.'.membro.cadastro', [
            'head' => $head            
        ]);
    }

    public function createMemberSend(Request $request)
    {
        // if($request->name == ''){
        //     $json = "Por favor preencha o campo <strong>Nome</strong>";
        //     return response()->json(['error' => $json]);
        // }
        // if($request->birthday == ''){
        //     $json = "Por favor preencha a <strong>Data de Nascimento</strong>";
        //     return response()->json(['error' => $json]);
        // }

        // $birthday = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');        
        // if(Carbon::parse($birthday)->gt(Carbon::parse(now())->format('Y-m-d'))){
        //     $json = "Você selecionou uma <strong>Data</strong> inválida!";
        //     return response()->json(['error' => $json]);
        // }
        // if($request->gender == ''){
        //     $json = "Por favor informe o <strong>sexo</strong>";
        //     return response()->json(['error' => $json]);
        // }
        // if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
        //     $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
        //     return response()->json(['error' => $json]);
        // }
        // if($request->whatsapp == ''){
        //     $json = "Por favor preencha o campo <strong>Telefone</strong>";
        //     return response()->json(['error' => $json]);
        // }
        // if($request->baptism_date && $request->baptism_date != null){
        //     $baptism_date = Carbon::createFromFormat('d/m/Y', $request->baptism_date)->format('Y-m-d');        
        //     if(Carbon::parse($baptism_date)->gt(Carbon::parse(now())->format('Y-m-d'))){
        //         $json = "Você selecionou uma <strong>Data</strong> inválida!";
        //         return response()->json(['error' => $json]);
        //     }
        // }        
        // if(!empty($request->bairro) || !empty($request->cidade)){
        //     $json = "<strong>ERRO</strong> Você está praticando SPAM!";  
        //     return response()->json(['error' => $json]);
        // }

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
    }

    public function storeMember($data, $member_email)
    {   
        $member = User::create($data);
        $member->save();
        
        Mail::send( new CreateMember($data, $member_email));
        //return redirect()->route('web.membro.cadastro')->with('success', 'Cadastro realizado com sucesso!');
    }
    
}
