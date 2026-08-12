@props([
    'images',
    'title'
])

@php
    use Illuminate\Support\Facades\Storage;
    $images = collect($images)->values();
    $gallery = $images
        ->map(fn ($image) => Storage::url($image->path))
        ->values();
    $total = $gallery->count();
@endphp

<section
    x-data
    class="relative bg-slate-900 overflow-hidden max-h-[520px]"
>
    @if($total)
        <div
            class="grid h-[520px]"
            style="{{ $total >= 3 ? 'grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr;' : '' }}"
        >
            @foreach($gallery->take(3) as $index => $image)
                <div
                    @click="$dispatch('gallery:open',{
                        images:@js($gallery),
                        index:{{ $index }}
                    })"
                    class="
                        relative
                        overflow-hidden
                        cursor-pointer
                        group
                        {{ $index == 0 && $total >= 3 ? 'row-span-2' : '' }}
                    "
                >
                    <img
                        src="{{ $image }}"
                        alt="{{ $title }}"
                        loading="lazy"
                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition"></div>
                    @if($index==2 && $total>3)
                        <div class="absolute inset-0 flex items-center justify-center bg-black/50 backdrop-blur">

                            <div class="px-6 py-3 rounded-xl bg-white/20 text-white font-bold">
                                +{{ $total-3 }} fotos
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</section>