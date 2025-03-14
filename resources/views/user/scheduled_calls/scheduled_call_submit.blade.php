@extends('layouts.user')

@section('css')
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="dx-main">

        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <form id="scheduledCallForm" action="{{ route('user.scheduled-ticket.store') }}" method="POST"
                            class="dx-form" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                            <div class="dx-box dx-box-decorated">
                                <div class="dx-box-content">
                                    <h2 class="h6 mb-6">Scheduled a Call</h2>
                                    <!-- START: Breadcrumbs -->
                                    <nav aria-label="breadcrumb">
                                        <uo class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                            <li class="breadcrumb-item"><a
                                                    href="{{ route('scheduled_call.index') }}">Scheduled Calls</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Book Scheduled Call</li>
                                            </ol>
                                    </nav>
                                    <!-- END: Breadcrumbs -->
                                </div>

                                <div class="dx-separator"></div>

                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="date" class="mnt-7">Choose Date</label>
                                        <input type="date" class="form-control form-control-style-2" id="date"
                                            name="date" min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="time" class="mnt-7">Choose Time</label>
                                        <select class="form-control form-control-style-2" id="time" name="time">
                                            <option value="09:00">09:00 AM</option>
                                            <option value="09:30">09:30 AM</option>
                                            <option value="10:00">10:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="11:00">11:00 AM</option>
                                            <option value="11:30">11:30 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="12:30">12:30 PM</option>
                                            <option value="13:00">01:00 PM</option>
                                            <option value="13:30">01:30 PM</option>
                                            <option value="14:00">02:00 PM</option>
                                            <option value="14:30">02:30 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="15:30">03:30 PM</option>
                                            <option value="16:00">04:00 PM</option>
                                            <option value="16:30">04:30 PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="duration" class="mnt-7">Choose Duration</label>
                                        <select class="form-control form-control-style-2" id="duration" name="duration">
                                            <option value="30">30 minutes</option>
                                            <option value="45">45 minutes</option>
                                            <option value="60">60 minutes</option>
                                            <option value="90">90 minutes</option>
                                        </select>
                                    </div>

                                </div>
                                @csrf
                                <div class="dx-box-content">
                                    <div class="dx-form-group">
                                        <label for="category" class="mnt-7">Call Category</label>
                                        <select class="form-control form-control-style-2" name="category" id="category">
                                            @foreach ($callCategories as $callCategory)
                                                <option value="{{ $callCategory->name }}">{{ $callCategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="dx-box-content">
                                    <link
                                        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
                                        rel="stylesheet" />
                                    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
                                    <div class="dx-form-group">
                                        <label for="subject" class="mnt-7">Subject</label>
                                        <input type="text" class="form-control form-control-style-2" id="subject"
                                            placeholder="Enter Subject" name='title'>
                                    </div>

                                    <div class="dx-form-group">

                                        <label class="mnt-7">Attachments</label>
                                        <input type="file" class="filepond" id="fileInput" multiple>
                                        <input type="hidden" name="filepond" id="hidden_filePaths">
                                    </div>
                                    <div class="dx-form-group">
                                        <label class="mnt-7">Message</label>
                                        <div class="dx-editors" data-editor-height="150" data-editor-maxheight="250"
                                            style="min-height: 150px; max-height: 250px;">
                                        </div>
                                        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
                                        <script>
                                            const quill = new Quill('.dx-editors', {
                                                theme: 'snow',
                                                modules: {
                                                    toolbar: true
                                                },
                                                placeholder: 'Write a message...',
                                                bounds: '.dx-editors',
                                                scrollingContainer: '.dx-editors',
                                            });
                                            quill.on('text-change', function() {
                                                const editorHeight = quill.root.scrollHeight;
                                                const maxHeight = 250;
                                                const minHeight = 150;
                                                if (editorHeight > maxHeight) {
                                                    quill.root.style.height = `${maxHeight}px`;
                                                } else if (editorHeight < minHeight) {
                                                    quill.root.style.height = `${minHeight}px`;
                                                } else {
                                                    quill.root.style.height = `${editorHeight}px`;
                                                }
                                                document.getElementById('message').value = quill.root.innerHTML;
                                            });
                                        </script>
                                        <input type="hidden" name="message" id="message">
                                    </div>
                                </div>


                                <div class="dx-separator"></div>
                                <div class="dx-box-content">
                                    <div class="row justify-content-end mt-3">
                                        <div class="col-auto mb-20">
                                            <button type="submit" class="btn btn-primary" id="send_call">Send
                                                Call</button>


                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script>
        document.getElementById('send_call').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah form dikirim langsung
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
            // Kirim form setelah mengambil file
            event.target.closest('form').submit();
        });
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

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        const quill = new Quill('.dx-editors', {
            theme: 'snow',
            modules: {
                toolbar: true
            },
            placeholder: 'Write a message...',
            bounds: '.dx-editors',
            scrollingContainer: '.dx-editors',
        });
        quill.on('text-change', function() {
            const editorHeight = quill.root.scrollHeight;
            const maxHeight = 250;
            const minHeight = 150;
            if (editorHeight > maxHeight) {
                quill.root.style.height = `${maxHeight}px`;
            } else if (editorHeight < minHeight) {
                quill.root.style.height = `${minHeight}px`;
            } else {
                quill.root.style.height = `${editorHeight}px`;
            }
            document.getElementById('message').value = quill.root.innerHTML;
        });
    </script>
@endpush
