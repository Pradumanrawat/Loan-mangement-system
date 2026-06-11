@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="content" style="max-width: 400px; margin: 50px auto;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Register</h2>

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
            @error('mobile')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
    </form>

    <p style="text-align: center; margin-top: 20px;">
        Already have an account? <a href="{{ route('login') }}" style="color: #667eea;">Login here</a>
    </p>
</div>
@endsection
