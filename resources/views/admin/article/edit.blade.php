@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create Article" />
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
                <x-admin.summernote />
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.article.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
