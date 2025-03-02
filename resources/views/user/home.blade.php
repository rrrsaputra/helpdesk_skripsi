@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-separator"></div>
        <div class="dx-box-5 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center vertical-gap">

                    <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                        <div class="dx-feature dx-feature-3 dx-feature-color-4 dx-block-decorated">
                            <div class="dx-feature-icon" style="color: #F38F2F;">
                                <span class="icon pe-7s-ticket"></span>
                            </div>
                            <div class="dx-feature-cont">
                                <div class="dx-feature-title"><a href="{{ route('tickets.index') }}">Ticket System</a></div>
                                <div class="dx-feature-text">Lorem ipsum dolor sit amet.</div>
                                <a href="{{ route('tickets.index') }}"
                                    class="dx-btn dx-btn-link d-flex dx-feature-link">Lorem ipsum<span
                                        class="icon pe-7s-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                        <div class="dx-feature dx-feature-3 dx-feature-color-2 dx-block-decorated">
                            <div class="dx-feature-icon" style="color: #F38F2F;">
                                <span class="icon pe-7s-notebook"></span>
                            </div>
                            <div class="dx-feature-cont">
                                <div class="dx-feature-title"><a href="{{ route('article.index') }}">Article</a></div>
                                <div class="dx-feature-text">Lorem ipsum dolor sit amet.</div>
                                <a href="{{ route('article.index') }}"
                                    class="dx-btn dx-btn-link d-flex dx-feature-link">Lorem ipsum<span
                                        class="icon pe-7s-angle-right"></span></a>
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

                <div class="swiper-container dx-slider dx-slider-arrows dx-slider-articles" data-swiper-speed="400"
                    data-swiper-space="50" data-swiper-slides="3" data-swiper-breakpoints="true" data-swiper-arrows="true"
                    data-swiper-arrows-clone="true" data-swiper-loop="true" data-swiper-autoHeight="true"
                    data-swiper-grabCursor="true">
                    <div class="swiper-wrapper">
                        @foreach ($articleCategories as $articleCategory)
                            <div class="swiper-slide">
                                <div class="dx-article dx-article-list">
                                    <h4 class="h6 mt-0">{{ $articleCategory->name }}</h4>
                                    <ul class="dx-list">
                                        @foreach ($articleCategory->articles as $article)
                                            @if (auth()->user()->type == 'Standard' && $article->for_user == 'Standard')
                                                <li><a
                                                        href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a>
                                                </li>
                                            @elseif(auth()->user()->type == 'Premium' && in_array($article->for_user, ['Standard', 'Premium']))
                                                <li><a
                                                        href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"><span class="icon pe-7s-angle-left"></span></div>
                    <div class="swiper-button-next"><span class="icon pe-7s-angle-right"></span></div>
                </div>
            </div>
        </div>
    @endsection
