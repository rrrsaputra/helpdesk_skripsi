@props(['notifications'=>[]])

<!-- Notification Component -->
<div class="notification-component" style="display: none;">
    <ul id="notification-list" class="list-unstyled">
        @forelse ($notifications as $notification)
            <li id="notification-{{ $notification->id }}" class="dropdown-item">
                <strong>Category:</strong> {{ $notification->category }}<br>
                <strong>Title:</strong> {{ $notification->title }}<br>
                <strong>Message:</strong> {!! $notification->message !!}<br>
                <strong>Priority:</strong> {{ $notification->priority }}<br>
                <strong>Status:</strong> {{ $notification->status }}<br>
                <strong>Created At:</strong> {{ $notification->created_at }}<br>
            </li>
        @empty
            
        @endforelse
    </ul>
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ count($notifications) }} Notifications</span>
                <div class="dropdown-divider"></div>
                <ul id="notification-list" class="list-unstyled">
                    @forelse ($notifications as $notification)
                        <li id="notification-{{ $notification->id }}" class="dropdown-item">
                            <strong>Category:</strong> {{ $notification->category }}<br>
                            <strong>Title:</strong> {{ $notification->title }}<br>
                            <strong>Message:</strong> {!! $notification->message !!}<br>
                            <strong>Priority:</strong> {{ $notification->priority }}<br>
                            <strong>Status:</strong> {{ $notification->status }}<br>
                            <strong>Created At:</strong> {{ $notification->created_at }}<br>
                            
                        </li>
                    @empty
                       
                    @endforelse
                </ul>
            </div>
        </li>
        <script src="{{ mix('js/app.js') }}"></script>
     

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <li class="nav-item">
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </li>
        </form>
    </ul>
</nav>
<!-- /.navbar -->
