@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-separator"></div>
        <div class="dx-box-5 bg-grey-6">
            <div class="container">

                <div class="row align-items-center justify-content-between vertical-gap mnt-30 sm-gap mb-50">
                    <div class="col-auto">
                        <h2 class="h4 mb-0 mt-0">Pertanyaan Anda</h2>
                    </div>
                    <div class="col pl-30 pr-30 d-none d-sm-block">
                        <div class="dx-separator ml-10 mr-10"></div>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('user.ticket.create') }}" class="dx-btn dx-btn-md"
                            style="background-color: #F38F2F;">Buat Tiket</a>
                    </div>
                </div>

                <div class="row vertical-gap md-gap">
                    <div class="col-lg-8">
                        @if ($tickets->isEmpty())
                            <p class="text-center">Tiket Pertanyaan Tidak Ditemukan</p>
                        @else
                            @foreach ($tickets as $ticket)
                                <a href="{{ route('user.ticket.show', $ticket->id) }}"
                                    class="dx-ticket-item dx-ticket-new dx-ticket-open dx-block-decorated">
                                    <span class="dx-ticket-cont">
                                        <span class="dx-ticket-name">{{ $ticket->user->name }}</span>
                                        <span class="dx-ticket-title h5"
                                            style="color: black">{{ $ticket->references . ' - ' . $ticket->title }}</span>
                                        <p class="dx-ticket-paragraph mt-8" style="color: black">
                                            {{ strip_tags($ticket->message) }}</p>
                                        <ul class="dx-ticket-info">
                                            <li>Dibuat: {{ $ticket->updated_at->format('d M Y') }}</li>
                                            <li>Kategori: {{ $ticket->category }}</li>
                                            @php $newMessagesCount = $ticket->messages->where('user_id', '!=', Auth::id())->where('is_read', '')->count(); @endphp
                                            @if ($newMessagesCount > 0)
                                                <li style="color: blue; font-weight: bold;">New Messages:
                                                    {{ $newMessagesCount }}</li>
                                            @endif
                                            @if ($ticket->is_new)
                                                <li class="dx-ticket-new">New</li>
                                            @endif
                                        </ul>
                                    </span>
                                    <span class="dx-ticket-status">{{ $ticket->status }}</span>
                                </a>
                            @endforeach
                        @endif
                        <div class="mt-20">
                            {{ $tickets->links() }}
                        </div>
                    </div>

                    <div class="col-lg-4 mt-25">
                        <div class="dx-widget dx-box dx-box-decorated">
                            <form action="{{ route('user.ticket.index') }}" class="dx-form dx-form-group-inputs">
                                <input type="search" name="search" value="{{ request()->query('search') }}"
                                    class="form-control form-control-style-2" placeholder="Search...">
                                <button class="dx-btn dx-btn-lg dx-btn-grey dx-btn-grey-style-2 dx-btn-icon"><span
                                        class="icon fas fa-search"></span></button>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
@endsection
