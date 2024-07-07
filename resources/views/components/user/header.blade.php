<header class="dx-header dx-box-1">
    <div class="container">
        <div class="bg-image bg-image-parallax">
            <img src="{{ asset('image/background.jpg') }}" class="jarallax-img" alt="">
            <div style="background-color: rgba(27, 27, 27, .8);"></div>
        </div>
        @if (Request::is('/'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Hi, {{ Auth::user()->name }}!<br>How can we help you?</h1>
                    <form action="{{ route('article.index') }}" class="dx-form dx-form-group-inputs">
                        <input type="search" name="search" value="{{ request()->query('search') }}"
                            class="form-control" placeholder="Keyword search...">
                        <button class="dx-btn dx-btn-lg">Search</button>
                    </form>
                </div>
            </div>
        @elseif(Request::is('tickets'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Tickets</h1>
                </div>
            </div>
        @elseif(Request::is('scheduled-calls'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Scheduled Calls</h1>
                </div>
            </div>
        @elseif(Request::is('scheduled-calls/*'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Scheduled Call</h1>
                </div>
            </div>
        @elseif(Request::is('scheduled-call-submit'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Book Scheduled Call</h1>
                </div>
            </div>
        @elseif(Request::is('article'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Articles</h1>
                </div>
            </div>
        @elseif(Request::is('feedback'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Feedbacks</h1>
                </div>
            </div>
        @elseif(Request::is('article/*'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Article</h1>
                </div>
            </div>
        @elseif(Request::is('article'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Articles</h1>
                </div>
            </div>
        @elseif(Request::is('category/*'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Article Categories</h1>
                </div>
            </div>
        @endif
    </div>
</header>
