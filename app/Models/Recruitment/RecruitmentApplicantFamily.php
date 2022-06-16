<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicantFamily extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'name',
        'identity_number',
        'relation_id',
        'gender',
        'birth_date',
        'birth_place',
        'filename',
        'description'
    ];
}
