<?php


require_once "./m_almacen.php";


$mostrar = new m_almacen();


$datos = $mostrar->MostrarAlmacenMuestra();
try {
    if (!$datos) {
        throw new Exception("Hubo un error en la consulta");
    }

    $json = array();
    foreach ($datos as $row) {
        $json[] = array(
            "id" => $row->id,
            "codigo" => $row->codigo,
            "nombreArea" => $row->nombreArea,
            "fecha" => $row->fecha,
            "version" => $row->version,
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


// if (!$mostrar) {
//     die("Hubo un error en la consulta");
// }



// $json = array();
// foreach ($datos as $row) {
//     $json[] = array(
//         "id" => $row->id,
//         "codigo" => $row->codigo,
//         "nombreArea" => $row->nombreArea,
//         "fecha" => $row->fecha,
//         "version" => $row->version,
//     );
// }
// $jsonstring = json_encode($json);
// echo $jsonstring;
