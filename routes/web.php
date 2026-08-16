<?php

use App\Http\Controllers\Web\MemberAreaController;
use App\Http\Controllers\Web\RssFeedController;
use App\Http\Controllers\Web\SendEmailController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Livewire\Dashboard\Announcements\AnnouncementForm;
use App\Livewire\Dashboard\Announcements\Announcements;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Dashboard\Events\EventForm;
use App\Livewire\Dashboard\Events\Events;
use App\Livewire\Dashboard\Families\Families;
use App\Livewire\Dashboard\Ministries\Ministries;
use App\Livewire\Dashboard\Ministries\MinistryForm;
use App\Livewire\Dashboard\Donations\DonationForm;
use App\Livewire\Dashboard\Donations\Donations;
use App\Livewire\Dashboard\NotificationsList;
use App\Livewire\Dashboard\Permissions\Index as PermissionIndex;
use App\Livewire\Dashboard\Posts\CatPosts;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Posts\Posts;
use App\Livewire\Dashboard\PrayerRequests\PrayerRequests;
use App\Livewire\Dashboard\Registrations\Registrations;
use App\Livewire\Dashboard\Roles\Index as RoleIndex;
use App\Livewire\Dashboard\Settings;
use App\Livewire\Dashboard\Sitemap\SitemapGenerator;
use App\Livewire\Dashboard\Slides\SlideForm;
use App\Livewire\Dashboard\Slides\Slides;
use App\Livewire\Dashboard\Users\Form;
use App\Livewire\Dashboard\Users\Time;
use App\Livewire\Dashboard\Users\Users;
use App\Livewire\Dashboard\Users\ViewUser;
use App\Livewire\Dashboard\Youtube\YoutubeManager;
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
    Route::get('/ministerios', [WebController::class, 'ministerios'])->name('ministerios');
    Route::get('/eventos', [WebController::class, 'eventos'])->name('eventos');
    Route::get('/pedido-de-oracao', [WebController::class, 'pedidoOracao'])->name('pedido-oracao');
    Route::get('/transmissao-ao-vivo', [WebController::class, 'transmissao'])->name('transmissao');
    Route::get('/cultos-online', [WebController::class, 'cultosOnline'])->name('cultos');
    Route::get('/pregacoes', [WebController::class, 'pregacoes'])->name('pregacoes');
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

    // ****************************** Doações *****************************************/
    Route::get('/doacoes', \App\Livewire\Web\DonationForm::class)->name('doacoes');

});

/** Área do membro */
Route::middleware(['auth', 'member'])->prefix('minha-conta')->as('member.')->group(function () {
    Route::get('/', [MemberAreaController::class, 'dashboard'])->name('dashboard');
    Route::get('/perfil', [MemberAreaController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [MemberAreaController::class, 'updatePerfil'])->name('perfil.update');
    Route::get('/familia', [MemberAreaController::class, 'familia'])->name('familia');
    Route::get('/agenda', [MemberAreaController::class, 'agenda'])->name('agenda');
    Route::post('/inscrever', [MemberAreaController::class, 'inscrever'])->name('inscrever');
    Route::post('/inscricao/{registration}/cancelar', [MemberAreaController::class, 'cancelarInscricao'])->name('inscricao.cancelar');
    Route::get('/inscricoes', [MemberAreaController::class, 'inscricoes'])->name('inscricoes');
    Route::get('/historico', [MemberAreaController::class, 'historico'])->name('historico');
    Route::get('/oracoes', [MemberAreaController::class, 'oracoes'])->name('oracoes');
    Route::post('/oracoes', [MemberAreaController::class, 'storeOracao'])->name('oracoes.store');
    Route::get('/contribuicoes', [MemberAreaController::class, 'contribuicoes'])->name('contribuicoes');
    Route::get('/avisos', [MemberAreaController::class, 'avisos'])->name('avisos');
});

Route::group(['middleware' => ['auth', 'staff'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

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

    // *********************** Doações *********************************************/
    Route::get('doacoes/{donation}/editar', DonationForm::class)->name('donations.edit');
    Route::get('doacoes/cadastrar', DonationForm::class)->name('donations.create');
    Route::get('doacoes', Donations::class)->name('donations.index');

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

    // *********************** Famílias ******************************************/
    Route::get('familias', Families::class)->name('families.index');

    // *********************** Inscrições ****************************************/
    Route::get('inscricoes', Registrations::class)->name('registrations.index');

    // *********************** Pedidos de oração *********************************/
    Route::get('pedidos-de-oracao', PrayerRequests::class)->name('prayers.index');

    // *********************** Avisos ********************************************/
    Route::get('avisos/{announcement}/editar', AnnouncementForm::class)->name('announcements.edit');
    Route::get('avisos/cadastrar', AnnouncementForm::class)->name('announcements.create');
    Route::get('avisos', Announcements::class)->name('announcements.index');

    // *********************** YouTube ********************************************/
    Route::get('youtube', YoutubeManager::class)->name('youtube.index');
});

/** Webhooks de pagamento (fora do grupo web -> sem CSRF) */
Route::post('/webhooks/payments/{gateway}', PaymentWebhookController::class)
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
