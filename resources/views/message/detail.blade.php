@extends('foro.layout')

@section('content')
<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
  <a href="{{route('foro.index')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-home mr-2"></i>Inicio</a>
  <a href="{{route('mensaje.get')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-mail-bulk mr-2"></i>Mensajería privada</a> 
  <a class="breadcrumbs__item is-active"  style="text-decoration:none;"><i class="fas fa-envelope-open-text mr-2"></i>Leer mensaje</a> 
</div>
<div class="card card-forum">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-envelope-open-text mr-2"></i>
        @if(\Auth::user() && $message->user_id == \Auth::user()->id) 
        Mensaje para <b>{{$message->receptor->username}}</b> con asunto <b>{{$message->asunto}}
        @else
        Mensaje de <b>{{$message->user->username}}</b> con asunto <b>{{$message->asunto}}
        @endif

        </b></h4>
    </div>
    <div class="card-body card-body-forum">
        <p>{{$message->mensaje}}</p>
            @if(\Auth::user() && $message->user_id != \Auth::user()->id)
            <a href="#" style="color:#fff; background:#bd1823;" data-toggle="modal" data-target="#createMessage" class="w-100 btn">Escribir mensaje privado</a>
            @php $user = $message->user; @endphp
            @include('partials.modals.create_message')
            @endif
    </div>
</div>
@endsection