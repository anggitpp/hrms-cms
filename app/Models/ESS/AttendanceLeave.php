<?php

namespace App\Models\ESS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLeave extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'type_id',
        'number',
        'date',
        'start_date',
        'end_date',
        'quota',
        'amount',
        'remaining',
        'filename',
        'description',
        'approved_status',
        'approved_by',
        'approved_date',
        'approved_note'
    ];

    public function type()
    {
        return $this->belongsTo(AttendanceLeaveMaster::class, "type_id", "id");
    }
}
