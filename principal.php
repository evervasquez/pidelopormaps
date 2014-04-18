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
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxwbFVqKVoA8WR6wmqsoBsuUEc45OvP5g&sensor=false" ></script>
        <script src="lib/js/jquery.min.js"></script>
        <script type="text/javascript" src="lib/js/principal.js" ></script>
        <link rel="stylesheet" href="lib/css/principal.css" type="text/css" />
        <link rel="stylesheet" href="lib/css/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="lib/css/bootstrap-theme.min.css" type="text/css" />
        <script src="lib/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
    <body>
        <a class='logout' href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] ?>/ubicaciones/index.php?logout">Logout</a>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <h1>PIDELO CON MAPS</h1>
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
                            <?php
                            $link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
                            mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');
                            $query = "select nombres,imagen,correo from usuarios where estado=1";
                            
                            $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
                            // Imprimir los resultados en HTML
                            while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                echo "<div><img src='".$line['imagen']."?sz=50'></div>".$line['nombres'];   
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
    </body>
</html>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ingrese sus Observaciones</h4>
            </div>
            <div class="modal-body">
                <textarea id="observaciones" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="save" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>