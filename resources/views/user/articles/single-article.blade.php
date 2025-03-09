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
                                        <li>By: {{ $article->user->name }}</li>
                                        <li>Category: {{ $article->articleCategory->name }}</li>
                                        <li>Published {{ $article->created_at->format('d F Y') }}</li>
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
                                    <div class="dx-article-content">
                                        {!! $article->content !!}
                                    </div>
                                    <style>
                                        .dx-article-content ol {
                                            list-style-type: decimal;
                                            padding-left: 40px;
                                        }

                                        .dx-article-content ul {
                                            list-style-type: disc;
                                            padding-left: 40px;
                                        }

                                        .dx-article-content h1 {
                                            font-weight: bold;
                                            font-size: 34px;
                                            margin-top: 20px;
                                            margin-bottom: 10px;
                                        }

                                        .dx-article-content h2 {
                                            font-weight: bold;
                                            font-size: 30px;
                                            margin-top: 20px;
                                            margin-bottom: 10px;
                                        }

                                        .dx-article-content blockquote {
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
                                    <h3 class="h5 mnt-6 mnb-6">Was this helpful to you?</h3>
                                </div>
                                <div class="col-auto d-flex">
                                    <a href="{{ route('user.feedback.index') }}"
                                        class="dx-btn dx-btn-md dx-btn-main-1">Yes</a>
                                    <a href="{{ route('user.feedback.index') }}"
                                        class="dx-btn dx-btn-md dx-btn-grey-2 ml-20">No</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="dx-sticky dx-sidebar" data-sticky-offsetTop="120" data-sticky-offsetBot="40">
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title">Articles Categories</div>
                                <ul class="dx-widget-categories">
                                    @foreach ($articleCategories as $articleCategory)
                                        <li>
                                            <a href="{{ route('category.show', $articleCategory->slug) }}">
                                                <span class="icon pe-7s-angle-right"></span>
                                                <span
                                                    class="dx-widget-categories-category">{{ $articleCategory->name }}</span>
                                                <span class="dx-widget-categories-badge">
                                                    {{ $articleCategory->articles->count() }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="dx-widget dx-box dx-box-decorated">
                                <div class="dx-widget-title"> Latest Articles </div>
                                @foreach ($articles as $article)
                                    <a href="{{ route('article.show', $article->id) }}" class="dx-widget-link">
                                        <span class="dx-widget-link-text">{{ $article->title }}</span>
                                        <span
                                            class="dx-widget-link-date">{{ $article->created_at->format('d F Y') }}</span>
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
