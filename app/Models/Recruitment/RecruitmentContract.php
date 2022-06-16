<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentContract extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'plan_id',
        'position_id',
        'type_id',
        'sk_number',
        'start_date',
        'end_date',
        'filename',
        'description',
        'status'
    ];
}
