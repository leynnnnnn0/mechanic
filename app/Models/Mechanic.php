<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'specialization',
        'street_address',
        'city',
        'barangay',
        'state_or_province',
        'postal_code',
        'email',
        'phone_number',
        'password'
    ];
}
