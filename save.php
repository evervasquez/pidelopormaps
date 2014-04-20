<?php

session_start();
$longitud = $_POST['longitud'];
$latitud = $_POST['latitud'];
$observacion = $_POST['observacion'];
$cantidad = $_POST['cantidad'];
$contacto = $_POST['contacto'];
$telefono = $_POST['telefono'];
$email = $_SESSION['email'];
$id = $_POST['id'];

$link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
if ($id == 0) {
    $query = 'INSERT INTO ubicaciones(latitud,longitud,email,cantidad,contacto,telefono,observacion,estado) '
            . 'VALUES ("' . $latitud . '","' . $longitud . '","' . $email . '","' . $cantidad . '","' . $contacto . '","' . $telefono . '","' . $observacion . '",1)';
} else {
    $query = 'UPDATE ubicaciones SET cantidad='.$cantidad.',contacto="' . $contacto . '",telefono="' . $telefono . '",observacion="' . $observacion . '"
    WHERE id_ubicaciones='.$id;
            
}

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
mysql_free_result($result);
// Cerrar la conexión
mysql_close($link);
