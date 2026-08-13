<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // URL::forceScheme('https');
        // Schema::defaultStringLength(191);
        // Blade::aliasComponent('admin.components.message', 'message');

        // //Newsletter FORM
        // $newsletter = \App\Models\Config::find(1);
        // View()->share('newsletterForm', $newsletter);

        // //Páginas
        // $paginas = Post::where('tipo', 'pagina')->where('menu', 1)->postson()->get();
        // View()->share('viewPaginas', $paginas);

        // //Config
        // $configuracoes = \App\Models\Config::find(1);
        // View()->share('configuracoes', $configuracoes);

        // //Paginator do Bootstrap css
        // Paginator::useBootstrap();
    }
}
