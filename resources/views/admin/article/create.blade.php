@extends('layouts.admin')
@section('header')
    <x-admin.header title="Create Article" />
@endsection


@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Create Article</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="title" class="form-control" id="inputTitle" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Summernote</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
            <!-- /.card-body -->


            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
