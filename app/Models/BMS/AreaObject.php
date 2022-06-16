<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaObject extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_objects';

    protected $fillable = [
        'service_id',
        'building_id',
        'area_id',
        'object_id',
        'name',
        'employee_id',
        'code',
        'shift',
        'qr',
        'order',
        'description',
        'status',
    ];
}
