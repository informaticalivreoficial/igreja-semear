<div
    class="form-group"
    x-data="currencyInput(@js($attributes->get('value')), '{{ $name }}')"
>
    @if($label)
        <label class="labelforms">
            <b>{{ $label }}</b>
        </label>
    @endif

    <input
        type="text"
        :value="display"
        @input="onInput($event)"
        {{ $attributes->merge([
            'class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')
        ]) }}
    />

    @error($name)
        <span class="error erro-feedback">{{ $message }}</span>
    @enderror
</div>