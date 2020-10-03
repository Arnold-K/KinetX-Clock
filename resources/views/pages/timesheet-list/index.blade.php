@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Select dates</h4>
        </div>
        <div class="card-body">
            <form action="{{route('timesheet-list.search.show', $employee->id)}}" method="POST" >
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input class="form-control" type="date" id="start_date" name="start_date" value="{{\Carbon\Carbon::now()->subDays(30)->format('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input class="form-control" type="date" id="end_date" name="end_date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-100 btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
    @if(count($timesheets))
        <div class="card mt-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4>Timesheet</h4>
                    <button class="btn btn-success">{{$total_working_time}}</button>
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
                                    {{ $timesheet->description }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <div class="mt-3 d-flex justify-content-between">
        <a class="btn btn-primary" href="{{ url()->previous() }}">{{ __('Go Back') }}</a>
        <a class="btn btn-dark" href="{{ route('timesheet-list.export.index', $employee->id) }}?type=csv">{{ __('Export to CSV')}}</a>
    </div>
</div>
@endsection('content')
@extends('layouts.app')