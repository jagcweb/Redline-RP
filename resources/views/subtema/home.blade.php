@extends('foro.layout')

@section('content')

@if(\Auth::user())
  <a href="#" class="w-100 text-center mb-2 d-block btn" data-toggle="modal" data-target="#crearPost" style="color:#fff; background:#7e030b ;"><i class="fas fa-plus" style="font-size:18px; margin-right:5px"></i>Nuevo Post</a>
  @include('partials.modals.create_post')
  @else
    <span class="text-center w-100 d-block  mb-2" style=" color:#fff;">Para crear un post has de loguearte.</span>
  @endif

<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
  <a href="{{route('foro.index')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-home mr-2"></i>Inicio</a>
  <a class="breadcrumbs__item is-active"  style="text-decoration:none;"><i class="fas fa-folder mr-2"></i>{{$subt->tema->nombre}} - {{$subt->nombre}}</a> 
</div>
@if(count($posts)>0)
    <div class="card card-forum" style="background:none!important;">
        <div class="card-header card-header-forum">
            <h4 style="margin:0px;">{{ucfirst($subt->nombre)}}</h4>
        </div>
      @if(is_null($subt->post_propio))
        @foreach($posts as $i=>$post)
            <div class="card-body card-body-forum">
              <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
              <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
            </div>
        @endforeach
      @else
      @foreach($posts as $i=>$post)
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
        \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
          <div class="card-body card-body-forum">
                <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
                <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
              </div>
        @elseif(\Auth::user() && $post->user->id === \Auth::user()->id)
        <div class="card-body card-body-forum">
              <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
              <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
            </div>
        @endif
      @endforeach
      @endif
    </div>
  @else
    <p class="text-center w-100 d-block" style="color:#fff;">No hay posts aún</p>
  @endif

@endsection