@props(['categorias' => [], 'recentes' => [], 'active' => null, 'type' => 'artigo'])

<aside class="space-y-8">
    {{-- BUSCA --}}
    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
        <h3 class="font-display text-lg font-bold text-slate-900">Buscar</h3>
        <form action="{{ route('web.blog.searchBlog') }}" method="GET" class="mt-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Digite sua busca..." class="input-site">
        </form>
    </div>

    {{-- CATEGORIAS --}}
    @if($categorias->count())
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <h3 class="font-display text-lg font-bold text-slate-900">Categorias</h3>
            <ul class="mt-4 space-y-1">
                @foreach($categorias as $categoria)
                    <li>
                        <a
                            href="{{ route($categoria->type === 'noticia' ? 'web.noticia.categoria' : 'web.blog.categoria', ['slug' => $categoria->slug]) }}"
                            class="flex items-center justify-between rounded-lg px-3 py-2 text-sm font-medium transition {{ $active && $active->id === $categoria->id ? 'bg-sky-600/10 text-sky-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                        >
                            <span>{{ $categoria->title }}</span>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-bold text-slate-500">{{ $categoria->countposts() }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RECENTES --}}
    @if($recentes->count())
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <h3 class="font-display text-lg font-bold text-slate-900">Publicações recentes</h3>
            <ul class="mt-4 space-y-4">
                @foreach($recentes as $post)
                    <li>
                        <a href="{{ route($post->type === 'noticia' ? 'web.noticia' : 'web.blog.artigo', ['slug' => $post->slug]) }}" class="group flex gap-3">
                            <img src="{{ $post->cover() }}" alt="" class="h-14 w-14 shrink-0 rounded-lg object-cover">
                            <span>
                                <span class="block text-sm font-semibold leading-snug text-slate-700 transition group-hover:text-sky-700">{{ $post->title }}</span>
                                @if($post->publish_at)
                                    <span class="text-xs text-slate-400">{{ $post->publish_at->format('d/m/Y') }}</span>
                                @endif
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CTA --}}
    <div class="page-hero rounded-2xl p-6">
        <h3 class="font-display text-xl font-bold text-white">Participe da nossa comunidade!</h3>
        <p class="mt-2 text-sm text-sky-100/90">Venha nos visitar e conhecer mais sobre a nossa igreja.</p>
        <a href="{{ route('web.atendimento') }}" class="btn-white btn-sm mt-4">Fale conosco</a>
    </div>
</aside>
