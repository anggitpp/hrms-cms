<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionAllowance extends Model
{
    use HasFactory, Blameable;

    protected $table = 'payroll_position_allowances';

    protected $fillable = [
        'rank_id',
        'value',
        'description'
    ];
}
