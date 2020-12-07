<?php

namespace App\Http\Controllers\TimeSheet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

class TimeSheetListController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $employee = auth()->user()->employee()->firstOrFail();
        $timesheets = $employee->timesheet->all();
        $timesheet_start_time = $timesheet_start_time = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        return view('pages.timesheet-list.index')->with([
            'timesheets' => $timesheets,
            'employee' => $employee,
            'timesheet_start_time' => $timesheet_start_time
        ]);
    }

    public function showEmployeeTimesheet(Request $request, Employee $employee) {

        //check if user has the right to see this timesheet
        if(!auth()->user()->can('viewTimeSheet', $employee)) {
            return redirect(route('timesheet-list.show', auth()->user()->employee->id))->with(["error" => "You can only see your own timesheet"]);
        }

        $timesheet_start_time = $timesheet_start_time = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now());
        $data['timesheet_start_time'] = $timesheet_start_time;

        if($request->has('start_date') && $request->has('end_date')){
            $start_time = Carbon::createFromDate($request->start_date);
            $end_time = Carbon::createFromDate($request->end_date)->hour(23)->minute(59)->second(59);
            $timesheets = $employee->timesheet()->whereBetween('clock_out', [$start_time, $end_time])->get();
            if(!$timesheets) {
                return redirect(route('timesheet-list.index', $employee->id))->with(["error" => "Timesheet list is empty"]);
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
            $data['employee'] = $employee;
            $data['total_selected_amount'] = $total_selected_amount;
            $data['total_working_time'] = $total_working_time;

            return view('pages.timesheet-list.index')->with($data);
        } else {
            $start_time = Carbon::now()->subDays(30);
            $end_time = Carbon::now()->hour(23)->minute(59)->second(59);
            $timesheets = $employee->timesheet()->whereBetween('clock_out', [$start_time, $end_time])->get();
            if(!$timesheets) {
                return redirect(route('timesheet-list.index', $employee->id))->with(["error" => "Timesheet list is empty"]);
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
        }
        $data['employee'] = $employee;
        return response()->json($data);
        return view('pages.timesheet-list.index')->with($data);
    }

}
