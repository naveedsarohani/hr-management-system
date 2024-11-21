<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public $table = 'positions';
    protected $fillable = [
        'employee_id',
        'job_position'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function jobHistories()
    {
        return $this->hasMany(JobHistory::class);
    }
}
