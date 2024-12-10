<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
@include('admin.includes.head')

<body class="cbp-spmenu-push container fluid pt-5 pb-5">
    <div class="main-content">
        @include('admin.includes.sidebar')

        <div id="page-wrapper">
            <div class="main-page container-fluid">
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

                <h5>User Management</h5>
                <div class="col-md-12 bg-white" style="padding-top: 20px;">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUsersModal">
                            <i class="fas fa-plus me-2"></i>Add New User
                        </button>
                    </div>

                    @if($users->isEmpty())
                    <x-alert-info msg="No User Found. Please add a new User."></x-alert-info>
                    @else
                    <x-data-table :items="$users" :columns="$columns" :deleteAction="'user'" />
                    @endif
                </div>
            </div>
        </div>

        @include('admin.pages.user.add')
        @include('admin.pages.user.edit')
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
            order: [[3, 'desc']], // Sort by created_at by default
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search users..."
            }
        });

        // Handle edit button click
        $('.edit-btn').click(function() {
            var userId = $(this).data('id');
            var name = $(this).data('name');
            var phone = $(this).data('phone');
            var email = $(this).data('email');
            var role = $(this).data('role');
            var status = $(this).data('status');

            // Set form action URL
            $('#editUserForm').attr('action', '/user/' + userId);

            // Populate form fields
            $('#edit_name').val(name);
            $('#edit_phone').val(phone);
            $('#edit_email').val(email);
            $('#edit_role').val(role);
            $('#edit_status').val(status);

            // Show modal
            $('#editUserModal').modal('show');
        });
    });
    </script>
</body>
</html>