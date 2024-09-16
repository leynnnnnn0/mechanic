<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceJobAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'attachment',
    ];

    public function serviceJob()
    {
        return $this->belongsTo(ServiceJob::class);
    }
}
