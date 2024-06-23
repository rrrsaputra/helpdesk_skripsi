@extends('layouts.admin')

@section('header')
    <x-admin.header title="Update Article Category" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.article_category.update', $articleCategory->id) }}">
            @csrf
            @method('PUT') 
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kategori" value="{{ old('name', $articleCategory->name) }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.article_category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
