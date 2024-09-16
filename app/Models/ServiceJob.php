<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_job_id',
        'car_id',
        'mechanic_id',
        'status',
        'service_type',
        'start_date',
        'end_date',
        'description',
        'estimated_cost',
        'final_cost',
        'payment_status',
        'notes'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    public function attachments()
    {
        return $this->hasMany(ServiceJobAttachment::class);
    }
}
