<title>{{ $seo->title }}</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $seo->description }}">
<meta name="robots" content="{{ $seo->index ? 'index,follow' : 'noindex,nofollow' }}">
<link rel="canonical" href="{{ $seo->url }}">

<meta property="og:type" content="{{ $seo->type }}">
<meta property="og:site_name" content="{{ config('seo.site_name') }}">
<meta property="og:locale" content="{{ config('seo.locale') }}">
<meta property="og:title" content="{{ $seo->title }}">
<meta property="og:description" content="{{ $seo->description }}">
<meta property="og:url" content="{{ $seo->url }}">
<meta property="og:image" content="{{ $seo->image }}">
<meta name="twitter:card" content="summary_large_image">

@if(config('seo.twitter'))
    <meta name="twitter:site" content="{{ config('seo.twitter') }}">
@endif

<meta name="twitter:title" content="{{ $seo->title }}">
<meta name="twitter:description" content="{{ $seo->description }}">
<meta name="twitter:image" content="{{ $seo->image }}">

@if(config('seo.facebook_app_id'))
    <meta property="fb:app_id" content="{{ config('seo.facebook_app_id') }}">
@endif

@foreach($seo->schemas as $schema)
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>
@endforeach