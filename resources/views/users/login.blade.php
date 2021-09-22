
@extends('layouts.login')
@section('content')
        <div id="login-box">
            <div class="login-img"></div>
            {{ Form::open(['id' => 'formlogin', 'class' => 'form' , 'autocomplete' => 'Off']) }}
                <h3>{{ __('Login') }}</h3>
                <div class="inputBox">
                    <div class="form-floating mb-3">
                        {{ Form::text('username', null, ['class' => 'form-control','placeholder' => 'Name', 'id'=> 'username'])}}
                        {!! Html::decode(Form::label('username','<span class="fa fa-user"></span> Usuario')) !!}
                    </div>
                </div>
                <div class="inputBox">
                    <div class="form-floating">
                        {{ Form::password('password', ['class' => 'form-control','placeholder' => 'Password', 'id'=> 'password'])}}
                        {!! Html::decode(Form::label('password','<span class="fa fa-lock"></span> Contraseña')) !!}
                    </div>
                </div>
                <div class="inputBox d-grid gap-2 col-6 mx-auto" style="padding-bottom: 15px;">
                    {{ Form::submit(__(' Ingresar'), ['class' => 'btn btn-primary', 'id' => 'submit']) }}
                </div>
            {{ Form::close() }}
        </div>
@if(Session::has('msg'))
    <script type="text/javascript">
    toastr['{{ Session::get('msg')['type'] }}']('{{ Session::get('msg')['message'] }}', '{{ Session::get('msg')['tittle'] }}',{
        "progressBar": false,
        "onclick": null,
        "positionClass": "toast-top-right"
    });
    </script>
@endif
@endsection