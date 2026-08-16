<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Post;

class RssFeedController extends Controller
{
    public function feed()
    {
        $posts = Post::orderBy('created_at', 'DESC')->where('type', 'artigo')->postson()->limit(10)->get();
        $paginas = Post::orderBy('created_at', 'DESC')->where('type', 'pagina')->postson()->limit(10)->get();

        return response()->view('web.'.Config::where('id', 1)->first()->template.'.feed', [
            'posts' => $posts,
            'paginas' => $paginas,
        ])->header('Content-Type', 'application/xml');

    }
}
