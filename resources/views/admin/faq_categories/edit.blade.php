@extends('layouts.admin')

@section('header')
    <x-admin.header title="Update FaQ Category" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.faq_category.update', $faqCategory->id) }}">
            @csrf
            @method('PUT') 
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kategori" value="{{ old('name', $faqCategory->name) }}">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Masukkan deskripsi">{{ old('description', $faqCategory->description) }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.faq_category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
