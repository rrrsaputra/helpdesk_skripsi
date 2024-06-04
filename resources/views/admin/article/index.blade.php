@extends('layouts.admin')
@section('header')
    <x-admin.header title="List of Articles" />
@endsection

@section('content')
    <a href="{{ route('admin.article.create') }}" class="btn btn-primary">Create Article</a>
@endsection
