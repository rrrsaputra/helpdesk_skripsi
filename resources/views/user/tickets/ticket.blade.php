@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-separator"></div>
        <div class="dx-box-5 bg-grey-6">
            <div class="container">

                <div class="row align-items-center justify-content-between vertical-gap mnt-30 sm-gap mb-50">
                    <div class="col-auto">
                        <h2 class="h4 mb-0 mt-0">Pertanyaan Anda</h2>
                    </div>
                    <div class="col pl-30 pr-30 d-none d-sm-block">
                        <div class="dx-separator ml-10 mr-10"></div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('user.ticket.create') }}" class="dx-btn dx-btn-md"
                            style="background-color: #F38F2F;">Buat Tiket</a>
                    </div>
                </div>

                <div class="row vertical-gap md-gap">
                    <div class="col-lg-8">
                        @if ($tickets->isEmpty())
                            <p class="text-center">Tiket Pertanyaan Tidak Ditemukan</p>
                        @else
                            @foreach ($tickets as $ticket)
                                <a href="{{ route('user.ticket.show', $ticket->id) }}"
                                    class="dx-ticket-item dx-ticket-new dx-ticket-open dx-block-decorated">
                                    <span class="dx-ticket-cont">
                                        <span class="dx-ticket-name">{{ $ticket->user->name }}</span>
                                        <span class="dx-ticket-title h5" style="color: black">{{ $ticket->references . ' - ' . $ticket->title }}</span>
                                        <p class="dx-ticket-paragraph mt-8" style="color: black">{{ strip_tags($ticket->message) }}</p>
                                        <ul class="dx-ticket-info">
                                            <li>Created: {{ $ticket->updated_at->format('d M Y') }}</li>
                                            <li>Category: {{ $ticket->category }}</li>
                                            @php $newMessagesCount = $ticket->messages->where('user_id', '!=', Auth::id())->where('is_read', '')->count(); @endphp
                                            @if ($newMessagesCount > 0)
                                                <li style="color: blue; font-weight: bold;">New Messages: {{ $newMessagesCount }}</li>
                                            @endif
                                            @if ($ticket->is_new)
                                                <li class="dx-ticket-new">New</li>
                                            @endif
                                        </ul>
                                    </span>
                                    <span class="dx-ticket-status">{{ $ticket->status }}</span>
                                </a>
                            @endforeach
                        @endif
                        <div class="mt-20">
                            {{ $tickets->links() }}
                        </div>
                    </div>

                    <div class="col-lg-4 mt-25">
                        <div class="dx-widget dx-box dx-box-decorated">
                            <form action="{{ route('user.ticket.index') }}" class="dx-form dx-form-group-inputs">
                                <input type="search" name="search" value="{{ request()->query('search') }}"
                                    class="form-control form-control-style-2" placeholder="Search...">
                                <button class="dx-btn dx-btn-lg dx-btn-grey dx-btn-grey-style-2 dx-btn-icon"><span
                                        class="icon fas fa-search"></span></button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100">
            <div class="container mt-4 mnb-7">
                <div class="row align-items-center justify-content-between vertical-gap mnt-30 sm-gap mb-50">
                    <h2 class="col-auto h4 mb-0 mt-0">Artikel Unggulan</h2>
                    <div class="col pl-30 pr-30 d-none d-sm-block">
                        <div class="dx-separator ml-10 mr-10"></div>
                    </div>
                    <div class="col-auto dx-slider-arrows-clone"></div>
                </div>

                <div class="swiper-container dx-slider dx-slider-arrows dx-slider-articles" data-swiper-speed="400"
                    data-swiper-space="50" data-swiper-slides="3" data-swiper-breakpoints="true" data-swiper-arrows="true"
                    data-swiper-arrows-clone="true" data-swiper-loop="true" data-swiper-autoHeight="true"
                    data-swiper-grabCursor="true">
                    <div class="swiper-wrapper">
                        @foreach ($articles as $article)
                            <div class="swiper-slide">
                                <div class="dx-article dx-article-block">
                                    <h4 class="h6 dx-article-title">{{ $article->title }}</h4>
                                    <div class="dx-article-text">
                                        <p class="mb-0">{{ Str::limit(strip_tags($article->content), 150) }}</p>
                                    </div>
                                    <a href="{{ route('article.show', $article->id) }}"
                                        class="dx-btn dx-btn-link d-flex dx-article-link">Read More
                                        <span class="icon pe-7s-angle-right"></span></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"><span class="icon pe-7s-angle-left"></span></div>
                    <div class="swiper-button-next"><span class="icon pe-7s-angle-right"></span></div>
                </div>
            </div>
        </div>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="dx-popup dx-popup-signin" id="login">
        <button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="Close"><svg
                xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
        <div class="dx-signin-content dx-signin text-center">
            <h1 class="h3 text-white mb-30">Log In</h1>
            <form action="#" class="dx-form">
                <div class="dx-form-group-md">
                    <a href="account.html"
                        class="dx-btn dx-btn-block dx-btn-popup dx-btn-envato d-flex align-items-center justify-content-center">
                        <span class="fas fa-leaf mr-20"></span><span>Log in with Envato</span>
                    </a>
                </div>
                <div class="dx-form-group-md">
                    <div class="dx-signin-or">OR</div>
                </div>
                <div class="dx-form-group-md">
                    <input type="text" class="form-control form-control-style-4" placeholder="Username Or Email">
                </div>
                <div class="dx-form-group-md">
                    <input type="password" class="form-control form-control-style-4" placeholder="Password">
                </div>
                <div class="dx-form-group-md">
                    <a href="account.html" class="dx-btn dx-btn-block dx-btn-popup">Log In</a>
                </div>
                <div class="dx-form-group-md">
                    <div class="d-flex justify-content-between">
                        <a data-fancybox data-touch="false" data-close-existing="true" data-src="#reset-password"
                            href="javascript:;">Reset your password</a>
                        <a data-fancybox data-touch="false" data-close-existing="true" data-src="#signup"
                            href="javascript:;">Sign Up</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="dx-popup dx-popup-signin" id="signup">
        <button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="Close"><svg
                xmlns="http://www.w3.org/2000/svg" version="10" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
        <div class="dx-popup-content dx-signin text-center">
            <h1 class="h3 text-white mb-30">Sign Up</h1>
            <form action="#" class="dx-form">
                <div class="dx-form-group-md">
                    <a href="account.html"
                        class="dx-btn dx-btn-block dx-btn-popup dx-btn-envato d-flex align-items-center justify-content-center">
                        <span class="fas fa-leaf mr-20"></span><span>Sign Up with Envato</span>
                    </a>
                </div>
                <div class="dx-form-group-md">
                    <div class="dx-signin-or">OR</div>
                </div>
                <div class="dx-form-group-md">
                    <input type="text" class="form-control form-control-style-4" placeholder="Username">
                </div>
                <div class="dx-form-group-md">
                    <input type="email" class="form-control form-control-style-4" aria-describedby="emailHelp"
                        placeholder="Email">
                </div>
                <div class="dx-form-group-md">
                    <input type="password" class="form-control form-control-style-4" placeholder="Password">
                </div>
                <div class="dx-form-group-md">
                    <input type="password" class="form-control form-control-style-4" placeholder="Confirm password">
                </div>
                <div class="dx-form-group-md">
                    <a href="account.html" class="dx-btn dx-btn-block dx-btn-popup">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
    <div class="dx-popup dx-popup-signin" id="reset-password">
        <button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="Close"><svg
                xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
        <div class="dx-popup-content dx-signin text-center">
            <h1 class="h3 text-white mb-30">Reset Password</h1>
            <form action="#" class="dx-form">
                <div class="dx-form-group-md">
                    <input type="email" class="form-control form-control-style-4" aria-describedby="emailHelp"
                        placeholder="Email">
                </div>
                <div class="dx-form-group-md">
                    <button class="dx-btn dx-btn-block dx-btn-popup">Reset My Password</button>
                </div>
            </form>
        </div>
    </div>
    <div id="subscribe" class="dx-popup dx-popup-modal dx-popup-subscribe">
        <button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="Close"><svg
                xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24">
                <path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path>
            </svg></button>
        <div class="dx-box dx-box-decorated">
            <div class="dx-box-content">
                <h6 class="mnt-5 mnb-5">Subscribe to Newsletter</h6>
            </div>
            <div class="dx-separator"></div>
            <div class="dx-box-content">
                <p class="mnt-5 fs-15">Join the newsletter to receive news, updates, new products and freebies in your
                    inbox.</p>
                <form action="#" class="dx-form dx-form-group-inputs">
                    <input type="email" name="" value="" aria-describedby="emailHelp"
                        class="form-control form-control-style-2" placeholder="Your Email Address">
                    <button class="dx-btn dx-btn-lg dx-btn-icon"><span class="icon fas fa-paper-plane"></span></button>
                </form>
            </div>
        </div>
    </div>
@endsection
