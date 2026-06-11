<?php

namespace App\Repositories\Interfaces;

use App\Models\Loan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface LoanRepositoryInterface
{
    public function create(array $data): Loan;

    public function findById(int $id): ?Loan;

    public function findByUserId(int $userId): LengthAwarePaginator;

    public function getAllWithPagination(int $perPage = 10): LengthAwarePaginator;

    public function getByStatus(string $status): LengthAwarePaginator;

    public function updateStatus(int $id, string $status): ?Loan;

    public function searchByName(string $name): LengthAwarePaginator;

    public function searchByEmail(string $email): LengthAwarePaginator;

    public function getFilteredLoans(?string $status, ?string $searchName, ?string $searchEmail, int $perPage = 10): LengthAwarePaginator;

    /** @return array<string, int|float> */
    public function getDashboardStats(): array;
}
