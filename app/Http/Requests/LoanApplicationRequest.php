<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanApplicationRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0.01',
            'tenure' => 'required|integer|min:1|max:60',
            'purpose' => 'required|string|max:255',
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
            'amount.required' => 'Loan amount is required.',
            'amount.numeric' => 'Loan amount must be a number.',
            'amount.min' => 'Loan amount must be positive.',
            'tenure.required' => 'Loan tenure is required.',
            'tenure.integer' => 'Loan tenure must be in months.',
            'tenure.min' => 'Loan tenure must be at least 1 month.',
            'tenure.max' => 'Loan tenure cannot exceed 60 months.',
            'purpose.required' => 'Loan purpose is required.',
        ];
    }
}
