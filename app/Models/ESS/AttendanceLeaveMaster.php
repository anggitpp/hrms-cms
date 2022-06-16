<?php

namespace App\Models\ESS;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLeaveMaster extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'name',
        'quota',
        'start_date',
        'end_date',
        'working_life',
        'gender',
        'location_id',
        'description',
        'status'
    ];

    public function scopeActive($query)
    {
        $query->where('status', 't');

        return $query;
    }

}
