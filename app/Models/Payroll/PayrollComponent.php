<?php

namespace App\Models\Payroll;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollComponent extends Model
{
    use HasFactory, Blameable;

    protected $fillable = [
        'type_id',
        'type',
        'code',
        'name',
        'method',
        'method_value',
        'description',
        'status',
        'order',
    ];

    public function scopeActive($query)
    {
        $query->where('status','t');

        return $query;
    }
}
