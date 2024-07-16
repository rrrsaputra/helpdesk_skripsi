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

                <div class="form-group">
                    <label for="for_user">For User</label>
                    <select class="form-control" name="for_user" id="for_user">
                        <option value="Standard" {{ $article->for_user == 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Premium" {{ $article->for_user == 'Premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <x-admin.summernote />
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.article.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
