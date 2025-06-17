@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Events</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Event form --}}
    @if(session('api_token'))
    <h3>Create a New Event</h3>

    

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }} </textarea>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Start Date/Time</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required value="{{ old('start_time') }}">
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">End Date/Time</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control" required value="{{ old('end_time') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Event</button>
    </form>
    <hr>
@else
    <div class="alert alert-info">
        Please <a href="{{ route('login') }}">log in</a> to create an event.
    </div>
@endif

    @php
        $authUserId = session('user_id');
        $myEvents = collect($events)->where('user_id', (int) $authUserId);
        $otherEvents = collect($events)->where('user_id', '!=', (int) $authUserId);
    @endphp

    {{-- My Events --}}
    @if(session('api_token'))
        <h4>My Events</h4>
        @forelse($myEvents as $event)
            @include('events.partials.event-card', ['event' => $event])
        @empty
            <p class="text-muted">You haven't created any events yet.</p>
        @endforelse

        <hr>
    @endif

    {{-- All Other Events --}}
    <h4>All Events</h4>
    @forelse($otherEvents as $event)
        @include('events.partials.event-card', ['event' => $event])
    @empty
        <p class="text-muted">No other events available.</p>
    @endforelse
</div>
@endsection
