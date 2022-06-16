<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicSalary extends Model
{
    use HasFactory, Blameable;

    protected $table = 'payroll_basic_salaries';

    protected $fillable = [
        'rank_id',
        'value',
        'description'
    ];
}
