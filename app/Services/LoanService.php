<?php

namespace App\Services;

use App\Enums\LoanStatus;
use App\Models\Loan;
use App\Models\Repayment;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Centralizes loan and repayment business rules.
 * Controllers delegate here to keep HTTP layer thin and logic testable.
 */
class LoanService
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository,
        protected RepaymentRepositoryInterface $repaymentRepository
    ) {
    }

    public function submitApplication(int $userId, array $data): Loan
    {
        return $this->loanRepository->create([
            'user_id' => $userId,
            'amount' => $data['amount'],
            'tenure' => $data['tenure'],
            'purpose' => $data['purpose'],
            'status' => LoanStatus::Pending->value,
        ]);
    }

    public function approveLoan(int $loanId): Loan
    {
        $loan = $this->findLoanOrFail($loanId);

        if (! $loan->isPending()) {
            throw new InvalidArgumentException('Only pending loans can be approved.');
        }

        return $this->updateStatusOrFail($loanId, LoanStatus::Approved->value);
    }

    public function rejectLoan(int $loanId): Loan
    {
        $loan = $this->findLoanOrFail($loanId);

        if (! $loan->isPending()) {
            throw new InvalidArgumentException('Only pending loans can be rejected.');
        }

        return $this->updateStatusOrFail($loanId, LoanStatus::Rejected->value);
    }

    public function recordRepayment(int $userId, array $data): Repayment
    {
        $loan = $this->findLoanOrFail($data['loan_id']);

        if ($loan->user_id !== $userId) {
            throw new InvalidArgumentException('You are not authorized to repay this loan.');
        }

        if (! $loan->isApproved()) {
            throw new InvalidArgumentException('Repayments are only allowed on approved loans.');
        }

        return DB::transaction(function () use ($data) {
            return $this->repaymentRepository->create([
                'loan_id' => $data['loan_id'],
                'amount_paid' => $data['amount_paid'],
                'payment_date' => $data['payment_date'],
            ]);
        });
    }

    public function getCustomerLoan(int $loanId, int $userId): Loan
    {
        $loan = $this->findLoanOrFail($loanId);

        if ($loan->user_id !== $userId) {
            throw new InvalidArgumentException('Loan not found.');
        }

        return $loan;
    }

    protected function findLoanOrFail(int $loanId): Loan
    {
        $loan = $this->loanRepository->findById($loanId);

        if (! $loan) {
            throw new ModelNotFoundException('Loan not found.');
        }

        return $loan;
    }

    protected function updateStatusOrFail(int $loanId, string $status): Loan
    {
        $loan = $this->loanRepository->updateStatus($loanId, $status);

        if (! $loan) {
            throw new ModelNotFoundException('Loan not found.');
        }

        return $loan;
    }
}
