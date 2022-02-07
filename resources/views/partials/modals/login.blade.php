<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" class="text-center" style="color:#fff;">Ingresar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        {{-- <a href="{{route('login')}}">Ingresar con Discord</a> --}}


        <form method="POST" class="form-login" action="{{route('login.normal')}}">
          @csrf
          <div class="form-group">
              <label for="email" style="color:#fff;">Email</label>
              <input type="email" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="email" name="email" required>
          </div>

          <div class="form-group">
              <label for="password" style="color:#fff;">Contraseña</label>
              <input type="password" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;" minlenght="8" class="form-control" id="password" name="password" required>
          </div>

          <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn" value="Ingresar"/>
        </form>

        <hr style="border-bottom:2px solid #eee">
        
        <a  href="#" style="color:#fff;" class="w-100 d-block text-center mt-2 forgetpw"> ¿Has olvidado tu contraseña? </a>
        <a  href="#" style="color:#fff;" class="w-100 text-center mt-2 d-none forgetpw-dnone">Ocultar olvidar contraseña</a>
        <div class="d-none fogetpw-div mt-4">
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" style="color:#fff;">Email</label>
                <input type="email" style="border:none; border-bottom:2px solid #fff; background:transparent;  color:#fff;"  class="form-control" id="email" name="email" required>
            </div>
            <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn submit-pass" value="Recuperar Contraseña"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $( document ).ready(function() {
    $( ".forgetpw" ).click(function() {
      $(".fogetpw-div").removeClass('d-none');
      $(".forgetpw").removeClass('d-block');
      $(".forgetpw").addClass('d-none');
      $(".forgetpw-dnone").removeClass('d-none');
      $(".forgetpw-dnone").addClass('d-block');
    });

    $( ".forgetpw-dnone" ).click(function() {
      $(".fogetpw-div").addClass('d-none');
      $(".forgetpw").removeClass('d-none');
      $(".forgetpw").addClass('d-block');
      $(".forgetpw-dnone").addClass('d-none');
      $(".forgetpw-dnone").removeClass('d-block');
    });

    $(".submit-pass").on('submit',function(e){
      $(".form-login").preventDefault();
    });
});
</script>