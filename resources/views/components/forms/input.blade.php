@props([
    'label' => null,
    'name',
    'type' => 'text',
])

<div class="form-group">

    @if($label)
        <label
            for="{{ $name }}"
            class="labelforms"
        >
            <b>{{ $label }}</b>
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"

        wire:model.live="{{ $name }}"

        {{ $attributes->merge([
            'class' => '
                form-control
                ' . ($errors->has($name) ? 'is-invalid' : '')
        ]) }}
    />

    @error($name)
        <span class="error erro-feedback">
            {{ $message }}
        </span>
    @enderror

</div>