<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupModul extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_group_moduls';

    protected $fillable = [
        'modul_id', 'group_id'
    ];
}
