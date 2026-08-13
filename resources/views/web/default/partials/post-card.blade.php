@props(['post'])

<a
    href="{{ route($post->type === 'noticia' ? 'web.noticia' : 'web.blog.artigo', ['slug' => $post->slug]) }}"
    class="card-post group"
>
    <div class="aspect-[16/9] overflow-hidden">
        <img src="{{ $post->cover() }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
    </div>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-2">
            @if($post->categoriaObject)
                <span class="badge-cat">{{ $post->categoriaObject->title }}</span>
            @endif
            @if($post->publish_at)
                <span class="text-xs text-slate-400">{{ $post->publish_at->format('d/m/Y') }}</span>
            @endif
        </div>
        <h3 class="font-display mt-3 text-lg font-bold leading-snug text-slate-900 transition group-hover:text-sky-700">{{ $post->title }}</h3>
        @if($post->excerpt)
            <p class="mt-2 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($post->excerpt, 120) }}</p>
        @endif
    </div>
</a>
