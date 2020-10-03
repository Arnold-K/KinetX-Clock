@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Rate for User:') }} <a href="{{ route('user.edit', $employee->user->id) }}">{{ $employee->user->name }}</a></h4>
        </div>
        <div class="card-body">
            <form action="{{route('rate.update', $employee->id)}}" method="POST" >
                @csrf
                <input type="hidden" name="_method" value="put">
                <label for="current_rate">{{ __('Current rate') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><strong>$</strong></div>
                    </div>
                    <input type="text" class="form-control" disabled name="current_rate" value="{{ $employee->rate?$employee->rate:'No rate set' }}">
                </div>

                <label for="rate">{{ __('Set new rate') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><strong>$</strong></div>
                    </div>
                    <input type="number" id="rate" class="form-control" value="{{ $employee->rate?$employee->rate:'' }}" step="0.05" min="0" name="rate" placeholder="{{ __('Rate') }}">
                    @error('rate')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group text-center mt-5">
                    <button class="btn btn-primary">{{ __('Update Rate') }}</button>
                </div>
                @if (session()->has('success'))
                    <div class="alert alert-success d-flex justify-content-between" role="alert">
                        <span>{{ session()->get('success') }}</span>
                        <div>
                            <a class="btn btn-sm btn-primary" href="{{ route('user.index') }}">{{ __('Go Back') }}</a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection('content')
@extends('layouts.app')
