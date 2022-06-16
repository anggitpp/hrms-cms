<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollProcessDetail extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'process_id',
        'employee_id',
        'component_id',
        'value',
    ];

    public function component()
    {
        return $this->belongsTo(PayrollComponent::class, "component_id", "id");
    }
}
