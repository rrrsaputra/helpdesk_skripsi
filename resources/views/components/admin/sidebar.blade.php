<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard.index') }}">
        <img src="{{ asset('image/logounggul.png')}}" alt="AdminLTE Logo" width="200px" class="mt-3 mx-auto d-block mb-4">
        
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
                    <a href="{{ route('admin.dashboard.index') }}" class="nav-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            DASHBOARD
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.ticket.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p>
                            INBOX
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ route('admin.ticket.index', ['inbox' => 'unassigned']) }}" class="nav-link {{ request()->input('inbox') == 'unassigned' ? 'active' : '' }} ">
                                @if(request()->has('inbox') && request()->input('inbox') == 'unassigned')
                                    <i class="fas fa-circle nav-icon"></i>
                                
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Unassigned</p>
                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ticket.index', ['inbox' => 'assigned']) }}" class="nav-link {{ request()->input('inbox') == 'assigned' ? 'active' : '' }} ">
                                @if(request()->has('inbox') && request()->input('inbox') == 'assigned')
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Assigned To</p>
                                
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.ticket.index', ['inbox' => 'closed']) }}" class="nav-link {{ request()->input('inbox') == 'closed' ? 'active' : '' }} " >
                                @if(request()->has('inbox') && request()->input('inbox') == 'closed')
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>Closed</p>
                               
                            </a>
                        </li>
                    </ul>
                </li>
                
                {{-- <li class="nav-item menu-close">
                    <a href="{{ route('admin.scheduled_call.index') }}" class="nav-link {{ request()->routeIs('admin.scheduled_call.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-phone-alt"></i>
                        <p>
                            SCHEDULED CALLS
                        </p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item menu-close">
                    <a href="{{ route('admin.scheduled_call_category.index') }}" class="nav-link {{ request()->routeIs('admin.scheduled_call_category.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            CALL CATEGORY
                        </p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item menu-close">
                    <a href="{{ route('admin.ticket_quota.index') }}" class="nav-link {{ request()->routeIs('admin.ticket_quota.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            TICKET QUOTA
                        </p>
                    </a>
                </li> --}}

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.ticket_category.index') }}" class="nav-link {{ request()->routeIs('admin.ticket_category.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            TICKET CATEGORY
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item menu-close">
                    <a href="{{ route('admin.article.index') }}" class="nav-link {{ request()->routeIs('admin.article.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            ARTICLE
                        </p>
                    </a>
                </li> --}}

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.faq.index') }}" class="nav-link {{ request()->routeIs('admin.faq.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            FAQ
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.faq_category.index') }}" class="nav-link {{ request()->routeIs('admin.faq_category.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            FAQ CATEGORY
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item menu-close">
                    <a href="{{ route('admin.article_category.index') }}" class="nav-link {{ request()->routeIs('admin.article_category.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            ARTICLE CATEGORY
                        </p>
                    </a>
                </li> --}}
                
                <li class="nav-item menu-close">
                    <a href="{{ route('admin.feedback.index') }}" class="nav-link {{ request()->routeIs('admin.feedback.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>
                            FEEDBACK
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item menu-close">
                    <a href="{{ route('admin.triggers.index') }}" class="nav-link {{ request()->routeIs('admin.triggers.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            TRIGGER
                        </p>
                    </a>
                </li> --}}

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.data_repository.index') }}" class="nav-link {{ request()->routeIs('admin.data_repository.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            DATA REPOSITORY
                        </p>
                    </a>
                </li>
                
                <li class="nav-item menu-close">
                    <a href="{{ route('admin.user_management.index') }}" class="nav-link {{ request()->routeIs('admin.user_management.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            USER MANAGEMENT
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.report.index') }}" class="nav-link {{ request()->routeIs('admin.report.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-excel"></i>
                        <p>
                            REPORT
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('admin.study_programs.index') }}" class="nav-link {{ request()->routeIs('admin.study_programs.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            STUDY PROGRAMS
                        </p>
                    </a>
                </li>

                <li class="nav-item menu-close">
                    <a href="{{ route('user.ticket.index') }}" class="nav-link {{ request()->routeIs('user.ticket.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            USER VIEW
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
