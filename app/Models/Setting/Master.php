<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_masters';

    protected $fillable = [
        'id',
        'parent_id',
        'category',
        'name',
        'code',
        'description',
        'parameter',
        'additional_parameter',
        'status',
        'order',
    ];

    public function scopeActive($query, $id = '')
    {
        $query->where('status', 't');
        if($id)
            $query->orWhere('id', $id);
        return $query;
    }

}
