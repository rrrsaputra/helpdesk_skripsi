@extends('layouts.admin')

@section('header')
    <x-admin.header title="Dashboard" />
@endsection

@section('content')
    <div class="card card-primary">
        {{-- <div class="card-header">
            <h3 class="card-title">Create Article</h3>
        </div> --}}

        <!-- form start -->
        {{-- <form method="POST" action="{{ route('article.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category">
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                        <option value="3">Category 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tag">Tag</label>
                    <select class="form-control" id="tag" name="tag">
                        <option value="1">Tag 1</option>
                        <option value="2">Tag 2</option>
                        <option value="3">Tag 3</option>
                    </select>
                </div>
                
                <x-admin.summernote />

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> --}}
    </div>
@endsection
