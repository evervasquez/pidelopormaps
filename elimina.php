<?php

$id = $_POST['id'];

$link = mysql_connect('localhost', 'root', 'admin')or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('ubicaciones') or die('No se pudo seleccionar la base de datos');

$query = 'UPDATE ubicaciones SET estado=0 WHERE id_ubicaciones=' . $id;

$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
mysql_free_result($result);
// Cerrar la conexión
mysql_close($link);
