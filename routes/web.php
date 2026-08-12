<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\{
    NotificationsList,
    Settings,
};
use App\Livewire\Dashboard\Users\{
    Time,
    Users,
    ViewUser,
    Form,
};

use App\Livewire\Dashboard\Permissions\Index as PermissionIndex;
use App\Livewire\Dashboard\Roles\Index as RoleIndex;

use App\Livewire\Dashboard\Menu\Index;

use App\Livewire\Dashboard\Posts\CatPosts;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Posts\Posts;

use App\Livewire\Dashboard\Sitemap\SitemapGenerator;
use App\Livewire\Dashboard\Slides\SlideForm;
use App\Livewire\Dashboard\Slides\Slides;

use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';


Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */
    Route::get('/', [WebController::class, 'home'])->name('home');
    Route::match(['post', 'get'], '/fetchCity', [WebController::class, 'fetchCity'])->name('fetchCity');

    //**************************** Emails ********************************************/
    Route::match(['post', 'get'], '/avaliacao', [WebController::class, 'avaliacaoCliente'])->name('avaliacao');
    Route::get('/avaliacaoSend', [SendEmailController::class, 'avaliacaoSend'])->name('avaliacaoSend');
    Route::get('/atendimento', [WebController::class, 'atendimento'])->name('atendimento');
    Route::get('/cadastro-novo-membro', [WebController::class, 'createMember'])->name('create.member');
    Route::get('/cadastro-novo-membro-send', [WebController::class, 'createMemberSend'])->name('create.member.send');
    Route::get('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');
    Route::get('/sendNewsletter', [SendEmailController::class, 'sendNewsletter'])->name('sendNewsletter');
    Route::get('/acomodacaoSend', [SendEmailController::class, 'acomodacaoSend'])->name('acomodacaoSend');
    
    //****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [WebController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [WebController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [WebController::class, 'artigos'])->name('blog.artigos');
    Route::match(['post', 'get'], '/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    //*************************************** Acomodações *******************************************/
    Route::get('/acomodacoes', [WebController::class, 'acomodacoes'])->name('acomodacoes');
    Route::get('/acomodacao/{slug}', [WebController::class, 'acomodacao'])->name('acomodacao');
    Route::match(['post', 'get'], '/reservar', [WebController::class, 'reservar'])->name('reservar');

    //*************************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');
    Route::get('/noticia/{slug}', [WebController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [WebController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [WebController::class, 'categoria'])->name('noticia.categoria');
    
    //** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', [WebController::class, 'pesquisa'])->name('pesquisa');

    /** FEED */
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/sitemap', [WebController::class, 'sitemap'])->name('sitemap');

});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {

    Route::get('/', Dashboard::class)->name('admin');
    Route::get('configuracoes', Settings::class)->name('settings');

    //******************************* Sitemap *********************************************/
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');
    //Route::get('/relatorios/imoveis', PropertiesReport::class)->name('reports.properties');

    Route::get('notificacoes', NotificationsList::class)->name('notifications.index'); 

    
    // Route::put('listas/email/{id}', [NewsletterController::class, 'newsletterUpdate'])->name('listas.newsletter.update');
    // Route::get('listas/email/set-status', [NewsletterController::class, 'emailSetStatus'])->name('emails.emailSetStatus');
    // Route::get('listas/email/delete', [NewsletterController::class, 'emailDelete'])->name('emails.delete');
    // Route::delete('listas/email/deleteon', [NewsletterController::class, 'emailDeleteon'])->name('emails.deleteon');
    // Route::get('listas/email/{id}/edit', [NewsletterController::class, 'newsletterEdit'])->name('listas.newsletter.edit');
    // Route::get('listas/email/cadastrar', [NewsletterController::class, 'newsletterCreate'])->name('lista.newsletter.create');
    // Route::post('listas/email/store', [NewsletterController::class, 'newsletterStore'])->name('listas.newsletter.store');
    // Route::get('listas/emails/categoria/{categoria}', [NewsletterController::class, 'newsletters'])->name('lista.newsletters');

    //******************* Templates ************************************************/
    // Route::get('templates/set-status', [TemplateController::class, 'templateSetStatus'])->name('templates.templateSetStatus');
    // Route::get('templates/delete', [TemplateController::class, 'delete'])->name('templates.delete');
    // Route::delete('templates/deleteon', [TemplateController::class, 'deleteon'])->name('templates.deleteon');
    // Route::put('templates/{id}', [TemplateController::class, 'update'])->name('templates.update');
    // Route::get('templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    // Route::get('templates/create', [TemplateController::class, 'create'])->name('templates.create');
    // Route::post('templates/store', [TemplateController::class, 'store'])->name('templates.store');
    // Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');

   
    
    //*********************** Slides ********************************************/
    Route::get('slides/{slide}/editar', SlideForm::class)->name('slides.edit');
    Route::get('slides/cadastrar', SlideForm::class)->name('slides.create');
    Route::get('slides', Slides::class)->name('slides.index');

    Route::get('menus', Index::class)->name('menus.index');

    //*********************** Posts *********************************************/
    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts', Posts::class)->name('posts.index');

    //*********************** Categorias de Posts ********************************/
    Route::get('posts/categorias', CatPosts::class)->name('posts.categories.index');

    //*********************** Usuários *******************************************/
    Route::get('/cargos', RoleIndex::class)->name('admin.roles');
    Route::get('/permissoes', PermissionIndex::class)->name('admin.permissions');

    Route::get('usuarios/clientes', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{user}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{user}/visualizar', ViewUser::class)->name('users.view');     
});
