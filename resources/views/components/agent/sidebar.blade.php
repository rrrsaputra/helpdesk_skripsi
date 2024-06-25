<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('agent.index', ['inbox' => 'unassigned']) }}">
        <img src="{{ asset('image/logoeq.png')}}" alt="AdminLTE Logo" width="200px" class="mt-3 mx-auto d-block mb-4">
        
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ asset('image/profil.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item menu-close">
                    <a href="{{ route('agent.dashboard.index') }}" class="nav-link {{ request()->routeIs('agent.dashboard.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            DASHBOARD
                        </p>
                    </a>
                </li>
                
                <li class="nav-item menu-close">
                    <a href="#" class="nav-link {{ request()->routeIs('agent.index') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p>
                            INBOX
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ route('agent.index', ['inbox' => 'unassigned']) }}" class="nav-link {{ request()->input('inbox') == 'unassigned' ? 'active' : '' }}">
                                @if(request()->has('inbox') && request()->input('inbox') == 'unassigned')
                                    <i class="fas fa-circle nav-icon"></i>
                                
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Unassigned</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('agent.index', ['inbox' => 'mine']) }}" class="nav-link {{ request()->input('inbox') == 'mine' ? 'active' : '' }} ">
                                @if(request()->has('inbox') && request()->input('inbox') == 'mine')
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Mine</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('agent.index', ['inbox' => 'closed']) }}" class="nav-link {{ request()->input('inbox') == 'closed' ? 'active' : '' }} " >
                                @if(request()->has('inbox') && request()->input('inbox') == 'closed')
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Closed</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item menu-close">
                    <a href="{{ route('agent.scheduled_call.index') }}" class="nav-link {{ request()->routeIs('agent.scheduled_call.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-phone-alt"></i>
                        <p>
                            SCHEDULED CALLS
                        </p>
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
