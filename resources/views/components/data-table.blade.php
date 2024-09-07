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
                <form action="/{{$deleteAction}}/destroy/{{$item["id"]}}" method="POST">
                    @csrf
                    <!-- CSRF token for security -->
                    @method('DELETE')
                    <!-- Spoofing DELETE method -->
                    <button type="submit" class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>