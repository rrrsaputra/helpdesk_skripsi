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

                            <div class="dx-separator"></div>
                            <div style="background-color: #fafafa;">
                                <ul class="dx-blog-post-info dx-blog-post-info-style-2 mb-0 mt-0">
                                    <li><span><span class="dx-blog-post-info-title">Call
                                                ID</span>{{ $scheduledCall->references }}</span></li>
                                    <li><span><span
                                                class="dx-blog-post-info-title">Status</span>{{ $scheduledCall->status }}</span>
                                    </li>
                                    @if ($scheduledCall->status == 'rejected')
                                        <li><span><span class="dx-blog-post-info-title">Reason for
                                                    Rejection</span>{{ $scheduledCall->rejected_reason }}</span>
                                        </li>
                                    @endif
                                    <li><span><span
                                                class="dx-blog-post-info-title">Date</span>{{ $scheduledCall->created_at->format('d F Y') }}</span>
                                    </li>
                                    <li><span><span
                                                class="dx-blog-post-info-title">Category</span>{{ $scheduledCall->categoty }}</span>
                                    </li>
                                    <li><span><span class="dx-blog-post-info-title">Link</span> <a
                                                href="{{ strpos($scheduledCall->link, 'http') === 0 ? $scheduledCall->link : 'http://' . $scheduledCall->link }}"
                                                target="_blank">{{ $scheduledCall->link }}</a></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="dx-separator"></div>

                            <div class="dx-comment dx-ticket-comment">
                                @if ($scheduledCall->attachments->isNotEmpty())
                                    <p style="margin: 0;">
                                        <a href="#" onclick="toggleAttachments({{ $scheduledCall->id }})">
                                            <i class="fas fa-paperclip"></i> View Attachments
                                        </a>
                                    </p>
                                    <div id="attachments-{{ $scheduledCall->id }}" class="attachments-container"
                                        style="display: none; max-height: 400px; overflow-y: auto;">
                                        @foreach ($scheduledCall->attachments as $attachment)
                                            <div class="attachment-item">
                                                @if (strpos($attachment->path, '.jpg') !== false || strpos($attachment->path, '.jpeg') !== false || strpos($attachment->path, '.png') !== false || strpos($attachment->path, '.gif') !== false)
                                                    <img src="{{ asset('storage/' . $attachment->path) }}"
                                                        alt="{{ $attachment->name }}" style="max-width: 100%; height: auto;">
                                                @else
                                                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">{{ $attachment->name }}</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="dx-separator"></div>
                                @endif
                                
                                <div class="pt-30">
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
                            <form action="#" class="dx-form dx-form-group-inputs">
                                <input type="text" name="" value=""
                                    class="form-control form-control-style-2" placeholder="Search...">
                                <button class="dx-btn dx-btn-lg dx-btn-grey dx-btn-grey-style-2 dx-btn-icon"><span
                                        class="icon fas fa-search"></span></button>
                            </form>
                        </div>
                        <div class="dx-widget dx-box dx-box-decorated">
                            <div class="dx-widget-title"> Latest Articles </div>
                            @foreach ($articles as $article)
                                <a href="{{ route('article.show', $article->id) }}" class="dx-widget-link">
                                    <span class="dx-widget-link-text">{{ $article->title }}</span>
                                    <span class="dx-widget-link-date">{{ $article->created_at->format('d F Y') }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function toggleAttachments(messageId) {
            var container = document.getElementById('attachments-' + messageId);
            if (container.style.display === 'none') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var messagesContainer = document.getElementById('messages-container');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });
    </script>

@endpush
