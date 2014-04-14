<?php

$longitud = $_POST['longitud'];
$latitud = $_POST['latitud'];
$observacion = $_POST['observacion'];
$idusuario = $_POST['idusuario'];

$link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
$query = 'INSERT INTO ubicaciones(latitud,longitud,observacion,estado,idusuario) '
        . 'VALUES ("'.$latitud.'","'.$longitud.'","'.$observacion.'",1,"'.$idusuario.'")';

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

// Cerrar la conexión
mysql_close($link);