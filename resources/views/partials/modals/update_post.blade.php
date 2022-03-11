@if(\Auth::user())
<div class="modal fade" id="editarPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Crear Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" class="update_post_form" action="{{route('post.update', ['id' => \Crypt::encryptString($post->id)])}}">
          @csrf
          <div class="form-group">
              <label for="titulo" style="color:#fff;">Título</label>
              <input type="text" value="{{$post->titulo}}" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="titulo" name="titulo" required>
          </div>


          
          <div class="form-group">
              <label for="desc" style="color:#fff;">Descripción</label>
              <textarea name="desc" id="desc" class="form-control tiny" required></textarea>
              <input type="text" value="{{$post->descr}}" class="area" hidden/>
          </div>

          @if(\Auth::user()->getRoleNames()[0] == "mod" || \Auth::user()->getRoleNames()[0] == "admin")
          <div class="form-group">
              <label for="block" style="color:#fff;">Bloqueado (solo mods y admins podrán escribir)</label>
              <input type="checkbox" name="block" value="1" id="block" class="form-control" @if($post->bloqueado) checked @endif/>
          </div>

          <div class="form-group">
              <label for="own_reply" style="color:#fff;">Respuesta propia (solo los mods y admins podrán ver todas las respuestas. Los usuarios únicamente podrán ver la suya)</label>
              <input type="checkbox" name="own_reply"  value="1" id="own_reply" class="form-control"  @if($post->respuesta_propia) checked @endif/>
          </div>

          <div class="form-group">
              <label for="own_reply" style="color:#fff;">Ocultar post (solo los mods y admins podrán ver el post)</label>
              <input type="checkbox" name="hidden"  value="1" id="hidden" class="form-control"  @if($post->oculto) checked @endif/>
          </div>
          @endif

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn btn-editar" value="Editar"/>
        </form>
      </div>
    </div>
  </div>
</div>
@endif