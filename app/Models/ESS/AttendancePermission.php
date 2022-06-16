<?php

namespace App\Models\ESS;

use App\Models\Setting\Master;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendancePermission extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'category_id',
        'number',
        'date',
        'start_date',
        'end_date',
        'description',
        'filename',
        'approved_by',
        'approved_status',
        'approved_note',
        'approved_date'
    ];

    public function category()
    {
        return $this->belongsTo(Master::class, "category_id", "id");
    }
}
