<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAccess extends Model
{
    use HasFactory, Blameable;

    protected $table = "app_menu_accesses";

    protected $fillable = [
        'menu_id',
        'type',
        'name',
        'method',
        'param'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

}
