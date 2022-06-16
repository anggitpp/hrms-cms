<?php

namespace App\Models\Attendance;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRoster extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'date',
        'shift_id',
        'start',
        'end',
        'description',
    ];
}
