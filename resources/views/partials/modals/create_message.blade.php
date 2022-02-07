<div class="modal fade" id="createMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Enviar mensaje privado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('mensaje.save')}}">
          @csrf
          <input type="text" name="receptor_id" value="{{\Crypt::encryptString($user->id)}}" hidden/>
          <div class="form-group">
              <label for="username" style="color:#fff;">Usuario</label>
              <input type="text" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" value="{{$user->username}}" disabled class="form-control" id="username" name="username" required>
          </div>

          <div class="form-group">
              <label for="asunto" style="color:#fff;">Asunto</label>
              <input type="text" name="asunto" id="asunto" class="form-control" required/>
          </div>

          <div class="form-group">
              <label for="mensaje" style="color:#fff;">Mensaje</label>
              <textarea type="text" name="mensaje" id="mensaje" class="form-control" required></textarea>
          </div>

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Enviar"/>
        </form>
      </div>
    </div>
  </div>
</div>