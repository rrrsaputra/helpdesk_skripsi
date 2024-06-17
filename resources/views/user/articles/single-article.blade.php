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
                                    <h1 class="h4 mnt-5 mb-8">{{ $article->title }}</h1>
                                    <ul class="dx-blog-post-info mnt-10 mnb-2">
                                        <li>By {{ $article->user->name }}</li>
                                        <li>Published {{ $article->created_at->format('d F Y') }}</li>
                                        <li>Views</li>
                                    </ul>
                                    <ul class="dx-social-links dx-social-links-style-2 mt-20">
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                                                target="_blank" class="dx-social-link dx-social-link-facebook"><span
                                                    class="fab fa-facebook-f" style="color: black;"></span></a></li>
                                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}"
                                                target="_blank" class="dx-social-link dx-social-link-twitter"><span
                                                    class="fab fa-twitter" style="color: black;"></span></a></li>
                                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(Request::fullUrl()) }}"
                                                target="_blank" class="dx-social-link dx-social-link-linkedin"><span
                                                    class="fab fa-linkedin-in" style="color: black;"></span></a></li>
                                        <li><a href="https://wa.me/?text={{ urlencode(Request::fullUrl()) }}"
                                                target="_blank" class="dx-social-link dx-social-link-whatsapp"><span
                                                    class="fab fa-whatsapp" style="color: black;"></span></a></li>
                                    </ul>
                                </div>

                                <div class="dx-separator"></div>

                                <div class="dx-blog-post-box">
                                    <p>{{ strip_tags($article->content) }}</p>
                                </div>
                                <div class="dx-separator"></div>

                            </div>
                        </div>
                        <div class="dx-box dx-box-content dx-box-decorated mt-40">
                            <div class="row vertical-gap align-items-center justify-content-center">
                                <div class="col-auto">
                                    <h3 class="h5 mnt-6 mnb-6">Was this helpful to you?</h3>
                                </div>
                                <div class="col-auto d-flex">
                                    <a href="#" class="dx-btn dx-btn-md dx-btn-main-1">Yes</a>
                                    <a href="#" class="dx-btn dx-btn-md dx-btn-grey-2 ml-20">No</a>
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
@endsection
