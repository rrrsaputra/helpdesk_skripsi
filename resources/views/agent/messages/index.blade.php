@extends('layouts.agent')
@section('header')
    <x-agent.header title="Ticket: {{ $ticket->references }} - {{ $ticket->title }}" />
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
                                        @if (in_array(pathinfo($attachment->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $attachment->path) }}"
                                                alt="{{ $attachment->name }}" style="max-width: 100%; height: auto;">
                                        @else
                                            <a href="{{ asset('storage/' . $attachment->path) }}"
                                                target="_blank">{{ $attachment->name }}</a>
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

    <form id="message-form" action="{{ route('agent.messages.store', ['id' => $ticket_id]) }}" method="POST"
        style="width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); margin-bottom: 0;">
        @csrf

        <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
        <button type="button" onclick="toggleAttachmentInput()" class="dx-btn dx-btn-md"
            style="background-color: #007bff; color: white; border: none; border-radius: 5px; padding: 10px 15px; cursor: pointer; transition: background-color 0.3s; margin: 10px 0;">
            Add Attachment
        </button>
        <div class="dx-form-group" id="attachment-group" style="display: none;">

            <input type="file" class="filepond" id="fileInput" multiple>

        </div>
        <input type="hidden" name="filepond" id="hidden_filePaths">
        <script>
            function toggleAttachmentInput() {
                var attachmentGroup = document.getElementById('attachment-group');
                attachmentGroup.style.display = attachmentGroup.style.display === 'none' ? 'block' : 'none';
            }
        </script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script>
            // Get a reference to the file input element
            const inputElement = document.getElementById('fileInput');
            const pond = FilePond.create(inputElement);
            // Add file button click event
            // Ensure FilePond is properly initialized and configured
            pond.setOptions({
                server: {
                    process: {
                        url: "{{ route('uploads.process') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    },




                }
            });
            pond.on('addfile', function(file) {
                // Upload the file to your server
                const addedFiles = pond.getFiles();
                addedFiles.forEach(file => {
                   
                });


            });
        </script>
        <div class="form-group">
            <div id="editor" style="height: 100px;"></div>
            <input type="hidden" name="message" id="hidden_message">
            <input type="hidden" name="is_online" id="hidden_is_online">
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

                const editorContent = editor.innerHTML.trim(); // Get the trimmed content

                if (editorContent === '<br>' || editorContent === '') {
                    document.getElementById('hidden_message').value = ''; // Set to empty if only <br> or empty
                } else {
                    document.getElementById('hidden_message').value = editorContent.replace(/<br\s*\/?>/g,
                        ''); // Remove <br> tags
                }
                editor.innerHTML = ""; // Clear the editor
            });
        </script>
        <button id="btn" type="submit" class="btn btn-primary">Send</button>
    </form>

    <script>
        document.getElementById('editor').addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && !event.shiftKey) { // Check if Enter is pressed without Shift
                event.preventDefault(); // Prevent default behavior (new line)

                document.getElementById('btn').click(); // Trigger the button click

            }
        });

        

        document.addEventListener('DOMContentLoaded', function() {
            var messagesContainer = document.getElementById('messages-container');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            window.Echo.join(`messages.{{ $ticket_id }}`)
            .here((users) => {
                document.getElementById('hidden_is_online').value = users.some(user => user.id === {{ $ticket->user_id }}) ? 1 : 0;
            })
            .joining((user) => {
                if (user.id === {{ $ticket->user_id }}) {
                    document.getElementById('hidden_is_online').value = 1;
                }
            })
            .leaving((user) => {
                if (user.id === {{ $ticket->user_id }}) {
                    document.getElementById('hidden_is_online').value = 0;
                }
            });

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
                            var fileExtension = attachment.path.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                var attachmentImg = document.createElement('img');
                                attachmentImg.src = '{{ asset('storage/') }}/' + attachment.path;
                                attachmentImg.alt = attachment.name;
                                attachmentImg.style.cssText = 'max-width: 100%; height: auto;';
                                attachmentItem.appendChild(attachmentImg);
                            } else {
                                var attachmentLink = document.createElement('a');
                                attachmentLink.href = '{{ asset('storage/') }}/' + attachment.path;
                                attachmentLink.target = '_blank';
                                attachmentLink.innerText = attachment.name;
                                attachmentItem.appendChild(attachmentLink);
                            }
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
                const addedFiles = pond.getFiles();
                if (addedFiles.length > 0) {
                    const filePaths = addedFiles.map(file => ({
                        serverId: file.serverId,
                        name: file.file.name
                    }));
            
                    // Append filePaths to a hidden input field
                    const filePathsInput = document.createElement('input');
                    filePathsInput.type = 'hidden';
                    filePathsInput.name = 'filepond';
                    filePathsInput.value = JSON.stringify(filePaths);
                    event.target.closest('form').appendChild(filePathsInput);
                } else {
                   
                }

                var form = this;
                var formData = new FormData(form);

                pond.removeFiles(); // This will erase all files inside the filepond
                var attachmentGroup = document.getElementById('attachment-group');
                if (attachmentGroup.style.display === 'block') {
                    attachmentGroup.style.display = 'none';
                }
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

                            var fileExtension = attachment.path.split('.').pop().toLowerCase();
                            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                var attachmentImg = document.createElement('img');
                                attachmentImg.src = '{{ asset('storage/') }}/' + attachment.path;
                                attachmentImg.alt = attachment.name;
                                attachmentImg.style.cssText = 'max-width: 100%; height: auto;';
                                attachmentItem.appendChild(attachmentImg);
                            } else {
                                var attachmentLink = document.createElement('a');
                                attachmentLink.href = '{{ asset('storage/') }}/' + attachment.path;
                                attachmentLink.target = '_blank';
                                attachmentLink.innerText = attachment.name;
                                attachmentItem.appendChild(attachmentLink);
                            }

                            attachmentsContainer.appendChild(attachmentItem);
                        });

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
