@extends('layouts.app')

@section('content')
  {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@php
    $token = session('api_token');
    $userId = session('user_id');
     $attending = collect($attendees)->firstWhere('user_id', $userId);
    $isAttending = false;

    if ($token && isset($attendees)) {
        $isAttending = collect($attendees)->contains(function ($attendee) use ($userId) {
            return $attendee['user']['id'] === $userId;
        });
    }
@endphp

@if($token)
    @if($isAttending)
       <form action="{{ route('events.unattend', ['eventId' => $event['id'], 'attendeeId' => $attending['id']]) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm">Unattend</button>
</form>

    @else
        <form action="{{ route('events.attend', $event['id']) }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-success">Attend</button>
        </form>
    @endif
@else
    <div class="alert alert-info mt-3">Please <a href="{{ route('login') }}">log in</a> to attend this event.</div>
@endif

<div class="container py-5">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
           @if($event)
    <h2>{{ $event['name'] }}</h2>
    <p><strong>Date:</strong> {{ $event['start_time'] }}</p>
    <p><strong>Description:</strong> {{ $event['description'] }}</p>
@else
    <p>Event details not available.</p>
@endif

        </div>
    </div>

    <h4 class="mb-3">Attendees</h4>
    <ul class="list-group">
        <p><strong>{{ count($attendees) }}</strong> attending</p>


     @php
    $authUserId = session('user_id');
    $eventOwnerId = $event['user']['id'] ?? null;
@endphp

@if($authUserId && $eventOwnerId === $authUserId)
    <h5 class="mt-4">Attendees</h5>
    <ul class="list-group">
        @forelse($attendees as $attendee)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $attendee['user']['name'] }}</span>
                <span>({{ $attendee['user']['email'] }})</span>
            </li>
        @empty
            <li class="list-group-item text-muted">No attendees found.</li>
        @endforelse
    </ul>
@endif



    <a href="{{ route('events.index') }}" class="btn btn-secondary mt-4">Back to Events</a>
</div>
@endsection
