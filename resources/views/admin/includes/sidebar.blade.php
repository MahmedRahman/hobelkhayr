<!--left-fixed -navigation-->
<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-lef " id="cbp-spmenu-s1">

    <aside class="sidebar-left">
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
                    aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <h1><a class="navbar-brand" href="index.html"><span class="fa fa-area-chart"></span> Glance<span
                            class="dashboard_text">Hello</span></a></h1>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="{{ url('/admin') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>


                    <li class="treeview">
                        <a href="{{ url('/user') }}">
                            <i class="fa fa-dashboard"></i> <span>user</span>
                        </a>
                    </li>





                    <li class="treeview">
                        <a href="{{ url('/notifaction') }}">
                            <i class="fa fa-dashboard"></i> <span>Notifaction</span>
                        </a>
                    </li>


                    <li class="treeview">
                        <a href="{{ url('/services') }}">
                            <i class="fa fa-dashboard"></i> <span>Groups Type</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="{{ url('/groups') }}">
                            <i class="fa fa-dashboard"></i> <span>Groups</span>
                        </a>
                    </li>




                    <li class="treeview">
                        <a href="{{ url('/static') }}">
                            <i class="fa fa-dashboard"></i> <span>Static Page</span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="{{ url('/login') }}">
                            <i class="fa fa-dashboard"></i> <span>login in</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </aside>

</div>