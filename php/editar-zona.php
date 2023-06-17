<?php

require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();


if (isset($_POST["COD_ZONA"])) {
    $COD_ZONA = $_POST["COD_ZONA"];

    $selectZ = $mostrar->SelectZona($COD_ZONA);

    $json = array();
    foreach ($selectZ as $row) {
        $json[] = array(
            "COD_ZONA" => $row['COD_ZONA'],
            "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
        );
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
