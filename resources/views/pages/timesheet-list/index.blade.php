@section('content')
<div class="container">


    @if(session()->has('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session()->get('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4>Select dates</h4>
        </div>
        <div class="card-body">
            <form action="{{route('timesheet-list.search.show', $employee->id)}}" method="GET" >
                <input type="hidden" name="employee_id" id="employee_id_field" value="{{ $employee->id }}">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input class="form-control" type="date" id="start_date" name="start_date" value="{{ (request()->has('start_date'))?request()->start_date:\Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}">
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
    <div class="card mt-3">
    @if(count($timesheets))
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h4>Timesheet</h4>
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-between">
                        <span>Total work: </span>
                        <span><strong>{{ (int)($total_working_time/60) }}h {{($total_working_time%60)}}m</strong></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Payout: </span>
                        <span><strong>${{ $total_selected_amount }}</strong></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="accordion" id="timesheets">
                @foreach ($timesheets as $timesheet)
                    <div class="card">
                        <div class="card-header" id="timesheet-heading-{{$timesheet->id}}">
                            <div class="d-flex">
                                <button data-timesheet="{{$timesheet->id}}" class="btn btn-white" type="button" data-toggle="collapse" data-target="#collapse-{{$timesheet->id}}" aria-controls="collapse-{{$timesheet->id}}">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <div class="d-flex justify-content-between flex-grow-1">
                                    <h2 class="mb-0 flex-grow-1">
                                        <button data-timesheet="{{$timesheet->id}}" class="btn btn-white w-100 text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$timesheet->id}}" aria-controls="collapse-{{$timesheet->id}}">
                                            {{$timesheet->clock_in}} - {{($timesheet->clock_out)?$timesheet->clock_out:'Ongoing'}}
                                        </button>
                                    </h2>
                                    <div>
                                        <button class="btn btn-dark">
                                            {{ (new \Carbon\Carbon($timesheet->clock_in))->diff(new \Carbon\Carbon($timesheet->clock_out))->format('%h:%I') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapse-{{$timesheet->id}}" class="collapse" aria-labelledby="timesheet-heading-{{$timesheet->id}}" data-parent="#timesheets">
                            <div class="card-body">
                                <div class="alert alert-white" role="alert">
                                    <div>
                                        {{ $timesheet->description }}
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('timesheet.edit', $timesheet->id) }}" class="btn btn-primary">{{ __('Update') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card-body">
            <div class="alert alert-secondary" role="alert">{{ __('No items to show!') }}</div>
        </div>
    @endif
    </div>
    <div class="mt-3 d-flex justify-content-between">
        <a class="btn btn-primary" href="{{ url()->previous() }}">{{ __('Go Back') }}</a>
        <button id="csv_export_btn" class="btn btn-dark">{{ __('Export to CSV')}}</button>
    </div>
</div>
@endsection('content')
@extends('layouts.app')
