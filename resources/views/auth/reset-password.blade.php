@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2>Reset Password</h2>

    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form action="{{ route('reset') }}" method="POST">
        @csrf
         <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>New Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-success">Reset Password</button>
    </form>
</div>
@endsection
