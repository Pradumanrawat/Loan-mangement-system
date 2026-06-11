@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="content">
    <h2 style="margin-bottom: 30px; color: #333;">Admin Dashboard</h2>

    <div style="margin-bottom: 25px; display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('admin.loans') }}" class="btn btn-primary">View Loan Applications</a>
        <a href="{{ route('admin.repayments') }}" class="btn btn-primary">View Repayments</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ $stats['total_customers'] }}</h3>
            <p>Total Customers</p>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['total_applications'] }}</h3>
            <p>Total Applications</p>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['approved_loans'] }}</h3>
            <p>Approved Loans</p>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['rejected_loans'] }}</h3>
            <p>Rejected Loans</p>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['pending_loans'] }}</h3>
            <p>Pending Loans</p>
        </div>
        <div class="stat-card">
            <h3>${{ number_format($stats['total_repayments'], 2) }}</h3>
            <p>Total Repayments</p>
        </div>
    </div>
</div>
@endsection
