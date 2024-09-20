<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
