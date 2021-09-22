<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>

        <!-- CSS only -->
        <link href="{{ asset('css/boostrap_css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
		<link rel="stylesheet" href="{{ asset('css/toastr/toastr.min.css') }}">

		
		
		<script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>
		<script src="{{ asset('js/formValidate/jquery.validate.min.js') }}"></script>
		
        <!-- JavaScript Bundle with Popper -->
        <script src="{{ asset('js/boostrap/bootstrap.bundle.min.js') }}"></script>
		
		<script src="{{ asset('js/toastr/toastr.min.js') }}"></script>

        <script type="text/javascript" charset="utf8" src="{{ asset('js/dataTables/datatables.min.js') }}"></script>
        <script defer src="{{ asset('js/fontAwesome/all.min.js') }}"></script>
        <title>{{__('TEST')}}</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('../img/icon.png') !!}">

    </head>

    <body class="principal_login">
        <div > 
         @yield('content')
        </div>
    </body>
</html>
