{{-- regular object attribute --}}
@php
    $column['value'] = $column['value'] ?? data_get($entry, $column['name']);
    $column['escaped'] = $column['escaped'] ?? true;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
    $column['text'] = $column['default'] ?? '-';

    if($column['value'] instanceof \Closure) {
        $column['value'] = $column['value']($entry);
    }

    if(!empty($column['value'])) {
    if(is_array($column['value'])) {
        $column['value'] = implode(', ', $column['value']); // Convert array to comma-separated string
    }
    $column['text'] = $column['prefix'].$column['value'].$column['suffix'];
}

    // if(!empty($column['value'])) {
    //     $column['text'] = $column['prefix'].$column['value'].$column['suffix'];
    // }
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
