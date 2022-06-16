<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_masters';

    protected $fillable = [
        'id',
        'service_id',
        'object_id',
        'target_id',
        'name',
        'code',
        'category_id',
        'control_type',
        'control_parameter',
        'control_unit_id',
        'interval_id',
        'description',
        'order',
        'status',
    ];
}
