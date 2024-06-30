@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-box-5 bg-grey-6">
            <div class="container" style="max-height: calc(100vh - 100px); overflow-y: auto;">
                <a href="{{ route('user.ticket.index') }}" class="btn btn-secondary mb-3">Back</a>
                @if (isset($messages) && $messages->count() > 0)
                    <div class="messages-list" style="height: 100%;">
                        <div id="messages-container" style="max-height: 61.5vh; overflow-y: auto;">
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
                                        <p style="margin: 0; font-size: 0.8em; color: #888;">
                                            <small>{{ $message->created_at->format('d M Y, h:i A') }}</small>
                                        </p>
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
                    <input type="file" class="filepond" name="filepond[]" multiple
                        data-allow-reorder="true" data-max-file-size="3MB" data-max-files="3"
                        accept="image/*">

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
            }
        });
        // document.getElementById('message-form').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     var msgInput = document.getElementById('msg');
        //     var message = msgInput.value.trim();

        //     if (message === '') {
        //         return; // Do nothing if the message is empty
        //     }

        //     // Proceed with form submission
        //     var formData = new FormData(this);
        //     fetch(this.action, {
        //             method: 'POST',
        //             body: formData,
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                     'content')
        //             }
        //         }).then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 msgInput.value = ''; // Clear the input field
        //             }
        //         }).catch(error => console.error('Error:', error));
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

                fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
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
                            messageContent.appendChild(messageTime);

                            newMessage.appendChild(profilePic);
                            newMessage.appendChild(messageContent);

                            messagesContainer.appendChild(newMessage);
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        } else {
                            alert('Error sending message');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>

@endsection
