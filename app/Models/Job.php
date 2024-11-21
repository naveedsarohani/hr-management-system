<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'experience',
        'employment_type',
        'job_location',
        'salary_range',
        'qualifications',
        'benefits',
        'skills_required',
        'status'
    ];
    
    public function application()
    {
        return $this->hasOne(Application::class, 'job_id', 'id');
    }
}
