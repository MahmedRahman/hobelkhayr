<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
@include('admin.includes.head')

<body class="cbp-spmenu-push">
    <div class="main-content">

        @include('admin.includes.sidebar')


        <div id="page-wrapper">
            <div class="main-page container-fluid">



                <div class="col-md-12 bg-white" style="padding-top: 20px;">

                    @if($Groups->isEmpty())
                    <x-alert-info msg="No Group Found. Please add a new Group."></x-alert-info>
                    @else
                    <x-data-table :items="$Groups" :columns="$columns" :deleteAction="'deleteItem'" />
                    @endif

                </div>
            </div>
        </div>

        @include('admin.pages.user.add')
    </div>

    @include('admin.includes.footer')




</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>
function deleteItem(userId) {
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
            // Assuming you have a route set up to handle this deletion
            axios.delete(`/api/users/${userId}`)
                .then(response => {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page
                        }
                    });
                    // Optionally reload the page or remove the row from the table
                })
                .catch(error => {
                    Swal.fire(
                        'Failed!',
                        'There was a problem deleting the user.',
                        'error'
                    );
                });
        }
    });
}
</script>

</html>