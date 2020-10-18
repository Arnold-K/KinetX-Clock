@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @error('payment_employee')
                <div class="alert alert-danger text-center" role="alert">
                    {{ $message }}
                </div>
            @enderror
            @error('access_employee')
                <div class="alert alert-danger text-center" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4>Select dates</h4>
                        <div>
                            <span>Balance: <b>{{ $total_balance }}</b></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('payment.show', $employee->id)}}" method="GET" >
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
            <div class="my-3"></div>
            @error('empty')
                <div class="alert alert-danger text-center" role="alert">
                    {{ $message }}
                </div>
                <div class="my-3"></div>
            @enderror
            @if (session()->has('amount_updated_success'))
                <div class="alert alert-success text-center" role="alert">
                    <i class="fas fa-info-circle"></i> {{ session()->get('amount_updated_success') }}
                </div>
            @endif
            @if (isset($payments) && count($payments))
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Payment List') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul id="payment-list" class="list-group">
                            @foreach ($payments as $payment)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>{{ $payment->date }}</div>
                                        <div class="col-2">${{ $payment->amount }}</div>
                                        <div class="col-2">
                                            <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-sm btn-secondary"><i class="far fa-edit"></i></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
