@extends('layouts.admin')

@section('header')
    <x-admin.header title="Create Study Program" />
@endsection

@section('content')
    <div class="card card-primary">

        <form method="POST" action="{{ route('admin.study_programs.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Study Program Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter study program name">
                </div>
                <div >
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.study_programs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection



