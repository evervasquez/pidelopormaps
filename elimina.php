<?php
session_start();
$id = $_POST['id'];

if (isset($id)) {
    $link = mysql_connect('localhost', 'u557356656_maps', 'parrilladas')or die('No se pudo conectar: ' . mysql_error());
    mysql_select_db('u557356656_maps') or die('No se pudo seleccionar la base de datos');

    $query = 'UPDATE ubicaciones SET estado=0 WHERE id_ubicaciones=' . $id;

    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    mysql_free_result($result);
// Cerrar la conexión
    mysql_close($link);
}else{
    echo "<script>window.location='" . 'http://' . $_SERVER['HTTP_HOST'] . '/index.php' . "'</script>";
}
