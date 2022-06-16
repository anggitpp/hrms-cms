<?php

namespace App\Models\Recruitment;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentPlacement extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'applicant_id',
        'contract_id',
        'rank_id',
        'grade_id',
        'location_id',
        'placement_id',
        'shift_id',
        'payroll_id',
        'bank_id',
        'bank_branch',
        'account_name',
        'account_number',
        'status',
        'filename',
        'description'
    ];
}
