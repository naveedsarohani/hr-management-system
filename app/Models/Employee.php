<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'date_of_joining',
        'office_in_timing',
        'office_out_timing',
        'status',
        'password'
    ];

    public $timestamps = false;

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function performanceReview()
    {
        return $this->hasMany(PerformanceReview::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function position()
    {
        return $this->hasMany(Position::class);
    }

    public function jobHistories()
    {
        return $this->hasMany(JobHistory::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'employee_id');
    }

    public function resolvedComplaints()
    {
        return $this->hasMany(Complaint::class, 'hr_resolved_by');
    }

    public function leave()
    {
        return $this->hasOne(Leave::class, 'employee_id', 'id');
    }
}
