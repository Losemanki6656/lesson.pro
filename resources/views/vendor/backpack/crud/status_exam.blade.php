@php
    $value = data_get($entry, $column['name']);
    $id = $entry->id;
    if (is_array($value)) {
        $value = json_encode($value);
    }
@endphp

<span class="status-column" style="float: left" id="status-{{ $id }}">
    @if($value)
        <span class="badge rounded-pill bg-primary">
            якунланди
        </span>
    @else
       <span class="badge rounded-pill bg-warning">
            жараёнда
       </span>
    @endif
</span>
