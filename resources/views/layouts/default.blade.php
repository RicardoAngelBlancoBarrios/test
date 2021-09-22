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
        <link href="{{ asset('css/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link href="{{ asset('css/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datepicker/bootstrap-datepicker.css') }}">

		
		
		<script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>
		<script src="{{ asset('js/formValidate/jquery.validate.min.js') }}"></script>
		
        <!-- JavaScript Bundle with Popper -->
        <script src="{{ asset('js/boostrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/boostrap/bootstrap-multiselect.js') }}"></script>
		
        <script src="{{ asset('js/sweetalert2/sweetalert2.min.js') }}"></script>
		<script src="{{ asset('js/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>  
        <script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>  
        <script src="{{ asset('js/datatables/jszip.min.js') }}"></script>  
        <script src="{{ asset('js/datatables/pdfmake.min.js') }}"></script>  
        <script src="{{ asset('js/datatables/vfs_fonts.js') }}"></script>  
        <script src="{{ asset('js/datatables/buttons.html5.min.js') }}"></script>  
        <script src="{{ asset('js/datatables/datatables.export.js') }}"></script>  
        <script src="{{ asset('js/datatables/datatables.rowsGroup.js') }}"></script>  
        <script src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>    

        <script defer src="{{ asset('js/fontAwesome/all.min.js') }}"></script>
        <script defer src="{{ asset('js/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
        <script defer src="{{ asset('js/boostrap/bootstrap-autocomplete.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <title>{{__('TEST')}}</title>
        <link rel="icon" type="image/gif" sizes="32x32" href="{!! asset('img/icon.png') !!}">

    </head>

    <body>


        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar">
            <div class="sidebar-header">
                <h3 class="brand">
                    <span><img src="{{ asset('img/logo.png') }}" width="180px"></span>
                </h3>
                <label for="sidebar-toggle"><span class="fa fa-list"></span></label>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="/">
                            <span class="fa fa-home"></span>
                            <span>{{ __('Home') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/usuarios">
                            <span class="fa fa-user"></span>
                            <span>{{ __('Usuarios') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/personas">
                            <span class="fa fa-people-carry"></span>
                            <span>{{ __('Personas') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/visualizacion" target="_blank">
                            <span class="fa fa-binoculars"></span>
                            <span>{{ __('Visualización') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/logout">
                            <span class="fa fa-power-off"></span>
                            <span>{{ __('Cerrar Sesión') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
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

        <div class="main-content">

            <header>
                <h3>
                    <div class="row row lx-2">
                        <div class="col-6">
                            @yield('title')
                        </div>
                        <div class="col-4">
                            <div class="date" style="text-align: right;"></div>
                        </div>
                        <div class="col-2">
                            <div class="clock" style="text-align: right;"></div>
                        </div>
                    </div>
                </h3>
            </header>

            <main>

                @yield('content')

            </main>

        </div>

    </body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        fechaHeader();
    });
</script>
