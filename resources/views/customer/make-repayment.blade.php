@extends('layouts.app')

@section('title', 'Make Repayment')

@section('content')
<div class="content" style="max-width: 500px; margin: 50px auto;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Make Loan Repayment</h2>

    <div class="card" style="margin-bottom: 20px;">
        <h3>Loan Details</h3>
        <p><strong>Loan ID:</strong> {{ $loan->id }}</p>
        <p><strong>Total Amount:</strong> ${{ number_format($loan->amount, 2) }}</p>
        <p><strong>Tenure:</strong> {{ $loan->tenure }} months</p>
        <p><strong>Purpose:</strong> {{ $loan->purpose }}</p>
        <p><strong>Status:</strong> <span class="badge badge-{{ $loan->status->value }}">{{ ucfirst($loan->status->value) }}</span></p>
    </div>

    <form method="POST" action="{{ route('customer.repayment.post') }}">
        @csrf

        <div class="form-group">
            <label for="loan_id">Loan ID</label>
            <input type="number" id="loan_id" name="loan_id" value="{{ $loan->id }}" readonly>
        </div>

        <div class="form-group">
            <label for="amount_paid">Repayment Amount ($)</label>
            <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0.01" required>
            @error('amount_paid')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="payment_date">Payment Date</label>
            <input type="date" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
            @error('payment_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success" style="width: 100%;">Submit Repayment</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('customer.dashboard') }}" class="btn" style="color: #666;">Back to Dashboard</a>
    </div>

    @if($repayments->count() > 0)
        <h3 style="margin-top: 30px; margin-bottom: 15px; color: #333;">Repayment History</h3>
        <table>
            <thead>
                <tr>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repayments as $repayment)
                    <tr>
                        <td>${{ number_format($repayment->amount_paid, 2) }}</td>
                        <td>{{ $repayment->payment_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
