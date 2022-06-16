<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_areas';

    protected $fillable = [
        'building_id',
        'service_id',
        'name',
        'code',
        'employee_id',
        'description',
        'shift',
        'status',
        'order',
        'qr_file',
    ];

    public function objects()
    {
        return $this->hasMany(AreaObject::class, 'area_id', 'id');
    }
}
