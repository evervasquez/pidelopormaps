/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function soloNumeros(evt) {
    evt = (evt) ? evt : event; //Validar la existencia del objeto event
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0)); //Extraer el codigo del caracter de uno de los diferentes grupos de codigos
    var respuesta = true; //Predefinir como valido
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        respuesta = false;
    }
    return respuesta;
}
function serieComprobante(evt) {
    evt = (evt) ? evt : event; //Validar la existencia del objeto event
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0)); //Extraer el codigo del caracter de uno de los diferentes grupos de codigos
    var respuesta = true; //Predefinir como valido
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
        respuesta = false;
    }
    return respuesta;
}
function numeroTelefonico(evt) {
    evt = (evt) ? evt : event; //Validar la existencia del objeto event
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
    var respuesta = true; //Predefinir como valido
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode != 42 && charCode != 35 && charCode != 32 && charCode != 40 && charCode != 41 && charCode != 45)) {
        respuesta = false;
    }
    return respuesta;
}
function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = [8, 9, 37, 39, 46];
    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
function dosDecimales(evt, control) {
    //Limita un control a números con dos decimales.
    var texto = control.value;
    var punto = texto.indexOf('.');

    if (evt.keyCode <= 13 || (evt.keyCode >= 48 && evt.keyCode <= 57)) {
        if ((punto != -1) && (texto.length - (punto + 1)) >= 2) {
            return false;
        }
    }
    else if (evt.keyCode == 46 && texto.length >= 1) {
        if (punto != -1 && texto.indexOf('.', punto) != -1) {
            return false;
        }
    } else {
        return false;
    }
    return true;
}
function eliminar(url) {
    if (confirm("Esta seguro que desea eliminar este registro")) {
        href = url;
        window.location = href;
    }
}

function confirmar(url, mensaje) {
    if (confirm(mensaje)) {
        href = url;
        window.location = href;
    }
}

function editar(url) {
    window.location = url;
}


function redondeo(numero, decimales)
{
    var flotante = parseFloat(numero);
    var resultado = Math.round(flotante * Math.pow(10, decimales)) / Math.pow(10, decimales);
    return resultado;
}
//**********************************
$(function() {
    $.fn.required = function() {
        if ($(this).val() == '' || $(this).val() == 0) {
            $(this).css('border', 'solid 2px red');
            $('#msg').html('<label class="lbl_msg" style="color: red">Debes llenar todos los campos necesarios</label>');
            $(this).focus();
            return false;
        } else {
            $(this).css('border', 'solid 1px #ccc');
            $('#msg').html('');
            return true;
        }
    };
})

function refresh(){
    location.reload(true);
}

function trimText(string, largo)
 {
   largo = largo-3;
   var newst = string.split(" ");
   var contador = 0;
   var finalstr = '';
 
   for(var lar=0; lar<newst.length; ++lar) {
    if(contador >= largo)
      break;
    else
     {
      contador += newst[lar].length;
      finalstr += newst[lar]+' ';
      if(finalstr.length-1 > largo)
       {
        finalstr = finalstr.substr(0, finalstr.indexOf(newst[lar], 0));
        break;
       }
     }
   }
  return (finalstr != string) ?
         finalstr.substr(0, finalstr.length-1)+'…' :
         finalstr;
 }


UTF8 = {
	encode: function(s){
		for(var c, i = -1, l = (s = s.split("")).length, o = String.fromCharCode; ++i < l;
			s[i] = (c = s[i].charCodeAt(0)) >= 127 ? o(0xc0 | (c >>> 6)) + o(0x80 | (c & 0x3f)) : s[i]
		);
		return s.join("");
	},
	decode: function(s){
		for(var a, b, i = -1, l = (s = s.split("")).length, o = String.fromCharCode, c = "charCodeAt"; ++i < l;
			((a = s[i][c](0)) & 0x80) &&
			(s[i] = (a & 0xfc) == 0xc0 && ((b = s[i + 1][c](0)) & 0xc0) == 0x80 ?
			o(((a & 0x03) << 6) + (b & 0x3f)) : o(128), s[++i] = "")
		);
		return s.join("");
	}
};