<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanApplicationRequest;
use App\Http\Requests\RepaymentRequest;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;
use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class CustomerController extends Controller
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository,
        protected RepaymentRepositoryInterface $repaymentRepository,
        protected LoanService $loanService
    ) {
    }

    /**
     * Show customer dashboard with paginated loan applications.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $loans = $this->loanRepository->findByUserId($user->id);

        return view('customer.dashboard', compact('loans', 'user'));
    }

    /**
     * Show loan application form.
     */
    public function showLoanApplicationForm()
    {
        return view('customer.apply-loan');
    }

    /**
     * Handle loan application submission.
     */
    public function applyLoan(LoanApplicationRequest $request)
    {
        $this->loanService->submitApplication(Auth::id(), $request->validated());

        return redirect()->route('customer.dashboard')->with('success', 'Loan application submitted successfully!');
    }

    /**
     * Show repayment form for an approved loan.
     */
    public function showRepaymentForm($loanId)
    {
        try {
            $loan = $this->loanService->getCustomerLoan((int) $loanId, Auth::id());
        } catch (InvalidArgumentException $e) {
            return redirect()->route('customer.dashboard')->with('error', $e->getMessage());
        }

        if (! $loan->isApproved()) {
            return redirect()->route('customer.dashboard')->with('error', 'Cannot make repayment on pending or rejected loan.');
        }

        $repayments = $this->repaymentRepository->findByLoanId($loanId);

        return view('customer.make-repayment', compact('loan', 'repayments'));
    }

    /**
     * Record a loan repayment.
     */
    public function makeRepayment(RepaymentRequest $request)
    {
        try {
            $repayment = $this->loanService->recordRepayment(Auth::id(), $request->validated());

            return redirect()
                ->route('customer.repayment', $repayment->loan_id)
                ->with('success', 'Repayment recorded successfully!');
        } catch (InvalidArgumentException $e) {
            return redirect()->route('customer.dashboard')->with('error', $e->getMessage());
        }
    }
}
