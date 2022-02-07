@extends('foro.layout')

@section('content')
<div class="card card-forum">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-chart-pie mr-2"></i>Estadísticas de <b>{{$user->username}}</b></h4>
    </div>
    <div class="card-body card-body-forum">
        <p><b>Rol: </b>{{ucfirst($user->getRoleNames()[0])}}</p>
        <p><b>Creación de cuenta: </b>{{\Carbon\Carbon::parse($user->created_at)->format('d/M/Y')}}</p>
        <p><b>Última actualización de cuenta: </b>{{\Carbon\Carbon::parse($user->updated_at)->format('d/M/Y')}}</p>
        <p><b>Total de posts: </b>{{$user->posts->count()}}</p>
        <p><b>Total de mensajes: </b>{{$user->comments->count()}}</p>

        @if(\Auth::user() && $user->id !== \Auth::user()->id)
        <a href="#" style="color:#fff; background:#bd1823;" data-toggle="modal" data-target="#createMessage" class="w-100 btn">Escribir mensaje privado</a>
        @include('partials.modals.create_message')
        @endif
    </div>
</div>
@endsection