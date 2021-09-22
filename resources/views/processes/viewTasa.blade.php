@extends('layouts.default')

@section('title')
{{__('Registro de Tasa de Cambio')}}
@endsection


@section('content')
{{ Form::open(['route'=>'registro_tasa','id' => 'frm3', 'class' => 'form' , 'autocomplete' => 'Off', 'enctype' => 'multipart/form-data']) }}
    <div class="row row lx-2">
        <div class="col-6">
            <label for="">{{__('Monto')}}</label>
            <input class="form-control alingLeft vtdinero" name="monto" id="monto" type="text" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'">
        </div>
        <div class="col-6">
            <label for="">{{__('Fecha')}}</label>
            <div class="input-group"><span class="input-group-text" id="basic-style"><i class="far fa-calendar-alt"></i></span>
                {{ Form::text('fecha', date('dd/mm/YYYY'), ['class' => 'form-control', 'id'=> 'fecha','placeholder' => 'Seleccione una fecha'])}}
            </div>
        </div>
    </div>


    {{ Form::hidden('hidden_id_tasa', null, ['id'=> 'hidden_id_tasa'])}}

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
    var empty = "{!! $records_tasa !!}";
    empty = empty.replace(/\|/g,'"');
    empty = JSON.parse(empty);

    validaciones();
    fechaHeader();
    cargar_tabla(empty);
    $('#hidden_id_tasa').val(null);
    $('#monto').inputmask();

    $('#fecha').datepicker().datepicker("option", "dateFormat", 'dd/mm/yy' ).datepicker("setDate", new Date());

    $("#frm3").validate({
        rules: {
            monto: {
                required: true
            },
                        
        },
        messages: {
            monto :{
                required : 'Campo requerido'
            },
                        
        },
    });

    $('#guardar').on('click', function(){
        Swal.fire({
                title: 'Tasa de Cambio',
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
                title: 'Tasa de Cambio',
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
            {
                title: 'Monto',
                data: null,
                searchable: true,
                visible: true,
                className: 'text-center',
                render: function (data) {
                    var monto = convertir_monto(data.Monto);
                    return monto;
                }
            },          
            {title: 'Fecha', data:'Fecha', searchable: true, visible: true, className: 'text-center',defaultContent:null},          
            {title: 'Estatus', data:'Status', searchable: true, visible: true, className: 'text-center',defaultContent:null},          
            {
                title: 'Acciones',
                data: null,
                searchable: false,
                className: "text-center",
                render: function (data, type, row, index) {
                    var btn = "";
                    if(data.Status != 'INACTIVO'){
                        btn += ' <a  href="javascript:editar('+data.id+');" class="btn btn-outline-primary btn-sm btn-icon" >\n' +
                            '                <i class="fa fa-pencil-alt"></i>\n' +
                            '            </a>';
                    }
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
    $.post("buscar_edicion_tasa",  {"id":id},function(data){
        var fecha = data[0].Fecha;
        fecha = fecha.substr(8,2)+'/'+fecha.substr(5,2)+'/'+fecha.substr(0,4);
        $('#hidden_id_tasa').val(data[0].id);
        $('#monto').val(data[0].Monto);
        $('#fecha').val(fecha);
    },'json');
}

function eliminar(id){
    Swal.fire({
            title: 'Eliminar Tasa de Cambio',
            text: '¿Esta Seguro que Desea Realizar esta Operación?',
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Si"
        }).then(function (result) {
        if (result.value) {
            $.post("eliminar_registro_tasa",  {"id":id},function(data){
                toastr.success('Registro eliminado', '');
                cargar_tabla(data);
            },'json');
        }
    });
}

function clean_fields(){
    $('#monto').val('');
    $('#hidden_id_tasa').val(null);
}
</script>

@endsection
