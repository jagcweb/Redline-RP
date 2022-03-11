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
    <div class="card card-forum" style="background:none!important;">
        <div class="card-header card-header-forum" style="width:100%; display:flex; flex-direction:row; justify-content:space-between;">
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" || \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
        <h4 style="margin:0px;">{{ucfirst($subt->nombre)}}</h4><a href="#" style="color:#fff;" data-toggle="modal" data-target="#editSubtema-{{$subt->id}}"><i class="fas fa-pen ml-2" style="font-size: 1.5rem;"></i></a>
        @include('partials.modals.edit_subtema')
        @else
        <h4 style="margin:0px;">{{ucfirst($subt->nombre)}}</h4>
        @endif
        </div>
      @if(is_null($subt->post_propio))
        @if(count($posts)>0)
          @foreach($posts as $i=>$post)
          @if(!is_null($post->oculto) && \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" || !is_null($post->oculto) && \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
              <div class="card-body card-body-forum">
                <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
                <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
              </div>
            @else
            <div class="card-body card-body-forum">
                <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
                <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
              </div>
            @endif
          @endforeach
        @else
          <p class="text-center w-100 d-block mt-3" style="color:#fff;">No hay posts aún</p>
        @endif
      @else
      @if(count($posts)>0)
      @foreach($posts as $i=>$post)
      @if(!is_null($post->oculto))
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
        \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
          <div class="card-body card-body-forum">
                <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
                <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
              </div>
        @elseif(\Auth::user() && $post->user->id == \Auth::user()->id ||
         \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
          \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" ||
          $post->user->getRoleNames()[0] == "mod" ||
          $post->user->getRoleNames()[0] == "admin")
        <div class="card-body card-body-forum">
              <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
              <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
            </div>
        @endif
      @else
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
        \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
          <div class="card-body card-body-forum">
                <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
                <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
              </div>
        @elseif(\Auth::user() && $post->user->id == \Auth::user()->id ||
         \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
          \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" ||
          $post->user->getRoleNames()[0] == "mod" ||
          $post->user->getRoleNames()[0] == "admin")
        <div class="card-body card-body-forum">
              <h5><a href="{{route('post.get', ['tema' => $subt->tema->nombre, 'subtema' => $subt->nombre, 'post' => $post->id])}}" style=" color:#bd1823;">{{ucfirst($post->titulo)}}</a></h5>
              <small><span style="color:#eee;">Creado por:</span> <span style="color:#fff; font-size:14px; font-weight:bold;">{{$post->user->username}}</span></small>
            </div>
        @endif
      @endif
      @endforeach
      @else
          <p class="text-center w-100 d-block mt-3" style="color:#fff;">No hay posts aún</p>
        @endif
      @endif
    </div>

@endsection