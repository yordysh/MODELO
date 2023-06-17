<?php

require_once "registrar.php";

try {
    $search = $_POST["search"];

    if (!empty($search)) {
        $mostrar = new m_almacen();
        $datos = $mostrar->MostrarAlmacenMuestraBusqueda($search);

        if (!$datos) {
            throw new Exception("Hubo un error en la consulta");
        }

        $json = array();
        foreach ($datos as $row) {
            $json[] = array(
                "COD_ZONA" => $row->COD_ZONA,
                "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
