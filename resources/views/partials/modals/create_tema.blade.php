<div class="modal fade" id="crearTema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Crear Tema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('foro.save')}}">
          @csrf
          <div class="form-group">
              <label for="nombre" style="color:#fff;">Nombre</label>
              <input type="text" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="nombre" name="nombre" required>
          </div>

          <div class="form-group">
              <label for="oculto" style="color:#fff;">¿Ocultar? (solo mods y admins podrán verlo)</label>
              <input type="checkbox" name="oculto" id="oculto" value="1" class="form-control"/>
          </div>

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Crear"/>
        </form>
      </div>
    </div>
  </div>
</div>