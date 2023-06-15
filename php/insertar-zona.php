<?php
require_once "./DataBaseA.php";
require_once "./registrar.php";


$mostrar = new m_almacen();


if (isset($_POST["NOMBRE_T_ZONA_AREAS"])) {
    $NOMBRE_T_ZONA_AREAS = trim($_POST['NOMBRE_T_ZONA_AREAS']);

    $mostrar->InsertarAlmacen($NOMBRE_T_ZONA_AREAS);

    if (!$mostrar) {
        die("Hubo un error en la consulta" . $error());
    }

    echo "Tarea agregada!";
}
