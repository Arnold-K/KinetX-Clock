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
                        <a href="{{route('user.edit', $user->id)}}">{{$user->name}}</a>
                        <div>
                            <a href="{{route('employee.rate.index', $user->employee->id)}}"><span class="badge badge-pill badge-danger">{{__('Change Rate')}}</span></a>
                            <a href="{{route('timesheet-list.show', $user->employee->id)}}"><span class="badge badge-pill badge-success">{{__('Timesheet')}}</span></a>
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