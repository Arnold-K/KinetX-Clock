@section('content')
<div class="container">
    @if (session()->has('show_create_timesheet') )

    @endif
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
    @can('create_custom_entry')
        @if (isset($timesheet_entry_create_success))
            <div class="alert alert-success text-center mt-3" role="alert">
                {{ $timesheet_entry_create_success }}
            </div>
        @endif
        <div class="card mt-3">
            <div class="card-header" id="timesheet-heading-create">
                <div class="d-flex">
                    <button data-timesheet="create" class="btn btn-white {{ session()->has('show_create_timesheet') ?'':'collapsed' }}" type="button" data-toggle="collapse" data-target="#collapse-create" aria-controls="collapse-create" aria-expanded="{{ session()->has('show_create_timesheet') ?'true':'false' }}">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <div class="d-flex justify-content-between flex-grow-1">
                        <h2 class="mb-0 flex-grow-1">
                            <button data-timesheet="create" class="btn btn-white w-100 text-left {{ session()->has('show_create_timesheet') ?'':'collapsed' }}" type="button" data-toggle="collapse" data-target="#collapse-create" aria-controls="collapse-create" aria-expanded="{{ session()->has('show_create_timesheet') ?'true':'false' }}">
                                {{ __('Create Timesheet Entry') }}
                            </button>
                        </h2>
                    </div>
                </div>
            </div>
            <div data-entry="create" id="collapse-create" class="{{ session()->has('show_create_timesheet') ?'collapse show':'collapse' }}" aria-labelledby="timesheet-heading-create">
                <div class="card-body">
                    @error('employee')
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('clock_in')
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('clock_out')
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('description')
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('start_time_greater')
                        <div class="alert alert-danger text-center mt-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    <form action="{{route('timesheet.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="employee" value="{{ $employee->id }}">
                        <input type="hidden" name="custom" value="true">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_time">{{ __('Clock in time') }}</label>
                                    <div class="input-group date" id="start_time" data-target-input="nearest">
                                        <input type="text" name="clock_in" value="{{ $timesheet_start_time }}" class="form-control datetimepicker-input" data-target="#start_time"/>
                                        <div class="input-group-append" data-target="#start_time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_time">{{ __('Clock out time') }}</label>
                                    <div class="input-group date" id="end_time" data-target-input="nearest">
                                        <input type="text" name="clock_out" value="{{ $timesheet_start_time }}" class="form-control datetimepicker-input" data-target="#end_time"/>
                                        <div class="input-group-append" data-target="#end_time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                            @error('description')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="card-body d-flex justify-content-around">
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
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
                        <div data-entry={{ "$timesheet->id" }} id="collapse-{{$timesheet->id}}" class="collapse" aria-labelledby="timesheet-heading-{{$timesheet->id}}" data-parent="#timesheets">
                            <div class="card-body">
                                <div class="alert alert-white" role="alert">
                                    <div>
                                        {{ $timesheet->description }}
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('timesheet.edit', $timesheet->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                        <button data-action="delete-timesheet-entry" class="btn btn-danger">{{ __('Delete') }}</button>
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
