<?php
session_start();
if (!isset($_SESSION['token'])) {
    echo "<script>window.location='" . 'http://' . $_SERVER['HTTP_HOST'] . '/ubicaciones/index.php' . "'</script>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pidelo por Maps</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="lib/css/bootstrap.min.css" type="text/css" media="screen" />
        <script src="https://desk-customers.s3.amazonaws.com/shared/sessvars.js" type="text/javascript"></script>
        <link rel="stylesheet" href="lib/css/principal.css" type="text/css" />
        <script type="text/javascript" src="lib/js/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxwbFVqKVoA8WR6wmqsoBsuUEc45OvP5g&sensor=false" ></script>
        <script type="text/javascript" src="lib/js/principal.js" ></script>

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', initialize);
            $(function() {
                cargarMarcadores();
            });
        </script>

    </head>
    <body>
        <a class='logout pull-right' href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] ?>/ubicaciones/index.php?logout">Logout</a>
        <input type="hidden" id="session_email" value="<?php echo $_SESSION['email'] ?>"/>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <h1>Localización de Pedidos</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div id="map-canvas">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>USUARIOS</h4></div>
                        <div class="panel-body">
                            <div class="container-fluid usuarios">
                                

                                    <?php
                                    $link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
                                    mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');
                                    $query = "select nombres,imagen,email from usuarios where estado=1";

                                    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
                                    // Imprimir los resultados en HTML
                                    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                        echo '<div class="row users">';
                                        echo "<div class='col-md-3'>"
                                            . "<img class='img-circle' src='" . $line['imagen'] . "?sz=50'>"
                                                . "</div>" . 
                                                "<div class='col-md-9' ><label class='user'>" . $line['nombres'] . "<label>"
                                        . "</div>"
                                        . "</div>";
                                    }
                                    // Liberar resultados
                                    mysql_free_result($result);
                                    // Cerrar la conexión
                                    mysql_close($link);
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="lib/js/validaciones.js"></script>
    <script src="lib/js/bootbox.min.js"></script>
</html>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ingresar Parrilladas</h4>
                <input type="hidden" name="id" id="id" value="0"/>
            </div>
            <div class="modal-body">

                <div class="form-group col-xs-4">
                    <label for="cantidad">Cantidad</label>
                    <input class="form-control" type="number" name="cantidad" id="cantidad" onkeypress="return soloNumeros(event)"/>
                </div>

                <div class="form-group col-xs-5">
                    <label for="contacto">Contacto</label>
                    <input type="text" class="form-control" name="contacto" id="contacto" required="required" />
                </div>

                <div class="form-group col-xs-3">
                    <label for="telefono">Telefono</label>
                    <input type="tel" class="form-control" name="telefono" id="telefono" />
                </div>

                <div class="form-group">
                    <label for="message">Observaciones</label>
                    <textarea class="form-control" name="observaciones" id="observaciones" ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="save" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>