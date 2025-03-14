@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create FaQ Category" />
@endsection

@section('content')
    <div class="card card-primary">

        <form method="POST" action="{{ route('admin.faq_category.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter category name">
                </div>
                <div >
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.faq_category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection



