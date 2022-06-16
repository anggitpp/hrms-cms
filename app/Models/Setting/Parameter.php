<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_parameters';

    protected $fillable = [
        'code',
        'name',
        'value',
        'description'
    ];
}
