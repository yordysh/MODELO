<?php

require_once "DataBaseA.php";
require_once "registrar.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();
$mostrar = new m_almacen();

if (isset($_POST["COD_ZONA"])) {
    $task_id = $_POST["COD_ZONA"];
    $NOMBRE_T_ZONA_AREAS = $_POST["NOMBRE_T_ZONA_AREAS"];

    // $query = $dats->prepare("UPDATE T_ZONA_AREAS SET NOMBRE_T_ZONA_AREAS = :NOMBRE_T_ZONA_AREAS WHERE COD_ZONA = :COD_ZONA");
    // $query->bindParam(':COD_ZONA', $task_id, PDO::PARAM_INT);
    // $query->bindParam(':NOMBRE_T_ZONA_AREAS', $NOMBRE_T_ZONA_AREAS, PDO::PARAM_STR);

    // $query->execute();
    $mostrar->editarAlmacen($NOMBRE_T_ZONA_AREAS, $task_id);

    echo "La tarea ha sido actualizada";
}
