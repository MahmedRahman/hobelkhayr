<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
@include('admin.includes.head')

<body class="cbp-spmenu-push container fluid">
    <div class="main-content">
        @include('admin.includes.sidebar')

        <div id="page-wrapper">
            <div class="main-page container-fluid">
                <h5>Force Update Management</h5>

                <div class="col-md-12 bg-white" style="padding-top: 20px;">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUpdateModal">
                            <i class="fas fa-plus me-2"></i>Add New Version
                        </button>
                    </div>

                    @if($updates->isEmpty())
                        <x-alert-info msg="No versions found. Please add a new version." />
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Platform</th>
                                        <th>Version Number</th>
                                        <th>Force Update</th>
                                        <th>Optional Update</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($updates as $update)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $update->platform == 'android' ? 'success' : 'info' }}">
                                                {{ ucfirst($update->platform) }}
                                            </span>
                                        </td>
                                        <td>{{ $update->version_number }}</td>
                                        <td>
                                            <span class="badge bg-{{ $update->is_force_update ? 'danger' : 'warning' }}">
                                                {{ $update->is_force_update ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $update->is_optional_update ? 'info' : 'secondary' }}">
                                                {{ $update->is_optional_update ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($update->update_description, 30) }}</td>
                                        <td>{{ $update->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info edit-btn" 
                                                    data-id="{{ $update->id }}"
                                                    data-version="{{ $update->version_number }}"
                                                    data-platform="{{ $update->platform }}"
                                                    data-force="{{ $update->is_force_update }}"
                                                    data-optional="{{ $update->is_optional_update }}"
                                                    data-description="{{ $update->update_description }}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editUpdateModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-btn" 
                                                    data-id="{{ $update->id }}">
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

        <!-- Add Update Modal -->
        <div class="modal fade" id="addUpdateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Version</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addUpdateForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Platform</label>
                                <select class="form-select" name="platform" required>
                                    <option value="android">Android</option>
                                    <option value="ios">iOS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Version Number</label>
                                <input type="text" class="form-control" name="version_number" 
                                       placeholder="e.g., 1.0.0" required>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="forceUpdate" name="is_force_update" value="1">
                                    <label class="form-check-label" for="forceUpdate">Force Update</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="optionalUpdate" name="is_optional_update" value="1">
                                    <label class="form-check-label" for="optionalUpdate">Optional Update</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Update Description</label>
                                <textarea class="form-control" name="update_description" 
                                          placeholder="Describe what's new in this update" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Version</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Update Modal -->
        <div class="modal fade" id="editUpdateModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Version</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editUpdateForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="update_id" id="edit_update_id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Platform</label>
                                <select class="form-select" name="platform" id="edit_platform" required>
                                    <option value="android">Android</option>
                                    <option value="ios">iOS</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Version Number</label>
                                <input type="text" class="form-control" name="version_number" 
                                       id="edit_version_number" required>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="edit_force_update" name="is_force_update" value="1">
                                    <label class="form-check-label" for="edit_force_update">Force Update</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" 
                                           id="edit_optional_update" name="is_optional_update" value="1">
                                    <label class="form-check-label" for="edit_optional_update">Optional Update</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Update Description</label>
                                <textarea class="form-control" name="update_description" 
                                          id="edit_description" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Version</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.includes.footer')

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#dataTable').DataTable({
            order: [[5, 'desc']], // Sort by created_at by default
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search versions..."
            }
        });

        // Setup AJAX CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add Update Form Submit
        $('#addUpdateForm').on('submit', function(e) {
            e.preventDefault();
            let formData = {
                version_number: $(this).find('input[name="version_number"]').val(),
                platform: $(this).find('select[name="platform"]').val(),
                is_force_update: $(this).find('input[name="is_force_update"]').is(':checked') ? 1 : 0,
                is_optional_update: $(this).find('input[name="is_optional_update"]').is(':checked') ? 1 : 0,
                update_description: $(this).find('textarea[name="update_description"]').val()
            };
            
            $.ajax({
                url: '/api/force-updates',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        $('#addUpdateModal').modal('hide');
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Edit button click handler
        $('.edit-btn').click(function() {
            $('#edit_update_id').val($(this).data('id'));
            $('#edit_version_number').val($(this).data('version'));
            $('#edit_platform').val($(this).data('platform'));
            $('#edit_force_update').prop('checked', $(this).data('force') == 1);
            $('#edit_optional_update').prop('checked', $(this).data('optional') == 1);
            $('#edit_description').val($(this).data('description'));
        });

        // Edit Update Form Submit
        $('#editUpdateForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_update_id').val();
            
            let formData = {
                version_number: $('#edit_version_number').val(),
                platform: $('#edit_platform').val(),
                is_force_update: $('#edit_force_update').is(':checked') ? 1 : 0,
                is_optional_update: $('#edit_optional_update').is(':checked') ? 1 : 0,
                update_description: $('#edit_description').val()
            };

            $.ajax({
                url: '/api/force-updates/' + id,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        $('#editUpdateModal').modal('hide');
                        window.location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Delete Update
        $('.delete-btn').click(function() {
            if (confirm('Are you sure you want to delete this version?')) {
                var id = $(this).data('id');
                $.ajax({
                    url: '/api/force-updates/' + id,
                    method: 'DELETE',
                    success: function(response) {
                        if (response.status) {
                            window.location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
