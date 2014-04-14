/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function initialize() {
    //Creo un nuevo mapa situado en Buenos Aires, Argentina, con 13 de Zoom y del tipo ROADMAP
    var mapa = new google.maps.Map(document.getElementById("map-canvas"),
            {center: new google.maps.LatLng(-6.489087879805055, -76.3608169555664),
                zoom: 14, mapTypeId: google.maps.MapTypeId.ROADMAP});

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
        $("#myModal").modal("show", function() {
            $("#observaciones").focus();
        });

        $("#save").click(function() {
            $.post('save.php', 'latitud=' + latitud + '&longitud=' + longitud + '&observacion=' + $("#observaciones").val() + '&idusuario=' + 1,
                    function() {
                        $("#myModal").modal("hide");
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

