<?php

namespace App\Models\ESS;

use App\Models\Setting\Master;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceReimbursement extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'number',
        'date',
        'category_id',
        'value',
        'filename',
        'description',
        'approved_date',
        'approved_by',
        'approved_note',
        'approved_status'
    ];

    public function category()
    {
        return $this->belongsTo(Master::class, "category_id", "id");
    }
}
