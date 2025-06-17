@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<h2>Edit Event</h2>
<form method="POST" action="{{ route('events.update', $event['id']) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ $event['name'] }}" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ $event['description'] }}</textarea>
    </div>
    <div class="mb-3">
        <label>Start Time</label>
        <input type="datetime-local" name="start_time" class="form-control" 
            value="{{ \Carbon\Carbon::parse($event['start_time'])->format('Y-m-d\TH:i') }}" required>
    </div>
    <div class="mb-3">
        <label>End Time</label>
        <input type="datetime-local" name="end_time" class="form-control" 
            value="{{ \Carbon\Carbon::parse($event['end_time'])->format('Y-m-d\TH:i') }}" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection
