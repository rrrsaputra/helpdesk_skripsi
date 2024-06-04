<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('AdminLTE-3.2.0/index3.html" class="brand-link') }}">
        <img
            src="{{ asset('AdminLTE-3.2.0/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8') }}">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img
                    src="{{ asset('AdminLTE-3.2.0/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image') }}">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
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
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p>
                            INBOX
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ route('agent.index', ['inbox' => 'unassigned']) }}" class="nav-link">
                                @if(request()->has('inbox') && request()->input('inbox') == 'unassigned')
                                    <i class="fas fa-circle nav-icon"></i>
                                @elseif(request()->input('inbox') == '')
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Unassigned</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('agent.index', ['inbox' => 'mine']) }}" class="nav-link">
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
                            <a href="{{ route('agent.index', ['inbox' => 'assigned']) }}" class="nav-link">
                                @if(request()->has('inbox') && request()->input('inbox') == 'assigned')
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Assigned</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('agent.index', ['inbox' => 'closed']) }}" class="nav-link">
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
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Category
                            <i class="fas fa-angle-left right"></i>
                            
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../layout/top-nav.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Top Navigation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../layout/top-nav-sidebar.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Top Navigation + Sidebar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../layout/boxed.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Boxed</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../layout/fixed-sidebar.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fixed Sidebar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
