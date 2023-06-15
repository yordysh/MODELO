<?php

require_once "DataBaseA.php";
require_once("../funciones/f_funcion.php");
$c = new DataBase();
$conn = $c->Conectar();

$fechaCreacion = $_POST['fechaCreacion'];
$codInfraestructura = $_POST['codInfraestructura'];

$fechaCreacion = new DateTime();
$fechaCreacion = $fechaCreacion->format('Y-m-d');

// Verifica si la fecha de creación es sábado
if (date("l", strtotime($fechaCreacion)) === "Saturday") {
    $taskNdias = 2;
}

$FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);
$FECHA_TOTAL = retunrFechaSqlphp(date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days')));



$stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL)");


$stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
$stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
$stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);


$insert = $stm->execute();
return $insert;

if ($insert) {
    echo "Inserción exitosa";
} else {
    echo "Error en la inserción: " . $stm->errorInfo()[2];
}
