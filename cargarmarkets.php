<?php
session_start();
$id = $_POST['id'];
if (isset($id)) {
    $link = mysql_connect('localhost', 'u557356656_maps', 'parrilladas')or die('No se pudo conectar: ' . mysql_error());
    mysql_select_db('u557356656_maps') or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
    if ($id == 0) {
        $query = 'SELECT id_ubicaciones,latitud,longitud,observacion,cantidad,contacto,telefono,ubicaciones.estado,ubicaciones.idusuario,nombres,imagen 
FROM ubicaciones INNER JOIN usuarios on ubicaciones.idusuario=usuarios.idusuario
WHERE usuarios.estado=1 and ubicaciones.estado=1';
    } else {
        $query = 'SELECT id_ubicaciones,latitud,longitud,observacion,cantidad,contacto,telefono,ubicaciones.estado,ubicaciones.idusuario,nombres,imagen 
FROM ubicaciones INNER JOIN usuarios on ubicaciones.idusuario=usuarios.idusuario
WHERE usuarios.estado=1 and ubicaciones.id_ubicaciones=' . $id;
    }

    $result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
    $resultado[] = null;
    $contador = 0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $resultado[$contador]['id_ubicaciones'] = $line['id_ubicaciones'];
        $resultado[$contador]['latitud'] = $line['latitud'];
        $resultado[$contador]['longitud'] = $line['longitud'];
        $resultado[$contador]['observacion'] = $line['observacion'];
        $resultado[$contador]['estado'] = $line['estado'];
        $resultado[$contador]['idusuario'] = $line['idusuario'];
        $resultado[$contador]['nombres'] = $line['nombres'];
        $resultado[$contador]['imagen'] = $line['imagen'];
        $resultado[$contador]['cantidad'] = $line['cantidad'];
        $resultado[$contador]['contacto'] = $line['contacto'];
        $resultado[$contador]['telefono'] = $line['telefono'];
        $contador += 1;
    }
    echo json_encode($resultado);
    mysql_free_result($result);
// Cerrar la conexión
    mysql_close($link);
} else {
    echo "<script>window.location='" . 'http://' . $_SERVER['HTTP_HOST'] . '/index.php' . "'</script>";
}

