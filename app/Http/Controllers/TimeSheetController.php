<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TimeSheet;
use Carbon\Carbon;

class TimeSheetController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $timesheets['timesheet'] = auth()->user()->timeSheet()->whereNull('clock_out')->first();

        // return response()->json($timesheets);
        return view('timesheet.index')->with($timesheets);
    }

    public function store(Request $request) {
        $timesheet = TimeSheet::create(
            ['user_id'=> auth()->user()->id, 'clock_in' => Carbon::now()]
        );

        return redirect(route('timesheet.index'))->with(['status' => 'clock_in']);
    }

    public function clockOut(Request $request) {
        $validator = Validator::make($request->all(), [
            'description' => 'string|min:0',
            // 'rate' => 'numeric|min:0'
        ], $this->messages());
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $timesheet = auth()->user()->timeSheet()->whereNull('clock_out')->first();
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
