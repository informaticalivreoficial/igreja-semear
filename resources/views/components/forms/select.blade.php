@props([
    'label' => null,
    'name',
])

<div class="form-group">

    @if($label)
        <label for="{{ $name }}" class="labelforms">
            <b>{{ $label }}</b>
        </label>
    @endif

    <select
        id="{{ $name }}"
        wire:model.live="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')
        ]) }}
    >
        {{ $slot }}
    </select>

    @error($name)
        <span class="error erro-feedback">
            {{ $message }}
        </span>
    @enderror

</div>