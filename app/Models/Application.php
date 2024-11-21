<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'candidate_name',
        'email',
        'contact_number',
        'cover_letter',
        'portfolio_link',
        'expected_salary',
        'notice_period',
        'resume',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id', 'id');
    }
}
