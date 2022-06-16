<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory;

    protected $table = "app_user_accesses";

    protected $fillable = [
        'group_id',
        'menu_id',
        'name'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
