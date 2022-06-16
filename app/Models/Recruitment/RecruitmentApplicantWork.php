<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicantWork extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'position',
        'company',
        'start_date',
        'end_date',
        'city',
        'job_desc',
        'description',
        'filename',
    ];
}
