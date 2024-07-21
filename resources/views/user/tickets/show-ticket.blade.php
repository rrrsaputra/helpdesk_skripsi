@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class=" ">
            <div class="container" style="padding-bottom: 60px;">
                <a href="{{ route('user.ticket.index') }}" class="btn btn-secondary mb-3">Back</a>
                @if (isset($messages) && $messages->count() > 0)
                    <div class="messages-list" style="height: calc(95vh - 360px); overflow-y: auto; max-width: 100%; box-sizing: border-box;">
                        <div id="messages-container">
                            @foreach ($messages as $message)
                                <div class="message-item"
                                    style="display: flex; align-items: flex-start; margin-bottom: 10px; {{ $message->user->id == Auth::id() ? 'flex-direction: row-reverse;' : '' }}">
                                    <img src="{{ $message->user->profile_pic ?? asset('default-avatar.jpg') }}"
                                        alt="Profile Picture"
                                        style="width: 40px; height: 40px; border-radius: 50%; margin-{{ $message->user->id == Auth::id() ? 'left' : 'right' }}: 10px;">
                                    <div
                                        style="background-color: #dfdfdf; border-radius: 15px; padding: 10px; max-width: 70%;">
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
                                                    @if (strpos($attachment->path, '.jpg') !== false || strpos($attachment->path, '.jpeg') !== false || strpos($attachment->path, '.png') !== false || strpos($attachment->path, '.gif') !== false)
                                                        <img src="{{ asset('storage/' . $attachment->path) }}"
                                                            alt="{{ $attachment->name }}" style="max-width: 100%; height: auto;">
                                                    @else
                                                        <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">{{ $attachment->name }}</a>
                                                    @endif
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
            </div>
            <form id="message-form" action="{{ route('agent.messages.store', ['id' => $ticket_id]) }}" method="POST"
                style="width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); position: fixed; bottom: 0; left: 0; right: 0; z-index: 1000;">
                @csrf
                <div class="dx-form-group">
                    <label class="mnt-7">Attachments</label>
                    <input type="file" class="filepond" name="filepond[]" multiple data-allow-reorder="true"
                        data-max-file-size="3MB" data-max-files="3" accept="image/*">

                    <script>
                        import * as FilePond from 'filepond';
                        import 'filepond/dist/filepond.min.css';
                        import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
                        import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
                        import FilePondPluginFileRemove from 'filepond-plugin-file-remove';

                        FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType, FilePondPluginFileRemove);
                        const inputElement = document.querySelector('input[type="file"].filepond');

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        FilePond.create(inputElement).setOptions({
                            server: {
                                process: './uploads/process',
                                revert: './uploads/revert',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                }
                            },
                            acceptedFileTypes: ['image/*'],
                            allowImagePreview: true,
                            imagePreviewMaxHeight: 100,
                            allowRemove: true
                        });
                    </script>
                    <input type="hidden" name="message" id="message">
                    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
                    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
                    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
                    <script src="https://unpkg.com/filepond-plugin-file-remove/dist/filepond-plugin-file-remove.min.js"></script>
                </div>
                <div class="form-group">
                    <textarea id="msg" name="message" class="form-control" rows="3" placeholder="Type your message here..."
                        required></textarea>
                </div>
                <button id='btn' type="submit" class="btn btn-primary">Send</button>
            </form>

        </div>
    </div>



    <script>
        document.getElementById('msg').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('btn').click();
                document.getElementById('msg').value = '';

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
                e.preventDefault(); // Mencegah pengiriman form default

                var form = this;
                var formData = new FormData(form);

                // Tambahkan indikator loading
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
                        // Hapus indikator loading
                        form.removeChild(loadingIndicator);

                        if (data.success) {
                            form.reset();
                            // Tambahkan pesan baru ke container pesan
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

                            var messagesContainer = document.getElementById('messages-container');
                            messagesContainer.appendChild(newMessage);
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        } else {
                            alert('Error sending message');
                        }
                    })
                    .catch(error => {
                        // Hapus indikator loading jika terjadi error
                        form.removeChild(loadingIndicator);
                        console.error('Error:', error);
                    });
            });
        });
    </script>

@endsection
