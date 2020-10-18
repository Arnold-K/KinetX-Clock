@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="title">Users List</h4>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($users as $user)
                    <li class="list-group-item d-flex justify-content-between">
                        <a href="{{route('user.edit', $user->id)}}">{{ $user->name }}</a>
                        <div>
                            <a href="{{route('rate.show', $user->employee->id)}}"><span class="btn btn-danger btn-sm">{{__('Change Rate')}}</span></a>
                            <a href="{{route('timesheet-list.show', $user->employee->id)}}"><span class="btn btn-warning btn-sm">{{__('Timesheet')}}</span></a>
                            <a href="{{route('payment.show', $user->employee->id)}}"><span class="btn btn-success btn-sm">{{__('Payments')}}</span></a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
@endsection('content')
@extends('layouts.app')
