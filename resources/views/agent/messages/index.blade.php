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

                            @if ($message->attachments->isNotEmpty())
                                <p style="margin: 0;">
                                    <a href="#" onclick="toggleAttachments({{ $message->id }})">
                                        <i class="fas fa-paperclip"></i> View Attachments
                                    </a>
                                </p>
                                <div id="attachments-{{ $message->id }}" class="attachments-container"
                                    style="display: none; max-height: 400px; overflow-y: auto;">
                                    @foreach ($message->attachments as $attachment)
                                        <div class="attachment-item">
                                            <img src="{{ asset('storage/' . $attachment->path) }}"
                                                alt="{{ $attachment->name }}" style="max-width: 100%; height: auto;">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <p style="margin: 0; font-size: 0.8em; color: #888;">
                                <small>{{ $message->created_at->format('d M Y, h:i A') }}</small>
                            </p>
                        </div>
                    </div>
                @endforeach
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
            </div>
        </div>
    @else
        <p>No messages found.</p>
    @endif

    <form id="message-form" action="{{ route('agent.messages.store', ['id' => $ticket_id]) }}" method="POST"
        style="width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); margin-bottom: 0;">
        @csrf
        <div class="form-group">
            <div id="editor" style="height: 150px;"></div>
            <input type="hidden" name="message" id="hidden_message">
        </div>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: true
                },
                placeholder: 'Type your message here...'
            });

            document.getElementById('message-form').addEventListener('submit', function() {
                var editor = document.querySelector('#editor .ql-editor');
                document.getElementById('hidden_message').value = editor.innerHTML;
            });
        </script>
        
        <div class="form-group">
            <label for="attachments">Attachments</label>
            <input type="file" id="attachments" name="filepond[]" class="filepond" multiple data-allow-reorder="true"
                data-max-file-size="3MB" data-max-files="3" >
        </div>
        <button id="btn" type="submit" class="btn btn-primary">Send</button>
    </form>

    <script>
        // document.getElementById('msg').addEventListener('keypress', function(e) {
        //     if (e.key === 'Enter' && !e.shiftKey) {
        //         e.preventDefault();
        //         document.getElementById('btn').click();
        //     }
        // });

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
                    messageContent.style.cssText =
                        'background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;';

                    var messageUser = document.createElement('p');
                    messageUser.style.margin = '0';
                    messageUser.innerHTML = '<strong>' + e.user.name + ':</strong>';

                    var messageText = document.createElement('p');
                    messageText.style.margin = '0';
                    messageText.innerHTML = e.message.message;

                    var messageTime = document.createElement('p');
                    messageTime.style.cssText = 'margin: 0; font-size: 0.8em; color: #888;';
                    messageTime.innerHTML = '<small>' + new Date(e.message.created_at).toLocaleString() +
                        '</small>';

                    messageContent.appendChild(messageUser);
                    messageContent.appendChild(messageText);

                    if (e.message.attachments.length > 0) {
                        var attachmentLink = document.createElement('p');
                        attachmentLink.style.margin = '0';
                        var attachmentAnchor = document.createElement('a');
                        attachmentAnchor.href = '#';
                        attachmentAnchor.onclick = function() {
                            toggleAttachments(e.message.id);
                        };
                        attachmentAnchor.innerHTML = '<i class="fas fa-paperclip"></i> View Attachments';
                        attachmentLink.appendChild(attachmentAnchor);
                        messageContent.appendChild(attachmentLink);

                        var attachmentsContainer = document.createElement('div');
                        attachmentsContainer.id = 'attachments-' + e.message.id;
                        attachmentsContainer.classList.add('attachments-container');
                        attachmentsContainer.style.cssText =
                            'display: none; max-height: 400px; overflow-y: auto;';

                        e.message.attachments.forEach(function(attachment) {
                            var attachmentItem = document.createElement('div');
                            attachmentItem.classList.add('attachment-item');
                            var attachmentImg = document.createElement('img');
                            attachmentImg.src = '{{ asset('storage/') }}/' + attachment.path;
                            attachmentImg.alt = attachment.name;
                            attachmentImg.style.cssText = 'max-width: 100%; height: auto;';
                            attachmentItem.appendChild(attachmentImg);
                            attachmentsContainer.appendChild(attachmentItem);
                        });

                        messageContent.appendChild(attachmentsContainer);
                    }
                    messageContent.appendChild(messageTime);
                    newMessage.appendChild(profilePic);
                    newMessage.appendChild(messageContent);

                    messagesContainer.appendChild(newMessage);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });

            // Handle form submission without refreshing
            document.getElementById('message-form').addEventListener('submit', function(e) {
                e.preventDefault();
                var form = this;
                var formData = new FormData(form);

                // Add this on top of the message
                var loadingIndicator = document.createElement('div');
                loadingIndicator.classList.add('loading-indicator');
                loadingIndicator.innerHTML = 'Sending...';
                form.insertBefore(loadingIndicator, form.firstChild);

                fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove loading indicator
                        form.removeChild(loadingIndicator);

                        if (data.success) {
                            form.reset();
                            // Append the new message to the messages container
                            var newMessage = document.createElement('div');
                            newMessage.classList.add('message-item');
                            newMessage.style.cssText =
                                'display: flex; align-items: flex-start; margin-bottom: 10px;' +
                                (data.message.user_id == {{ Auth::id() }} ?
                                    'flex-direction: row-reverse;' : '');

                            var profilePic = document.createElement('img');
                            profilePic.src = data.user.profile_pic ||
                                '{{ asset('default-avatar.jpg') }}';
                            profilePic.alt = 'Profile Picture';
                            profilePic.style.cssText =
                                'width: 40px; height: 40px; border-radius: 50%; margin-' +
                                (data.message.user_id == {{ Auth::id() }} ? 'left' : 'right') +
                                ': 10px;';

                            var messageContent = document.createElement('div');
                            messageContent.style.cssText =
                                'background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;';

                            var messageUser = document.createElement('p');
                            messageUser.style.margin = '0';
                            messageUser.innerHTML = '<strong>' + data.user.name + ':</strong>';

                            var messageText = document.createElement('p');
                            messageText.style.margin = '0';
                            messageText.innerHTML = data.message.message;

                            var messageTime = document.createElement('p');
                            messageTime.style.cssText = 'margin: 0; font-size: 0.8em; color: #888;';
                            messageTime.innerHTML = '<small>' + new Date(data.message.created_at)
                                .toLocaleString() + '</small>';

                            messageContent.appendChild(messageUser);
                            messageContent.appendChild(messageText);

                            if (data.message.attachments && data.message.attachments.length > 0) {
                                var attachmentsLink = document.createElement('p');
                                attachmentsLink.style.margin = '0';
                                attachmentsLink.innerHTML = '<a href="#" onclick="toggleAttachments(' +
                                    data.message.id +
                                    ')"><i class="fas fa-paperclip"></i> View Attachments</a>';

                                var attachmentsContainer = document.createElement('div');
                                attachmentsContainer.id = 'attachments-' + data.message.id;
                                attachmentsContainer.classList.add('attachments-container');
                                attachmentsContainer.style.cssText =
                                    'display: none; max-height: 400px; overflow-y: auto;';

                                data.message.attachments.forEach(function(attachment) {
                                    var attachmentItem = document.createElement('div');
                                    attachmentItem.classList.add('attachment-item');

                                    var attachmentImg = document.createElement('img');
                                    attachmentImg.src = '{{ asset('storage/') }}/' + attachment
                                        .path;
                                    attachmentImg.alt = attachment.name;
                                    attachmentImg.style.cssText =
                                        'max-width: 100%; height: auto;';

                                    attachmentItem.appendChild(attachmentImg);
                                    attachmentsContainer.appendChild(attachmentItem);
                                });

                                messageContent.appendChild(attachmentsLink);
                                messageContent.appendChild(attachmentsContainer);
                            }
                            messageContent.appendChild(messageTime);
                            newMessage.appendChild(profilePic);
                            newMessage.appendChild(messageContent);

                            messagesContainer.appendChild(newMessage);
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        } else {
                            alert('Error sending message');
                        }
                    })
                    .catch(error => {
                        // Remove loading indicator in case of error
                        form.removeChild(loadingIndicator);
                        console.error('Error:', error);
                    });
            });
        });
    </script>


@endsection
