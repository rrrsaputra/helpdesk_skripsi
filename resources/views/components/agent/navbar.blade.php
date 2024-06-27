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
                <a href="{{ route('notifications.read', $notification->id) }}">Mark as read</a>
            </li>
        @empty
            <li id="no-notifications" class="dropdown-item">No notifications available.</li>
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
            <a class="nav-link" data-toggle="dropdown" href="#" id="notification-icon">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ count($notifications) }}</span>
            </a>
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
                            <a href="{{ route('notifications.read', $notification->id) }}">Mark as read</a>
                        </li>
                    @empty
                        <li id="no-notifications" class="dropdown-item">No notifications available.</li>
                    @endforelse
                </ul>
            </div>
        </li>
        <script src="{{ mix('js/app.js') }}"></script>
        <script>
            window.Echo.channel("tickets")
                .listen("TicketSent", (event) => {
                    console.log("Event received:", event);
                    const notificationList = document.getElementById('notification-list');
                    const noNotifications = document.getElementById('no-notifications');
                    
                    if (noNotifications) {
                        noNotifications.remove();
                    }

                    const newNotification = document.createElement('li');
                    newNotification.id = `notification-${event.notification.id}`;
                    newNotification.innerHTML = `
                        ${event.notification.data.message}
                        <a href="/notifications/read/${event.notification.id}">Mark as read</a>
                    `;
                    notificationList.prepend(newNotification);

                    // Show the notification component
                    const notificationComponent = document.querySelector('.notification-component');
                    notificationComponent.style.display = 'block';
                })
                .error((error) => {
                    console.error("Error:", error);
                });

            document.getElementById('notification-icon').addEventListener('click', function() {
                const notificationComponent = document.querySelector('.notification-component');
                if (notificationComponent.style.display === 'none' || notificationComponent.style.display === '') {
                    notificationComponent.style.display = 'block';
                } else {
                    notificationComponent.style.display = 'none';
                }
            });
        </script>

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
