<?php

namespace App\Models\Attendance;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceShift extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'name',
        'code',
        'start',
        'end',
        'break_start',
        'break_end',
        'tolerance',
        'night_shift',
        'description',
        'status',
    ];
}
