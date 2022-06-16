<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamily extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'name',
        'relation_id',
        'identity_number',
        'birth_date',
        'birth_place',
        'gender',
        'filename',
        'description',
    ];
}
