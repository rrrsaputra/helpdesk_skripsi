@extends('layouts.admin')

@section('header')
    <x-admin.header title="Edit Article" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.article.update', $article->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title"
                        value="{{ $article->title }}">
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category">
                        @foreach ($articleCategories as $articleCategory)
                            <option value="{{ $articleCategory->id }}">{{ $articleCategory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="for_user">For User</label>
                    <select class="form-control" name="for_user" id="for_user">
                        <option value="Standard" {{ $article->for_user == 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Premium" {{ $article->for_user == 'Premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <div id="editor" style="height: 300px; min-height: 300px;"></div>
                    <input type="hidden" name="content" id="content" value="{{ $article->content }}">
                </div>
                <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
                <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                <script>
                    var quill = new Quill('#editor', {
                        theme: 'snow',
                        modules: {
                            toolbar: [
                                [{ 'header': [1, 2, false] }],
                                ['bold', 'italic', 'underline'],
                                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                ['image', 'code-block', 'video'],
                            ]
                        }
                    });
                    // Set initial content
                    quill.root.innerHTML = {!! json_encode($article->content) !!};
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
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.article.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
