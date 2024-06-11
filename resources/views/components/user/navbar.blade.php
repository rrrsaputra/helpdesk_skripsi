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
                <li><a href="{{ route('ticket') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Ticket System</a></li>
                <li><a href="{{ route('article.index') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Articles</a></li>
                <li><a href="{{ route('scheduled_call') }}"
                        style="color: white; transition: color 0.3s;"onmouseover="this.style.color='grey'"
                        onmouseout="this.style.color='white'">Scheduled Calls</a></li>

            </ul>
            <ul class="dx-nav dx-nav-align-right">

                <li class="dx-nav-item">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button style="color: white; transition: color 0.3s;"
                                        onmouseover="this.style.color='grey'" onmouseout="this.style.color='white'"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-black">
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
                    {{-- <a class="dx-nav-link" data-fancybox data-touch="false" data-close-existing="true"
                        data-src="#login" href="javascript:;">Log In</a>
                </li>
                <li class="dx-nav-item">
                    <span><a data-fancybox data-touch="false" data-close-existing="true" data-src="#signup"
                            href="javascript:;" class="dx-btn dx-btn-md dx-btn-transparent">Sign Up</a></span> --}}
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
                <li class="dx-nav-item dx-nav-item-drop">
                    <a class="dx-nav-link" href="store.html"> Store </a>
                    <ul class="dx-navbar-dropdown">
                        <li>
                            <a class="dx-nav-link" href="store.html"> Store </a>
                        </li>
                        <li>
                            <a class="dx-nav-link" href="product.html"> Product </a>
                        </li>
                        <li>
                            <a class="dx-nav-link" href="checkout.html"> Checkout </a>
                        </li>
                        <div class="dx-navbar-dropdown-triangle"></div>
                    </ul>
                </li>
                <li class="dx-nav-item dx-nav-item-drop">
                    <a class="dx-nav-link" href="blog.html"> Blog </a>
                    <ul class="dx-navbar-dropdown">
                        <li>
                            <a class="dx-nav-link" href="blog.html"> Blog </a>
                        </li>
                        <li>
                            <a class="dx-nav-link" href="single-post.html"> Single Post </a>
                        </li>
                        <div class="dx-navbar-dropdown-triangle"></div>
                    </ul>
                </li>
                <li class="dx-nav-item dx-nav-item-drop active">
                    <a class="dx-nav-link" href="help-center.html"> Help Center </a>
                    <ul class="dx-navbar-dropdown">
                        <li>
                            <a class="dx-nav-link" href="help-center.html"> Help Center </a>
                        </li>
                        <li class="dx-nav-item dx-nav-item-drop">
                            <a class="dx-nav-link" href="documentations.html"> Documentations </a>
                            <ul class="dx-navbar-dropdown">
                                <li>
                                    <a class="dx-nav-link" href="documentations.html"> Documentations </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="single-documentation.html"> Single documentation </a>
                                </li>
                                <div class="dx-navbar-dropdown-triangle"></div>
                            </ul>
                        </li>
                        <li class="dx-nav-item dx-nav-item-drop">
                            <a class="dx-nav-link" href="articles.html"> Knowledge Base </a>
                            <ul class="dx-navbar-dropdown">
                                <li>
                                    <a class="dx-nav-link" href="articles.html"> Knowledge Base </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="single-article-category.html"> Single Article
                                        Category </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="single-article.html"> Single Article </a>
                                </li>
                                <div class="dx-navbar-dropdown-triangle"></div>
                            </ul>
                        </li>
                        <li class="dx-nav-item dx-nav-item-drop">
                            <a class="dx-nav-link" href="forums.html"> Forums </a>
                            <ul class="dx-navbar-dropdown">
                                <li>
                                    <a class="dx-nav-link" href="forums.html"> Forums </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="topics.html"> Topics </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="single-topic.html"> Single Topic </a>
                                </li>
                                <div class="dx-navbar-dropdown-triangle"></div>
                            </ul>
                        </li>
                        <li class="dx-nav-item dx-nav-item-drop active">
                            <a class="dx-nav-link" href="ticket.html"> Ticket System </a>
                            <ul class="dx-navbar-dropdown">
                                <li class="dx-nav-item active">
                                    <a class="dx-nav-link" href="ticket.html"> Ticket System </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="ticket-submit.html"> Submit Ticket </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="ticket-submit-2.html"> Submit Ticket 2 </a>
                                </li>
                                <li>
                                    <a class="dx-nav-link" href="single-ticket.html"> Single Ticket </a>
                                </li>
                                <div class="dx-navbar-dropdown-triangle"></div>
                            </ul>
                        </li>
                        <div class="dx-navbar-dropdown-triangle"></div>
                    </ul>
                </li>
                <li class="dx-nav-item dx-nav-item-drop">
                    <a class="dx-nav-link" href="account.html"> Account </a>
                    <ul class="dx-navbar-dropdown">
                        <li>
                            <a class="dx-nav-link" href="account.html"> Account </a>
                        </li>
                        <li>
                            <a class="dx-nav-link" href="account-licenses.html"> Licenses </a>
                        </li>
                        <li>
                            <a class="dx-nav-link" href="account-settings.html"> Settings </a>
                        </li>
                        <div class="dx-navbar-dropdown-triangle"></div>
                    </ul>
                </li>
            </ul>
            <ul class="dx-nav dx-nav-align-right">
                <li>
                    <a class="dx-nav-icon" href="checkout.html">
                        <span class="dx-nav-badge">2</span>
                        <span class="icon dx-icon-bag"></span>
                    </a>
                </li>
                <li>
                    <a data-fancybox data-touch="false" data-close-existing="true" data-src="#login"
                        href="javascript:;">Log In</a>
                </li>
                <li>
                    <span><a data-fancybox data-touch="false" data-close-existing="true" data-src="#signup"
                            href="javascript:;" class="dx-btn dx-btn-md dx-btn-transparent">Sign Up</a></span>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END: Navbar -->
