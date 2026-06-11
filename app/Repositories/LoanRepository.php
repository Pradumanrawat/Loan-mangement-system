<?php

namespace App\Repositories;

use App\Enums\LoanStatus;
use App\Enums\UserRole;
use App\Models\Loan;
use App\Models\Repayment;
use App\Models\User;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LoanRepository implements LoanRepositoryInterface
{
    public function __construct(protected Loan $model)
    {
    }

    public function create(array $data): Loan
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Loan
    {
        return $this->model->with('user')->find($id);
    }

    public function findByUserId(int $userId): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)->orderByDesc('created_at')->paginate(10);
    }

    public function getAllWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('user')->orderByDesc('created_at')->paginate($perPage);
    }

    public function getByStatus(string $status): LengthAwarePaginator
    {
        return $this->model->with('user')->where('status', $status)->orderByDesc('created_at')->paginate(10);
    }

    public function updateStatus(int $id, string $status): ?Loan
    {
        $loan = $this->model->find($id);

        if (! $loan) {
            return null;
        }

        $loan->status = $status;
        $loan->save();

        return $loan->fresh();
    }

    public function searchByName(string $name): LengthAwarePaginator
    {
        return $this->model->whereHas('user', function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%');
        })->with('user')->orderByDesc('created_at')->paginate(10);
    }

    public function searchByEmail(string $email): LengthAwarePaginator
    {
        return $this->model->whereHas('user', function ($query) use ($email) {
            $query->where('email', 'like', '%'.$email.'%');
        })->with('user')->orderByDesc('created_at')->paginate(10);
    }

    public function getFilteredLoans(?string $status, ?string $searchName, ?string $searchEmail, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('user')->orderByDesc('created_at');

        if ($status) {
            $query->where('status', $status);
        }

        if ($searchName) {
            $query->whereHas('user', function ($userQuery) use ($searchName) {
                $userQuery->where('name', 'like', '%'.$searchName.'%');
            });
        }

        if ($searchEmail) {
            $query->whereHas('user', function ($userQuery) use ($searchEmail) {
                $userQuery->where('email', 'like', '%'.$searchEmail.'%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getDashboardStats(): array
    {
        return [
            'total_customers' => User::where('role', UserRole::Customer->value)->count(),
            'total_applications' => $this->model->count(),
            'approved_loans' => $this->model->where('status', LoanStatus::Approved->value)->count(),
            'rejected_loans' => $this->model->where('status', LoanStatus::Rejected->value)->count(),
            'pending_loans' => $this->model->where('status', LoanStatus::Pending->value)->count(),
            'total_repayments' => Repayment::sum('amount_paid'),
        ];
    }
}
