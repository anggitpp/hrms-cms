<?php

namespace App\Models\Recruitment;

use App\Models\Setting\Master;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentPlan extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'plan_number',
        'title',
        'propose_date',
        'need_date',
        'employee_id',
        'position_id',
        'location_id',
        'number_of_people',
        'gender',
        'age_from',
        'age_to',
        'education_id',
        'experience',
        'recruitment_reason',
        'notes',
        'filename',
        'status'
    ];
}
