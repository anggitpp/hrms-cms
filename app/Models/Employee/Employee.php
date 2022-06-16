<?php

namespace App\Models\Employee;

use App\Models\Setting\Master;
use App\Models\Setting\Parameter;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class Employee extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'name',
        'nickname',
        'emp_number',
        'email',
        'identity_number',
        'birth_date',
        'birth_place',
        'address',
        'identity_address',
        'religion_id',
        'mobile_phone',
        'phone',
        'gender',
        'marital_id',
        'blood_type',
        'status_id',
        'join_date',
        'leave_date',
        'photo',
        'identity_file',
        'applicant_id',
    ];

    public function contract(){
        return $this->hasOne(EmployeeContract::class)->where('status', 't');
    }

    public function payroll(){
        return $this->hasOne(EmployeePayroll::class);
    }

    public function scopeActive($query, $id = "")
    {
        $query->where('status_id', Parameter::where('code', 'SA')->pluck('value'));
        if($id)
            $query->orWhere('id', $id);

        return $query;
    }
}
