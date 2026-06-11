@extends('layouts.app')

@section('title', 'Apply for Loan')

@section('content')
<div class="content" style="max-width: 500px; margin: 50px auto;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Apply for Loan</h2>

    <form method="POST" action="{{ route('customer.apply-loan.post') }}">
        @csrf

        <div class="form-group">
            <label for="amount">Loan Amount ($)</label>
            <input type="number" id="amount" name="amount" step="0.01" min="0.01" required>
            @error('amount')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tenure">Loan Tenure (Months)</label>
            <input type="number" id="tenure" name="tenure" min="1" max="60" required>
            @error('tenure')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="purpose">Loan Purpose</label>
            <input type="text" id="purpose" name="purpose" required>
            @error('purpose')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Application</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('customer.dashboard') }}" class="btn" style="color: #666;">Cancel</a>
    </div>
</div>
@endsection
