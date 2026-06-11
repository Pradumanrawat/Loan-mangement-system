@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="content">
    <h2 style="margin-bottom: 20px; color: #333;">Welcome, {{ $user->name }}!</h2>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('customer.apply-loan') }}" class="btn btn-primary">Apply for New Loan</a>
    </div>

    <h3 style="margin-bottom: 15px; color: #333;">My Loan Applications</h3>

    @if($loans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Tenure (Months)</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->id }}</td>
                        <td>${{ number_format($loan->amount, 2) }}</td>
                        <td>{{ $loan->tenure }}</td>
                        <td>{{ $loan->purpose }}</td>
                        <td>
                            <span class="badge badge-{{ $loan->status->value }}">
                                {{ ucfirst($loan->status->value) }}
                            </span>
                        </td>
                        <td>{{ $loan->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($loan->isApproved())
                                <a href="{{ route('customer.repayment', $loan->id) }}" class="btn btn-success" style="padding: 5px 10px; font-size: 12px;">Make Repayment</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $loans->links() }}
    @else
        <p style="color: #666; padding: 20px; text-align: center;">No loan applications found. <a href="{{ route('customer.apply-loan') }}" style="color: #667eea;">Apply for your first loan</a></p>
    @endif
</div>
@endsection
