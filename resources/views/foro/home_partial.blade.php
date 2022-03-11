@if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
   \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
   <a  class="w-100 text-center mb-2 d-block btn " href="#" data-toggle="modal" data-target="#crearTema" style="color:#fff; background:#7e030b;">Crear tema</a>  
   @include('partials.modals.create_tema')
   
   @if(count($temas)>0)
   <a  class="w-100 text-center mb-2 d-block btn " href="#" data-toggle="modal" data-target="#crearSubtema" style="color:#fff; background:#7e030b ;">Crear subtema</a>  
   @include('partials.modals.create_subtema') 
   @endif
@endif
<div style="margin:0px auto;display:flex; justify-content:flex-start; align-items:center;" class="">
  <a class="breadcrumbs__item  is-active" style="text-decoration:none;"><i class="fas fa-home mr-2"></i>Inicio</a>
</div>
@if(count($temas)>0)
    @foreach($temas as $i=>$tema)
      @if(!is_null($tema->oculto))
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" ||
        \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
      <div class="card card-forum @if($i==0) @else mt-2 @endif">
        <div class="card-header card-header-forum" style="width:100%; display:flex; flex-direction:row; justify-content:space-between;">
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" || \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
        <h4 style="margin:0px;"><i class="fas fa-lock mr-2"></i>{{ucfirst($tema->nombre)}}</h4><a href="#" style="color:#fff;" data-toggle="modal" data-target="#editarTema-{{$tema->id}}"><i class="fas fa-pen ml-2" style="font-size: 1.5rem;"></i></a>
        @include('partials.modals.edit_tema')
        @else
        <h4 style="margin:0px;">{{ucfirst($tema->nombre)}}</h4>
        @endif
        
        </div>
          @foreach($tema->subtemas as $subtema)
        <div class="card-body card-body-forum">
          <h5><a href="{{route('subtema.index', ['tema' => $tema->nombre, 'subtema' => $subtema->nombre])}}" style=" color:#bd1823;">{{ucfirst($subtema->nombre)}}</a></h5>
          <small>{{ucfirst($subtema->descr)}}</small>
        </div>
        @endforeach
      </div>
      @endif
    @else
    <div class="card card-forum @if($i==0) @else mt-2 @endif">
        <div class="card-header card-header-forum" style="width:100%; display:flex; flex-direction:row; justify-content:space-between;">
        @if(\Auth::user() && \Auth::user()->getRoleNames()[0] == "mod" || \Auth::user() && \Auth::user()->getRoleNames()[0] == "admin")
        <h4 style="margin:0px;"><i class="fas fa-lock-open mr-2"></i>{{ucfirst($tema->nombre)}}</h4><a href="#" style="color:#fff;" data-toggle="modal" data-target="#editarTema-{{$tema->id}}"><i class="fas fa-pen ml-2" style="font-size: 1.5rem;"></i></a>
        @include('partials.modals.edit_tema')
        @else
        <h4 style="margin:0px;">{{ucfirst($tema->nombre)}}</h4>
        @endif
        </div>
          @foreach($tema->subtemas as $subtema)
        <div class="card-body card-body-forum">
          <h5><a href="{{route('subtema.index', ['tema' => $tema->nombre, 'subtema' => $subtema->nombre])}}" style=" color:#bd1823;">{{ucfirst($subtema->nombre)}}</a></h5>
          <small>{{ucfirst($subtema->descr)}}</small>
        </div>
        @endforeach
      </div>
    @endif
    @endforeach
  @endif