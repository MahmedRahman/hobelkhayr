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
                <h1>

                    <a class="navbar-brand" href="#"><span class="fa fa-area-chart">

                        </span> khayr <span class="dashboard_text"></span></a>
                </h1>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview {{ request()->is('admin*') ? 'active' : '' }}">
                        <a href="{{ url('/admin') }}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="treeview {{ request()->is('user*') ? 'active' : '' }}">
                        <a href="{{ url('/user') }}">
                            <i class="fa fa-dashboard"></i> <span>User</span>
                        </a>
                    </li>

                    <li class="treeview {{ request()->is('notification*') ? 'active' : '' }}">
                        <a href="{{ url('/notification') }}">
                            <i class="fa fa-dashboard"></i> <span>Notification</span>
                        </a>
                    </li>

                    <li class="treeview {{ request()->is('services*') ? 'active' : '' }}">
                        <a href="{{ url('/services') }}">
                            <i class="fa fa-dashboard"></i> <span>Groups Type</span>
                        </a>
                    </li>

                    <li class="treeview {{ request()->is('groups*') ? 'active' : '' }}">
                        <a href="{{ url('/groups') }}">
                            <i class="fa fa-dashboard"></i> <span>Groups</span>
                        </a>
                    </li>


                    <li class="treeview">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-link treeview" style="">
                                <i class="fa fa-sign-out"></i> <span>Logout</span>
                            </button>
                        </form>
                    </li>

                    <!-- 
                    <li class="treeview {{ request()->is('static*') ? 'active' : '' }}">
                        <a href="{{ url('/static') }}">
                            <i class="fa fa-dashboard"></i> <span>Static Page</span>
                        </a>
                    </li> -->

                    <!-- <li class="treeview">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="fa fa-dashboard"><span>Logout</span> </button>
                        </form>
                    </li> -->
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </aside>

</div>