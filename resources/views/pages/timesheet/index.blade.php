@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session()->has('status') && session()->get('status') == "clock_in")
                <div class="alert alert-success" role="alert">
                    {{ __('You clocked in successfully') }}
                </div>
            @endif
            @if (session()->has('status') && session()->get('status') == "clock_out")
                <div class="alert alert-success" role="alert">
                    {{ __('You clocked out successfully') }}
                </div>
            @endif
            @if (session()->has('status') && session()->get('status') == "payment_success")
                <div class="alert alert-success" role="alert">
                    {{ __('Payment was recoreded successfully') }}
                </div>
            @endif
            <div class="card">
                @if ($timesheet)
                    <div class="card-header bg-primary text-white">{{ __('Clock Out') }}</div>
                @else
                    <div class="card-header bg-primary text-white">{{ __('Clock in a timesheet') }}</div>
                @endif

                <div class="card-body">
                    {{-- {{!!json_encode(session()->has('status'))!!}} --}}


                    @if ($timesheet)
                        <form action="{{route('timesheet.clockOut')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button name="clock_out_btn" id="clock_out_btn" class="btn btn-primary" type="submit" >{{ __('Clock Out')}}</button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('timesheet.store')}}" name="clock_in_form" method="POST">
                            @csrf
                            <div class="form-group d-flex justify-content-center">
                                <button class="btn btn-primary" type="submit" >{{ __('Clock In')}}</button>
                            </div>
                        </form>
                    @endif
                </div>

                <div class="card-body">
                    <a href="{{route('timesheet-list.show', $employee->id)}}" class="btn btn-primary" href="">View Timesheet</a>
                </div>
            </div>
            <div class="my-3"></div>
            <div class="card">
                <div class="card-header bg-success">
                    <h5 class="m-0">Payments</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id", value="{{ $employee->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date">{{ __('Date') }}</label>
                                    <input class="form-control" type="date" name="payment_date" id="date" placeholder="Date">
                                    @error('payment_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">{{ __('Amount') }}</label>
                                    <input class="form-control" type="number" min="0" step="0.01" name="payment_amount" id="amount" placeholder="Amount">
                                    @error('payment_amount')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="h-100 form-group d-flex align-items-center">
                                    <button class="btn btn-success">Record Payment</button>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('payment.index') }}" class="btn btn-success"> View Payments</a>
                    </form>
                </div>
            </div>
            <div class="my-3">
            </div>
            <div class="card">
                <div class="card-header bg-info">
                    <h5 class="m-0">Timesheet</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('timesheet-list.search.show', $employee->id)}}" method="GET" >
                        <input type="hidden" name="employee_id" id="employee_id_field" value="{{ $employee->id }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input class="form-control" type="date"  id="start_date" name="start_date" value="{{ (request()->has('start_date'))?request()->start_date:\Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control" type="date" id="end_date" name="end_date" value="{{(request()->has('end_date'))?request()->end_date:\Carbon\Carbon::now()->format('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="w-100 btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
