@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create Article" />
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Article</h3>
        </div>

        <!-- form start -->
        {{-- <form action="{{ route('article.store') }}" method="POST">
            @csrf
            <div>
                <label for="title">Judul:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="content">Konten:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <div>
                <label for="category">Kategori:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div>
                <label for="tags">Tag:</label>
                <input type="text" id="tags" name="tags">
            </div>
            <button type="submit">Simpan</button>
        </form> --}}

        {{-- {{ route('article.store') }} --}}
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
                <x-admin.summernote />
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection
