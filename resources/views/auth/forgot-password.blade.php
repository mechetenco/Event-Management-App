@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2>Forgot Password</h2>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form action="{{ route('forgot') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button class="btn btn-primary">Send Reset Link</button>
    </form>
</div>
@endsection
