<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoanFilterRequest;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;
use App\Services\LoanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use InvalidArgumentException;

class AdminController extends Controller
{
    public function __construct(
        protected LoanRepositoryInterface $loanRepository,
        protected RepaymentRepositoryInterface $repaymentRepository,
        protected LoanService $loanService
    ) {
    }

    public function dashboard(): View
    {
        $stats = $this->loanRepository->getDashboardStats();

        return view('admin.dashboard', compact('stats'));
    }

    public function loans(AdminLoanFilterRequest $request): View
    {
        $validated = $request->validated();

        $loans = $this->loanRepository->getFilteredLoans(
            $validated['status'] ?? null,
            $validated['search_name'] ?? null,
            $validated['search_email'] ?? null
        );

        return view('admin.loans', compact('loans'));
    }

    public function approveLoan(int $id): RedirectResponse
    {
        try {
            $this->loanService->approveLoan($id);

            return redirect()->route('admin.loans')->with('success', 'Loan approved successfully!');
        } catch (InvalidArgumentException $e) {
            return redirect()->route('admin.loans')->with('error', $e->getMessage());
        }
    }

    public function rejectLoan(int $id): RedirectResponse
    {
        try {
            $this->loanService->rejectLoan($id);

            return redirect()->route('admin.loans')->with('success', 'Loan rejected successfully!');
        } catch (InvalidArgumentException $e) {
            return redirect()->route('admin.loans')->with('error', $e->getMessage());
        }
    }

    public function repayments(): View
    {
        $repayments = $this->repaymentRepository->getAllWithPagination();

        return view('admin.repayments', compact('repayments'));
    }
}
