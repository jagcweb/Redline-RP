@extends('foro.layout')

@section('content')
<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
  <a href="{{route('foro.index')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-home mr-2"></i>Inicio</a>
  <a class="breadcrumbs__item is-active"  style="text-decoration:none;"><i class="fas fa-mail-bulk mr-2"></i>Mensajería privada</a> 
</div>
<div class="card card-forum">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-inbox mr-2"></i>Mensajes recibidos</b></h4>
    </div>
    <div class="card-body card-body-forum">
        @if(count($messages)>0)
        @foreach($messages as $message)
        <a href="{{route('mensaje.get_message', ['id' => \Crypt::encryptString($message->id)])}}" class="p-2 w-100 d-block" style="background:rgba(255,255,255,0.2); color:#fff; text-decoration:none;">
        @if(is_null($message->leido)) <b>{{$message->user->username}}</b>: {{$message->asunto}} - <small>(Sin leer)</small>
        @else
        {{$message->user->username}}: {{$message->asunto}}
        @endif
        </a>
        <br>
        @endforeach
        @else
        <p>Aún no tienes mensajes en tu bandeja de entrada!</p>
        @endif
    </div>
</div>

<div class="card card-forum mt-3">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-envelope mr-2"></i>Mensajes enviados</b></h4>
    </div>
    <div class="card-body card-body-forum">
        @if(count($messages_sended)>0)
        @foreach($messages_sended as $message)
        <a href="{{route('mensaje.get_message', ['id' => \Crypt::encryptString($message->id)])}}" class="p-2 w-100 d-block" style="background:rgba(255,255,255,0.2); color:#fff; text-decoration:none;"><span style="color:#bd1823;">{{$message->receptor->username}}: </span>{{$message->asunto}}</a>
        <br>
        @endforeach
        @else
        <p>Aún no has enviado ningún mensaje!</p>
        @endif
    </div>
</div>
@endsection