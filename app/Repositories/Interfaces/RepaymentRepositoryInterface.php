<?php

namespace App\Repositories\Interfaces;

use App\Models\Repayment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepaymentRepositoryInterface
{
    public function create(array $data): Repayment;

    public function findByLoanId(int $loanId): Collection;

    public function getAllWithPagination(int $perPage = 10): LengthAwarePaginator;

    public function getTotalRepayments(): float;
}
