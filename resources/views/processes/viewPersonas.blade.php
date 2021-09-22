@extends('layouts.default')

@section('title')
{{__('Registro de Personas')}}
@endsection


@section('content')
{{ Form::open(['route'=>'registro_personas','id' => 'frm3', 'class' => 'form' , 'autocomplete' => 'Off', 'enctype' => 'multipart/form-data']) }}
    <div class="row row lx-2">
        <div class="col-4">
            <label for="">{{__('Identificador')}}</label>
            <input class="form-control alingLeft vtcedula" name="identificador" id="identificador" type="text" maxlength="8">
        </div>
        <div class="col-8">
            <label for="">{{__('Nombres y Apellidos')}}</label>
            <input class="form-control alingLeft solotexto" name="nombre" id="nombre" type="text">
        </div>
    </div>


    {{ Form::hidden('hidden_id_identificador', null, ['id'=> 'hidden_id_identificador'])}}

    <div class="input-group mb-3 mt-3">
        <div class="col-6">
            {{ Form::button('Guardar', ['class' => 'btn btn-primary style', 'id' => 'guardar']) }}
            {{ Form::button('Cancelar', ['class' => 'btn btn-danger style', 'id' => 'cancelar']) }}
        </div>
    </div>

        <div class="content-table">
            <div class="content-table-style">
                <table class="table table-striped table-hover" id="table1">
                </table>
            </div>
        </div>

{{ Form::close() }}

<script type="text/javascript">

$(document).ready(function () {
    var empty = "{!! $records !!}";
    empty = empty.replace(/\|/g,'"');
    empty = JSON.parse(empty);

    validaciones();
    fechaHeader();
    cargar_tabla(empty);
    $('#hidden_id_identificador').val(null);

    $("#frm3").validate({
        rules: {
            identificador: {
                required: true
            },
            nombre: {
                required: true
            },
                       
        },
        messages: {
            identificador :{
                required : 'Campo requerido'
            },
            nombre :{
                required : 'Campo requerido'
            },
                       
        },
    });

    $('#guardar').on('click', function(){
        Swal.fire({
                title: 'Registro de Personas',
                text: '¿Esta Seguro que Desea Realizar esta Operación?',
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Si"
            }).then(function (result) {
            if (result.value) {
                $("form#frm3").submit();
                clean_fields();
            }
        });
    });

    $('#cancelar').on('click', function(){
        Swal.fire({
                title: 'Registro de Personas',
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
            {title: 'id', data: 'id' , searchable: true, visible: false, className: 'text-center',defaultContent:null},           
            {title: 'Identificador', data: 'Identificador' , searchable: true, visible: true, className: 'text-center',defaultContent:null},           
            {title: 'Nombre', data: 'Nombre' , searchable: true, visible: true, className: 'text-center',defaultContent:null},                    
            {
                title: 'Acciones',
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

function editar(id){
    $.post("buscar_edicion_persona",  {"id":id},function(data){
        $('#hidden_id_tasa').val(data[0].id);
        $('#identificador').val(data[0].Identificador);
        $('#nombre').val(data[0].Nombre);
    },'json');
}

function clean_fields(){
    $('#identificador').val('');
    $('#nombre').val('');
    $('#hidden_id_identificador').val(null);
}
</script>

@endsection
