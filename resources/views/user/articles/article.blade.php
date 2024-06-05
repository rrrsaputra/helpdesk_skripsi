@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row vertical-gap md-gap">
                    <div class="col-lg-8">
                        <div class="dx-box dx-box-decorated">
                            <div class="dx-blog-post">
                                <div class="dx-blog-post-box pt-30 pb-30">
                                    <h2 class="h4 mnt-5 mb-5">Browse Article</h2>
                                </div>
                                <div class="dx-separator"></div>
                                <div class="dx-blog-post-box">
                                    @foreach ($articles as $article)
                                        <div class="row vertical-gap lg-gap mb-4">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $article->title }}</h5>
                                                        <div class="card-text">{{ Str::limit(strip_tags($article->content), 150) }}</div>
                                                        <a href="/single-article" class="btn btn-primary mt-10">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="dx-sticky dx-sidebar" data-sticky-offsetTop="120" data-sticky-offsetBot="40">
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title"> Subscribe to Newsletter </div>
                                <div class="dx-widget-subscribe">
                                    <div class="dx-widget-text">
                                        <p>Join the newsletter to receive news, updates, new products and freebies in your
                                            inbox.</p>
                                    </div>
                                    <form action="#" class="dx-form dx-form-group-inputs">
                                        <input type="email" name="" value="" aria-describedby="emailHelp"
                                            class="form-control form-control-style-2" placeholder="Your Email Address">
                                        <button class="dx-btn dx-btn-lg dx-btn-icon"><span
                                                class="icon fas fa-paper-plane"></span></button>
                                    </form>
                                </div>
                            </div>
                            <div class="dx-widget dx-box dx-box-decorated">
                                <form action="#" class="dx-form dx-form-group-inputs">
                                    <input type="text" name="" value=""
                                        class="form-control form-control-style-2" placeholder="Search...">
                                    <button class="dx-btn dx-btn-lg dx-btn-grey dx-btn-grey-style-2 dx-btn-icon"><span
                                            class="icon fas fa-search"></span></button>
                                </form>
                            </div>
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title">Articles Categories</div>
                                <ul class="dx-widget-categories">
                                    <li>
                                        <a href="single-article.html">
                                            <span class="icon pe-7s-angle-right"></span>
                                            <span class="dx-widget-categories-category">Quantial</span>
                                            <span class="dx-widget-categories-badge">(4)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="single-article.html">
                                            <span class="icon pe-7s-angle-right"></span>
                                            <span class="dx-widget-categories-category">Sensific</span>
                                            <span class="dx-widget-categories-badge">(4)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="single-article.html">
                                            <span class="icon pe-7s-angle-right"></span>
                                            <span class="dx-widget-categories-category">Minist</span>
                                            <span class="dx-widget-categories-badge">(8)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="single-article.html">
                                            <span class="icon pe-7s-angle-right"></span>
                                            <span class="dx-widget-categories-category">Desty</span>
                                            <span class="dx-widget-categories-badge">(2)</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="single-article.html">
                                            <span class="icon pe-7s-angle-right"></span>
                                            <span class="dx-widget-categories-category">Silies</span>
                                            <span class="dx-widget-categories-badge">(3)</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title"> Latest Articles </div>
                                <a href="single-article.html" class="dx-widget-link">
                                    <span class="dx-widget-link-text">How to manually import Demo data (if you faced with
                                        problems in one-click demo import)</span>
                                    <span class="dx-widget-link-date">6 Sep 2018</span>
                                </a>
                                <a href="single-article.html" class="dx-widget-link">
                                    <span class="dx-widget-link-text">Make menu dropdown working without JavaScript</span>
                                    <span class="dx-widget-link-date">2 Sep 2018</span>
                                </a>
                                <a href="single-article.html" class="dx-widget-link">
                                    <span class="dx-widget-link-text">Add top menu link inside dropdown on mobile
                                        devices</span>
                                    <span class="dx-widget-link-date">27 Aug 2018</span>
                                </a>
                            </div>
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title"> Latest Forum Topics </div>
                                <a href="single-article.html" class="dx-widget-link">
                                    <span class="dx-widget-link-text">Need help with customization. Some options are not
                                        appearing...</span>
                                    <span class="dx-widget-link-date">6 Sep 2018</span>
                                </a>
                                <a href="single-article.html" class="dx-widget-link">
                                    <span class="dx-widget-link-text">My images on profile and item pages doesnt show up?!
                                        Whats the matter?</span>
                                    <span class="dx-widget-link-date">2 Sep 2018</span>
                                </a>
                                <a href="single-article.html" class="dx-widget-link">
                                    <span class="dx-widget-link-text">Theme not updating in downloads</span>
                                    <span class="dx-widget-link-date">27 Aug 2018</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
