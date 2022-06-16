<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_shifts';

    protected $fillable = [
        'building_id',
        'service_id',
        'area_id',
        'name',
        'code',
        'start',
        'end',
        'finish_today',
        'interval_id',
        'special',
        'description',
        'status',
        'order',
    ];

}
