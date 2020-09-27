<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TimeSheet;

class Employee extends Model {
    protected $table = 'employees';

    protected $fillable = [
        'description',
        'rate',
        'clock_in',
        'clock_out',
        'user_id',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }
    public function timesheet() {
        return $this->hasMany(TimeSheet::class);
    }
}
