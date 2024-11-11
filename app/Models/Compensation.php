<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensation extends Model
{
    use HasFactory;

    public $table = 'compensations';

    protected $fillable = [
        'employee_id',
        'base_salary',
        'bonus',
        'total_compensation'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
