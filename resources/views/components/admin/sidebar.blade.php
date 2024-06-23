<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ asset('AdminLTE-3.2.0/index3.html" class="brand-link') }}">
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
                <li class="nav-item menu-close">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            DASHBOARD
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
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
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Unassigned</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mine</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Assigned</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Closed</p>
                                <span class="badge badge-info right">3</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item menu-close">
                    <a href="{{ route('admin.scheduled_call.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-phone-alt"></i>
                        <p>
                            SCHEDULED CALLS
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.ticket_quota.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            TICKET QUOTA
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.ticket_category.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            TICKET CATEGORY
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.article.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            ARTICLE
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.article_category.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            ARTICLE CATEGORY
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>
                
                <li class="nav-item menu-close">
                    <a href="{{ route('admin.feedback.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            FEEDBACK
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.business_hour.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-business-time"></i>
                        <p>
                            BUSINESS HOURS
                            <span class="badge badge-warning right">6</span>
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
