<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Authenticatable implements HasName, FilamentUser
{

    use HasFactory;

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // Or implement your own logic here
    }

    protected $fillable = [
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getFilamentName(): string
    {
        return "{$this->username}";
    }
}
