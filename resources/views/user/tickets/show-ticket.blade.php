@extends('layouts.user')
@section('header')
    <h1>Ticket: {{ $ticket->references }} - {{ $ticket->category }} - {{ $ticket->title }}</h1>
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

    @if ($ticket->status !== 'closed' && $ticket->messages()->where('user_id', Auth::id())->count() < 20)
        <form id="message-form" action="{{ route('agent.messages.store', ['id' => $ticket_id]) }}" method="POST"
            style="width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 5px rgba(0,0,0,0.1); margin-bottom: 0;">
            @csrf

            <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                <button type="button" onclick="toggleAttachmentInput()" class="dx-btn dx-btn-md"
                    style="background-color: #F38F2F; color: white; border: none; border-radius: 5px; padding: 10px 15px; cursor: pointer; transition: background-color 0.3s; margin: 10px 0; display: inline-block;">
                    Tambah Lampiran
                </button>
                <p style="margin: 0; color: #888; display: inline-block; margin-left: 10px;">
                    <small>Remaining messages: {{ 20 - $ticket->messages()->where('user_id', Auth::id())->count() }}</small>
                </p>
                </div>
                <p id="ticket-info"
                    style="margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px; cursor: pointer;"
                    onclick="showModal()">
                    {{ $ticket->references }} - {{ $ticket->title }}
                </p>
            </div>

            <!-- Modal -->
            <div id="ticketModal" class="modal"
                style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">
                <div class="modal-content"
                    style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%;">
                    <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;"
                        onclick="closeModal()">&times;</span>
                    <p>{{ $ticket->references }} - {{ $ticket->title }}</p>
                </div>
            </div>

            <script>
                function showModal() {
                    document.getElementById('ticketModal').style.display = "block";
                }

                function closeModal() {
                    document.getElementById('ticketModal').style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == document.getElementById('ticketModal')) {
                        closeModal();
                    }
                }
            </script>

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
                        // Handle file upload
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
            <button id="btn" type="submit" class="btn btn-primary" style="background-color: #F38F2F; border-color: #F38F2F">Kirim</button>
        </form>
    @else
        @if ($ticket->status == 'closed')
            <div class="alert alert-info" role="alert" style="border-radius: 10px; padding: 15px; font-size: 1.1em; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <strong>Info:</strong> Tiket ini sudah ditutup. Anda tidak dapat mengirim pesan lagi.
            </div>
        @elseif ($ticket->messages->count() >= 20)
            <div class="alert alert-warning" role="alert" style="border-radius: 10px; padding: 15px; font-size: 1.1em; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <strong>Peringatan:</strong> Tiket ini telah mencapai jumlah maksimum pesan (20).
            </div>
        @endif
    @endif

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
                    // Handle no files case
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

                   // Kirim form setelah mengambil file
                event.target.closest('form').submit();
            });
        });
    </script>
@endsection
