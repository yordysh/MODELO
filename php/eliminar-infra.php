<?php

require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();

if (isset($_POST['COD_INFRAESTRUCTURA'])) {
    $COD_INFRAESTRUCTURA = $_POST['COD_INFRAESTRUCTURA'];
    $mostrar->eliminarInfraestructura($COD_INFRAESTRUCTURA);
}
