/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var mapa;
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
        var latitud = evento.latLng.lat();
        var longitud = evento.latLng.lng();

        //Puedo unirlas en una unica variable si asi lo prefiero
        var coordenadas = evento.latLng.lat() + ", " + evento.latLng.lng();

        //Creo un marcador utilizando las coordenadas obtenidas y almacenadas por separado en "latitud" y "longitud"
        var coordenadas = new google.maps.LatLng(latitud, longitud);

        //creamos el popup
        $("#myModal").modal("show");

        $('#myModal').on('hidden.bs.modal', function(e) {
            marcador.setMap(null);
            limpiarFormulario();
        });

        $("#save").click(function() {
            $.post('save.php',
                    'latitud=' + latitud +
                    '&longitud=' + longitud +
                    '&cantidad=' + $("#cantidad").val() +
                    '&contacto=' + $("#contacto").val() +
                    '&telefono=' + $("#telefono").val() +
                    '&observacion=' + $("#observaciones").val(),
                    function() {
                        $("#myModal").modal("hide");
                        marcador.setMap(null);
                        cargarMarcadores();
                        limpiarFormulario();
                    });
        });

        /* Debo crear un punto geografico utilizando google.maps.LatLng */
        var marcador = new google.maps.Marker({
            position: coordenadas,
            map: mapa,
            animation: google.maps.Animation.DROP,
            title: "Un marcador cualquiera"});
    }); //Fin del evento  
}

function limpiarFormulario() {
    $("#cantidad,#contacto,#telefono,#observaciones").val("");
}

function cargarMarcadores() {
    $.post('cargarmarkets.php', 'session=1',
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

                    marcador.content =
                            '<div class="container-fluid">' +
                            '<div class="row">' +
                            '<div class="col-md-9">' +
                            '<h4>Detalle de pedido</h4>' +
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
                            '<label>Observacion :</label> ' + datosmarker.observacion + '' +
                            '</div>' +
                            '</div>';

                    //llenamos el contenido
                    infowindow = new google.maps.InfoWindow();

                    google.maps.event.addListener(marcador, 'click', function() {
                        infowindow.setContent(this.content);
                        infowindow.open(mapa, this);
                    });
                }
            });
}