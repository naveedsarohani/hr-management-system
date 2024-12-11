<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'complaint_date',
        'complaint_text',
        'status',
        'hr_response',
        'hr_resolved_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function hr()
    {
        return $this->belongsTo(Employee::class, 'hr_resolved_by');
    }
}
