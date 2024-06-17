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
                                                <div class="card shadow-sm border-0">
                                                    <div class="card-body">
                                                        <h5 class="card-title ">{{ $article->title }}</h5>
                                                        <div class="card-text text-muted">
                                                            {{ Str::limit(strip_tags($article->content), 150) }}
                                                        </div>
                                                        <a href="{{ route('article.show', $article->id) }}"
                                                            class="btn btn-outline-primary mt-10">Read More</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
