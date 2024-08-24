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

                        <form method="POST" action="{{ route('loginWithEmail') }}">
                            @csrf
                            <input id="email" type="email" name="email" placeholder="Enter Your Email" required>
                            <input id="password" type="password" name="password" placeholder="Password" required>
                            <input type="submit" value="Sign In">
                        </form>

                    </div>
                </div>

            </div>
        </div>

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
    <script src="js/classie.js"></script>
    <script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

    showLeftPush.onclick = function() {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
    };

    function disableOther(button) {
        if (button !== 'showLeftPush') {
            classie.toggle(showLeftPush, 'disabled');
        }
    }
    </script>
    <!-- //Classie -->
    <!-- //for toggle left push menu script -->

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
    <!-- //Bootstrap Core JavaScript -->

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const swalSuccess = "{{ session('swal-success') }}";
        if (swalSuccess) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: swalSuccess,
            });
        }

        const swalError =
            "{{ session('swal-error') }}"; // Make sure this matches what you set in the controller
        if (swalError) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: swalError,
            });
        }
    });
    </script>


</body>

</html>