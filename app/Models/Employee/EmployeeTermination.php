<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTermination extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'termination_number',
        'date',
        'category_id',
        'description',
        'filename',
        'employee_id',
        'effective_date',
        'note',
        'approve_by',
        'approve_date',
        'approve_status',
        'approve_note'
    ];
}
