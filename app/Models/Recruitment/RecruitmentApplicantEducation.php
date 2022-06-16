<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicantEducation extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'level_id',
        'name',
        'major',
        'essay',
        'city',
        'score',
        'start_year',
        'end_year',
        'description',
        'filename'
    ];
}
