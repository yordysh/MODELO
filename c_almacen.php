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

    function c_mostrar(){
        $mfor
    }
}
