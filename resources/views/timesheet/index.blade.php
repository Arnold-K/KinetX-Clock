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

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
