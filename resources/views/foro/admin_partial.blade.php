
<div class="card card-forum">
    <div class="card-header card-header-forum">
        <h4 style="margin:0px;">
        <i class="fas fa-shield mr-2"></i>Panel de administración</h4>
    </div>
    <div class="card-body card-body-forum">
        <form autocomplete="off">
            <div class="form-group">
                <label for="search" style="color:#fff;">Buscar por</label>
                <select class="form-control search">
                    <option selected disabled hidden>Escoge una opción...</option>
                    <option value="username">Usuario</option>
                    <option value="email">Email</option>
                </select>
            </div>

            <div class="form-group username-div d-none">
                <label for="username" style="color:#fff;">Usuario</label>
                <input type="text" name="username" class="form-control username"/>
            </div>

            <div class="form-group email-div d-none">
                <label for="email" style="color:#fff;">Email</label>
                <input type="email" name="email" class="form-control email"/>
            </div>

            <div id="wrap">

            </div>

            <input type="submit" style="color:#fff; background:#bd1823;" class="w-100 btn submit-but" disabled value="Buscar"/>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $( document ).ready(function() {
        $( ".search" ).change(function() {
            type = $(this).val();
            value = null;

            if(type === 'username'){
                $(".username-div").removeClass('d-none');
                $(".email-div").addClass('d-none');
                $( ".username" ).on( "change, keyup", function() {
                    value = $(this).val();
                });
            }

            if(type === 'email'){
                $(".username-div").addClass('d-none');
                $(".email-div").removeClass('d-none');
                $( ".email" ).on( "change, keyup", function() {
                    value = $(this).val();
                });
            }

            $(document).on( "change, keyup", function() {
                if(type && value != null ){
                    $('.submit-but').prop("disabled", false); 
                }
            });
        });

        $( ".submit-but" ).click(function(e) {
            const wrap = $("#wrap");
            wrap.empty();
            e.preventDefault();
            $.ajax({
                url: '{{url('admin/get-user-ajax')}}' + '/' + type + '/' + value,
                method: 'GET'
            }).done(function (res){
                if(res === '404'){
                    wrap.append('<hr style="border:2px solid #eee;"><p class="text-center w-100 d-block">No se ha encontrado ningún usuario con ese username o email.</p>');
                }else{
                    let user = JSON.parse(res);
                    switch(user.banned){
                        case(1):
                            ban = `<a  class="ml-3 unban" style="color:#fff; cursor:pointer;" title="Desbanear"><i class="fas fa-user"></i></a>`;
                        break;

                        case(null):
                            ban = `<a  class="ml-3 ban" style="color:#fff; cursor:pointer;" title="Banear"><i class="fas fa-user-slash"></i></a>`;
                        break;
                    }
                    switch(user.roles[0].name){
                        case('user'):
                            acciones = `<td style="font-size:22px";><a  class="ml-3 make-mod" style="color:#b7b7b7; cursor:pointer;" title="Hacer mod"><i class="fas fa-user-plus"></i></a><a  class="ml-3 make-admin" style="color:#efb710; cursor:pointer;" title="Hacer admin"><i class="fas fa-user-plus"></i></a>${ban}</td>`
                        break;

                        case('mod'):
                            acciones = `<td style="font-size:22px";><a  class="ml-3 make-user" style="color:#fff; cursor:pointer;" title="Hacer usuario"><i class="fas fa-user-minus"></i></a><a  class="ml-3 make-admin" style="color:#efb710; cursor:pointer;" title="Hacer admin"><i class="fas fa-user-plus"></i></a>${ban}</td>`
                        break;

                        case('admin'):
                            acciones = `<td style="font-size:22px";><a  class="ml-3 make-user" style="color:#fff; cursor:pointer;" title="Hacer usuario"><i class="fas fa-user-minus"></i></a><a  class="ml-3 make-mod" style="color:#b7b7b7; cursor:pointer;" title="Hacer mod"><i class="fas fa-user-minus"></i></a>${ban}</td>`
                        break;
                    }
                    
                    wrap.append(`<hr style="border:2px solid #eee;"><div class="table-responsive"> <table class="table table-hover table-bordered"> <thead style="background:#bd1823; border:1px solid #bd1823; color:#fff;"> <tr> <th scope="col">Username</th> <th scope="col">Email</th> <th scope="col">Rol</th> <th scope="col">Acciones</th> </tr> </thead> <tbody style="color:#fff!important;" class="wrap-table"> <tr> <td style="color:#fff!important;">${user.username}</td> <td style="color:#fff!important;">${user.email}</td> <td style="color:#fff!important;">${user.roles[0].name}</td> ${acciones} </tr> </tbody> </table></div>`);
                
                    $( ".unban" ).click(function(e) {
                        $.ajax({
                            url: '{{url('admin/unban-user')}}' + '/' + user.id,
                            method: 'GET'
                        }).done(function (res){
                            wrap.append('<p class="text-center w-100 d-block" style="color:#fff;">Usuario desbaneado!</p>');
                            setTimeout(function(){
                                location.reload();
                            }, 1200);
                        });
                    });

                    $( ".ban" ).click(function(e) {
                        $.ajax({
                            url: '{{url('admin/ban-user')}}' + '/' + user.id,
                            method: 'GET'
                        }).done(function (res){
                            wrap.append('<p class="text-center w-100 d-block" style="color:#fff;">Usuario baneado!</p>');
                            setTimeout(function(){
                                location.reload();
                            }, 1200);
                        });
                    });

                    $( ".make-user" ).click(function(e) {
                        $.ajax({
                            url: '{{url('admin/make-user')}}' + '/' + user.id,
                            method: 'GET'
                        }).done(function (res){
                            wrap.append('<p class="text-center w-100 d-block" style="color:#fff;">Al usuario se le ha asignado el rol de user</p>');
                            setTimeout(function(){
                                location.reload();
                            }, 1200);
                        });
                    });

                    $( ".make-mod" ).click(function(e) {
                        $.ajax({
                            url: '{{url('admin/make-mod')}}' + '/' + user.id,
                            method: 'GET'
                        }).done(function (res){
                            wrap.append('<p class="text-center w-100 d-block" style="color:#fff;">Al usuario se le ha asignado el rol de mod</p>');
                            setTimeout(function(){
                                location.reload();
                            }, 1200);
                        });
                    });

                    $( ".make-admin" ).click(function(e) {
                        $.ajax({
                            url: '{{url('admin/make-admin')}}' + '/' + user.id,
                            method: 'GET'
                        }).done(function (res){
                            wrap.append('<p class="text-center w-100 d-block" style="color:#fff;">Al usuario se le ha asignado el rol de admin</p>');
                            setTimeout(function(){
                                location.reload();
                            }, 1200);
                        });
                    });
                }
            });
        });

    });
</script>
