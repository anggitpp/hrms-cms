<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModul extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_sub_moduls';

    protected $fillable = [
        'modul_id',
        'name',
        'description',
        'status',
        'order',
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 't');
    }
}
