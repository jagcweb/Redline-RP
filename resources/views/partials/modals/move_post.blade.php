<div class="modal fade"  id="moverPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Mover Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('post.move')}}">
          @csrf
          
          <div class="form-group">
              <label for="subtema_id" style="color:#fff;">Subtema</label>
              <select class="form-control" name="subtema_id">
                  <option selected hidden>Elige al subtema que lo quieres mover...</option>
                  @foreach($subtemas as $subtema)
                    <option value="{{$subtema->id}}">{{ucfirst($subtema->nombre)}}</option>
                  @endforeach
              </select>
          </div>
          <input type="text" value="{{$post->id}}" name="post_id" hidden/>

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Mover"/>
        </form>
      </div>
    </div>
  </div>
</div>