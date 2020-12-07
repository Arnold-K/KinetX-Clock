@include('component.password.override-password')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="title">Users List</h4>
        </div>
        <div class="card-body">
            <ul class="list-group" id="user-list-group">
                @foreach ($users as $key => $user)
                    <li data-id="{{ $user->id }}" class="list-group-item d-flex align-items-center">
                        <div class="mr-3">
                            <span>{{ $key+1 }} - </span>
                        </div>
                        <div class="d-flex justify-content-between flex-grow-1 align-items-center">
                            <a href="{{route('user.edit', $user->id)}}">{{ $user->name }}</a>
                            <div>
                                <button type="button" class="btn btn-warning" data-action="override-password"><i class="fas fa-lock"></i></button>
                                <a href="{{route('rate.show', $user->employee->id)}}"><span class="btn btn-danger">{{__('Change Rate')}}</span></a>
                                <a href="{{route('timesheet-list.show', $user->employee->id)}}"><span class="btn btn-warning">{{__('Timesheet')}}</span></a>
                                <a href="{{route('payment.show', $user->employee->id)}}"><span class="btn btn-success">{{__('Payments')}}</span></a>
                                <button type="button" class="btn btn-danger" data-action="delete-user"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">

        </div>
    </div>

    @yield('override_password')
</div>
@endsection('content')
@extends('layouts.app')
