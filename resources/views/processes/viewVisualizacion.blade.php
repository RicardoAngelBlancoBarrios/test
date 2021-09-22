<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>

        <!-- CSS only -->
        <link href="{{ asset('css/boostrap_css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/boostrap_css/bootstrap-multiselect.css') }}" rel="stylesheet">
        <link href="{{ asset('css/boostrap_css/bootstrap-autocomplete.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        
        <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="{{ asset('js/boostrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/boostrap/bootstrap-multiselect.js') }}"></script>
        
        <script src="{{ asset('js/main.js') }}"></script>
        <title>{{__('TEST')}}</title>
        <link rel="icon" type="image/gif" sizes="32x32" href="{!! asset('img/icon.png') !!}">

    </head>
    <style type="text/css">
        body{
            background-color: #27201a;
        }
        .titulo{
            font-size: 25px;
            text-align: center;
            width: 100%;
            color: #fff;
        }
        .identificador{
            font-size: 80px;
            font-weight: bold;
            text-align: center;
            width: 100%;
            color: #fca015;
        }
        .nombre{
            font-size: 40px;
            font-weight: bold;
            text-align: center;
            width: 100%;
            color: #fca015;
        }
        .cola{
            color: #fff;
            font-size: 20px;
            text-align: center;
        }
        .colaItem{
            margin-right: 20px;
            margin-left: 20px;
        }
        .colaLista{
            margin-top: 50px;
        }
    </style>
    <body>
        <div class="main-content-visualizacion">
        <div class="row row lx-2">
            <div class="col-6">
                <label for="" class="titulo">{{__('Cola 1')}}</label>
                <label for="" class="identificador" id="identificador1"></label>
                <label for="" class="nombre" id="nombre1"></label>
                <div id="cola1" class="colaLista"></div>
            </div>
            <div class="col-6">
                <label for="" class="titulo">{{__('Cola 2')}}</label>
                <label for="" class="identificador" id="identificador2"></label>
                <label for="" class="nombre" id="nombre2"></label>
                <div id="cola2" class="colaLista"></div>
            </div>
        </div>
    </div>
    </body>
</html>


<script type="text/javascript">

var tiempoespera = IdAsignacion = tiempoespera2 = IdAsignacion2 = 0;

$(document).ready(function () {
    cargar();
    setInterval(function() {
        cargar();
    }, 10000);
});

function cargar(){
    var cola1 = [];
    var cola2 = [];
    $.post("buscar_cola",function(data){
        $('#cola1').empty();
        $('#cola2').empty();
        for (var i = 0; i < data.length; i++) {
            if(data[i].IdCola == 1){
                cola1.push(data[i]);
            }else{
                cola2.push(data[i]);
            }
        }
        for (var i = 0; i < cola1.length; i++) {
            if(i == 0){
                $('#identificador1').html(cola1[i].Identificador);
                $('#nombre1').html(cola1[i].Nombre);
                if(cola1[i].IdAsignacion != IdAsignacion){
                    actualizarStatus(cola1[i].Duracion, cola1[i].IdAsignacion);
                    IdAsignacion = cola1[i].IdAsignacion;
                }
            }else{
                crearelemento('div','cola1_'+cola1[i].IdAsignacion,'cola1','row row','');
                crearelemento('div','cola1row_'+cola1[i].IdAsignacion,'cola1_'+cola1[i].IdAsignacion,'col-12 cola','');
                crearelemento('span','','cola1row_'+cola1[i].IdAsignacion,'colaItem',cola1[i].Identificador);
                crearelemento('span','','cola1row_'+cola1[i].IdAsignacion,'colaItem',cola1[i].Nombre);
            }
        }
        for (var i = 0; i < cola2.length; i++) {
            if(i == 0){
                $('#identificador2').html(cola2[i].Identificador);
                $('#nombre2').html(cola2[i].Nombre);
                if(cola2[i].IdAsignacion != IdAsignacion2){
                    actualizarStatus(cola2[i].Duracion, cola2[i].IdAsignacion);
                    IdAsignacion2 = cola2[i].IdAsignacion;
                }
            }else{
                crearelemento('div','cola2_'+cola2[i].IdAsignacion,'cola2','row row','');
                crearelemento('div','cola2row_'+cola2[i].IdAsignacion,'cola2_'+cola2[i].IdAsignacion,'col-12 cola','');
                crearelemento('span','','cola2row_'+cola2[i].IdAsignacion,'colaItem',cola2[i].Identificador);
                crearelemento('span','','cola2row_'+cola2[i].IdAsignacion,'colaItem',cola2[i].Nombre);
            }
        }
    },'json');
}

function actualizarStatus(valortiempoespera, valorIdAsignacion){
    $.post("actualiza_status_cola", {"id":valorIdAsignacion, "status": 15},function(data){
        if(data.type == 'success'){
            setTimeout(function() {
                $.post("actualiza_status_cola", {"id":valorIdAsignacion, "status": 16},function(data){
                    if(data.type == 'success'){
                        cargar();
                    }
                });
            }, valortiempoespera * 1000);
        }
    });
}
</script>


