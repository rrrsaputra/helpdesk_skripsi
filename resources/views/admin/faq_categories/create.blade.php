@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create FAQ Category" />
@endsection

@section('content')
    <div class="card card-primary">

        <form method="POST" action="{{ route('admin.faq_category.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Category Name <span class="text-danger" title="This field is required">*</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter category name">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Description <span class="text-danger" title="This field is required">*</span></label>
                    <textarea name="description" class="form-control" id="description" placeholder="Enter description" required></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.faq_category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection



