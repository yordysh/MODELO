<?php

require_once "m_almacen.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();

if (isset($_POST['COD_ZONA'])) {
    $COD_ZONA = $_POST['COD_ZONA'];
    $mostrar->eliminarAlmacen($COD_ZONA);
}
