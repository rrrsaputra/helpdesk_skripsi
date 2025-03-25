<header class="dx-header dx-box-1">
    <div class="container">
        <div class="bg-image bg-image-parallax">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('image/background1.jpg') }}" class="d-block w-100 jarallax-img" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('image/background2.jpg') }}" class="d-block w-100 jarallax-img" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('image/background3.jpg') }}" class="d-block w-100 jarallax-img" alt="">
                    </div>
                </div>
                {{-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a> --}}
            </div>
            <div style="background-color: rgba(27, 27, 27, .8);"></div>
        </div>
        @if (Request::is('/'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Halo, {{ Auth::user()->name }}!<br>Apa yang bisa kami bantu?</h1>
                    <form action="{{ route('user.faq.index') }}" class="dx-form dx-form-group-inputs">
                        <input type="search" name="search" value="{{ request()->query('search') }}"
                            class="form-control" placeholder="Keyword search...">
                        <button class="dx-btn dx-btn-lg" style="background-color: #F38F2F;">Search</button>
                    </form>
                </div>
            </div>
        @elseif(Request::is('tickets'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Tiket</h1>
                </div>
            </div>
        {{-- @elseif(Request::is('scheduled-calls'))
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
            </div> --}}
        @elseif(Request::is('feedback'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Umpan Balik</h1>
                </div>
            </div>
        @elseif(Request::is('faq/*'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Pertanyaan yang Sering Diajukan</h1>
                </div>
            </div>
        @elseif(Request::is('faq'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Pertanyaan yang Sering Diajukan</h1>
                </div>
            </div>
        @elseif(Request::is('faq_category/*'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Kategori FAQ</h1>
                </div>
            </div>
        @elseif(Request::is('profile'))
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <h1 class="h2 mb-30 text-white text-center">Profil</h1>
                </div>
            </div>
        @endif
    </div>
</header>
