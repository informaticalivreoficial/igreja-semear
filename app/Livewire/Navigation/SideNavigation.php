<?php

namespace App\Livewire\Navigation;

use App\Models\Config;
use App\Models\Event;
use App\Models\Ministry;
use App\Models\Offering;
use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use Livewire\Component;

class SideNavigation extends Component
{
    public function render()
    {
        $membersCount = User::role('member')->count();
        $equipeCount = User::role(['admin', 'editor'])->count();
        $postsCount = Post::count();
        $slidesCount = Slide::count();
        $ministriesCount = Ministry::count();
        $eventsCount = Event::count();
        $offeringsCount = Offering::count();
        $config = Config::first();

        return view('livewire.navigation.side-navigation', [
            'membersCount' => $membersCount,
            'equipeCount' => $equipeCount,
            'postsCount' => $postsCount,
            'slidesCount' => $slidesCount,
            'ministriesCount' => $ministriesCount,
            'eventsCount' => $eventsCount,
            'offeringsCount' => $offeringsCount,
            'config' => $config,
        ]);
    }
}
