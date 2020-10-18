<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    protected $table = 'payments';
    protected $fillable = [
        'date',
        'amount',
        'employee_id'
    ];

    public function user() {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }

}
