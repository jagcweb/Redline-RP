<script src="https://cdn.tiny.cloud/1/lwe1t2tv4oggrwpolep8lzhzppmk8rqknh8tvf2e3suyecx5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.remove();
var demoBaseConfig = {
  selector: '#desc',
  setup: function(editor){
        // Let the editor save every change to the textarea
        editor.on('change', function(){
            tinymce.triggerSave();
        });
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
  },
  spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
  tinydrive_demo_files_url: '/docs/demo/tiny-drive-demo/demo_files.json',
  tinydrive_token_provider: function (success, failure) {
    success({ token: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJqb2huZG9lIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.Ks_BdfH4CWilyzLNk8S2gDARFhuxIauLa8PwhdEQhEo' });
  },
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
};
tinymce.init(demoBaseConfig);

$( document ).ready(function() {
  $(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
  });
});

</script>
<div class="modal fade"  id="crearPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Crear Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('post.save')}}">
          @csrf
          <input type="text" name="subtema_id" value="{{\Crypt::encryptString($subt->id)}}" hidden/>
          <div class="form-group">
              <label for="titulo" style="color:#fff;">Título</label>
              <input type="text" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="titulo" name="titulo" required>
          </div>


          
          <div class="form-group">
              <label for="desc" style="color:#fff;">Descripción</label>
              <textarea name="desc" id="desc" class="form-control" required></textarea>
          </div>

          @if(\Auth::user()->getRoleNames()[0] == "mod" || \Auth::user()->getRoleNames()[0] == "admin")
          <div class="form-group">
              <label for="block" style="color:#fff;">Bloqueado (solo mods y admins podrán escribir)</label>
              <input type="checkbox" name="block" value="1" id="block" class="form-control"/>
          </div>

          <div class="form-group">
              <label for="own_reply" style="color:#fff;">Respuesta propia (solo los mods y admins podrán ver todas las respuestas. Los usuarios únicamente podrán ver la suya)</label>
              <input type="checkbox" name="own_reply"  value="1" id="own_reply" class="form-control"/>
          </div>

          <div class="form-group">
              <label for="own_reply" style="color:#fff;">Ocultar post (solo los mods y admins podrán ver el post)</label>
              <input type="checkbox" name="hidden"  value="1" id="hidden" class="form-control" />
          </div>
          @endif

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Crear"/>
        </form>
      </div>
    </div>
  </div>
</div>