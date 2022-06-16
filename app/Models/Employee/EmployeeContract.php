<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContract extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'position_id',
        'type_id',
        'rank_id',
        'grade_id',
        'sk_number',
        'location_id',
        'area_id',
        'start_date',
        'end_date',
        'placement_id',
        'shift_id',
        'status',
        'description',
        'filename'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 't');
    }
}
