<?php

require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();

if (isset($_POST['COD_ZONA'])) {
    $COD_ZONA = $_POST['COD_ZONA'];
    $mostrar->eliminarAlmacen($COD_ZONA);
}
