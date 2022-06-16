<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapping extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_mappings';

    protected $fillable = [
        'employee_id',
        'region_id',
        'building_id',
        'service',
    ];
}
