@extends('foro.layout')

@section('content')

<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
  <a href="{{route('foro.index')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-home mr-2"></i>Inicio</a>
  <a class="breadcrumbs__item is-active"  style="text-decoration:none;"><i class="fas fa-user-cog mr-2"></i>Config. de mi cuenta</a> 
</div>
<div class="card card-forum">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-cogs mr-2"></i>Configuración de mi cuenta</h4>
    </div>
    <div class="card-body card-body-forum">
        <form method="POST" action="{{route('cuenta.update')}}" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="nombre" style="color:#fff;">Nombre</label>
                <input type="text" value="{{\Auth::user()->name}}" style="border:none; border-bottom:2px solid #fff; background:transparent; color:#fff;" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="usuario" style="color:#fff;">Usuario</label>
                <input type="text" value="{{\Auth::user()->username}}" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="form-group">
                <label for="email" style="color:#fff;">Email</label>
                <input type="email" value="{{\Auth::user()->email}}" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="avatar" style="color:#fff;">Avatar</label>
                <input type="file" accept=".jpg,.jpeg,.png,.webp" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="avatar" name="avatar">
                @if(!is_null(\Auth::user()->avatar))
                <p class="mt-2">Avatar actual: <img src="{{url('/user-image').'/'.\Auth::user()->avatar}}"  class="rounded-circle" width="50" height="50" style="object-fit:cover;"/></p>
                @else
                <p class="mt-2">Avatar actual:<img src="{{url('assets')}}/images/user.webp" class="rounded-circle" width="50" /></p>
                @endif
            </div>

            <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn " value="Modificar"/>
        </div>
        </form>
    </div>
</div>

<div class="card card-forum mt-3">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-key mr-2"></i>Cambiar contraseña</h4>
    </div>
    <div class="card-body card-body-forum">
    <form method="POST" action="{{route('cuenta.password')}}" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">

            <div class="form-group">
                <label for="actual_password" style="color:#fff;">Contraseña actual</label>
                <input type="password" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" minlenght="8" class="form-control" id="actual_password" name="actual_password" required>
            </div>

            <div class="form-group">
                <label for="password" style="color:#fff;">Nueva contraseña</label>
                <input type="password" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" minlenght="8" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password" style="color:#fff;">Confirmar nueva contraseña</label>
                <input type="password" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" minlenght="8" class="form-control" id="confirm_password" name="password_confirmation" required>
            </div>

            <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn " value="Modificar"/>
        </div>
        </form>
    </div>
</div>
@endsection