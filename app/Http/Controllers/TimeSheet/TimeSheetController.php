<?php

namespace App\Http\Controllers\TimeSheet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TimeSheet;
use Carbon\Carbon;

class TimeSheetController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $data['employee'] = auth()->user()->employee()->firstOrFail();
        $data['timesheet'] = $data['employee']->timesheet()->whereNull('clock_out')->first();
        return view('timesheet.index')->with($data);
    }

    public function store(Request $request) {
        $employee = auth()->user()->employee()->firstOrFail();
        $timesheet = TimeSheet::create(
            ['employee_id'=> $employee->id, 'clock_in' => Carbon::now()]
        );
        return redirect(route('timesheet.index'))->with(['status' => 'clock_in']);
    }

    public function edit(Request $request, TimeSheet $timesheet) {
        return view('timesheet.edit')->with(['timesheet' => $timesheet]);
    }

    public function update(Request $request, TimeSheet $timesheet) {
        return response()->json($timesheet);
    }

    public function clockOut(Request $request) {
        $validator = Validator::make($request->all(), [
            'description' => 'string|min:0',
        ], $this->messages());
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $employee = auth()->user()->employee()->firstOrFail();
        $timesheet = $employee->timesheet()->whereNull('clock_out')->firstOrFail();
        $timesheet->description = $request->description;
        $timesheet->clock_out = Carbon::now();
        $timesheet->save();
        return redirect(route('timesheet.index'))->with(['status' => 'clock_out']);
    }

    private function messages() {
        return [
            'description.string' => 'Description must not be empty',
            'rate.numeric' => 'Rate must be a number',
            'rate.min' => 'Rate must be greater than 0'
        ];
    }

}
