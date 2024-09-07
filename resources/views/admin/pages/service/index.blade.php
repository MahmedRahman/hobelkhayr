@include('admin.includes.head')

<body class="cbp-spmenu-push">

    <div class="main-content">
        @include('admin.includes.sidebar')

        <div id="page-wrapper">
            <div class="main-page container-fluid">

                <x-table-title title="Group Type List" bntText="Add Service" dataTargetModel="#addServiceModal">
                </x-table-title>


                <div class="col-md-12 bg-white" style="padding-top: 20px;">
                    @if($services->isEmpty())
                    <x-alert-info msg="No services found. Please add a new service."></x-alert-info>
                    @else
                    @include('admin.pages.service.table')
                    @endif
                </div>



            </div>
        </div>
        <!-- Modal -->
        @include('admin.pages.service.add')
    </div>
    @include('admin.includes.footer')
</body>

</html>