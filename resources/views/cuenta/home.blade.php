@extends('foro.layout')

@section('content')
<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
  <a href="{{route('foro.index')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-home mr-2"></i>Inicio</a>
  <a class="breadcrumbs__item is-active"  style="text-decoration:none;"><i class="fas fa-user-lock mr-2"></i>Estadís. de mi cuenta</a> 
</div>
<div class="card card-forum">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-chart-pie mr-2"></i>Estadísticas de mi cuenta</h4>
    </div>
    <div class="card-body card-body-forum">
        <p><b>Creación de cuenta: </b>{{\Carbon\Carbon::parse(\Auth::user()->created_at)->format('d/M/Y')}}</p>
        <p><b>Última actualización de cuenta: </b>{{\Carbon\Carbon::parse(\Auth::user()->updated_at)->format('d/M/Y')}}</p>
        <p><b>Total de posts: </b>{{\Auth::user()->posts->count()}}</p>
        <p><b>Total de mensajes: </b>{{\Auth::user()->comments->count()}}</p>
    </div>
</div>
@endsection