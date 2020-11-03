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

        $start_time = Carbon::now()->subDays(30);
        $end_time = Carbon::now()->hour(23)->minute(59)->second(59);
        $timesheets = $data['employee']->timesheet()->whereBetween('clock_out', [$start_time, $end_time])->get();
        if(!$timesheets) {
            return redirect(route('timesheet-list.index', $data['employee']->id))->with(["error" => "Timesheet list is empty"]);
        }
        $total_working_time = 0;
        $total_selected_amount = 0;
        foreach($timesheets as $timesheet){
            if($timesheet->clock_out){
                $clock_out = new Carbon($timesheet->clock_out);
                $clock_in = new Carbon($timesheet->clock_in);
                $total_working_time = (int)$total_working_time + (int)$clock_out->diffInMinutes($clock_in);
                $current_working_time = (int)$clock_out->diffInMinutes($clock_in);
                $total_selected_amount = $total_selected_amount + (($current_working_time / 60) * $timesheet->rate) ;
            }

        }

        $data['timesheets'] = $timesheets;
        $data['total_selected_amount'] = $total_selected_amount;
        $data['total_working_time'] = $total_working_time;

        return view('pages.timesheet.index')->with($data);
    }

    public function store(Request $request) {
        if($request->has('custom')) {
            $validator = Validator::make($request->all(), [
                "employee" => "required|exists:employees,id",
                "clock_in" => "required",
                "clock_out" => "required",
                "description" => "required|min:1"
            ]);
            if($validator->fails()) {
                return redirect( url()->previous() )->withErrors($validator->errors())->with(["show_create_timesheet" => true]);
            }

            $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $request->clock_in);
            $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $request->clock_out);

            if($start_time->gt($end_time)) {
                return redirect( url()->previous() )->withErrors([
                    "start_time_greater" => "Clock in time cannot be greater than clock out!"
                ])->with(["show_create_timesheet" => true]);
            }

            $timesheet = TimeSheet::create([
                "employee_id" => $request->employee,
                "clock_in" => $request->clock_in,
                "clock_out" => $request->clock_out,
                "description" => $request->description
            ]);

            return redirect( url()->previous() )->with([
                "timesheet_entry_create_success" => "Timesheet entry created successfully"
            ]);
        }
        $employee = auth()->user()->employee()->firstOrFail();
        $timesheet = TimeSheet::create(
            ['employee_id'=> $employee->id, 'clock_in' => Carbon::now()]
        );
        return redirect(route('timesheet.index'))->with(['status' => 'clock_in']);
    }

    public function edit(Request $request, TimeSheet $timesheet) {
        $timesheet_start_time = Carbon::createFromFormat('Y-m-d H:i:s', $timesheet->clock_in);
        $timesheet_end_time = Carbon::createFromFormat('Y-m-d H:i:s', $timesheet->clock_out);

        return view('pages.timesheet.edit')->with([
            'timesheet' => $timesheet,
            "employee" => $timesheet->employee,
            "timesheet_start_time" => $timesheet_start_time,
            "timesheet_end_time" => $timesheet_end_time
        ]);
    }

    public function destroy(Request $request, TimeSheet $timesheet) {
        $timesheet->delete();
        return response()->json(["message" => "Timesheet entry has been deleted!"]);
    }

    public function update(Request $request, TimeSheet $timesheet) {
        $timesheet->description = $request->description;
        $timesheet->clock_in = $request->clock_in;
        $timesheet->clock_out = $request->clock_out;
        $timesheet->save();
        return redirect(route('timesheet-list.show', $timesheet->employee->id));
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
        $timesheet->rate = $employee->rate;
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
