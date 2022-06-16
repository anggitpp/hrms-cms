<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEducation extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'level_id',
        'name',
        'major',
        'essay',
        'city',
        'score',
        'start_year',
        'end_year',
        'description',
        'filename'
    ];
}
