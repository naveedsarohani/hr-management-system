<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $table = 'departments';
    protected $fillable = ['title'];

    public function jobHistories()
    {
        return $this->hasMany(JobHistory::class);
    }
}
