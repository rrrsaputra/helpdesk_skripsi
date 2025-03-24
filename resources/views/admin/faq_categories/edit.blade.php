@extends('layouts.admin')

@section('header')
    <x-admin.header title="Update FAQ Category" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.faq_category.update', $faqCategory->id) }}">
            @csrf
            @method('PUT') 
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nama Kategori <span class="text-danger" title="This field is required">*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kategori" value="{{ old('name', $faqCategory->name) }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi <span class="text-danger" title="This field is required">*</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Masukkan deskripsi" required>{{ old('description', $faqCategory->description) }}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.faq_category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
