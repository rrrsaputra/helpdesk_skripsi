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
                                    <h2 class="h4 mnt-5 mb-5">Pertanyaan yang Sering Diajukan</h2>
                                </div>
                                <div class="dx-separator"></div>
                                <div class="dx-blog-post-box">
                                    @foreach ($faqs as $faq)
                                        <div class="row vertical-gap lg-gap mb-4">
                                            <div class="col-md-12 position-relative">
                                                <div class="card shadow-sm border-0">
                                                    <div class="card-body">
                                                        <h5 class="card-title"
                                                            style="font-weight: bold; color:#333; font-size: 20px">
                                                            {{ $faq->title }}</h5>
                                                        <div class="card-text text-muted" style="font-size: 16px">
                                                            {{ Str::limit(strip_tags($faq->content), 150) }}
                                                        </div>
                                                        <a href="{{ route('user.faq.show', $faq->id) }}"
                                                            class="btn mt-10 position-relative"
                                                            style="border-radius: 20px; z-index: 1; background-color: #F38F2F; color: white; border-color: #F38F2F;"
                                                            onmouseover="this.style.backgroundColor='#85171A'; this.style.color='white';"
                                                            onmouseout="this.style.backgroundColor='#F38F2F'; this.style.color='white';">Selengkapnya</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-20">
                                        {{ $faqs->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dx-box dx-box-content dx-box-decorated mt-40">
                            <div class="row vertical-gap align-items-center justify-content-center">
                                <div class="col-auto">
                                    <h3 class="h5 mnt-6 mnb-6">Apakah Anda menemukan informasi yang diinginkan?</h3>
                                </div>
                                <div class="col-auto d-flex">
                                    <a href="#"
                                        class="dx-btn dx-btn-md dx-btn-main-1" style="background-color: #28a745;">Ya</a>
                                    <a href="{{ route('user.ticket.create') }}"
                                        class="dx-btn dx-btn-md" style="background-color: #F38F2F; color: white; margin-left: 20px;">Ajukan Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="dx-widget dx-box dx-box-decorated">
                            <form action="{{ route('user.faq.index') }}" class="dx-form dx-form-group-inputs">
                                <input type="search" name="search" value="{{ request()->query('search') }}"
                                    class="form-control form-control-style-2" placeholder="Search...">
                                <button class="dx-btn dx-btn-lg dx-btn-grey dx-btn-grey-style-2 dx-btn-icon"><span
                                        class="icon fas fa-search"></span></button>
                            </form>
                        </div>
                        <div class="dx-widget dx-box dx-box-decorated">
                            <div class="dx-widget-title">Kategori Artikel</div>
                            <ul class="dx-widget-categories">
                                @foreach ($faqCategories as $faqCategory)
                                    <li>
                                        <a href="{{ route('user.faq_category.show', $faqCategory->slug) }}">
                                        <span class="icon pe-7s-angle-right"></span>
                                        <span class="dx-widget-categories-category">{{ $faqCategory->name }}</span>
                                        <span class="dx-widget-categories-badge">
                                            {{ $faqCategory->faqs->count() }}
                                        </span>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
