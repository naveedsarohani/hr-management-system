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
        'department',
        'position',
        'date_of_joining',
        'in_time',
        'out_time'
    ];

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
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
}
