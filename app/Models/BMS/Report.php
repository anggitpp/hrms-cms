<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_reports';

    protected $fillable = [
        'building_id',
        'service_id',
        'area_id',
        'employee_id',
        'location',
        'description',
        'date',
        'time',
        'image',
    ];
}
