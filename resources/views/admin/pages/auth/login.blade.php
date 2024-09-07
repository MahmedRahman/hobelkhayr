@include('admin.includes.head')

<body class="cbp-spmenu-push">

    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->

        </div>
        <!--left-fixed -navigation-->
        <!-- header-starts -->
        <div class="sticky-header header-section ">

            <div class="clearfix"> </div>
        </div>
        <!-- //header-ends -->
        <!-- main content start-->
        <div id="page-wrapper align-items-center h-100">
            <div class="main-page login-page main-content align-items-center">
                <h2 class="title1">Login</h2>
                <div class="widget-shadow">
                    <div class="login-body">

                        <form method="POST" action="{{route("login.post")}}">
                            @csrf
                            <input id="email" type="email" name="email" placeholder="Enter Your Email" required>
                            <input id="password" type="password" name="password" placeholder="Password" required>
                            <input type="submit" value="Sign In">

                            @error('email')
                            <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </form>

                    </div>
                </div>

            </div>
        </div>



        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <!-- side nav js -->
    <script src='js/SidebarNav.min.js' type='text/javascript'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $('.sidebar-menu').SidebarNav()
    </script>
    <!-- //side nav js -->

    <!-- Classie -->
    <!-- for toggle left push menu script -->

    <!-- //Classie -->
    <!-- //for toggle left push menu script -->

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
    <!-- //Bootstrap Core JavaScript -->




</body>

</html>