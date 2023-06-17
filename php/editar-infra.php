<?php

require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();


if (isset($_POST["COD_INFRAESTRUCTURA"])) {

    $COD_INFRAESTRUCTURA = $_POST["COD_INFRAESTRUCTURA"];

    $select = $mostrar->SelectInfra($COD_INFRAESTRUCTURA);


    $json = array();

    foreach ($select as $row) {
        $json[] = array(
            "COD_INFRAESTRUCTURA" => $row['COD_INFRAESTRUCTURA'],
            "NOMBRE_INFRAESTRUCTURA" => $row['NOMBRE_INFRAESTRUCTURA'],
            "NDIAS" => $row['NDIAS']
        );
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
