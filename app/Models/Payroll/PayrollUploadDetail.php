<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollUploadDetail extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'upload_id',
        'employee_id',
        'value',
        'description',
    ];
}
