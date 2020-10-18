<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $data['employee'] = auth()->user()->employee()->firstOrFail();
        $data['start_time'] = Carbon::now()->subDays(30)->toDateString();
        $data['end_time'] = Carbon::now()->toDateString();
        $data['payments'] = $data['employee']->payments()->whereBetween('date', [$data['start_time'], $data['end_time']])->get();
        if(!count($data['payments'])) {
            return view('pages.payments.show')->with($data)->withErrors(['empty' => "This user has no payments in the last 30 days"]);
        }
        return view('pages.payments.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'payment_date' => 'required',
            'payment_amount' => 'required|min:0',
            'employee_id' => 'required|exists:employees,id',
        ]);
        if($validator->fails()) {
            return redirect(route('timesheet.index'))->withErrors($validator->errors());
        }

        $payment = Payment::create([
            "date" => $request->payment_date,
            "amount" => $request->payment_amount,
            "employee_id" => $request->employee_id,
        ]);

        return redirect(route('timesheet.index'))->with(['status' => 'payment_success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $employee_id) {
        $employee = Employee::where('id', $employee_id)->first();

        if(!$employee) {
            return redirect(route('payment.index'))->withErrors(['payment_employee' => "You do not have access to see this user or it doesn't exist."]);
        }

        if(auth()->user()->cant('view', $employee)) {
            return redirect(route('payment.index'))->withErrors(['access_employee' => "You are not authorized to view this content!"]);
        }
        $data['employee'] = $employee;
        if($request->has('start_date') && $request->has('end_date')){
            $data['start_time'] = Carbon::createFromDate($request->start_date)->toDateString();
            $data['end_time'] = Carbon::createFromDate($request->end_date)->hour(23)->minute(59)->second(59)->toDateString();
            $data['payments'] = $employee->payments()->whereBetween('date', [$data['start_time'], $data['end_time']])->get();
            if(!count($data['payments'])) {
                return view('pages.payments.show')->with($data)->withErrors(['empty' => "There is no data for this search"]);
            }
            return view('pages.payments.show')->with($data);
        } else {
            $data['start_time'] = Carbon::now()->subDays(30)->toDateString();
            $data['end_time'] = Carbon::now()->toDateString();
            $data['payments'] = $employee->payments()->whereBetween('date', [$data['start_time'], $data['end_time']])->get();
            if(!count($data['payments'])) {
                return redirect(route('payment.show', $employee->id))->with($data)->withErrors(['empty' => "There is no data for this search"]);
            }
        }

        return view('pages.payments.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
