<?php

namespace App\Enums;

/**
 * Defines valid loan application lifecycle states.
 */
enum LoanStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}
