<?php

require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();


if (isset($_POST["COD_INFRAESTRUCTURA"])) {
    $task_id = $_POST["COD_INFRAESTRUCTURA"];
    $NOMBRE_INFRAESTRUCTURA = $_POST["NOMBRE_INFRAESTRUCTURA"];
    $NDIAS = $_POST["NDIAS"];

    $mostrar->editarInfraestructura($NOMBRE_INFRAESTRUCTURA, $NDIAS, $task_id);

    if ($resultado) {
        echo "La tarea ha sido actualizada";
    } else {
        echo "Error al actualizar la tarea";
    }
}
