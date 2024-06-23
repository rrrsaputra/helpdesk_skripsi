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
                                    <h2 class="h4 mnt-5 mb-5">{{ $category->name }}</h2>
                                </div>
                                <div class="dx-separator"></div>
                                <div class="dx-blog-post-box">
                                    @foreach ($articles as $article)
                                        <div class="row vertical-gap lg-gap mb-4">
                                            <div class="col-md-12">
                                                <div class="card shadow-sm border-0">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $article->title }}</h5>
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
                                @foreach ($articleCategories as $articleCategory)
                                    <li>
                                        <a href="{{ route('category.show', $articleCategory->slug) }}">
                                            <span class="icon pe-7s-angle-right"></span>
                                            <span class="dx-widget-categories-category">{{ $articleCategory->name }}</span>
                                            <span class="dx-widget-categories-badge">{{ $articleCategory->articles->count() }}</span>
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