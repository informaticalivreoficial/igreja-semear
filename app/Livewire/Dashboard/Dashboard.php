<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use App\Models\Ministry;
use App\Models\Offering;
use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $postsCount = Post::count();
        $postsYearCount = Post::whereYear('publish_at', now()->year)->count();
        $newsCount = Post::where('type', 'noticia')->count();
        $articlesCount = Post::where('type', 'artigo')->count();

        $slidesCount = Slide::count();
        $ministriesCount = Ministry::count();
        $eventsCount = Event::count();
        $membersCount = User::role('member')->count();

        $offeringsTotal = Offering::sum('amount');
        $offeringsYear = Offering::whereYear('offering_date', now()->year)->sum('amount');
        $dizimosTotal = Offering::where('type', 'dizimo')->sum('amount');

        $topposts = Post::orderBy('views', 'desc')->take(5)->get();

        $upcomingEvents = Event::where('status', 1)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->take(5)
            ->get();

        $title = 'Painel de Controle';

        return view('livewire.dashboard.dashboard', compact(
            'postsCount', 'postsYearCount', 'newsCount', 'articlesCount',
            'slidesCount', 'ministriesCount', 'eventsCount', 'membersCount',
            'offeringsTotal', 'offeringsYear', 'dizimosTotal',
            'topposts', 'upcomingEvents', 'title'
        ));
    }
}
