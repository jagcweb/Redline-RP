<div style="margin:0px auto;" class="mt-3">
    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
            @php
                Session::forget('error');
            @endphp
        </div>
    @endif

    @if(Session::has('exito'))
        <div class="alert alert-success">
            {!! Session::get('exito') !!}
            @php
                Session::forget('exito');
            @endphp
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>