<table class="table">
    <thead>
        <tr>
            @foreach ($columns as $column)
            <th>{{ $column['name'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            @foreach ($columns as $column)
            <td>{{ $item->{$column['field']} }}</td>
            @endforeach
            <td>
                @if ($deleteAction)
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem({{ $item->id }})">
                    Delete
                </button>
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>