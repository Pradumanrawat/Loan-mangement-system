<?php

namespace App\Enums;

/**
 * Defines application user roles for authorization checks.
 */
enum UserRole: string
{
    case Admin = 'admin';
    case Customer = 'customer';
}
