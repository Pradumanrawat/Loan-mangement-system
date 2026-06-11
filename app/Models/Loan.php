<?php

namespace App\Models;

use App\Enums\LoanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'tenure',
        'purpose',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'status' => LoanStatus::class,
    ];

    /**
     * Get the user that owns the loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the repayments for the loan.
     */
    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * Get total amount paid for this loan.
     */
    public function getTotalPaidAttribute()
    {
        return $this->repayments()->sum('amount_paid');
    }

    /**
     * Get remaining balance for this loan.
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->amount - $this->total_paid;
    }

    /**
     * Check if loan is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === LoanStatus::Approved;
    }

    /**
     * Check if loan is pending.
     */
    public function isPending(): bool
    {
        return $this->status === LoanStatus::Pending;
    }

    /**
     * Check if loan is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === LoanStatus::Rejected;
    }
}
