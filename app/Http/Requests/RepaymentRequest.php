<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'loan_id' => 'required|exists:loans,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'loan_id.required' => 'Loan ID is required.',
            'loan_id.exists' => 'Selected loan does not exist.',
            'amount_paid.required' => 'Repayment amount is required.',
            'amount_paid.numeric' => 'Repayment amount must be a number.',
            'amount_paid.min' => 'Repayment amount must be positive.',
            'payment_date.required' => 'Payment date is required.',
            'payment_date.date' => 'Payment date must be a valid date.',
            'payment_date.before_or_equal' => 'Payment date cannot be in the future.',
        ];
    }
}
