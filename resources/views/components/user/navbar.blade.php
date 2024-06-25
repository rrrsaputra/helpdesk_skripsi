<nav
    class="dx-navbar dx-navbar-top dx-navbar-collapse dx-navbar-sticky dx-navbar-expand-lg dx-navbar-dropdown-triangle dx-navbar-autohide">
    <div class="container">
        <a href="index.html" class="dx-nav-logo">
            <img src="assets/images/logo.svg" alt="" width="88px">
        </a>
        <button class="dx-navbar-burger">
            <span></span><span></span><span></span>
        </button>
        <div class="dx-navbar-content">
            <ul class="dx-nav ">

                <li><a href="/" style="color: white; transition: color 0.3s;"
                        onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">Home</a></li>
                <li><a href="{{ route('tickets.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Ticket System</a></li>
                <li><a href="{{ route('scheduled_call.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Scheduled Calls</a></li>
                <li><a href="{{ route('article.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Articles</a></li>
                <li><a href="{{ route('user.feedback.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Feedback</a></li>

            </ul>
            <ul class="dx-nav dx-nav-align-right">

                <li class="dx-nav-item">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button style="color: white; transition: color 0.3s;"
                                        onmouseover="this.style.color='white'" onmouseout="this.style.color='white'"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Log Out
                                    </button>

                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="dx-navbar dx-navbar-fullscreen">
    <div class="container">
        <button class="dx-navbar-burger">
            <span></span><span></span><span></span>
        </button>
        <div class="dx-navbar-content">
            <ul class="dx-nav dx-nav-align-left">
                <li><a href="/" class="dx-nav-link" onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">Home</a></li>
                <li><a href="{{ route('tickets.index') }}" class="dx-nav-link" onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">Ticket System</a></li>
                <li><a href="{{ route('scheduled_call.index') }}" class="dx-nav-link" onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">Scheduled Calls</a></li>
                <li><a href="{{ route('article.index') }}" class="dx-nav-link" onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">Articles</a></li>
                <li><a href="{{ route('user.feedback.index') }}" class="dx-nav-link" onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">Feedback</a></li>
            </ul>
            <ul class="dx-nav dx-nav-align-right">
                <li class="dx-nav-item">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dx-nav-link rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" onmouseover="this.style.color='white'" onmouseout="this.style.color='white'">
                                        Log Out
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="dx-nav-link rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="dx-nav-link rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Register</a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END: Navbar -->
