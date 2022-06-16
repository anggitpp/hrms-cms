<?php

namespace App\Models\BMS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory, Blameable;

    protected $table = 'bms_targets';

    protected $fillable = [
        'service_id',
        'object_id',
        'name',
        'code',
        'description',
        'order',
        'status',
    ];

    public function masters()
    {
        return $this->hasMany(Master::class, 'target_id', 'id');
    }
}
