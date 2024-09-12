<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'street_address',
        'city',
        'barangay',
        'state_or_province',
        'postal_code',
        'email',
        'phone_number'
    ];
}
