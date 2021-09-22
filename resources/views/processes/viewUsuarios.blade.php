@extends('layouts.default')

@section('title')
    {{__('Usuarios')}}
@endsection


@section('content')
{{ Form::open(['route'=>'registro_usuarios','id' => 'frm4', 'class' => 'form' , 'autocomplete' => 'Off', 'enctype' => 'multipart/form-data']) }}
    <div class="row row lx-2">
        <div class="col-6">
            <label for="">{{__('Nombre y Apellido')}}</label>
            <input class="form-control solotexto" name="nombre_completo" id="nombre_completo" type="text">
        </div>
        <div class="col-6">
            <label for="">{{__('Nombre de Usuario')}}</label>
            <input class="form-control" name="nombre_usuario" id="nombre_usuario" type="text" readonly="true">
        </div>
    </div>

    <div class="row row lx-2">
        <div class="col-6">
            <label for="">{{__('Correo Electrónico')}}</label>
            <input class="form-control" name="correo" id="correo" type="text">
        </div>
        <div class="col-6">
            <label for="">{{__('Contraseña')}}</label>
            <input class="form-control" name="contraseña" id="contraseña" type="text">
        </div>
    </div>
    <div class="row row lx-2">
        <div class="col-6">&nbsp;</div>
        <div class="col-6">
            <div class="row separacion">
                <div class="col-3 indicador pass_weak">&nbsp;</div>
                <div class="col-3 indicador pass_good">&nbsp;</div>
                <div class="col-3 indicador pass_strong">&nbsp;</div>
                <div class="col-3 indicador pass_vstrong">&nbsp;</div>
            </div>
        </div>
    </div>

    {{ Form::hidden('hidden_id_user', null, ['id'=> 'hidden_id_user'])}}

    <div class="input-group mb-3 mt-3">
        <div class="col-6">
            {{ Form::button('Guardar', ['class' => 'btn btn-primary style', 'id' => 'guardar']) }}
            {{ Form::button('Cancelar', ['class' => 'btn btn-danger style', 'id' => 'cancelar']) }}
        </div>
    </div>

        <div class="content-table">
            <div class="content-table-style">
                <table class="table table-striped table-hover" id="table1">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('id') }}</th>
                            <th scope="col">{{ __('Nombre Usuario') }}</th>
                            <th scope="col">{{ __('Nombre Completo') }}</th>
                            <th scope="col">{{ __('Correo Electrónico') }}</th>
                            <th scope="col">{{ __('Acciones') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

{{ Form::close() }}
<script type="text/javascript">
    var empty = "{!! $records_usuarios !!}";
    empty = empty.replace(/\|/g,'"');
    empty = JSON.parse(empty);
$(document).ready(function () {
    validaciones();
    fechaHeader();
    cargar_tabla(empty);
    $("#correo").inputmask('email');
    $('#contraseña').attr('type','password');

    $('#correo').on('blur',function(){
        $.post("buscar_correo", {"correo":$('#correo').val()},function(data){
            if(data != ''){
                Swal.fire("", "{{ __('El correo ya existe.') }}" , 'error'); 
                $('#correo').val('');
            }
        },'json');
    });

    $('#nombre_completo').on('blur',function(){
        var nombre_arreglo = [];
        var inicio = 0;
        var nombre_usuario = '';
        if($('#nombre_completo').val() != ''){
            var nombre = $('#nombre_completo').val();
            nombre = nombre.trim();
            largo_nombre = nombre.length;
            for (var i = 0; i < largo_nombre; i++) {
                if(nombre.substr(i,1) == ' '){
                    if(nombre.substr(i-1,1) != ' '){
                        nombre_arreglo.push(nombre.substr(inicio,i-inicio));
                        inicio = i;
                    }
                }
            }
            nombre_arreglo.push(nombre.substr(inicio,i-inicio));
            for (var i = 0; i < nombre_arreglo.length; i++) {
                nombre_usuario += nombre_arreglo[i].trim()+'.';
            }
            var nombre_user= nombre_usuario.substr(0,nombre_usuario.length-1).toLowerCase();
            validar_usuario(nombre_user);
            //$('#nombre_usuario').val();
        }
    });

    $("#frm4").validate({
        rules: {
            nombre_completo: {
                required: true
            },
            nombre_usuario:{
                required: true
            },
            correo:{
                required: true
            },
            contraseña:{
                required: true
            },
            contraseña:{
                minlength: 8
            },

        },
        messages: {
            nombre_completo :{
                required : 'Campo requerido'
            },
            nombre_usuario :{
                required : 'Campo requerido'
            },
            correo :{
                required : 'Campo requerido'
            },
            contraseña :{
                required : 'Campo requerido'
            },
            contraseña :{
                minlength : 'Debe tener un minimo de 8 caracteres'
            },
        },
    });

    $('#guardar').on('click', function(){
        Swal.fire({
                title: 'Usuario',
                text: '¿Esta Seguro que Desea Realizar esta Operación?',
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Si"
            }).then(function (result) {
            if (result.value) {
                $("form#frm4").submit();
                clean_fields();
            }
        });
    });

    $('#cancelar').on('click', function(){
        Swal.fire({
                title: 'Usuario',
                text: '¿Esta Seguro que Desea Realizar esta Operación?',
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Si"
            }).then(function (result) {
            if (result.value) {
                clean_fields();
            }
        });
    });

    $('#contraseña').on('keyup', function(){
        validate_strength();
    });
});

function cargar_tabla(valor) {
    $("#table1").DataTable({
        processing: true,
        ordering: false,
        select: false,
        destroy:true,
        responsive: true,
        data: valor,
        "columnDefs": [
            {
              "defaultContent": "",
              "targets": '_all'
            }, 
            {
                "className": "dt-center",
                "targets"  : [0]
            },
        ],
        columns: [
            {data: 'id' , searchable: true, visible: false, className: 'text-center',defaultContent:null},           
            {data:'name', searchable: true, visible: true, className: 'text-center',defaultContent:null},                 
            {data:'full_name', searchable: true, visible: true, className: 'text-center',defaultContent:null},           
            {data:'email', searchable: true, visible: true, className: 'text-center',defaultContent:null},  
            {
                data: null,
                searchable: false,
                className: "text-center",
                render: function (data, type, row, index) {
                    var btn = "";
                        btn += ' <a  href="javascript:editar('+data.id+');" class="btn btn-primary btn-sm btn-icon" >\n' +
                            '                <i class="fa fa-pencil-alt"></i>\n' +
                            '            </a>';
                        return btn;
                }
            },         
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        },
        "autoWidth": true,
        "bLengthChange": false,
        "bFilter": false,
    })
}

function clean_fields(){
    $('#nombre_completo').val('');
    $('#nombre_usuario').val('');
    $('#correo').val('');
    $('#contraseña').val('');
}

function validate_strength(){
    var password_strength = $('#contraseña').val();
    var regex = new Array();
    regex.push("[A-Z]");
    regex.push("[a-z]");
    regex.push("[0-9]");
    regex.push("[$@$!%*#?&]");
    var passed = 0;

    for (var i = 0; i < regex.length; i++) {
        if((new RegExp (regex[i])).test(password_strength)){
            passed++;
        }
    }

    if(passed > 2 && password_strength.length > 8){
        passed++;
    }

    switch(passed){
        case 0:
            $('.pass_weak').css('backgroundColor','unset');
            $('.pass_good').css('backgroundColor','unset');
            $('.pass_strong').css('backgroundColor','unset');
            $('.pass_vstrong').css('backgroundColor','unset');
            break;
        case 1:
            $('.pass_weak').css('background','linear-gradient(90deg, rgba(249,0,0,1) 0%, rgba(249,96,0,1) 100%)');
            break;
        case 2:
            $('.pass_good').css('background','linear-gradient(90deg, rgba(249,96,0,1) 0%, rgba(249,242,0,1) 100%)');
            break;
        case 3:
            break;
        case 4:
            $('.pass_strong').css('background','linear-gradient(90deg, rgba(249,242,0,1) 0%, rgba(109,249,0,1) 100%)');
            break;
        case 5:
            $('.pass_vstrong').css('background','linear-gradient(90deg, rgba(109,249,0,1) 0%, rgba(0,120,6,1) 100%)');
            break;
    }
}

function validar_usuario(valor){
    $.post("buscar_usuario", {"nombre_usuario":valor},function(data){
        if(data == ''){
            $('#nombre_usuario').val(valor);
        }else{
            Swal.fire("", "{{ __('El nombre de usuario ya existe.') }}" , 'error'); 
            $('#nombre_completo').val('');
            $('#nombre_usuario').val('');

        }
    },'json');
}

function editar(id){
    $.post("buscar_edicion_user",  {"id":id},function(data){
        $('#hidden_id_user').val(data[0].id);
        $('#nombre_completo').val(data[0].full_name);
        $('#nombre_completo').attr("disabled",true);
        $('#nombre_usuario').val(data[0].name);
        $('#nombre_usuario').attr("disabled",true);
        $('#correo').val(data[0].email);
        $('#correo').attr("disabled",true);
    },'json');
}
</script>
@endsection
