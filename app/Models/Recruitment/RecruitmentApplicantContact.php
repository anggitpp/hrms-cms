<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicantContact extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'name',
        'relation_id',
        'phone_number'
    ];
}
