@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Event</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('events.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Start Time</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Time</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
