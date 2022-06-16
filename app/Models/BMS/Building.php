<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_buildings';

    protected $fillable = [
        'code',
        'type_id',
        'region_id',
        'name',
        'address',
        'city',
        'services',
        'status',
        'photo',
    ];
}
