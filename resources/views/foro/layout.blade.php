<!DOCTYPE html>
<html lang="es-es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RedlineRP - Foro</title>

    <link rel="stylesheet" type="text/css" href="{{url('assets')}}/css/styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet"> 
</head>
<body style="background: #0d1219;">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: url('{{url('assets')}}/images/4.jpg') no-repeat center center; 
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover; 
border-bottom:1px solid #b2b2b2; height:200px;">
    <a class="navbar-brand" href="{{route('foro.index')}}"><img class="logo" src="{{url('assets')}}/images/redline_logo.png" width="150" style="object-fit:cover;"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    @if(\Auth::user())
    @php $notificaciones = \App\Models\Notificacion::where('user_id', \Auth::user())->get(); @endphp
    <li class="dropdown notification-list topbar-dropdown" style="list-style:none;">
            <a class="navbar-brand dropdown-toggle waves-effect waves-light" style=" color:#fff;" data-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fas fa-bell noti-icon text-dark"></i>
                @if(count($notificaciones) >9)
                <span class="badge badge-danger rounded-circle noti-icon-badge font-12"><strong>9+</strong></span>
                @else
                    <span class="badge badge-danger rounded-circle noti-icon-badge font-12"><strong>{{count($notificaciones)}}</strong></span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title"   style="pointer-events: none; font-size:16px;">
                    <h5 class="m-0">
                        <span class="float-right">
                                @if(count($notificaciones)>0)
                            <a href="" class="text-dark">
                                <a href="{{route('notificacion.borrar_all')}}" style="font-size:12px; color:#323A46;">Borrar todas</a>
                            </a>
                                @endif
                        </span>
                        <span>Notificaciones</span>
                    </h5>
                </div>

                <div class="noti-scroll mt-2" style="font-size:14px;">
                    @if(count($notificaciones)<1)
                    <p class="text-center">No tienes notificaciones :(</p>
                    @else

                    @foreach($notificaciones as $notificacion)
                    <small class="text-muted mt-2" style="padding: 1.2rem; font-size:13px; padding-top:15px;">{{$notificacion->type}}</small>
                    <a title="Borrar notificación" style="color:#de0000; font-weight:bold; float:right; margin-right:50px;" href="{{route('notificacion.borrar', ['id' => \Crypt::encryptString($notificacion->id)])}}">X</a>
                        @switch($notificacion->type)
                            @case('post')
                            <a href="#">
                                    <div class="notify-icon bg-dark">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                <p class="notify-details">{{$notificacion->text}}
                                    <small class="text-muted">{{\Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i')}}</small>
                                </p>
                            </a>
                            @break

                            @case('mensaje')
                            <a href="#">
                                    <div class="notify-icon bg-dark">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                <p class="notify-details">{{$notificacion->text}}
                                    <small class="text-muted">{{\Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i')}}</small>
                                </p>
                            </a>
                            @break
                        @endswitch
                      @endforeach
                      @endif
                </div>
            </div>
        </li>
      @endif
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
        @if(\Auth::user())
        <li style="list-style: none;" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="color:#fff;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if(!is_null(\Auth::user()->avatar))
              <img src="{{url('/user-image').'/'.\Auth::user()->avatar}}"  class="rounded-circle" width="50" height="50" style="object-fit:cover;"/>
              @else
              <img src="{{url('assets')}}/images/user.webp" class="rounded-circle" width="50" />
              @endif
            </a>
  
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{route('cuenta.home')}}">Mi cuenta</a>
              <a class="dropdown-item" href="{{route('mensaje.get')}}">Mensajes privados</a>
              <a class="dropdown-item" href="{{route('cuenta.config')}}">Configuración</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}">
                  Salir
              </a>
            </div>
          </li>
          @else
          <li class="nav-item log">
          <a class="nav-link p-2" style="color:#fff; background:rgba(189, 24, 35, 1); border-radius:10px;  width:100px; text-align:center;" href="#" data-toggle="modal" data-target="#loginModal">Ingresar</a>
        </li>
        <li class="nav-item log">
          <a class="nav-link p-2" style="color:#fff;background:rgba(189, 24, 35, 1); border-radius:10px; width:100px; text-align:center;"  href="#" data-toggle="modal" data-target="#registerModal">Registrarse</a>
        </li>
          @endif
    </div>
  </nav>

  @include('partials.msg')
  <div class="card card-forum-div">
    <div class="card-body">
      @yield('content')

      <div class="mt-5"></div>
      <hr style="border-bottom: 1px solid #b2b2b2;">
      <div class="card mt-5 card-forum">
        <div class="card-header card-header-forum">
            <h4 style="margin:0px;">
            <i class="fas fa-chart-pie mr-2"></i>Estadísticas del foro</h4>
        </div>
        <div class="card-body card-body-forum">
            @php
            $users = App\Models\User::all(); 
            $total_online = 0; 
            $posts = App\Models\Post::count();
            $comments = App\Models\Comment::count();
            @endphp
            <p style="color:#bd1823;"> <b style="color:#fff;"> Total de usuarios registrados:</b> {{$users->count()}}</p>
            @foreach($users as $user)
              @if(\Cache::has('user-is-online-' . $user->id))
                @php $total_online++; @endphp
              @endif
            @endforeach
            <p style="color:#bd1823;"> <b style="color:#fff;"> Total de usuarios online:</b> {{$total_online}}</p>
            <p style="color:#bd1823;"> <b style="color:#fff;"> Total de posts:</b> {{$posts}}</p>
            <p style="color:#bd1823;"> <b style="color:#fff;"> Total de mensajes:</b> {{$comments}}</p>
        </div>
    </div>
    @include('partials.modals.register')
    @include('partials.modals.login')
  </div>
</div>

<footer style="height:120px;
display:flex; flex-direction:column; justify-content:center; align-items:center;" class="mt-4">
  <p style="color:#fff; font-size:24px;" class="mt-5"><i class="fas fa-paper-plane mr-2"></i>Redes sociales</p>
  <div style="display:flex; flex-direction:row; justify-content:space-between; align-items:center;">
    <div class="weblink2 ">
        <a style="text-decoration:none;" id="discord"  href="https://discord.io/RedLineRoleplay18" target="_blank">
            <i class="fab fa-discord"></i>
        </a>
    </div>
    <div class="weblink2 ml-3">
        <a style="text-decoration:none;" id="twitter"  href="https://twitter.com/RedLineRP6" target="_blank">
            <i class="fab fa-twitter"></i>
        </a>
    </div>
    <div class="weblink2  ml-3">
        <a style="text-decoration:none;" id="instagram"  href="https://www.instagram.com/redlinerp_oficial/" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
    </div>
    <div class="weblink2  ml-3">
        <a style="text-decoration:none;" id="tiktok" href="https://www.tiktok.com/@redlinerp6" target="_blank">
        <i class="fab fa-tiktok"></i>
        </a>
    </div>
  </div>
  <hr style="width:85%; border-bottom:1px solid white;">
  <div style="width:85%; display:flex; flex-direction:row; justify-content:space-between; align-items:center;">
    <p style="color:#fff; font-size:16px;">REDLINE Role Play</p>
    <p style="color:#fff; font-size:16px;">&copy; 2022</p>
  </div>
</footer>

</body>

</html>