<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_categories';

    protected $fillable = [
        'parent_id',
        'modul_id',
        'name',
        'code',
        'description',
        'order'
    ];

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
}
