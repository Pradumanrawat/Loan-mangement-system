@extends('layouts.app')

@section('title', 'Repayment History')

@section('content')
<div class="content">
    <h2 style="margin-bottom: 30px; color: #333;">Repayment History</h2>

    @if($repayments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Loan ID</th>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repayments as $repayment)
                    <tr>
                        <td>{{ $repayment->id }}</td>
                        <td>{{ $repayment->loan->user->name }}</td>
                        <td>{{ $repayment->loan_id }}</td>
                        <td>${{ number_format($repayment->amount_paid, 2) }}</td>
                        <td>{{ $repayment->payment_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $repayments->links() }}
    @else
        <p style="color: #666; padding: 20px; text-align: center;">No repayment records found.</p>
    @endif
</div>
@endsection
