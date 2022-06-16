<?php

namespace App\Models\Mobile;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileActivation extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'user_id',
        'device_id',
        'device_name',
        'status',
    ];
}
