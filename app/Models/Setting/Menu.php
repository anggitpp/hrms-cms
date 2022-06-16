<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Blameable;

    protected $table = "app_menus";

    protected $fillable = [
        'name',
        'parent_id',
        'modul_id',
        'sub_modul_id',
        'target',
        'description',
        'order',
        'status',
        'controller',
        'parameter',
        'full_screen'
    ];

    public function scopeActive($query)
    {
        return $query->where('status','t');
    }

    public function menuAccess(){
        return $this->hasMany(MenuAccess::class);
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
}
