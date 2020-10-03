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
        return view('pages.timesheet-list.index')->with(['timesheets' => $timesheets, 'employee' => $employee]);
    }

    public function showEmployeeTimesheet(Request $request, Employee $employee) {

        //check if user has the right to see this timesheet
        if(!auth()->user()->can('viewTimeSheet', $employee)) {
            return redirect(route('timesheet-list.show', auth()->user()->employee->id))->with(["error" => "You can only see your own timesheet"]);
        }

        if($request->has('start_date') && $request->has('end_date')){
            $start_time = Carbon::createFromDate($request->start_date);
            $end_time = Carbon::createFromDate($request->end_date)->hour(23)->minute(59)->second(59);
            $timesheets = $employee->timesheet()->whereBetween('clock_out', [$start_time, $end_time])->get();
            if(!$timesheets) {
                return redirect(route('timesheet-list.index', $employee->id))->with(["error" => "Timesheet list is empty"]);
            }
            $total_working_time = 0;
            foreach($timesheets as $timesheet){
                if($timesheet->clock_out){
                    $clock_out = new Carbon($timesheet->clock_out);
                    $clock_in = new Carbon($timesheet->clock_in);
                    $total_working_time = (int)$total_working_time + (int)$clock_out->diffInMinutes($clock_in);
                }

            }

            return view('pages.timesheet-list.index')->with(['timesheets' => $timesheets, 'employee' => $employee, 'total_working_time' => ($total_working_time)]);
        }
        $timesheets = [];
        return view('pages.timesheet-list.index')->with(['timesheets' => $timesheets, 'employee' => $employee]);
    }

}
