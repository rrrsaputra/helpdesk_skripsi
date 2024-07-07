@extends('layouts.user')

@section('content')
    <div class="dx-main">
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

        <div class="dx-main">
            <div class="dx-separator"></div>
            <div class="dx-box-5 pb-100 bg-grey-6">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-7">
                            <form action="{{ route('user.feedback.store') }}" method="POST" class="dx-form">
                                <div class="dx-box dx-box-decorated">
                                    <div class="dx-box-content">
                                        <h2 class="h6 mb-6">Feedback</h2>
                                        <nav aria-label="breadcrumb">
                                            <uo class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Submit a Feedback</li>
                                            </ol>
                                        </nav>

                                    </div>
                                    <div class="dx-separator"></div>

                                    @csrf
                                    <div class="dx-box-content">
                                        <div class="dx-form-group">
                                            <label for="category" class="mnt-7">Feedback Category</label>
                                            <select class="form-control form-control-style-2" id="category"
                                                name="category">
                                                <option value="Complaint">Complaint</option>
                                                <option value="Suggestion">Suggestion</option>
                                                <option value="Compliment">Compliment</option>
                                            </select>
                                        </div>
                                        <div class="dx-form-group">
                                            <label for="subject" class="mnt-7">Subject</label>
                                            <input type="text" class="form-control form-control-style-2" id="subject"
                                                placeholder="Enter Subject" name='subject'>
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
                                                document.querySelector('.dx-editors').addEventListener('keyup', function() {
                                                    document.getElementById('message').value = quill.root.innerHTML;
                                                });
                                            </script>
                                            <input type="hidden" name="message" id="message">
                                        </div>

                                    </div>
                                    <button class="dx-btn dx-btn-lg mx-4 float-right my-3" type="submit"
                                        name="submit">Submit</button>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
