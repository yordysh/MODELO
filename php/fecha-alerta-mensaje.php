<?php

require_once "DataBaseA.php";
require_once "registrar.php";
require_once "../funciones/f_funcion.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();

$mostrar = new m_almacen();


$datos = $mostrar->AlertaMensaje();
try {
    if (!$datos) {
        throw new Exception("Hubo un error en la consulta");
    }

    $json = array();
    foreach ($datos as $row) {
        $json[] = array(
            "COD_ALERTA" => $row->COD_ALERTA,
            "NDIAS" => $row->NDIAS,
            "NOMBRE_AREA" => $row->NOMBRE_AREA,
            "COD_INFRAESTRUCTURA" => $row->COD_INFRAESTRUCTURA,
            "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,
            "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
            "FECHA_TOTAL" =>  convFecSistema($row->FECHA_TOTAL),
            "FECHA_ACORDAR" =>  convFecSistema($row->FECHA_ACORDAR),

        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
