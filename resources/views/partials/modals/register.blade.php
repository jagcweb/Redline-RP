<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Registrarse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('register.home')}}" enctype="multipart/form-data">
        @csrf
      <div class="modal-body">
        <div class="form-group">
            <label for="nombre" style="color:#fff;">Nombre</label>
            <input type="text" style="border:none; border-bottom:2px solid #fff; background:transparent; color:#fff;" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="usuario" style="color:#fff;">Usuario</label>
            <input type="text" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="usuario" name="usuario" required>
        </div>

        <div class="form-group">
            <label for="email" style="color:#fff;">Email</label>
            <input type="email" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password" style="color:#fff;">Contraseña</label>
            <input type="password" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" minlenght="8" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password" style="color:#fff;">Confirmar Contraseña</label>
            <input type="password" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" minlenght="8" class="form-control" id="confirm_password" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="avatar" style="color:#fff;">Avatar</label>
            <input type="file" accept=".jpg,.jpeg,.png,.webp" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="avatar" name="avatar">
        </div>

        <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Registrarse"/>
      </div>
      </form>
    </div>
  </div>
</div>