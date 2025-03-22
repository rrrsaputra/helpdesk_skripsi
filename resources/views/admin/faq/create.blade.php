@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create FAQ" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.faq.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="title">
                        Question <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter question">
                    @if ($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="category">Category <span class="text-danger" title="This field is required">*</span></label>
                    <select class="form-control" id="category" name="category">
                        <option value="">Choose FAQ Category</option>
                        @foreach ($faqCategories as $faqCategory)
                            <option value="{{ $faqCategory->id }}">{{ $faqCategory->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                        <span class="text-danger">{{ $errors->first('category') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="content">Answer <span class="text-danger" title="This field is required">*</span></label>
                    <div id="editor" style="height: 300px; min-height: 300px;"></div>
                    <input type="hidden" name="content" id="content">
                    @if ($errors->has('content'))
                        <span class="text-danger">{{ $errors->first('content') }}</span>
                    @endif
                </div>
                <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
                <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                <script>
                    var quill = new Quill('#editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{
                                    'header': [1, 2, false]
                                }],
                                ['bold', 'italic', 'underline'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['image', 'code-block', 'video'],
                            ]
                        }
                    });
                    quill.on('text-change', function() {
                        document.getElementById('content').value = quill.root.innerHTML;
                    });
                    var editor = document.getElementById('editor');
                    var editorHeight = 300;
                    var maxHeight = 500;
                    quill.on('text-change', function() {
                        var currentHeight = quill.root.scrollHeight;
                        if (currentHeight > editorHeight && currentHeight < maxHeight) {
                            editor.style.height = currentHeight + 'px';
                        } else if (currentHeight >= maxHeight) {
                            editor.style.height = maxHeight + 'px';
                        }
                    });
                </script>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
