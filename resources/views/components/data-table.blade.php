<div class="table-responsive">
    @include('components.search-box')
    
    <table class="table">
        <thead>
            <tr>
                @foreach ($columns as $column)
                <th>{{ $column['name'] }}</th>
                @endforeach
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                @foreach ($columns as $column)
                @if($column['field'] == 'location')
                <td>{!! $item->{$column['field']} !!}</td>
                @else
                <td>{{ $item->{$column['field']} }}</td>
                @endif
                @endforeach
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary btn-sm edit-btn me-2"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}"
                            data-phone="{{ $item->phone }}"
                            data-email="{{ $item->email }}"
                            data-role="{{ $item->role }}"
                            data-status="{{ $item->status }}">
                            Edit
                        </button>
                        <form action="/{{$deleteAction}}/destroy/{{$item->id}}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            order: [[0, 'asc']], // Sort by ID by default
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            }
        });
    });
</script>
@endpush