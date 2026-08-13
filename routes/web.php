<?php

use App\Http\Controllers\Web\RssFeedController;
use App\Http\Controllers\Web\SendEmailController;
use App\Http\Controllers\Web\WebController;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\Events\EventForm;
use App\Livewire\Dashboard\Events\Events;
use App\Livewire\Dashboard\Ministries\Ministries;
use App\Livewire\Dashboard\Ministries\MinistryForm;
use App\Livewire\Dashboard\NotificationsList;
use App\Livewire\Dashboard\Offerings\OfferingForm;
use App\Livewire\Dashboard\Offerings\Offerings;
use App\Livewire\Dashboard\Permissions\Index as PermissionIndex;
use App\Livewire\Dashboard\Posts\CatPosts;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Posts\Posts;
use App\Livewire\Dashboard\Roles\Index as RoleIndex;
use App\Livewire\Dashboard\Settings;
use App\Livewire\Dashboard\Sitemap\SitemapGenerator;
use App\Livewire\Dashboard\Slides\SlideForm;
use App\Livewire\Dashboard\Slides\Slides;
use App\Livewire\Dashboard\Users\Form;
use App\Livewire\Dashboard\Users\Time;
use App\Livewire\Dashboard\Users\Users;
use App\Livewire\Dashboard\Users\ViewUser;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::group(['as' => 'web.'], function () {

    /** Página Inicial */
    Route::get('/', [WebController::class, 'home'])->name('home');

    // **************************** Emails ********************************************/
    Route::get('/atendimento', [WebController::class, 'atendimento'])->name('atendimento');
    Route::get('/cadastro-novo-membro', [WebController::class, 'createMember'])->name('create.member');
    Route::get('/cadastro-novo-membro-send', [WebController::class, 'createMemberSend'])->name('create.member.send');
    Route::get('/sendEmail', [SendEmailController::class, 'sendEmail'])->name('sendEmail');

    // ****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', [WebController::class, 'artigo'])->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', [WebController::class, 'categoria'])->name('blog.categoria');
    Route::get('/blog', [WebController::class, 'artigos'])->name('blog.artigos');
    Route::match(['post', 'get'], '/blog/pesquisar', [WebController::class, 'searchBlog'])->name('blog.searchBlog');

    // *************************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', [WebController::class, 'pagina'])->name('pagina');
    Route::get('/noticia/{slug}', [WebController::class, 'noticia'])->name('noticia');
    Route::get('/noticias', [WebController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/categoria/{slug}', [WebController::class, 'categoria'])->name('noticia.categoria');

    // ** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', [WebController::class, 'pesquisa'])->name('pesquisa');

    /** FEED */
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    Route::get('/politica-de-privacidade', [WebController::class, 'politica'])->name('politica');
    Route::get('/sitemap', [WebController::class, 'sitemap'])->name('sitemap');

});

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('configuracoes', Settings::class)->name('settings');
    Route::get('notificacoes', NotificationsList::class)->name('notifications.index');

    // ******************************* Sitemap *********************************************/
    Route::get('sitemap-generator', SitemapGenerator::class)->name('sitemap.generator');

    // *********************** Slides ********************************************/
    Route::get('slides/{slide}/editar', SlideForm::class)->name('slides.edit');
    Route::get('slides/cadastrar', SlideForm::class)->name('slides.create');
    Route::get('slides', Slides::class)->name('slides.index');

    // *********************** Ministérios *****************************************/
    Route::get('ministerios/{ministry}/editar', MinistryForm::class)->name('ministries.edit');
    Route::get('ministerios/cadastrar', MinistryForm::class)->name('ministries.create');
    Route::get('ministerios', Ministries::class)->name('ministries.index');

    // *********************** Eventos *********************************************/
    Route::get('eventos/{event}/editar', EventForm::class)->name('events.edit');
    Route::get('eventos/cadastrar', EventForm::class)->name('events.create');
    Route::get('eventos', Events::class)->name('events.index');

    // *********************** Ofertas *********************************************/
    Route::get('ofertas/{offering}/editar', OfferingForm::class)->name('offerings.edit');
    Route::get('ofertas/cadastrar', OfferingForm::class)->name('offerings.create');
    Route::get('ofertas', Offerings::class)->name('offerings.index');

    // *********************** Posts *********************************************/
    Route::get('posts/{post}/editar', PostForm::class)->name('posts.edit');
    Route::get('posts/cadastrar', PostForm::class)->name('posts.create');
    Route::get('posts', Posts::class)->name('posts.index');

    // *********************** Categorias de Posts ********************************/
    Route::get('posts/categorias', CatPosts::class)->name('posts.categories.index');

    // *********************** Usuários *******************************************/
    Route::get('/cargos', RoleIndex::class)->name('roles');
    Route::get('/permissoes', PermissionIndex::class)->name('permissions');

    Route::get('usuarios/membros', Users::class)->name('users.index');
    Route::get('usuarios/time', Time::class)->name('users.time');
    Route::get('usuarios/cadastrar', Form::class)->name('users.create');
    Route::get('usuarios/{user}/editar', Form::class)->name('users.edit');
    Route::get('usuarios/{user}/visualizar', ViewUser::class)->name('users.view');
});
