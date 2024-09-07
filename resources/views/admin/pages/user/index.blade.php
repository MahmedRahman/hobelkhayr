@include('admin.includes.head')

<body class="cbp-spmenu-push">
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
                <x-table-title title="User Table" bntText="ADD User" dataTargetModel="#addUsersModal">
                </x-table-title>

                <div class="col-md-12 bg-white" style="padding-top: 20px;">

                    @if($users->isEmpty())
                    <x-alert-info msg="No User Found. Please add a new User."></x-alert-info>
                    @else
                    <x-data-table :items="$users" :columns="$columns" :deleteAction="'user'" />
                    @endif

                </div>
            </div>
        </div>

        @include('admin.pages.user.add')
    </div>

    @include('admin.includes.footer')
</body>

</html>