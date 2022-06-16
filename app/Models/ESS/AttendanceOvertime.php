<?php

namespace App\Models\ESS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceOvertime extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'number',
        'date',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'duration',
        'filename',
        'description',
        'approved_status',
        'approved_date',
        'approved_note',
        'approved_by'
    ];
}
