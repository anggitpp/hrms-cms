<?php

namespace App\Models\Attendance;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'date',
        'start_date',
        'end_date',
        'in',
        'out',
        'duration',
        'description'
    ];
}
