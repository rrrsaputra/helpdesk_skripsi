@extends('layouts.agent')
@section('header')
    <x-agent.header title="agent" />
@endsection

@section('content')
    @if (isset($messages) && $messages->count() > 0)
        <div class="messages-list" style="height: 100%;">
            <div id="messages-container" style="max-height: 61.5vh; overflow-y: auto;">
                @foreach ($messages as $message)
                    <div class="message-item"
                        style="display: flex; align-items: flex-start; margin-bottom: 10px; {{ $message->user->id == Auth::id() ? 'flex-direction: row-reverse;' : '' }}">
                        <img src="{{ $message->user->profile_pic ?? asset('default-avatar.jpg') }}" alt="Profile Picture"
                            style="width: 40px; height: 40px; border-radius: 50%; margin-{{ $message->user->id == Auth::id() ? 'left' : 'right' }}: 10px;">
                        <div style="background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;">
                            <p style="margin: 0;"><strong>{{ $message->user->name }}:</strong></p>
                            <p style="margin: 0;">{!! $message->message !!}</p>
                            <p style="margin: 0; font-size: 0.8em; color: #888;">
                                <small>{{ $message->created_at->format('d M Y, h:i A') }}</small></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p>No messages found.</p>
    @endif

    <form id="message-form" action="{{ route('agent.messages.store', ['id' => $ticket_id]) }}" method="POST"
        style="width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); margin-bottom: 0;">
        @csrf
        <div class="form-group">
            <textarea id="msg" name="message" class="form-control" rows="3" placeholder="Type your message here..."
                required></textarea>
        </div>
        <button id="btn" type="submit" class="btn btn-primary">Send</button>
    </form>

    <script>
        document.getElementById('message-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            var msgInput = document.getElementById('msg');
            var message = msgInput.value.trim();

            if (message === '') {
                return; // Do nothing if the message is empty
            }

            // Proceed with form submission
            var formData = new FormData(this);
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const data = await response.json();
                if (data.success) {
                    msgInput.value = ''; // Clear the input field
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var messagesContainer = document.getElementById('messages-container');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // Listen for new messages
            window.Echo.private('messages.{{ $ticket_id }}')
                .listen('MessageSent', (e) => {
                    var newMessage = document.createElement('div');
                    newMessage.classList.add('message-item');
                    newMessage.style.cssText = 'display: flex; align-items: flex-start; margin-bottom: 10px;' +
                        (e.message.user_id == {{ Auth::id() }} ? 'flex-direction: row-reverse;' : '');

                    var profilePic = document.createElement('img');
                    profilePic.src = e.user.profile_pic || '{{ asset('default-avatar.jpg') }}';
                    profilePic.alt = 'Profile Picture';
                    profilePic.style.cssText = 'width: 40px; height: 40px; border-radius: 50%; margin-' +
                        (e.message.user_id == {{ Auth::id() }} ? 'left' : 'right') + ': 10px;';

                    var messageContent = document.createElement('div');
                    messageContent.style.cssText = 'background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;';

                    var messageUser = document.createElement('p');
                    messageUser.style.margin = '0';
                    messageUser.innerHTML = '<strong>' + e.user.name + ':</strong>';

                    var messageText = document.createElement('p');
                    messageText.style.margin = '0';
                    messageText.innerHTML = e.message.message;

                    var messageTime = document.createElement('p');
                    messageTime.style.cssText = 'margin: 0; font-size: 0.8em; color: #888;';
                    messageTime.innerHTML = '<small>' + new Date(e.message.created_at).toLocaleString() + '</small>';

                    messageContent.appendChild(messageUser);
                    messageContent.appendChild(messageText);
                    messageContent.appendChild(messageTime);

                    newMessage.appendChild(profilePic);
                    newMessage.appendChild(messageContent);

                    messagesContainer.appendChild(newMessage);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });

            // Handle form submission without refreshing
            document.getElementById('message-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        form.reset();
                        // Append the new message to the messages container
                        var newMessage = document.createElement('div');
                        newMessage.classList.add('message-item');
                        newMessage.style.cssText = 'display: flex; align-items: flex-start; margin-bottom: 10px;' +
                            (data.message.user_id == {{ Auth::id() }} ? 'flex-direction: row-reverse;' : '');

                        var profilePic = document.createElement('img');
                        profilePic.src = data.user.profile_pic || '{{ asset('default-avatar.jpg') }}';
                        profilePic.alt = 'Profile Picture';
                        profilePic.style.cssText = 'width: 40px; height: 40px; border-radius: 50%; margin-' +
                            (data.message.user_id == {{ Auth::id() }} ? 'left' : 'right') + ': 10px;';

                        var messageContent = document.createElement('div');
                        messageContent.style.cssText = 'background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;';

                        var messageUser = document.createElement('p');
                        messageUser.style.margin = '0';
                        messageUser.innerHTML = '<strong>' + data.user.name + ':</strong>';

                        var messageText = document.createElement('p');
                        messageText.style.margin = '0';
                        messageText.innerHTML = data.message.message;

                        var messageTime = document.createElement('p');
                        messageTime.style.cssText = 'margin: 0; font-size: 0.8em; color: #888;';
                        messageTime.innerHTML = '<small>' + new Date(data.message.created_at).toLocaleString() + '</small>';

                        messageContent.appendChild(messageUser);
                        messageContent.appendChild(messageText);
                        messageContent.appendChild(messageTime);

                        newMessage.appendChild(profilePic);
                        newMessage.appendChild(messageContent);

                        messagesContainer.appendChild(newMessage);
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    } else {
                        alert('Error sending message');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });
        });
    </script>


@endsection

