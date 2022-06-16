<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_moduls';

    protected $fillable = [
        'name',
        'target',
        'description',
        'icon',
        'status',
        'order',
    ];

    public function submodul()
    {
        return $this->hasMany(SubModul::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status','t');
    }
}
