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
      
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <li class="nav-item">
            <button >
              <i class="fas fa-sign-out-alt"></i>
            </button>
          </li>
        </form>
    </ul>
  </nav>
  <!-- /.navbar -->