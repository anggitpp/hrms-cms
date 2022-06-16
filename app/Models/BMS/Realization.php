<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realization extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_realizations';

    protected $fillable = [
        'employee_id',
        'building_id',
        'service_id',
        'area_id',
        'object_id',
        'shift_id',
        'activity_id',
        'control_type',
        'control_result'
    ];
}
