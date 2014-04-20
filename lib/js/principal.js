/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var mapa;
var contador = 0;
var longitud = null;
var latitud = null;
var marcador;
//controles para los markers
var marcadores = [];
//var ids = [];
function initialize() {
    //Creo un nuevo mapa situado en Buenos Aires, Argentina, con 13 de Zoom y del tipo ROADMAP
    mapa = new google.maps.Map(document.getElementById("map-canvas"),
            {
                center: new google.maps.LatLng(-6.489087879805055, -76.3608169555664),
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

    //Creo un evento asociado a "mapa" cuando se hace "click" sobre el
    google.maps.event.addListener(mapa, "click", function(evento) {
        //Obtengo las coordenadas separadas
        latitud = evento.latLng.lat();
        longitud = evento.latLng.lng();

        //Creo un marcador utilizando las coordenadas obtenidas y almacenadas por separado en "latitud" y "longitud"
        var coordenadas = new google.maps.LatLng(latitud, longitud);

        //creamos el popup
        $('#myModal').modal("show");

        $('#myModal').on('hidden.bs.modal', function(e) {
            marcador.setMap(null);
            limpiarFormulario();
        });

        /* Debo crear un punto geografico utilizando google.maps.LatLng */
        marcador = new google.maps.Marker({
            position: coordenadas,
            map: mapa,
            animation: google.maps.Animation.DROP,
            title: "Un marcador cualquiera"});
    }); //Fin del evento  
}

$(function() {

    $("#save").click(function() {
        $.post('save.php',
                'id=' + $("#id").val() +
                '&latitud=' + latitud +
                '&longitud=' + longitud +
                '&cantidad=' + $("#cantidad").val() +
                '&contacto=' + $("#contacto").val() +
                '&telefono=' + $("#telefono").val() +
                '&observacion=' + $("#observaciones").val(),
                function() {
                    $("#myModal").modal("hide");

                    if (parseFloat($("#id").val()) == 0) {
                        marcador.setMap(null);
                    } else {

                        marcadores[i].setMap(null);
                    }
                    cargarMarcadores();
                    limpiarFormulario();
                });
    });
});

function limpiarFormulario() {
    $("#cantidad,#contacto,#telefono,#observaciones").val("");
}

function cargarMarcadores() {
    $.post('cargarmarkets.php', 'id=0',
            function(response) {
                var datos = $.parseJSON(response);
                var datosmarker;
                for (var data in datos) {
                    datosmarker = datos[data];
                    var infowindow = null;


                    var coordenadas = new google.maps.LatLng(datosmarker.latitud, datosmarker.longitud);

                    var marcador = new google.maps.Marker({
                        position: coordenadas,
                        map: mapa,
                        title: datosmarker.observacion});

                    var botoneliminar = null;
                    
                    if ($("#session_email").val() == datosmarker.email) {
                        botoneliminar = '<div class="btn-group"><button type="button" onclick="eliminara(' + datosmarker.id_ubicaciones + ')" title="eliminar ubicación" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></div>';
                    } else {
                        botoneliminar = '';
                    }
                    
                    marcador.content =
                            '<div class="container-fluid">' +
                            '<div class="row">' +
                            '<div class="col-md-18">' +
                            '<label>Detalle de pedido</label>' +
                            botoneliminar +
                            //'<div class="btn-group"><button type="button" onclick="editars(' + datosmarker.id_ubicaciones + ')" title="editar" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></div>' +
                            //'<div class="btn-group"><button type="button" onclick="eliminara(' + datosmarker.id_ubicaciones + ')" title="eliminar ubicación" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="row">' +
                            '<div class="col-md-4">' +
                            '<img src="' + datosmarker.imagen + '?sz=80">' +
                            '</div>' +
                            '<div class="col-md-8">' +
                            '<label>Cliente de :</label> ' + datosmarker.nombres + '</br>' +
                            '<label>Cantidad :</label> ' + datosmarker.cantidad + '</br>' +
                            '<label>Contacto :</label> ' + datosmarker.contacto + '</br>' +
                            '<label>Tel.Contacto :</label> ' + datosmarker.telefono + '</br>' +
                            '<label>Observacion :</label> ' + datosmarker.observacion +
                            '</div>' +
                            '</div>' +
                            '</div>';

                    //agregamos al array
                    marcadores.push(marcador);

                    //esto es para editar
                    //ids.push(datosmarker.id_ubicaciones);

                    //llenamos el contenido
                    infowindow = new google.maps.InfoWindow();

                    google.maps.event.addListener(marcador, 'click', function() {
                        infowindow.setContent(this.content);
                        infowindow.open(mapa, this);
                    });
                }
            });
}

function editars(id) {
    $.post('cargarmarkets.php', 'id=' + id,
            function(response) {
                var datos = $.parseJSON(response);
                $("#myModal").modal('show');
                var datosmarker;
                for (var data in datos) {
                    datosmarker = datos[data];
                    $("#id").val(id);
                    $("#cantidad").val(datosmarker.cantidad);
                    $("#contacto").val(datosmarker.contacto);
                    $("#telefono").val(datosmarker.telefono);
                    $("#observaciones").val(datosmarker.observacion);
                }
            });

}

function eliminara(id) {
    bootbox.confirm("¿Desea eliminar la ubicación?", function(result) {
        if (result) {
            $.post('elimina.php', 'id=' + id,
                    function() {
                        deleteMarkers();
                        cargarMarcadores();
                    });
        }
    });
}

function setAllMap(map) {
    for (var i = 0; i < marcadores.length; i++) {
        marcadores[i].setMap(map);
    }
}

function clearMarkers() {
    setAllMap(null);
}

function deleteMarkers() {
    clearMarkers();
    marcadores = [];
}