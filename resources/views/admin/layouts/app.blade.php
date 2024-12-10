<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.includes.head')
    @yield('styles')
</head>

<body class="cbp-spmenu-push container fluid pt-5 pb-5">
    <div class="main-content">
        @include('admin.includes.sidebar')

        <!-- main content start-->
        <div id="page-wrapper cbp-spmenu-push container fluid">
            <div class="main-page">
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

                @yield('content')
            </div>
        </div>
    </div>

    @include('admin.includes.footer')
    @yield('scripts')
</body>
</html>
