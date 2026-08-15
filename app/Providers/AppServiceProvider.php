<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useTailwind();

        try {
            $configuracoes = Config::find(1);
        } catch (\Throwable) {
            $configuracoes = null;
        }

        View::share('configuracoes', $configuracoes);
        View::share('viewPaginas', $configuracoes
            ? Post::where('type', 'pagina')->where('menu', 1)->postson()->get()
            : collect());
    }
}
