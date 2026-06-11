@extends('layouts.app')

@section('title', 'Loan Applications')

@section('content')
<div class="content">
    <h2 style="margin-bottom: 30px; color: #333;">Loan Applications</h2>

    <form method="GET" action="{{ route('admin.loans') }}" style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center;">
        <select name="status" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <input type="text" name="search_name" placeholder="Search by customer name" value="{{ request('search_name') }}" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        <input type="text" name="search_email" placeholder="Search by email" value="{{ request('search_email') }}" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        <button type="submit" class="btn btn-primary">Apply Filters</button>
        <a href="{{ route('admin.loans') }}" class="btn" style="background: #6c757d; color: white;">Clear</a>
    </form>

    @if($loans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Tenure</th>
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
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->user->email }}</td>
                        <td>${{ number_format($loan->amount, 2) }}</td>
                        <td>{{ $loan->tenure }} months</td>
                        <td>{{ $loan->purpose }}</td>
                        <td>
                            <span class="badge badge-{{ $loan->status->value }}">
                                {{ ucfirst($loan->status->value) }}
                            </span>
                        </td>
                        <td>{{ $loan->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($loan->isPending())
                                <form method="POST" action="{{ route('admin.approve-loan', $loan->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" style="padding: 5px 10px; font-size: 12px;">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.reject-loan', $loan->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Reject</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $loans->links() }}
    @else
        <p style="color: #666; padding: 20px; text-align: center;">No loan applications found.</p>
    @endif
</div>
@endsection
