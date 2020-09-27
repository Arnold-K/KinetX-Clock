@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
<a class="btn btn-primary" href="{{route('home')}}">Go to Home Page</a>
@section('message', __('Not Found'))
