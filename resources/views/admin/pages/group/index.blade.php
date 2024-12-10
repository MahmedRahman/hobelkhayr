

@include('admin.includes.head')


<body class="cbp-spmenu-push container fluid pt-5 pb-5">
<div class="main-content">
@include('admin.includes.sidebar')

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

    <h5>Group Management</h5>
    <div class="col-md-12 bg-white" style="padding-top: 20px;">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                <i class="fas fa-plus me-2"></i>Add New Group
            </button>
        </div>

        @if($Groups->isEmpty())
        <x-alert-info msg="No Group Found. Please add a new Group."></x-alert-info>
        @else
        <x-data-table :items="$Groups" :columns="$columns" :deleteAction="'groups'" />
        @endif
    </div>
</div>
</div>
</div>
@include('admin.pages.group.add')
@include('admin.pages.group.edit')

@push('scripts')
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
            searchPlaceholder: "Search groups..."
        }
    });
});
</script>
@endpush