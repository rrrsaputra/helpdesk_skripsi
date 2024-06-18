@extends('layouts.agent')
@section('header')
    <x-agent.header title="agent"/>
@endsection

@section('content')
@if(isset($messages) && $messages->count() > 0)
    <div class="messages-list" style="height: 100%;">
            <div id="messages-container" style="max-height: 61.5vh; overflow-y: auto;">
            @foreach($messages as $message)
                <div class="message-item" style="display: flex; align-items: flex-start; margin-bottom: 10px; {{ $message->user->id == Auth::id() ? 'flex-direction: row-reverse;' : '' }}">
                    <img src="{{ $message->user->profile_pic ?? asset('default-avatar.jpg') }}" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%; margin-{{ $message->user->id == Auth::id() ? 'left' : 'right' }}: 10px;">
                    <div style="background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;">
                        <p style="margin: 0;"><strong>{{ $message->user->name }}:</strong></p>
                        <p style="margin: 0;">{!! $message->message !!}</p>
                        <p style="margin: 0; font-size: 0.8em; color: #888;"><small>{{ $message->created_at->format('d M Y, h:i A') }}</small></p>
                    </div>
                </div>
            @endforeach
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var messagesContainer = document.getElementById('messages-container');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
            </script>
        <form action="{{ route('agent.messages.store', ['id' => $ticket_id]) }}" method="POST" style="width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); margin-bottom: 0;">
            @csrf
            <div class="form-group">
                <textarea name="message" class="form-control" rows="3" placeholder="Type your message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
@else
    <p>No messages found.</p>
@endif
@endsection