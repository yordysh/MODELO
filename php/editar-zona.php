<?php

require_once "m_almacen.php";

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
