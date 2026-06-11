<?php

namespace App\Http\Requests;

use App\Enums\LoanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminLoanFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', Rule::in(array_column(LoanStatus::cases(), 'value'))],
            'search_name' => ['nullable', 'string', 'max:255'],
            'search_email' => ['nullable', 'string', 'max:255'],
        ];
    }
}
