@extends('layouts.user')

@section('content')
    <div class="dx-box-5 pb-100 bg-grey-6">
        <div class="container">
            <div class="row vertical-gap md-gap">
                <div class="col-lg-8">
                    <div class="dx-box dx-box-decorated">
                        <div class="dx-blog-post dx-ticket dx-ticket-open">
                            <div class="dx-blog-post-box pt-30 pb-30">
                                <h2 class="h4 mnt-5 mb-9 dx-ticket-title">{{ $scheduledCall->title }}</h2>
                                
                            </div>
                            <div class="dx-separator"></div>
                            <div class="dx-blog-post-box pt-30 pb-30">
                                <strong>Status: {{ $scheduledCall->status }}</strong>
                            @if($scheduledCall->status == 'rejected')
                                <p>Reason for Rejection: {{ $scheduledCall->rejected_reason }}</p>
                            @endif
                            </div>
                                
                            <div class="dx-separator"></div>
                            <div style="background-color: #fafafa;">
                                <ul class="dx-blog-post-info dx-blog-post-info-style-2 mb-0 mt-0">
                                    <li><span><span class="dx-blog-post-info-title">Call
                                                ID</span>{{ $scheduledCall->id }}</span></li>
                                    <li><span><span
                                                class="dx-blog-post-info-title">Status</span>{{ $scheduledCall->status }}</span>
                                    </li>
                                    <li><span><span
                                                class="dx-blog-post-info-title">Date</span>{{ $scheduledCall->created_at->format('d F Y') }}</span>
                                    </li>
                                    <li><span><span
                                                class="dx-blog-post-info-title">Category</span>{{ $scheduledCall->categoty }}</span>
                                    </li>
                                    <li><span><span
                                                class="dx-blog-post-info-title">Link</span> <a href="{{ strpos($scheduledCall->link, 'http') === 0 ? $scheduledCall->link : 'http://' . $scheduledCall->link }}" target="_blank">{{ $scheduledCall->link }}</a></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="dx-separator"></div>

                            <div class="dx-comment dx-ticket-comment">
                                <div>
                                    <div class="dx-comment-cont">
                                        <div class="dx-comment-text">
                                            <p style="text-align: justify;">{{ strip_tags($scheduledCall->message) }}</p>
                                        </div>
                                    </div>
                                </div>
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
                        <div class="dx-widget dx-box dx-box-decorated">
                            <div class="dx-widget-title"> Latest Forum Topics </div>
                            <a href="single-article.html" class="dx-widget-link">
                                <span class="dx-widget-link-text">Need help with customization. Some options are not
                                    appearing...</span>
                                <span class="dx-widget-link-date">6 Sep 2018</span>
                            </a>
                            <a href="single-article.html" class="dx-widget-link">
                                <span class="dx-widget-link-text">My images on profile and item pages doesnt show up?!
                                    Whats the matter?</span>
                                <span class="dx-widget-link-date">2 Sep 2018</span>
                            </a>
                            <a href="single-article.html" class="dx-widget-link">
                                <span class="dx-widget-link-text">Theme not updating in downloads</span>
                                <span class="dx-widget-link-date">27 Aug 2018</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
