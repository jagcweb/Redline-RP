@extends('foro.layout')

@section('content')

  @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "super-admin")
  @include('foro.admin_partial')
  @else
  @include('foro.home_partial')
  @endif

@endsection