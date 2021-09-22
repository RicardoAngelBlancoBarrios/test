
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function validaciones() {
    $('.vtcedula').keypress(function (e) {
        if (e.ctrlKey || e.altKey) {
            return true;
        }
        return validar(String.fromCharCode(e.which), /^[0-9\x00\b]+$/);
    });
    $('.vtcedula').blur(function () {
        $(this).val(parseInt($(this).val()));
        if ($(this).val() == 0) {
            $(this).val("");
        }
        return $(this).val(cambio($(this).val(), /^[0-9\x00\b]+$/));
    });
    $('.vtcode').keypress(function (e) {
        if (e.ctrlKey || e.altKey) {
            return true;
        }
        return validar(String.fromCharCode(e.which), /^[0-9\+\-\x00\b]+$/);
    });
    $('.vtcode').blur(function () {
        return $(this).val(cambio($(this).val(), /^[0-9\+\-\x00\b]+$/));
    });
    $('.vtforma').keypress(function (e) {
        if (e.ctrlKey || e.altKey) {
            return true;
        }
        return validar(String.fromCharCode(e.which), /^[0-9\x00\b]+$/);
    });
    $('.vtforma').blur(function () {
        return $(this).val(cambio($(this).val(), /^[0-9\x00\b]+$/));
    });
    $('.vtdinero').keypress(function (e) {
        if (e.ctrlKey || e.altKey) {
            return true;
        }
        return validar(String.fromCharCode(e.which), /^[0-9\.\x00\b]+$/);
    });
    $('.vtdinero').blur(function () {
        return $(this).val(cambio($(this).val(), /^[0-9\.\x00\b]+$/));
    });
    $(".solotexto").keypress(function (e) {
        var keyCode = e.which;
        if (!((keyCode >= 48 && keyCode <= 57)
                || (keyCode >= 65 && keyCode <= 90)
                || (keyCode >= 97 && keyCode <= 122))
                && keyCode != 8 && keyCode != 32 && keyCode != 46 && keyCode != 44 && keyCode != 45 && keyCode != 40 && keyCode != 41 && keyCode != 95 &&
                keyCode != 209 && keyCode != 241 && keyCode != 225 && keyCode != 233 && keyCode != 237 && keyCode != 243 && keyCode != 250 && keyCode != 193
                && keyCode != 201 && keyCode != 205 && keyCode != 211 && keyCode != 218) {
            e.preventDefault();
        }
    });
    $(".solotexto").keyup(function (e) {
        var solotexto = $(this).val();
        $(this).val(solotexto.toUpperCase());
    });
    $(".texto").keypress(function (e) {
        var keyCode = e.which;
        if (!((keyCode >= 48 && keyCode <= 57)
                || (keyCode >= 65 && keyCode <= 90)
                || (keyCode >= 97 && keyCode <= 122))
                && keyCode != 8 && keyCode != 32 && keyCode != 44 && keyCode != 46) {
            e.preventDefault();
        }
    });
    $(".texto").keyup(function (e) {
        var solotexto = $(this).val();
        $(this).val(solotexto.toUpperCase());
    });

}

function validar(cadena, correcta){
    if (correcta.test(cadena)){
        return true;
    }else {
        return false;
    }
}
function cambio(cadena, correcta){
    var cadena_correcta = "";
    for (var i = 0; i< cadena.length; i++) {
        var caracter = cadena.charAt(i);
        if (validar(caracter, correcta)){
            cadena_correcta = cadena_correcta + caracter;
        }
    };
    return cadena_correcta;
}

function idleLogout() {

    var tiempo = JSON.parse(timer);
    var t;
    var time_remaing = 0;
    var time_out = tiempo.timer; // valor en segundos
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer;  // catches touchscreen presses as well      
    window.ontouchstart = resetTimer; // catches touchscreen swipes as well 
    window.onclick = resetTimer;      // catches touchpad clicks as well
    window.onkeypress = resetTimer;
    window.addEventListener('scroll', resetTimer, true); // improved; see comments

    function yourFunction() {
		$.get('/general.reset_sessions', function (){ window.location.replace('logout');});
        
    }

    var myVar = setInterval(myTimer, 1000);
    function myTimer() {
        time_remaing++;
        if (time_remaing == time_out) {
            clearInterval(myVar);
            yourFunction();
        }
        if (time_remaing == (time_out - 10)) {
            mensaje_emergente('<span class="success">El sistema se cerrará en 10 seg.</span>', 'success');
        }
    }

    function resetTimer() {
        time_remaing = 0;
    }
}
function convertir_monto(monto) {
    var monto_str = monto.toString();
    monto_str = monto_str.search('\\.');
    monto = parseFloat(monto);
    var conv_monto = monto.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    conv_monto = conv_monto.toString();
    conv_monto = conv_monto.replace('.', '|');
    conv_monto = conv_monto.replace(/[,]/g, '.');
    conv_monto = conv_monto.replace(/[|]/g, ',');
    return conv_monto;
}

function mensaje_emergente(texto, tipo){
  Swal.fire({
        html: texto,
        icon: tipo,
        confirmButtonText: "Ok",
        allowOutsideClick: false
    }); 
}


function generate_tooltips(destiny, title){
 
    $('#'+destiny).attr("title", title).tooltip("_fixTitle").tooltip("show").attr("title", title).tooltip("_fixTitle");
}

setInterval(function() {

  var currentTime = new Date();
  var hours = currentTime.getHours();
  var minutes = currentTime.getMinutes();
  var seconds = currentTime.getSeconds();
  var indicador = '';
  // Add leading zeros
  if(hours > 12){
    hours = hours - 12;
    indicador = ' P.M.';
  }else{
    indicador = ' A.M.';
  }
  hours = (hours < 10 ? "0" : "") + hours;
  minutes = (minutes < 10 ? "0" : "") + minutes;
  seconds = (seconds < 10 ? "0" : "") + seconds;

  // Compose the string for display
  var currentTimeString = hours + ":" + minutes + ":" + seconds + indicador;
  $(".clock").html(currentTimeString);

}, 1000);

function fechaHeader(){
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var f=new Date();
    $('.date').html(f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
}


function crearelemento(elemento,identificador,destino,clase,texto){
    var elem = document.createElement(elemento);
    if(identificador!=''){
        elem.setAttribute('id',identificador);
    }
    if(clase!=''){
        elem.setAttribute('class',clase);
    }
    if(texto!=''){
        var labtext = document.createTextNode(texto);
        elem.appendChild(labtext);
    }
    document.getElementById(destino).appendChild(elem);
}