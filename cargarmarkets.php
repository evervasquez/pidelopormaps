<?php

$link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
$query = 'SELECT latitud,longitud,observacion,cantidad,contacto,telefono,ubicaciones.estado,ubicaciones.email,nombres,imagen 
FROM ubicaciones INNER JOIN usuarios on ubicaciones.email=usuarios.email
WHERE usuarios.estado=1';

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
$resultado[] = null;
$contador = 0;
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {  
    $resultado[$contador]['latitud']= $line['latitud'];
    $resultado[$contador]['longitud']= $line['longitud'];
    $resultado[$contador]['observacion']= $line['observacion'];
    $resultado[$contador]['estado']= $line['estado'];
    $resultado[$contador]['email']= $line['email'];
    $resultado[$contador]['nombres']= $line['nombres'];
    $resultado[$contador]['imagen']= $line['imagen'];
    $resultado[$contador]['cantidad']= $line['cantidad'];
    $resultado[$contador]['contacto']= $line['contacto'];
    $resultado[$contador]['telefono']= $line['telefono'];
    $contador += 1;
}
echo json_encode($resultado);
mysql_free_result($result);
// Cerrar la conexión
mysql_close($link);


