<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPlacement extends Model
{
    use HasFactory, Blameable;

    protected $table = 'employee_master_placements';

    protected $fillable = [
        'name',
        'leader_id',
        'administration_id',
        'description',
        'status'
    ];

    public function scopeActive($query, $id = '')
    {
        $query->where('status', 't');
        if($id)
            $query->orWhere('id', $id);
        return $query;
    }
}
