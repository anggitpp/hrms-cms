<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollProcess extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'type_id',
        'location_id',
        'month',
        'year',
        'total_values',
        'total_employees',
        'approved_status',
        'approved_by',
        'approved_date',
        'approved_description',
    ];
}
