
@php
    $currentUserId = auth()->id();
    $isOwnAccount = false;

    // Check if we're dealing with an Administrator model/table
    $model = $crud->getModel();
    $isAdminContext = $model instanceof \App\Models\Administrator
                     || $model->getTable() === 'administrators';

    if ($isAdminContext) {
        $isOwnAccount = $currentUserId && $currentUserId === $entry->getKey();
    }
@endphp


@if (!$isOwnAccount)
    @if ($crud->hasAccess('update'))
        <a href="{{ url($crud->route . '/' . $entry->getKey() . '/edit') }}" class="btn btn-sm btn-link">
            <i class="la la-edit"></i>
        </a>
    @endif

    @if ($crud->hasAccess('delete'))
        <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ url($crud->route . '/' . $entry->getKey()) }}"
            class="btn btn-sm btn-link text-danger">
            <i class="la la-trash"></i>
        </a>
    @endif
@endif

{{-- <!-- Render custom buttons defined in the 'buttons' array -->
    @if (isset($column['buttons']) && is_array($column['buttons']) && count($column['buttons']))
        @foreach ($column['buttons'] as $button)
            <a href="{{ $button['url']($entry) }}" class="btn btn-sm btn-link">
                <i class="fa {{ $button['icon'] }}"></i>
            </a>
        @endforeach
    @endif --}}


<script>
    function deleteEntry(element) {
        if (confirm('Are you sure you want to delete this administrator?')) {
            let route = element.getAttribute('data-route');
            fetch(route, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    location.reload(); // Reload the page on success
                } else {
                    alert('Failed to delete the administrator.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting.');
            });
        }
    }
</script>
