<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model {

    protected $table = 'payments';
    protected $fillable = [
        'date',
        'amount',
        'rate',
        'employee_id'
    ];

    public function employee() {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }

}
