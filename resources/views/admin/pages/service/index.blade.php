@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Service Management</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                            <i class="fas fa-plus me-2"></i>Add New Service
                        </button>
                    </div>

                    @if($services->isEmpty())
                    <div class="alert alert-info">
                        No services found. Please add a new service.
                    </div>
                    @else
                    @push('styles')
<style>
    .service-image {
        max-width: 100px;
        height: auto;
        border-radius: 4px;
    }
    .action-buttons {
        white-space: nowrap;
    }
</style>
@endpush

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th width="20%">Image</th>
                <th width="30%">Name</th>
                <th width="15%">Created</th>
                <th width="15%">Updated</th>
                <th width="15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
            <tr>
                <td>{{ $service->id }}</td>
                <td class="text-center">
                    @if($service->service_image)
                        <img src="{{ asset($service->service_image) }}" alt="{{ $service->service_name }}" class="service-image">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->created_at->format('Y-m-d') }}<br><small class="text-muted">{{ $service->created_at->format('H:i') }}</small></td>
                <td>{{ $service->updated_at->format('Y-m-d') }}<br><small class="text-muted">{{ $service->updated_at->format('H:i') }}</small></td>
                <td class="action-buttons">
                    <button type="button" class="btn btn-sm btn-primary edit-service" 
                        data-id="{{ $service->id }}"
                        data-name="{{ htmlspecialchars($service->service_name, ENT_QUOTES) }}"
                        data-image="{{ $service->service_image ? asset($service->service_image) : '' }}"
                        data-bs-toggle="modal" 
                        data-bs-target="#editServiceModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(event)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No services found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Check if there is a success or error message in the session
@if(session('success'))
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
@elseif(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
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

@push('scripts')
<script>
$(document).ready(function() {
    // Handle edit button click
    $('.edit-service').on('click', function() {
        var button = $(this);
        
        // Get data using attr() instead of data()
        var id = button.attr('data-id');
        var name = button.attr('data-name');
        var image = button.attr('data-image');
        
        console.log('Edit clicked:', { id, name, image });
        
        // Set form action
        var form = $('#editServiceForm');
        form.attr('action', '/admin/services/update/' + id);
        
        // Set service name
        $('#edit_service_name').val(name);
        
        // Show current image if exists
        var currentImage = $('#currentImage');
        if (image && image.trim() !== '') {
            currentImage.attr('src', image).show();
        } else {
            currentImage.hide();
        }
        
        // Reset file input and preview
        $('#edit_service_image').val('');
        $('#editImagePreview').hide();
    });

    // Preview new image before upload
    $('#edit_service_image').on('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#editImagePreview').attr('src', e.target.result).show();
                $('#currentImage').hide();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endpush                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.pages.service.add')
@include('admin.pages.service.edit')
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Handle success messages
    @if(session()->has('success'))
        Swal.fire({
            title: 'Success!',
            text: '{!! session('success') !!}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif

    // Preview image before upload
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#service_image").change(function() {
        readURL(this, '#imagePreview');
    });

    // Confirm delete
    window.confirmDelete = function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }
});
</script>
@endsection