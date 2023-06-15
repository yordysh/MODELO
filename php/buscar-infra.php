<?php
require_once "DataBaseA.php";
require_once "registrar.php";

try {
    $search = $_POST["search"];

    if (!empty($search)) {
        $mostrar = new m_almacen();
        $datos = $mostrar->MostrarInfraestructuraBusqueda($search);

        if (!$datos) {
            throw new Exception("Hubo un error en la consulta");
        }

        $json = array();
        foreach ($datos as $row) {
            $json[] = array(
                "COD_INFRAESTRUCTURA" => $row->COD_INFRAESTRUCTURA,
                "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
// echo "hola infraes";
