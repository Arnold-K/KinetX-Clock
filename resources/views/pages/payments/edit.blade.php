@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    Payment - <b>{{ $employee->name }}</b>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.update', $payment->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group">
                            <label for="new_amount">New Payment</label>
                            <input class="form-control" name="amount" id="new_amount" type="number" step="0.01" value="0.00" >
                            @error('field')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Update payment value</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
