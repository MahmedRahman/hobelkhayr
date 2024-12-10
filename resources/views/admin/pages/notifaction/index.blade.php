@extends('admin.layouts.app')

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Notifications Management</h6>
                    <div>
                        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#sendToAllModal">
                            <i class="fas fa-broadcast-tower me-2"></i>Send to All Users
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
                            <i class="fas fa-plus me-2"></i>Send New Notification
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($notifications->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>No notifications found. Use the buttons above to send notifications.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="notificationsTable">
                                <thead class="table-light">
                                    <tr>
                                    <th>id</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Recipients</th>
                                        <th>Status</th>
                                        <th>Sent At</th>
                                        <th width="120px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notifications as $notification)
                                        <tr>
                                        <td>{{ $notification->id }}</td>
                                            <td>{{ $notification->title }}</td>
                                            <td>{{ Str::limit($notification->body, 50) }}</td>
                                            <td class="text-center">
                                                @if($notification->send_to_all)
                                                    <span class="badge bg-info">All Users</span>
                                                @else
                                                    <span class="badge bg-primary">{{ count($notification->user_ids ?? []) }} Users</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @switch($notification->status)
                                                    @case('sent')
                                                        <span class="badge bg-success">Sent</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge bg-danger">Failed</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $notification->sent_at ? $notification->sent_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-info me-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewNotificationModal"
                                                        data-id="{{ $notification->id }}"
                                                        data-title="{{ $notification->title }}"
                                                        data-body="{{ $notification->body }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-notification" 
                                                        data-id="{{ $notification->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Notification Modal -->
<div class="modal fade" id="addNotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send New Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addNotificationForm" action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="body" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="send_to_all" id="sendToAll" value="1" required>
                            <label class="form-check-label" for="sendToAll">
                                Send to all users
                            </label>
                        </div>
                    </div>
                    <div class="mb-3" id="userSelectDiv" style="display: none;">
                        <label class="form-label">Select Users</label>
                        <select class="form-select select2" name="user_ids[]" multiple style="width: 100%">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Search by name or phone number</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Notification Modal -->
<div class="modal fade" id="viewNotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <div id="viewTitle" class="border rounded p-2"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <div id="viewBody" class="border rounded p-2"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Select2 JS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    // Initialize DataTable
    if($.fn.DataTable) {
        console.log('DataTable is loaded');
        var table = $('#notificationsTable').DataTable({
            responsive: true,
            order: [[4, 'desc']], // Sort by sent_at column by default
            pageLength: 10,
            language: {
                search: "Search notifications:"
            }
        });
    } else {
        console.error('DataTable is not loaded');
    }

    // Initialize Select2
    if($.fn.select2) {
        console.log('Select2 is loaded');
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select users',
            allowClear: true
        });
    } else {
        console.error('Select2 is not loaded');
    }

    // Handle send to all checkbox
    $('#sendToAll').change(function() {
        if($(this).is(':checked')) {
            $('#userSelectDiv').hide();
            $('.select2').prop('required', false);
            $('.select2').val(null).trigger('change');
        } else {
            $('#userSelectDiv').show();
            $('.select2').prop('required', true);
        }
    });

    // Trigger the change event on page load to set initial state
    $('#sendToAll').trigger('change');

    // Handle delete notification - Use event delegation with debug
    $(document).on('click', '.delete-notification', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var button = $(this);
        var id = button.data('id');
        var row = button.closest('tr');
        
        console.log('Delete button clicked');
        console.log('Notification ID:', id);
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This notification will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable the delete button
                button.prop('disabled', true);
                
                $.ajax({
                    url: '{{ route("admin.notifications.destroy", "") }}/' + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        console.log('Server response:', response);
                        
                        if(response.success) {
                            // Remove row from DataTable
                            table.row(row).remove().draw(false);
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 1500
                            });
                        } else {
                            // Re-enable the delete button
                            button.prop('disabled', false);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr);
                        
                        // Re-enable the delete button
                        button.prop('disabled', false);
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong while deleting.'
                        });
                    }
                });
            }
        });
    });

    // Handle view notification
    $('#viewNotificationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var title = button.data('title');
        var body = button.data('body');
        
        $('#viewTitle').html(title);
        $('#viewBody').html(body);
    });

    // Form validation
    $('#addNotificationForm').submit(function(e) {
        var title = $('input[name="title"]').val();
        var body = $('textarea[name="body"]').val();
        var sendToAll = $('#sendToAll').is(':checked');
        var selectedUsers = $('.select2').val();

        if (!title || !body) {
            e.preventDefault();
            Swal.fire(
                'Error!',
                'Please fill in all required fields.',
                'error'
            );
            return false;
        }

        if (!sendToAll && (!selectedUsers || selectedUsers.length === 0)) {
            e.preventDefault();
            Swal.fire(
                'Error!',
                'Please select at least one user or choose to send to all users.',
                'error'
            );
            return false;
        }

        return true;
    });
});
</script>
@endsection