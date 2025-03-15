@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-separator"></div>

        <div class="dx-banner" style="font-size: 1.2em;">
            <div class="overflow-hidden whitespace-nowrap">
                <div id="marquee-container" class="inline-block pl-full">
                    <p id="marquee-text" class="inline-block">
                        Jam Operasional BAA: Senin - Jumat: 08:00 - 17:00, Sabtu: 08:00 - 13:00, Tutup pada hari Minggu
                        &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;Info layanan BAA dapat diakses melalui link <a
                            href="https://linktr.ee/baaubakrie" target="_blank">linktr.ee/baaubakrie</a>
                    </p>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const marqueeContainer = document.getElementById('marquee-container');
                const marqueeText = document.getElementById('marquee-text');
                let startPosition = 0;

                function animateMarquee() {
                    startPosition--;
                    if (startPosition < -marqueeText.offsetWidth) {
                        startPosition = 0;
                    }
                    marqueeContainer.style.transform = `translateX(${startPosition}px)`;
                    requestAnimationFrame(animateMarquee);
                }
                animateMarquee();
            });
        </script>

        <div class="dx-box-5 bg-grey-6">
            <div class="container">
                <div class="row align-items-center vertical-gap mnt-30 sm-gap mb-50">
                    <h2 class="col-auto h4 mb-0 mt-0">Pertanyaan yang Sering Diajukan</h2>
                    <div class="col pl-30 pr-30 d-none d-sm-block">
                        <div class="dx-separator"></div>
                    </div>
                </div>
                <div class="row justify-content-center vertical-gap">
                    @foreach ($faqCategories as $faqCategory)
                        <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                            <div class="dx-feature dx-feature-3 dx-feature-color-4 dx-block-decorated" style="height: 300px;">
                                <div class="dx-feature-icon" style="color: #F38F2F;">
                                    <span class="icon pe-7s-help1"></span>
                                </div>
                                <div class="dx-feature-cont">
                                    <div class="dx-feature-title">{{ $faqCategory->name }}</div>
                                    <div class="dx-feature-text">{{ $faqCategory->description }}</div>
                                    <a href="{{ route('user.faq_category.show', $faqCategory->slug) }}"
                                        class="dx-btn dx-btn-link d-flex dx-feature-link">Lihat FAQ<span
                                            class="icon pe-7s-angle-right"></span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="dx-box-5 bg-grey-6">
            <div class="container">
                <div class="row align-items-center vertical-gap mnt-30 sm-gap mb-50">
                    <h2 class="col-auto h4 mb-0 mt-0">Tidak Menemukan Jawaban yang Dicari?</h2>
                    <div class="col pl-30 pr-30 d-none d-sm-block">
                        <div class="dx-separator"></div>
                    </div>
                </div>
                <div class="row justify-content-center vertical-gap">
                    <div class="col-12 col-md-4 col-lg-3 dx-feature-variable">
                        <div class="dx-feature dx-feature-3 dx-feature-color-4 dx-block-decorated" style="height: 300px;">
                            <div class="dx-feature-icon" style="color: #F38F2F;">
                                <span class="icon pe-7s-ticket"></span>
                            </div>
                            <div class="dx-feature-cont">
                                <div class="dx-feature-title"><a href="{{ route('tickets.index') }}">Tiket</a></div>
                                <div class="dx-feature-text">Laporkan masalah Anda secara online kepada ahlinya.</div>
                                <a href="{{ route('tickets.index') }}"
                                    class="dx-btn dx-btn-link d-flex dx-feature-link">Lihat Tiket<span
                                        class="icon pe-7s-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100">
            <div class="container mt-4 mnb-7">
                <div class="row align-items-center vertical-gap mnt-30 sm-gap mb-50">
                    <h2 class="col-auto h4 mb-0 mt-0">Artikel Populer</h2>
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
                                            <li><a
                                                    href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a>
                                            </li>
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
        </div> --}}
    @endsection
