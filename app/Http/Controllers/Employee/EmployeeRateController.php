<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeRateController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function show(Employee $employee) {
        if(!auth()->user()->hasRole('superadmin')) {
            abort(403);
        }
        $data['employee'] = $employee;
        return view('pages.employee.rate.index')->with($data);
    }

    public function update(Request $request, Employee $employee) {
        $validator = Validator::make($request->all(), [
            'rate' => 'required|numeric'
        ]);
        if($validator->fails()){
            return redirect(route('rate.show', $employee->id))->withErrors($validator->errors());
        }
        $employee->rate = $request->rate;
        $employee->save();
        TimeSheet::whereNull('rate')->where('employee_id', $employee->id)->update(['rate' => $employee->rate]);
        return redirect(route('rate.show', $employee->id))->with(['success' => 'Rate has been updated!']);
    }
}
