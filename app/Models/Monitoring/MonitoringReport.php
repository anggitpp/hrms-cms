<?php

namespace App\Models\Monitoring;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringReport extends Model
{
    use HasFactory, Blameable;
    
    protected $fillable = [
        'employee_id',
        'location',
        'description',
        'date',
        'time',
        'image',
    ];
}
