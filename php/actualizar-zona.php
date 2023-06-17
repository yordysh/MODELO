<?php

require_once "m_almacen.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();

if (isset($_POST["COD_ZONA"])) {
    $task_id = $_POST["COD_ZONA"];
    $NOMBRE_T_ZONA_AREAS = $_POST["NOMBRE_T_ZONA_AREAS"];

    $mostrar->editarAlmacen($NOMBRE_T_ZONA_AREAS, $task_id);

    echo "La tarea ha sido actualizada";
}
