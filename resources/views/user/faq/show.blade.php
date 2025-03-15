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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h1 class="h4 mnt-5 mb-8">{{ $faq->title }}</h1>
                                        <ul class="dx-social-links dx-social-links-style-2">
                                            <li>
                                                <a href="#" onclick="copyToClipboard('{{ Request::fullUrl() }}')" class="dx-social-link">
                                                    <span class="fas fa-link" style="color: black;"></span>
                                                </a>
                                            </li>
                                            <script>
                                                function copyToClipboard(text) {
                                                    navigator.clipboard.writeText(text).then(function() {
                                                        console.log('Link berhasil disalin ke clipboard!');
                                                    }, function(err) {
                                                        console.error('Gagal menyalin link: ', err);
                                                    });
                                                }
                                            </script>
                                            <li><a href="https://wa.me/?text={{ urlencode(Request::fullUrl()) }}"
                                                    target="_blank" class="dx-social-link dx-social-link-whatsapp"><span
                                                        class="fab fa-whatsapp" style="color: black;"></span></a></li>
                                        </ul>
                                    </div>
                                    <ul class="dx-blog-post-info mnt-10 mnb-2">
                                        <li>By: {{ $faq->user->name }}</li>
                                        <li>Category: {{ $faq->faqCategory->name }}</li>
                                        <li>Published {{ $faq->created_at->format('d F Y') }}</li>
                                    </ul>
                                </div>

                                <div class="dx-separator"></div>

                                <div class="dx-blog-post-box">
                                    <div class="dx-faq-content">
                                        {!! $faq->content !!}
                                    </div>
                                    <style>
                                        .dx-faq-content ol {
                                            list-style-type: decimal;
                                            padding-left: 40px;
                                        }

                                        .dx-faq-content ul {
                                            list-style-type: disc;
                                            padding-left: 40px;
                                        }

                                        .dx-faq-content h1 {
                                            font-weight: bold;
                                            font-size: 34px;
                                            margin-top: 20px;
                                            margin-bottom: 10px;
                                        }

                                        .dx-faq-content h2 {
                                            font-weight: bold;
                                            font-size: 30px;
                                            margin-top: 20px;
                                            margin-bottom: 10px;
                                        }

                                        .dx-faq-content blockquote {
                                            margin-left: 20px;
                                            font-style: italic;
                                            border-left: 5px solid #ccc;
                                            padding-left: 10px;
                                        }
                                    </style>
                                </div>
                                <div class="dx-separator"></div>

                            </div>
                        </div>
                        <div class="dx-box dx-box-content dx-box-decorated mt-40">
                            <div class="row vertical-gap align-items-center justify-content-center">
                                <div class="col-auto">
                                    <h3 class="h5 mnt-6 mnb-6">Apakah informasi ini membantu?</h3>
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
                        <div class="dx-sticky dx-sidebar" data-sticky-offsetTop="120" data-sticky-offsetBot="40">
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title">Kategori FAQ</div>
                                <ul class="dx-widget-categories">
                                    @foreach ($faqCategories as $faqCategory)
                                        <li>
                                            <a href="{{ route('user.faq_category.show', $faqCategory->slug) }}">
                                                <span class="icon pe-7s-angle-right"></span>
                                                <span
                                                    class="dx-widget-categories-category">{{ $faqCategory->name }}</span>
                                                <span class="dx-widget-categories-badge">
                                                    {{ $faqCategory->faqs->count() }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title">Sumber Lainnya</div>
                                @foreach ($faqs as $faq)
                                    <a href="{{ route('user.faq.show', $faq->id) }}" class="dx-widget-link">
                                        <span class="dx-widget-link-text">{{ $faq->title }}</span>
                                        <span class="dx-widget-link-date">{{ $faq->faqCategory->name }} - {{ $faq->created_at->format('d F Y') }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
