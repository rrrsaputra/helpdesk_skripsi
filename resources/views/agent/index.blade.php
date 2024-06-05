@extends('layouts.agent')
@section('header')
    <x-agent.header title=agenta/>
@endsection

{{-- Start of Selection --}}
@section('content')
    <form action="{{ route('agent.ticket.store')}}" method="post">
        @csrf
        <input type="hidden" name="title" value="anjdsajfahfo">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <x-agent.jsgrid/>
@endsection
{{-- End of Selection --}}