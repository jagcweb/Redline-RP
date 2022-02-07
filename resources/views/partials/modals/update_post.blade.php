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
        <form method="POST" action="{{route('post.update', ['id' => \Crypt::encryptString($post->id)])}}">
          @csrf
          <div class="form-group">
              <label for="titulo" style="color:#fff;">Título</label>
              <input type="text" value="{{$post->titulo}}" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="titulo" name="titulo" required>
          </div>


          
          <div class="form-group">
              <label for="desc" style="color:#fff;">Descripción</label>
              <textarea name="desc" id="desc" class="form-control tiny" value="{{$post->descr}}" required></textarea>
          </div>

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Editar"/>
        </form>
      </div>
    </div>
  </div>
</div>