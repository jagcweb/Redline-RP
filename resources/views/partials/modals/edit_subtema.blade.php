<div class="modal fade" id="editSubtema-{{$subt->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Editar Subtema {{$subt->nombre}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('subtema.update')}}">
          @csrf
          <div class="form-group">
              <label for="nombre" style="color:#fff;">Nombre</label>
              <input type="text" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" value="{{$subt->nombre}}"  class="form-control" id="nombre" name="nombre" required>
          </div>

          <div class="form-group">
              <label for="nombre" style="color:#fff;">Descripción</label>
             <textarea class="form-control" name="desc" id="desc">{{$subt->descr}}</textarea>
          </div>

          <div class="form-group">
              <label for="tema_id" style="color:#fff;">Tema</label>
              <select class="form-control" name="tema_id">
                  <option selected hidden value="{{$subt->tema->id}}">{{ucfirst($subt->tema->nombre)}}</option>
                  @foreach($temas as $tema)
                    <option value="{{$tema->id}}">{{ucfirst($tema->nombre)}}</option>
                  @endforeach
              </select>
          </div>

          <input type="text" name="id" value="{{\Crypt::encryptString($subt->id)}}" hidden/>

          <div class="form-group">
              <label for="own_post" style="color:#fff;">Post propio (solo los mods y admins podrán ver todos los posts. Los usuarios únicamente podrán ver los suyos)</label>
              <input type="checkbox" name="own_post"  value="1" id="own_post" @if(!is_null($subt->post_propio)) checked @endif class="form-control"/>
          </div>

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Editar"/>
        </form>
      </div>
    </div>
  </div>
</div>