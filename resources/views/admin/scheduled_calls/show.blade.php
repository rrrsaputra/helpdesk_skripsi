@extends('layouts.admin')
@section('header')
    <x-admin.header title="List of Schedule Calls" />
@endsection

@section('content')
<form method="POST" action="{{ route('admin.scheduled_call.update', $scheduledCall->id) }}">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="agentSelect">Choose Agent:</label>
        <select id="agentSelect" name="agent_id" class="form-control" onchange="updateUrl()">
            <option value="" {{ request()->query('agent') ? '' : 'selected' }} disabled>Pick Agent</option>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ request()->query('agent') == $agent->id ? 'selected' : '' }}>
                    {{ $agent->name }} ({{ $agent->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="date">Day:</label>
        <select id="date" name="date" class="form-control" onchange="updateUrl()">
            <option value="" {{ request()->query('date') ? '' : 'selected' }} disabled>Select an agent first</option>
            @foreach ($businessHours as $businessHour)
                @if($businessHour)
                    <option value="{{ $businessHour->day }} {{ $businessHour->from }}" {{ request()->query('date') == $businessHour->day ? 'selected' : '' }}>
                        {{ $businessHour->day }} {{ $businessHour->from }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
    <script>
        function updateUrl() {
            const agentId = document.getElementById('agentSelect').value;
            const date = document.getElementById('date').value;
            if (agentId && date) {
                window.location.href = "{{ route('admin.scheduled_call.show', $scheduledCall->id) }}" + `?agent=${agentId}&date=${date}`;
            }
        }
    </script>
    <div class="form-group">
        <label for="time">Hour</label>
        <select id="time" name="time" class="form-control" {{ !request()->query('agent') || !request()->query('date') ? 'disabled' : '' }}>
            @if(request()->query('agent') && request()->query('date'))
                @foreach ($availableTimes as $time)
                    <option value="{{ $time }}">
                        {{ $time }}
                    </option>
                @endforeach
            @else
                <option value="" disabled>Select an agent and date first</option>
            @endif
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
@endsection
