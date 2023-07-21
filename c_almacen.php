<?php
require_once("./php/m_almacen.php");
//  require_once("./funciones/f_funcion.php");
class c_almacen
{
    static function c_balamcen($cod, $oficina)
    {
        $m_formula = new m_almacen();
        $produccion = $m_formula->MostrarAlmacenMuestra(trim($cod), $oficina);

        $dato = array('dato' => $produccion);
        echo json_encode($dato, JSON_FORCE_OBJECT);
    }

    function c_insertar_zona()
    {
        $m_formula = new m_almacen();
        if (isset($_POST["NOMBRE_T_ZONA_AREAS"])) {
            $NOMBRE_T_ZONA_AREAS = trim($_POST['NOMBRE_T_ZONA_AREAS']);

            $m_formula->InsertarAlmacen($NOMBRE_T_ZONA_AREAS);

            if (!$m_formula) {
                die("Hubo un error en la consulta");
            }

            echo "Tarea agregada!";
        }
    }

    // function c_
}
