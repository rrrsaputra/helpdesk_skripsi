@extends('layouts.agent')
@section('header')
    <x-agent.header title="agenta"/>
@endsection

@section('content')
    @php
        $columns = ['','Customer', 'Summary', '', 'Number', 'Last Updated'];
        $data = [];
        foreach($tickets as $ticket) {
            $data[] = [
                'url' => '/path/to/resource1',
                'values' => ['',$ticket->user->name, [$ticket->title, $ticket->message ?? ''], '', $ticket->id, $ticket->last_updated]
            ];
        }
        $columnSizes = ['5%','10%', '50%', '10%', '10%', '15%'];
    @endphp
    <form action="{{ route('agent.ticket.store') }}" method="post">
        @csrf
        <input type="hidden" name="title" value="anjdsajfahfo">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <x-agent.jsgrid :columns="$columns" :data="$data" :columnSizes="$columnSizes"/>
@endsection
