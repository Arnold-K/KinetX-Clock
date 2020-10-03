<?php

namespace App\Http\Controllers\TimeSheet;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class TimeSheetExportController extends Controller {
    
    public function __construct() {

    }

    public function index(Request $request, Employee $employee) {
        if($request->has('type') && $request->type == "csv"){
            // $headers = array(
            //     "Content-type" => "text/csv",
            //     "Content-Disposition" => "attachment; filename=file.csv",
            //     "Pragma" => "no-cache",
            //     "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            //     "Expires" => "0"
            // );
            // return response()->streamDownload( function () {
            //     $employee->timesheet()->get();
            // }, $headers );
        }

        return response()->json([], 400);
    }

}
