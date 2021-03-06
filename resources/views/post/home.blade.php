@extends('foro.layout')

@section('content')
<script src="https://cdn.tiny.cloud/1/lwe1t2tv4oggrwpolep8lzhzppmk8rqknh8tvf2e3suyecx5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
    
<a href="{{route('foro.index')}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-home mr-2"></i>Inicio</a>
    <a href="{{route('subtema.index', ['tema' => $post->subtema->tema->nombre, 'subtema' => $post->subtema->nombre])}}" class="breadcrumbs__item" style="color:#fff;"><i class="fas fa-folder mr-2"></i>{{$post->subtema->tema->nombre}} - {{$post->subtema->nombre}}</a> 
    <a class="breadcrumbs__item is-active" style="text-decoration:none;"><i class="fas fa-pen mr-2"></i>{{$post->titulo}}</a> 
</div>
<div class="card card-forum" style="background:none!important;">
    <div class="card-header card-header-forum" style="display:flex; justify-content:space-between; align-items:center;" >
        <h4 style="margin:0px;">{{ucfirst($post->titulo)}} @if(!is_null($post->cerrado)) <small style="font-size:16px;">- (Cerrado)</small> @endif</h4>
        @include('partials.modals.update_post')
        @include('partials.modals.move_post')

        <a class="dropdown-toggle" href="#" style="color:#fff; ::after:content:none;" id="postDD" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones<i class="fas fa-sort-down ml-2" style="font-size:22px; margin-top:-5px;"></i></a>
        <div class="dropdown-menu" aria-labelledby="postDD">
        @if(is_null($post->cerrado))

            @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $post->user->getRoleNames()[0] != "admin" ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" )
            <a class="dropdown-item text-center " href="#" data-toggle="modal" data-target="#moverPost">Mover post</a>
            <hr>
            @endif

            
            @if(\Auth::user() && \Auth::user()->id == $post->user->id ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $post->user->getRoleNames()[0] != "admin" ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" )
            <a class="dropdown-item text-center " href="#" data-toggle="modal" data-target="#editarPost">Editar post</a>
            @endif

            @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $post->user->getRoleNames()[0] != "admin" || \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
            <form method="POST" action="{{route('post.close')}}">
                @csrf
                <input type="text" value="{{\Crypt::encryptString($post->id)}}" name="post_id" hidden/>
                <input class="dropdown-item text-center " type="submit" value="Cerrar Post"/>
            </form>
            @endif
            @endif

            @if(\Auth::user() && \Auth::user()->id == $post->user->id ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $post->user->getRoleNames()[0] != "admin" ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
            <form method="POST" action="{{route('post.delete')}}">
                @csrf
                <input type="text" value="{{\Crypt::encryptString($post->id)}}" name="post_id" hidden/>
                <input class="dropdown-item text-center " type="submit" value="Borrar Post"/>
            </form>
        @endif    
        </div>

    </div>
    @switch($post->user->getRoleNames()[0])
        @case('user')
            @php $post_creator = 'color:white; text-decoration:underline;'; @endphp
        @break

        @case('mod')
            @php $post_creator = 'color:#b7b7b7; text-decoration:underline;'; @endphp
        @break

        @case('admin')
            @php $post_creator = 'color:#efb710; text-decoration:underline;'; @endphp
        @break
    @endswitch
    <div class="card-body card-body-forum">
        <div style="background-color:rgba(0,0,0,0.3); border-radius:5px; width:200px; display:flex; flex-direction:row; justify-content:space-around; align-items:center;">
            <div class="p-2">
                @if(!is_null($post->user->avatar))
                <img src="{{url('/user-image').'/'.$post->user->avatar}}"  class="rounded-circle" width="60" height="60" style="object-fit:cover;"/>
                @else
                <img src="{{url('assets')}}/images/user.webp" class="rounded-circle" width="60" />
                @endif
            </div>
            <div class="p-2 ">
                <span style="color:#fff; font-size:14px; font-weight:bold;">
                    <a style="{{$post_creator}}" href="{{route('usuario.get', ['username' => $post->user->username])}}" style="text-decoration:underline; " target="_blank">{{$post->user->username}}</a>
                </span>
                <br>
                <span style="color:#fff; font-size:14px;">
                @switch($post->user->getRoleNames()[0])
                    @case('user')
                    <span style="background-color:rgba(0,0,0,0.3); padding:2px;">Usuario</span>
                    @break

                    @case('mod')
                    <span style="background-color:rgba(183,183,183,0.3); padding:2px;">Moderador</span>
                    @break

                    @case('admin')
                    <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Administrador</span>
                    @break

                    @case('super-admin')
                    <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Super Adm.</span>
                    @break
                @endswitch
                </span>
                <br>
                <span style="color:#fff; font-size:14px;">
                    Posts: {{$post->user->posts->count()}}
                </span>
            </div>
        </div>
        <p>{!! $post->descr !!}</p>
        <small>(??ltima edici??n @if(!is_null($post->edited_by) && $post->edited_by != $post->user_id) por <b>{{$post->editedby->user->username}}</b>@endif: 
            {{\Carbon\Carbon::parse($post->updated_at)->format('d/m/Y H:i')}})</small>
    </div>
            @if(count($comments)>0)
                @if(is_null($post->respuesta_propia))
                @foreach($comments as $comment)
                @switch($comment->user->getRoleNames()[0])
                    @case('user')
                        @php $comment_creator = 'color:white; text-decoration:underline;'; @endphp
                    @break

                    @case('mod')
                        @php $comment_creator = 'color:#b7b7b7; text-decoration:underline;'; @endphp
                    @break

                    @case('admin')
                        @php $comment_creator = 'color:#efb710; text-decoration:underline;'; @endphp
                    @break
                @endswitch
                <div class="position:relative; card-body card-body-forum mt-3">
                    @if(\Auth::user() && \Auth::user()->id == $comment->user->id ||
                        \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $comment->user->getRoleNames()[0] != "admin" ||
                        \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" )
                    <a class="dropdown-toggle" href="#" style="color:#fff; ::after:content:''; position:absolute; right:1%;" id="commentDD-{{$comment->id}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones<i class="fas fa-sort-down ml-2" style="font-size:22px; margin-top:-5px;"></i></a>
                    <div class="dropdown-menu" aria-labelledby="commentDD-{{$comment->id}}">
                        <a class="dropdown-item text-center " href="#" data-toggle="modal" data-target="#updateComment-{{$comment->id}}">Editar comentario</a>

                        <form method="POST" action="{{route('comment.delete')}}">
                            @csrf
                            <input type="text" value="{{\Crypt::encryptString($comment->id)}}" name="comment_id" hidden/>
                            <input class="dropdown-item text-center " type="submit" value="Borrar comentario"/>
                        </form>
                    </div>
                    @endif    
                    @include('partials.modals.update_comment')
                    
                <div style="background-color:rgba(0,0,0,0.3); border-radius:5px; width:200px; display:flex; flex-direction:row; justify-content:space-around; align-items:center;">
                        
                    <div class="p-2">
                            @if(!is_null($comment->user->avatar))
                            <img src="{{url('/user-image').'/'.$comment->user->avatar}}"  class="rounded-circle" width="60" height="60" style="object-fit:cover;"/>
                            @else
                            <img src="{{url('assets')}}/images/user.webp" class="rounded-circle" width="60" />
                            @endif
                        </div>
                        <div class="p-2 ">
                            <span style="color:#fff; font-size:14px; font-weight:bold;">
                                <a href="{{route('usuario.get', ['username' => $comment->user->username])}}" style="{{$comment_creator}}" target="_blank">{{$comment->user->username}}</a>
                            </span>
                            <br>
                            <span style="color:#fff; font-size:14px; text-align:center;">
                            @switch($comment->user->getRoleNames()[0])
                                @case('user')
                                <span style="background-color:rgba(0,0,0,0.3); padding:2px;">Usuario</span>
                                @break

                                @case('mod')
                                <span style="background-color:rgba(183,183,183,0.3); padding:2px;">Moderador</span>
                                @break

                                @case('admin')
                                <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Administrador</span>
                                @break

                                @case('super-admin')
                                <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Super Adm.</span>
                                @break
                            @endswitch
                            </span>
                            <br>
                            <span style="color:#fff; font-size:14px;">
                                Mensajes: {{$comment->user->comments->count()}}
                            </span>
                        </div>
                    </div>
                    <p>{!! $comment->comment !!}</p>
                    <small>(??ltima edici??n: {{\Carbon\Carbon::parse($comment->updated_at)->format('d/m/Y H:i')}})</small>
                </div>
                @endforeach
                @else
                @foreach($comments as $comment)
                @switch($comment->user->getRoleNames()[0])
                    @case('user')
                        @php $comment_creator = 'color:white; text-decoration:underline;'; @endphp
                    @break

                    @case('mod')
                        @php $comment_creator = 'color:#b7b7b7; text-decoration:underline;'; @endphp
                    @break

                    @case('admin')
                        @php $comment_creator = 'color:#efb710; text-decoration:underline;'; @endphp
                    @break
                @endswitch
                    @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
                    \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
  
                    <div style="position:relative;" class="card-body card-body-forum mt-3">
                        @if(\Auth::user() && \Auth::user()->id == $comment->user->id ||
                            \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $comment->user->getRoleNames()[0] != "admin" ||
                            \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" )
                        <a class="dropdown-toggle" href="#" style="color:#fff; ::after:content:''; position:absolute; right:1%;" id="commentDD-{{$comment->id}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones<i class="fas fa-sort-down ml-2" style="font-size:22px; margin-top:-5px;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="commentDD-{{$comment->id}}">
                            <a class="dropdown-item text-center " href="#" data-toggle="modal" data-target="#updateComment-{{$comment->id}}">Editar comentario</a>

                            <form method="POST" action="{{route('comment.delete')}}">
                                @csrf
                                <input type="text" value="{{\Crypt::encryptString($comment->id)}}" name="comment_id" hidden/>
                                <input class="dropdown-item text-center " type="submit" value="Borrar comentario"/>
                            </form>
                        </div>
                        @endif    
                        @include('partials.modals.update_comment')
                        <div style="background-color:rgba(0,0,0,0.3); border-radius:5px; width:200px; display:flex; flex-direction:row; justify-content:space-around; align-items:center;">
                        <div class="p-2">
                                @if(!is_null($comment->user->avatar))
                                <img src="{{url('/user-image').'/'.$comment->user->avatar}}"  class="rounded-circle" width="60" height="60" style="object-fit:cover;"/>
                                @else
                                <img src="{{url('assets')}}/images/user.webp" class="rounded-circle" width="60" />
                                @endif
                            </div>
                            <div class="p-2 ">
                                <span style="color:#fff; font-size:14px; font-weight:bold;">
                                    <a href="{{route('usuario.get', ['username' => $comment->user->username])}}" style="{{$comment_creator}}" target="_blank">{{$comment->user->username}}</a>
                                </span>
                                <br>
                                <span style="color:#fff; font-size:14px; text-align:center;">
                                @switch($comment->user->getRoleNames()[0])
                                    @case('user')
                                    <span style="background-color:rgba(0,0,0,0.3); padding:2px;">Usuario</span>
                                    @break

                                    @case('mod')
                                    <span style="background-color:rgba(183,183,183,0.3); padding:2px;">Moderador</span>
                                    @break

                                    @case('admin')
                                    <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Administrador</span>
                                    @break

                                    @case('super-admin')
                                    <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Super Adm.</span>
                                    @break
                                @endswitch
                                </span>
                                <br>
                                <span style="color:#fff; font-size:14px;">
                                    Mensajes: {{$comment->user->comments->count()}}
                                </span>
                            </div>
                        </div>
                        <p>{!! $comment->comment !!}</p>
                        <small>(??ltima edici??n: {{\Carbon\Carbon::parse($comment->updated_at)->format('d/m/Y H:i')}})</small>
                    </div>
                    @elseif(\Auth::user() && $comment->user->id == \Auth::user()->id ||
                     \Auth::user() &&  \Auth::user()->getRoleNames()[0] == "mod" ||
                      \Auth::user() &&  \Auth::user()->getRoleNames()[0] == "admin" ||
                      $comment->user->getRoleNames()[0] == "mod" ||
                      $comment->user->getRoleNames()[0] == "admin")
                      
                    <div style="position:relative;" class="card-body card-body-forum mt-3">
                        @if(\Auth::user() && \Auth::user()->id == $comment->user->id ||
                            \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $comment->user->getRoleNames()[0] != "admin" ||
                            \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" )
                        <a class="dropdown-toggle" href="#" style="color:#fff; ::after:content:''; position:absolute; right:1%;" id="commentDD-{{$comment->id}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones<i class="fas fa-sort-down ml-2" style="font-size:22px; margin-top:-5px;"></i></a>
                        <div class="dropdown-menu" aria-labelledby="commentDD-{{$comment->id}}">
                            <a class="dropdown-item text-center " href="#" data-toggle="modal" data-target="#updateComment-{{$comment->id}}">Editar comentario</a>

                            <form method="POST" action="{{route('comment.delete')}}">
                                @csrf
                                <input type="text" value="{{\Crypt::encryptString($comment->id)}}" name="comment_id" hidden/>
                                <input class="dropdown-item text-center " type="submit" value="Borrar comentario"/>
                            </form>
                        </div>
                        @endif    
                        @include('partials.modals.update_comment')
                        <div style="background-color:rgba(0,0,0,0.3); border-radius:5px; width:200px; display:flex; flex-direction:row; justify-content:space-around; align-items:center;">
                        
                        <div class="p-2">
                                @if(!is_null($comment->user->avatar))
                                <img src="{{url('/user-image').'/'.$comment->user->avatar}}"  class="rounded-circle" width="60" height="60" style="object-fit:cover;"/>
                                @else
                                <img src="{{url('assets')}}/images/user.webp" class="rounded-circle" width="60" />
                                @endif
                            </div>
                            <div class="p-2 ">
                                <span style="color:#fff; font-size:14px; font-weight:bold;">
                                        <a href="{{route('usuario.get', ['username' => $comment->user->username])}}" style="color:#fff; text-decoration:underline; " target="_blank">{{$comment->user->username}}</a>
                                </span>
                                <br>
                                <span style="color:#fff; font-size:14px; text-align:center;">
                                @switch($comment->user->getRoleNames()[0])
                                    @case('user')
                                    <span style="background-color:rgba(0,0,0,0.3); padding:2px;">Usuario</span>
                                    @break

                                    @case('mod')
                                    <span style="background-color:rgba(183,183,183,0.3); padding:2px;">Moderador</span>
                                    @break

                                    @case('admin')
                                    <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Administrador</span>
                                    @break

                                    @case('super-admin')
                                    <span style="background-color:rgba(239,184,16,0.3); padding:2px;">Super Adm.</span>
                                    @break
                                @endswitch
                                </span>
                                <br>
                                <span style="color:#fff; font-size:14px;">
                                    Mensajes: {{$comment->user->comments->count()}}
                                </span>
                            </div>
                            @if(\Auth::user() && \Auth::user()->id == $comment->user->id ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" && $comment->user->getRoleNames()[0] != "admin" ||
            \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin" )
        <a class="dropdown-toggle" href="#" style="color:#fff; ::after:content:none;" id="commentDD-{{$comment->id}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones<i class="fas fa-sort-down ml-2" style="font-size:22px; margin-top:-5px;"></i></a>
        <div class="dropdown-menu" aria-labelledby="commentDD-{{$comment->id}}">
            <a class="dropdown-item text-center " href="#" data-toggle="modal" data-target="#updateComment-{{$comment->id}}">Editar comentario</a>

            <form method="POST" action="{{route('comment.delete')}}">
                @csrf
                <input type="text" value="{{\Crypt::encryptString($comment->id)}}" name="comment_id" hidden/>
                <input class="dropdown-item text-center " type="submit" value="Borrar comentario"/>
            </form>
        </div>
        @endif    
        @include('partials.modals.update_comment')
                        </div>
                        <p>{!! $comment->comment !!}</p>
                        <small>(??ltima edici??n: {{\Carbon\Carbon::parse($comment->updated_at)->format('d/m/Y H:i')}})</small>
                    </div>
                    @endif
                @endforeach
                @endif
            @endif
</div>

@if(\Auth::user())

    @if(is_null($post->cerrado))
        @if(is_null($post->bloqueado) || !is_null($post->bloqueado) && \Auth::user()->getRoleNames()[0] == "admin" || !is_null($post->bloqueado) && \Auth::user()->getRoleNames()[0] == "mod")

<script>
function initMCEexact(e, tipo, id){
var area = document.querySelector('.area').value;
if(id !== undefined && id !== null ){
    var area2 = document.querySelector('#area2-'+id).value;
    console.log(area2);
}else{
    var area2 = '';
}
    tinymce.init({
        mode : "exact",
        elements : e,
    setup: function(editor){
        editor.save();
            // Let the editor save every change to the textarea
            editor.on('change', function(){
                tinymce.triggerSave();
            });
            

           if(tipo == 'post'){
                editor.on('init', function (e) {
                    editor.setContent(area);
                });

                $(".btn-editar").click(function() {
                    $(".update_post_form").submit();
                });
            }

            if(tipo == 'comment'){
                editor.on('init', function (e) {
                    editor.setContent(area2);
                });

                $(".btn-editar-comment").click(function() {
                    $(".update_comment_form").submit();
                });
            }
        },
    branding: false,
    elementpath: false,
    language: 'es',
    height: 500,
    resize: false,
    autosave_ask_before_unload: false,
    powerpaste_allow_local_images: true,
    plugins: [
        'autolink codesample fullscreen image',
        ' lists link media noneditable powerpaste preview',
        ' searchreplace table template tinymcespellchecker visualblocks wordcount'
    ],
    toolbar:
        'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image tinydrive',
    image_title: true, 
    automatic_uploads: true,
    spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
    tinydrive_demo_files_url: '/docs/demo/tiny-drive-demo/demo_files.json',
    tinydrive_token_provider: function (success, failure) {
        success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
    },
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    file_picker_types: 'image',
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function() {
        var file = this.files[0];
        var reader = new FileReader();
        
        reader.onload = function () {
            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            // call the callback and populate the Title field with the file name
            cb(blobInfo.blobUri(), { title: file.name });
        };
        reader.readAsDataURL(file);
        };
        
        input.click();
    }
    }); 
}    
initMCEexact("comment", null), null;
initMCEexact("desc", 'post', null);

if(document.querySelectorAll('.id-comment') !== undefined && document.querySelectorAll('.id-comment') !== null){
    const id_comment = [...document.querySelectorAll('.id-comment')]
    id_comment.map((str) => {
        initMCEexact('comment_set-'+str.value, 'comment', +str.value);
        console.log('comment_set-'+str.value)
    });
}



$( document ).ready(function() {
  $(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
  });
});
</script>

        <hr class="mt-5 mb-5    " style="border-top:2px solid #fff; margin:0px auto;">

        <form style=" margin:0px auto;" method="POST" action="{{route('comment.save')}}">
        @csrf
        <input type="text" name="post_id" value="{{\Crypt::encryptString($post->id)}}" hidden/>
        <div class="form-group">
            <textarea name="comment" id="comment" class="form-control tiny" required></textarea>
        </div>
        <input type="submit" class="w-100 btn " style="color:#fff; background:#7e030b ;" value="Enviar mensaje"/>
        </form>
        @endif
    @else
    <p class="w-100 d-block text-center mb-3" style=" color:#fff;">El post est?? cerrado, no se pueden enviar mensajes.</p>
    @endif

@else
<p class="w-100 d-block text-center" style=" color:#fff;">Para enviar un mensaje has de loguearte.</p>
@endif


@endsection