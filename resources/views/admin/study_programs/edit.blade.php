@extends('layouts.admin')

@section('header')
    <x-admin.header title="Update Study Program" />
@endsection

@section('content')
    <div class="card card-primary">
        <form method="POST" action="{{ route('admin.study_programs.update', $studyProgram->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Study Program Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                        placeholder="Enter study program name" value="{{ old('name', $studyProgram->name) }}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.study_programs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
