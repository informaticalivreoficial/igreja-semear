<?php

namespace App\Livewire\Dashboard;

use App\Enums\DonationStatusEnum;
use App\Enums\DonationTypeEnum;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use App\Services\Analytics\AnalyticsService;
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

        $donationsTotal = Donation::where('status', DonationStatusEnum::Paid->value)->sum('amount');
        $donationsYear = Donation::where('status', DonationStatusEnum::Paid->value)
            ->whereYear('created_at', now()->year)->sum('amount');
        $dizimosTotal = Donation::where('status', DonationStatusEnum::Paid->value)
            ->where('type', DonationTypeEnum::Tithe->value)->sum('amount');

        $topposts = Post::orderBy('views', 'desc')->take(5)->get();

        $upcomingEvents = Event::where('status', 1)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->take(5)
            ->get();

        $analytics = new AnalyticsService;
        $analyticsMonthly = $analytics->monthlyVisits(6);
        $analyticsDevices = $analytics->devices(6);

        $title = 'Painel de Controle';

        return view('livewire.dashboard.dashboard', compact(
            'postsCount', 'postsYearCount', 'newsCount', 'articlesCount',
            'slidesCount', 'ministriesCount', 'eventsCount', 'membersCount',
            'donationsTotal', 'donationsYear', 'dizimosTotal',
            'topposts', 'upcomingEvents', 'analyticsMonthly', 'analyticsDevices', 'title'
        ));
    }
}
