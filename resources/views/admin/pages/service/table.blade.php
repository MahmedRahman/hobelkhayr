<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Service Image</th>
            <th>Service Name</th>

            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($services as $service)
        <tr>
            <td>{{ $service->id }}</td>
            <td>
                @if($service->service_image)
                <img src="{{  $service->service_image) }}" alt="Service Image" width="100">
                @else
                No Image
                @endif
            </td>
            <td>{{ $service->service_name }}</td>

            <td>{{ $service->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $service->updated_at->format('Y-m-d H:i') }}</td>
            <td>
                <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(event)">Delete</button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Check if there is a success or error message in the session
@if(session('success'))
Swal.fire({
    title: 'Success!',
    text: "{{ session('success') }}",
    icon: 'success',
    confirmButtonText: 'OK'
});
@elseif(session('error'))
Swal.fire({
    title: 'Error!',
    text: "{{ session('error') }}",
    icon: 'error',
    confirmButtonText: 'OK'
});
@endif

function confirmDelete(event) {
    event.preventDefault();
    const form = event.target.closest('form');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>