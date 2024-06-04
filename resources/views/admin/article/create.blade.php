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
        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="title" class="form-control" id="inputTitle" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category">
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                        <option value="3">Category 3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Tag</label>
                    <select class="form-control" id="tag">
                        <option value="1">Tag 1</option>
                        <option value="2">Tag 2</option>
                        <option value="3">Tag 3</option>
                    </select>
                </div>
                {{-- Summernote component --}}
                <x-admin.summernote />

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
    </div>
@endsection
