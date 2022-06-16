<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollUpload extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'code',
        'month',
        'year',
        'total_employees',
        'total_values',
        'approved_by',
        'approved_status',
        'approved_date',
        'approved_description',
    ];
}
