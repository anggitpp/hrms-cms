<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicant extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'input_date',
        'applicant_number',
        'plan_id',
        'name',
        'nickname',
        'birth_date',
        'birth_place',
        'identity_number',
        'gender',
        'address',
        'identity_address',
        'religion_id',
        'phone',
        'mobile_phone',
        'email',
        'marital_id',
        'photo',
        'identity_file',
        'blood_type',
        'height',
        'weight'
    ];

}
