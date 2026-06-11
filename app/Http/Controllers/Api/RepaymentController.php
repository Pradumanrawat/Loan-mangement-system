<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RepaymentRequest;
use App\Services\LoanService;
use App\Traits\ApiResponse;
use InvalidArgumentException;

class RepaymentController extends Controller
{
    use ApiResponse;

    public function __construct(protected LoanService $loanService)
    {
    }

    /**
     * Record a repayment against an approved loan via API.
     */
    public function store(RepaymentRequest $request)
    {
        try {
            $repayment = $this->loanService->recordRepayment(auth()->id(), $request->validated());

            return $this->successResponse('Repayment recorded successfully', ['repayment' => $repayment], 201);
        } catch (InvalidArgumentException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        }
    }
}
