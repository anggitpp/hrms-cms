<?php

namespace App\Models\Employee;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContact extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'employee_id',
        'name',
        'relation_id',
        'phone_number'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
