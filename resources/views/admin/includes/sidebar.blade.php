<div class="admin-sidebar">
    <div class="sidebar-header p-3 border-bottom">
        <div class="d-flex align-items-center">
            <img src="https://img.icons8.com/color/96/000000/helping--v1.png" alt="HobelKhayr Logo" class="sidebar-logo" style="width: 40px; height: 40px;">
            <h5 class="mb-0 ms-2 text-primary fw-bold">HobelKhayr</h5>
        </div>
    </div>

    <div class="sidebar-content">
        <div class="user-info p-3 border-bottom">
            <div class="d-flex align-items-center">
                <div class="user-avatar">
                    <i class="fas fa-user-circle fa-2x text-primary"></i>
                </div>
                <div class="ms-2">
                    <p class="mb-0 fw-bold">{{ auth()->user()->name }}</p>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav p-3">
            <div class="nav-section mb-3">
                <small class="text-uppercase text-muted fw-bold">Main Navigation</small>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('user*') ? 'active' : '' }}" 
                       href="{{ url('/user') }}">
                        <i class="fas fa-users me-2"></i>
                        <span>Users</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('service*') ? 'active' : '' }}" 
                       href="{{ url('/services') }}">
                        <i class="fas fa-layer-group me-2"></i>
                        <span>Groups Type</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('groups*') ? 'active' : '' }}" 
                       href="{{ url('/groups') }}">
                        <i class="fas fa-users-cog me-2"></i>
                        <span>Groups</span>
                    </a>
                </li>

         


            </ul>

            <div class="nav-section mb-3">
                <small class="text-uppercase text-muted fw-bold">System</small>
            </div>
            <ul class="nav flex-column">
            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.notifications.index') }}">
                                    <i class="fas fa-bell me-2"></i>
                                    <span>Notifications</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center {{ request()->routeIs('admin.force-updates.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.force-updates.index') }}">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    <span>Force Update</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.settings.index') }}">
                                    <i class="fas fa-fw fa-cog"></i>
                                    <span>System Settings</span>
                                </a>
                            </li>

                            </ul>
            <div class="nav-section mt-4 mb-3">
                <small class="text-uppercase text-muted fw-bold">Account</small>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="nav-link">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger p-0 d-flex align-items-center w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
    .admin-sidebar {
        background: white;
        height: 100vh;
        overflow-y: auto;
    }

    .nav-link {
        color: #6c757d;
        padding: 0.75rem 1rem;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
    }

    .nav-link.active {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.1);
        font-weight: 600;
    }

    .nav-link i {
        width: 20px;
        text-align: center;
    }

    .sidebar-logo {
        transition: transform 0.3s ease;
    }

    .sidebar-logo:hover {
        transform: scale(1.1);
    }

    /* System submenu styles */
    #systemCollapse {
        transition: all 0.3s ease;
    }

    #systemCollapse .nav-link {
        padding-left: 2.5rem;
        font-size: 0.95rem;
    }

    .nav-link[data-bs-toggle="collapse"] .fa-chevron-down {
        transition: transform 0.3s ease;
    }

    .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Submenu animation */
    .collapse {
        transition: all 0.3s ease;
    }

    .collapse.show {
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: 0.25rem;
    }

    /* User avatar styles */
    .user-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(13, 110, 253, 0.1);
    }

    /* Logout button styles */
    .btn-link {
        text-decoration: none;
    }

    .btn-link:hover {
        text-decoration: none;
        color: #dc3545 !important;
    }

    /* Custom scrollbar */
    .admin-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>