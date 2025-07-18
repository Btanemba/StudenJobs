@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<div class="custom-select-wrapper">
    <select
        name="{{ $field['name'] }}"
        @include('crud::fields.inc.attributes')
        class="form-control custom-country-select"
    >
        @foreach ($field['options'] as $key => $label)
            @if ($key === $field['attributes']['data-separator-key'])
                <option value="{{ $key }}" disabled>{{ $label }}</option>
            @else
                <option
                    value="{{ $key }}"
                    @if ($key == old($field['name'], $field['value'] ?? $field['default'] ?? ''))
                        selected
                    @endif
                >{{ $label }}</option>
            @endif
        @endforeach
    </select>
</div>
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')
