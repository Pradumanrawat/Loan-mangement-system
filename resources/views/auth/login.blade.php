@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="content" style="max-width: 400px; margin: 50px auto;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Login</h2>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
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

        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
    </form>

    <p style="text-align: center; margin-top: 20px;">
        Don't have an account? <a href="{{ route('register') }}" style="color: #667eea;">Register here</a>
    </p>
</div>
@endsection
