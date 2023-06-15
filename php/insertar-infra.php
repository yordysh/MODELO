
<?php
require_once "./DataBaseA.php";
require_once "./registrar.php";


$mostrar = new m_almacen();


if (isset($_POST["NOMBRE_INFRAESTRUCTURA"])) {

    $NOMBRE_INFRAESTRUCTURA = trim($_POST['NOMBRE_INFRAESTRUCTURA']);
    $valorSeleccionado = trim($_POST['valorSeleccionado']);
    $NDIAS = trim($_POST['NDIAS']);


    $mostrar->insertarInfraestructura($valorSeleccionado, $NOMBRE_INFRAESTRUCTURA, $NDIAS);

    if (!$mostrar) {
        die("Hubo un error en la consulta" . $error());
    }

    echo "Tarea agregada!";
}
