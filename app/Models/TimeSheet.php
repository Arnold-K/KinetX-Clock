<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TimeSheet extends Model {

    protected $table = 'timesheet';

    protected $fillable = [
        'user_id',
        'description',
        'rate',
        'clock_in',
        'clock_out',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }
}
