@extends('layouts.admin')
@section('header')
    <x-admin.header title="List of Schedule Calls" />
@endsection

@section('content')
<form method="POST" action="{{ route('admin.scheduled_call.update', $user->id) }}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="agentSelect">Choose Agent:</label>
        <select id="agentSelect" name="agent_id" class="form-control" onchange="updateUrl()">
            <option value="" {{ request()->query('agent') ? '' : 'selected' }} disabled>Pick User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ request()->query('user') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
@endsection
