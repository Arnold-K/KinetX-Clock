@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="title">Users List</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" value="{{$user->name}}" name="name" placeholder="Full Name">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" value="{{$user->email}}" name="email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <label for="rate">Rate</label>
                <input type="number" step="0.05" min="0" id="rate" class="form-control" name="rate" placeholder="Rate">
            </div>
            <div class="form-group">
                <label for="role">E-mail</label>
                <select type="email" id="role" class="form-control" name="role" placeholder="Role">
                    @foreach($roles as $role)
                        @if($user->hasRole($role))
                            <option selected value="{{$role->id}}">{{$role->name}}</option>
                        @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="d-flex justify-content-around">
                    <button class="btn btn-primary" type="submit">Update User</button>
                    <a class="btn btn-secondary" href="{{route('user.index')}}" type="Back">Go Back</a>
                </div>
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>
@endsection('content')
@extends('layouts.app')
