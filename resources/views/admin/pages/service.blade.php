@include('admin.includes.head')

<body class="cbp-spmenu-push">
    <div class="main-content">
        @include('admin.includes.sidebar')


        <div id=" row">
            <div class="row">

                <x-table-title title="Services List" bntText="Add Service" dataTargetModel="#addServiceModal">
                </x-table-title>


                <div class="container bg-white">
                    @if($services->isEmpty())
                    @include('admin.pages.service.empty')
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