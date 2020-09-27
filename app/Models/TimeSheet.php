<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class TimeSheet extends Model {

    protected $table = 'timesheet';

    protected $fillable = [
        'description',
        'rate',
        'clock_in',
        'clock_out',
        'employee_id',
    ];


    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
