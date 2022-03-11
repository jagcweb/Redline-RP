<div class="modal fade" id="updateComment-{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Editar comentario {{$comment->id}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form style=" margin:0px auto;" method="POST" class="update_comment_form"  action="{{route('comment.update')}}">
          @csrf
          <input type="text" name="comment_id" value="{{\Crypt::encryptString($comment->id)}}" hidden/>
          <div class="form-group">
              <textarea name="comment" id="comment_set-{{$comment->id}}" class="form-control tiny" required></textarea>
              <input type="text" value="{{$comment->comment}}" id="area2-{{$comment->id}}" hidden/>
              <input type="text" value="{{$comment->id}}" class="id-comment" hidden/>
          </div>
          <input type="submit" class="w-100 btn btn-editar-comment" style="color:#fff; background:#7e030b ;" value="Editar comentario"/>
        </form>
      </div>
    </div>
  </div>
</div>