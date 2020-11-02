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
            <div class="card" id="timesheet-edit-card">
                @if ($timesheet)
                    <div class="card-header bg-primary text-white">{{ __('Update Timesheet') }}</div>
                @else
                    <div class="card-header bg-primary text-white">{{ __('Clock in a timesheet') }}</div>
                @endif

                <div class="card-body">
                    {{-- {{!!json_encode(session()->has('status'))!!}} --}}


                    @if ($timesheet)
                        <form action="{{route('timesheet.update', $timesheet->id)}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="put">
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
                                            <input type="text" name="clock_out" value="{{ $timesheet_end_time }}" class="form-control datetimepicker-input" data-target="#end_time"/>
                                            <div class="input-group-append" data-target="#end_time" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $timesheet->description }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="card-body d-flex justify-content-around">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @else
                        <div class="card-body">
                            <a href="{{ url()->previous() }}" class="btn btn-primary">{{ __('Go Back') }}</a>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
