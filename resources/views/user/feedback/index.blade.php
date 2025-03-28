@extends('layouts.user')

@section('css')
    <link href="https://unpkg.com/filepond@4.30.4/dist/filepond.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="dx-main">

        <div class="dx-main">
            <div class="dx-separator"></div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert"
                    style="opacity: 1; transition: opacity 0.5s;">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('success-alert').style.opacity = '0';
                    }, 4500); // Mengurangi 500ms untuk transisi lebih halus
                    setTimeout(function() {
                        document.getElementById('success-alert').style.display = 'none';
                    }, 5000);
                </script>
            @endif
            <div class="dx-box-5 pb-100 bg-grey-6">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <form action="{{ route('user.feedback.store') }}" method="POST" class="dx-form"
                                enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                                @csrf
                                <div class="dx-box dx-box-decorated">
                                    <div class="dx-box-content">
                                        <h2 class="h6 mb-6">Umpan Balik</h2>
                                        <nav aria-label="breadcrumb">
                                            <uo class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Umpan Balik
                                                </li>
                                                </ol>
                                        </nav>

                                    </div>
                                    <div class="dx-separator"></div>


                                    <div class="dx-box-content">
                                        <link
                                            href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
                                            rel="stylesheet" />
                                        <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
                                        <div class="dx-form-group">
                                            <label for="category" class="mnt-7">Kategori Umpan Balik</label>
                                            <select class="form-control form-control-style-2" id="category"
                                                name="category">
                                                <option value="Complaint">Complaint</option>
                                                <option value="Suggestion">Suggestion</option>
                                                <option value="Compliment">Compliment</option>
                                            </select>
                                        </div>
                                        <div class="dx-form-group">
                                            <label for="subject" class="mnt-7">Subjek</label>
                                            <input type="text" class="form-control form-control-style-2" id="subject"
                                                placeholder="Enter Subject" name='subject'>
                                            @error('subject')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="dx-form-group">

                                            <label class="mnt-7">Lampiran</label>
                                            <input type="file" class="filepond" id="fileInput" multiple>
                                            <small class="form-text text-muted">Maksimal ukuran total lampiran: 10
                                                MB</small>
                                            <input type="hidden" name="filepond" id="hidden_filePaths">
                                        </div>
                                        <div class="dx-form-group">
                                            <label class="mnt-7">Pesan</label>
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
                                            @error('message')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="dx-separator"></div>

                                    <div class="dx-box-content">
                                        <div class="row justify-content-end mt-3">
                                            <div class="col-auto mb-20">
                                                <button type="submit" class="dx-btn dx-btn-lg mx-4 float-right my-3"
                                                    id="send_feedback"
                                                    style="background-color: #F38F2F; color: white; font-weight: bold;">Kirim
                                                </button>
                                            </div>
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
        document.getElementById('send_feedback').addEventListener('click', function(event) {
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

    <script src="https://unpkg.com/filepond@4.30.4/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.js"></script>
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
