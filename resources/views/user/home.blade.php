@extends('layouts.user')

@section('content')
<div class="dx-main">
            
    
    <div class="dx-separator"></div>
    <div class="dx-box-5 bg-grey-6">
        <div class="container">
            <div class="row justify-content-center vertical-gap">
                
                <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                    <div class="dx-feature dx-feature-3 dx-feature-color-4 dx-block-decorated">
                        <div class="dx-feature-icon">
                            <span class="icon pe-7s-ticket"></span>
                        </div>
                        <div class="dx-feature-cont">
                            <div class="dx-feature-title"><a href="ticket.html">Ticket System</a></div>
                            <div class="dx-feature-text">Vivamus sceleriue libero velit blandit, hendrerit nisl at,dapibus sollicitudin</div>
                            <a href="ticket.html" class="dx-btn dx-btn-link d-flex dx-feature-link">Read More <span class="icon pe-7s-angle-right"></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                    <div class="dx-feature dx-feature-3 dx-feature-color-4 dx-block-decorated">
                        <div class="dx-feature-icon">
                            <span class="icon fas fa-phone-alt"></span>
                        </div>
                        <div class="dx-feature-cont">
                            <div class="dx-feature-title"><a href="ticket.html">Scheduled Call</a></div>
                            <div class="dx-feature-text">Vivamus sceleriue libero velit blandit, hendrerit nisl at,dapibus sollicitudin</div>
                            <a href="ticket.html" class="dx-btn dx-btn-link d-flex dx-feature-link">Read More <span class="icon pe-7s-angle-right"></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                    <div class="dx-feature dx-feature-3 dx-feature-color-2 dx-block-decorated">
                        <div class="dx-feature-icon">
                            <span class="icon pe-7s-notebook"></span>
                        </div>
                        <div class="dx-feature-cont">
                            <div class="dx-feature-title"><a href="articles.html">Article</a></div>
                            <div class="dx-feature-text">Aliquam id nisi sit amet massa mollis lobortis interdum felis integer</div>
                            <a href="articles.html" class="dx-btn dx-btn-link d-flex dx-feature-link">Read More <span class="icon pe-7s-angle-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dx-separator"></div>
    <div class="dx-box-5 pb-100">
        <div class="container mt-4 mnb-7">
            <div class="row align-items-center vertical-gap mnt-30 sm-gap mb-50">
                <h2 class="col-auto h4 mb-0 mt-0">Popular Articles</h2>
                <div class="col pl-30 pr-30 d-none d-sm-block">
                    <div class="dx-separator"></div>
                </div>
                <div class="col-auto dx-slider-arrows-clone"></div>
            </div>

            <div class="swiper-container dx-slider dx-slider-arrows dx-slider-articles" data-swiper-speed="400" data-swiper-space="50" data-swiper-slides="3" data-swiper-breakpoints="true" data-swiper-arrows="true" data-swiper-arrows-clone="true" data-swiper-loop="true" data-swiper-autoHeight="true" data-swiper-grabCursor="true">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="dx-article dx-article-list">
                            <h4 class="h6 mt-0">Quantial</h4>
                            <ul class="dx-list">
                                <li><a href="single-article.html">Make menu dropdown working without JavaScript</a></li>
                                <li><a href="single-article.html">Google Analytics</a></li>
                                <li><a href="single-article.html">How to manually import Demo data (if you faced with problems in one-click demo import)</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="dx-article dx-article-list">
                            <h4 class="h6 mt-0">Sensific</h4>
                            <ul class="dx-list">
                                <li><a href="single-article.html">WordPress Themes FAQ</a></li>
                                <li><a href="single-article.html">Change navbar background color</a></li>
                                <li><a href="single-article.html">Change images and banners overlay color</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="dx-article dx-article-list">
                            <h4 class="h6 mt-0">Minist</h4>
                            <ul class="dx-list">
                                <li><a href="single-article.html">Add top menu link inside dropdown on mobile devices</a></li>
                                <li><a href="single-article.html">Google Map API Warning (NoApiKeys)</a></li>
                                <li><a href="single-article.html">Make dropdown items links working</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev"><span class="icon pe-7s-angle-left"></span></div>
                <div class="swiper-button-next"><span class="icon pe-7s-angle-right"></span></div>
            </div>
        </div>
    </div>
@endsection