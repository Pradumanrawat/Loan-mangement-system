<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanApplicationRequest;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Services\LoanService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected LoanRepositoryInterface $loanRepository,
        protected LoanService $loanService
    ) {
    }

    /**
     * Apply for a loan via API (customers only).
     */
    public function apply(LoanApplicationRequest $request)
    {
        if (auth()->user()->role !== UserRole::Customer) {
            return $this->errorResponse('Only customers can apply for loans.', 403);
        }

        $loan = $this->loanService->submitApplication(auth()->id(), $request->validated());

        return $this->successResponse('Loan application submitted successfully', ['loan' => $loan], 201);
    }

    /**
     * Get authenticated customer's loan applications.
     */
    public function status(Request $request)
    {
        $loans = $this->loanRepository->findByUserId(auth()->id());

        return $this->successResponse('Loan status retrieved successfully', ['loans' => $loans]);
    }
}
