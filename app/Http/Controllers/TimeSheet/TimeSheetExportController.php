<?php

namespace App\Http\Controllers\TimeSheet;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeSheetExportController extends Controller {

    public function __construct() {

    }

    public function index(Request $request, Employee $employee) {

        if($request->has('start_date') && $request->has('end_date')){
            $start_time = Carbon::createFromDate($request->start_date);
            $end_time = Carbon::createFromDate($request->end_date)->hour(23)->minute(59)->second(59);
            $timesheets = $employee->timesheet()->whereBetween('clock_out', [$start_time, $end_time])->get()->makeHidden(['deleted_at', 'id', 'employee_id']);
            if(!count($timesheets)) {
                return response()->json(["message" => "Selected period has no records."], 404);
            }

            $filename = $employee->user->name . ' - Timesheet.csv';
            $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=timesheet.csv',
                'Expires'             => '0',
                'Pragma'              => 'public'
            ];

            $callback = function() use ($timesheets) {
                $output = fopen('php://output', 'w');
                $timesheets->map(function($item) use ($output) {
                    fputcsv($output, [
                        $item->clock_in,
                        $item->clock_out,
                        $item->description,
                        $item->created_at,
                        $item->updated_at,
                    ]);
                });
                fclose($output);
            };
            return response()->stream($callback, 200, $headers);
        }

        return response()->json(["message" => "Please select a start date and end date"], 404);



    }

}
