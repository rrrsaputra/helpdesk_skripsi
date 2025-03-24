<nav class="dx-navbar dx-navbar-top dx-navbar-collapse dx-navbar-sticky dx-navbar-expand-lg dx-navbar-dropdown-triangle dx-navbar-autohide"
    style="background-color: #85171A;">
    <div class="container">
        @if (request()->routeIs('user.ticket.show'))
            <a href="{{ route('user.ticket.index') }}"
                style="top: 20px; left: 20px; margin-right: 10px; background-color: #F38F2F; border-color: #F38F2F;"
                class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
            </a>
        @endif
        <a href="{{ route('home') }}" class="dx-nav-logo">
            <img src="{{ asset('image/logounggul.png') }}" alt="" width="250px" width="340px --}}">
        </a>
        <button class="dx-navbar-burger">
            <span></span><span></span><span></span>
        </button>
        <div class="dx-navbar-content">
            <ul class="dx-nav ">

                <li><a href="/" style="color: white; transition: color 0.3s;"
                        onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'"><strong>Beranda</strong></a></li>
                <li><a href="{{ route('tickets.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'"><strong>Tiket</strong></a></li>
                <li><a href="{{ route('user.faq.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'"><strong>FAQ</strong></a></li>
                <li><a href="{{ route('user.feedback.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'"><strong>Umpan Balik</strong></a></li>

            </ul>
            <ul class="dx-nav dx-nav-align-right">
                @auth
                    @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('agent')))
                        <li class="dx-nav-item">
                            <a href="{{ route('dashboard') }}" style="color: white; transition: color 0.3s;"
                                onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">
                                Dashboard
                            </a>
                        </li>
                    @endif
                @endauth

                @auth
                    <li class="dx-nav-item">
                        <a href="{{ route('profile.edit') }}" style="color: white; transition: color 0.3s;"
                            onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                @endauth
                <li class="dx-nav-item">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="" onclick="event.preventDefault(); this.closest('form').submit();"
                                        style="color: white; transition: color 0.3s;" onmouseover="this.style.color='white'"
                                        onmouseout="this.style.color='white'"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Log Out
                                    </a>

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
<div class="dx-navbar dx-navbar-fullscreen" style="background-color: #85171A;">
    <div class="container">
        <button class="dx-navbar-burger">
            <span></span><span></span><span></span>
        </button>
        <div class="dx-navbar-content">
            <ul class="dx-nav dx-nav-align-left d-flex align-items-center gap-3 mb-0">
                <li>
                    <a href="/" class="text-white fw-bold nav-link px-2" style="transition: color 0.3s; font-weight: bold;"
                        onmouseover="this.style.color='lightgray'" onmouseout="this.style.color='white'">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('tickets.index') }}" class="text-white fw-bold nav-link px-2"
                        style="transition: color 0.3s; font-weight: bold;" onmouseover="this.style.color='lightgray'"
                        onmouseout="this.style.color='white'">
                        Tiket
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.faq.index') }}" class="text-white fw-bold nav-link px-2"
                        style="transition: color 0.3s; font-weight: bold;" onmouseover="this.style.color='lightgray'"
                        onmouseout="this.style.color='white'">
                        FAQ
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.feedback.index') }}" class="text-white fw-bold nav-link px-2"
                        style="transition: color 0.3s; font-weight: bold;" onmouseover="this.style.color='lightgray'"
                        onmouseout="this.style.color='white'">
                        Umpan Balik
                    </a>
                </li>
            </ul>
            <ul class="dx-nav dx-nav-align-right">
                <li class="dx-nav-item">
                    @auth
                    <li class="dx-nav-item">
                        <a href="" style="color: white; transition: color 0.3s;"
                            onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'">
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                @endauth
                </li>

                <li class="dx-nav-item">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="" onclick="event.preventDefault(); this.closest('form').submit();"
                                        style="color: white; transition: color 0.3s;" onmouseover="this.style.color='white'"
                                        onmouseout="this.style.color='white'"
                                        class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Log Out
                                    </a>

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
</div>
<!-- END: Navbar -->
