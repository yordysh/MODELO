<?php

require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();


if (isset($_POST["COD_INFRAESTRUCTURA"])) {

    $COD_INFRAESTRUCTURA = $_POST["COD_INFRAESTRUCTURA"];

    $stm = $dats->prepare("SELECT * FROM T_INFRAESTRUCTURA WHERE COD_INFRAESTRUCTURA = :COD_INFRAESTRUCTURA");
    $stm->bindParam(':COD_INFRAESTRUCTURA', $COD_INFRAESTRUCTURA, PDO::PARAM_STR);
    $stm->execute();
    // if (!$update) {
    //     die("Hubo un error en la consulta");
    // }

    $json = array();

    foreach ($stm as $row) {
        $json[] = array(
            "COD_INFRAESTRUCTURA" => $row['COD_INFRAESTRUCTURA'],
            "NOMBRE_INFRAESTRUCTURA" => $row['NOMBRE_INFRAESTRUCTURA'],
            "NDIAS" => $row['NDIAS']
        );
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
