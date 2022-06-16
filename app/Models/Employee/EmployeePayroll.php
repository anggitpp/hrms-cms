<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayroll extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'payroll_id',
        'npwp_number',
        'npwp_date',
        'bpjs_number',
        'bpjs_date',
        'bpjs_tk_date',
        'bpjs_tk_number',
        'bank_id',
        'bank_branch',
        'account_name',
        'account_number',
    ];
}
