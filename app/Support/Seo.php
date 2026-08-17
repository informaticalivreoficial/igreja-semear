<?php

/**
 * Created by PhpStorm.
 * User: gustavoweb
 * Date: 2019-02-28
 * Time: 11:15
 */

namespace App\Support;

use CoffeeCode\Optimizer\Optimizer;

class Seo
{
    private $optimizer;

    public function __construct()
    {
        $this->optimizer = new Optimizer;
        $this->optimizer->openGraph(
            config('app.name'),
            'pt_BR',
            'website'
        )->publisher(
            env('CLIENT_SOCIAL_FACEBOOK_PAGE', '') ?: 'default-page',
            env('CLIENT_SOCIAL_FACEBOOK_AUTHOR', '') ?: 'default-author'
        )->facebook(
            env('CLIENT_SOCIAL_FACEBOOK_APP', '') ?: '123456'
        )->twitterCard(
            env('CLIENT_SOCIAL_TWITTER_CREATOR', '') ?: '@SemearUbatuba',
            env('CLIENT_SOCIAL_TWITTER_PUBLISHER', '') ?: '@SemearUbatuba',
            url('/'),
            'summary_large_image'
        );
    }

    public function render(string $title, string $description, string $url, string $image, bool $follow = true, string $type = 'website')
    {
        if ($type !== 'website') {
            $this->setOgType($type);
        }

        return $this->optimizer->optimize($title, $description, $url, $image, $follow)->render();
    }

    private function setOgType(string $type): void
    {
        $meta = $this->optimizer->meta();

        foreach ($meta as $element) {
            if ((string) $element['property'] === 'og:type') {
                $element['content'] = $type;
                break;
            }
        }
    }
}