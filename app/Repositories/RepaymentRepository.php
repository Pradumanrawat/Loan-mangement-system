<?php

namespace App\Repositories;

use App\Models\Repayment;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RepaymentRepository implements RepaymentRepositoryInterface
{
    public function __construct(protected Repayment $model)
    {
    }

    public function create(array $data): Repayment
    {
        return $this->model->create($data);
    }

    public function findByLoanId(int $loanId): Collection
    {
        return $this->model->where('loan_id', $loanId)->orderByDesc('payment_date')->get();
    }

    public function getAllWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('loan.user')->orderByDesc('payment_date')->paginate($perPage);
    }

    public function getTotalRepayments(): float
    {
        return (float) $this->model->sum('amount_paid');
    }
}
