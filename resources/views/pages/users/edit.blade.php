@section('content')
<div class="container">
    <div class="card">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            <input type="hidden" name="_method" value="put">
            @csrf
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="title m-0">Users List</h4>
                    <a id="delete-user" class="btn btn-danger" href="{{route('user.destroy', $user->id)}}" type="Back">Delete User</a>
                </div>
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
                    <label for="role">Role</label>
                    <select id="role" class="form-control" name="role" placeholder="Role">
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
                {{-- {{ (session()->has('updated_success')) ? "hello" : "no" }}
                {{ print_r(session()->all()) }}
                @if (session()->has('updated_success'))
                    <div class="alert alert-success d-flex justify-content-between" role="alert">
                        <span>{{ session()->get('updated_success') }}</span>
                        <div>
                            <a class="btn btn-sm btn-primary" href="{{ route('user.index') }}">{{ __('Go Back') }}</a>
                        </div>
                    </div>
                @endif --}}
            </div>
        </form>
    </div>
</div>
@endsection('content')
@extends('layouts.app')
