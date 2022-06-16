<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentSelection extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'plan_id',
        'step',
        'selection_date',
        'selection_time',
        'result',
        'description',
        'filename',
    ];
}
