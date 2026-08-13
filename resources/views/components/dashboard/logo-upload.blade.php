@props([
    'label' => '',
    'width' => 200,
    'height' => 100,
    'preview' => '',
    'target' => 'logo',
])

<div class="relative rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <label class="mb-2 block text-sm font-medium text-slate-700">
        <b>{{ $label }}</b> - {{ $width }}x{{ $height }} pixels
    </label>

    <div
        x-data="{
            preview: '{{ $preview }}',
            updatePreview(event) {
                const fileInput = event.target;
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

                fileInput.value = '';
            }
        }"
        class="flex flex-col items-start space-y-3"
    >
        <div class="relative w-full">
            <img
                :src="preview"
                alt="Preview"
                class="h-auto max-w-full rounded-lg border border-slate-200"
                width="{{ $width }}"
                height="{{ $height }}"
            >

            <div
                wire:loading wire:target="{{ $target }}"
                class="absolute inset-0 flex items-center justify-center rounded-lg bg-white/70"
            >
                <svg class="h-8 w-8 animate-spin text-forest-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>
        </div>

        <input
            type="file"
            @change="updatePreview"
            {{ $attributes->whereStartsWith('wire:') }}
            class="block w-full cursor-pointer text-sm text-slate-500 file:mr-4 file:cursor-pointer file:rounded-lg file:border-0 file:bg-forest-50 file:px-4 file:py-2 file:font-semibold file:text-forest-700 hover:file:bg-forest-100"
        />
    </div>
</div>
