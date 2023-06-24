<?php
require_once "php/m_almacen.php";

$mostrar = new m_almacen();

$zona = $mostrar->MostrarInfraestructura();

$contar = count($zona);

// for ($i = 0; $i < count($zona); $i++) {
//     echo $zona[$i]->COD_ZONA;
//     echo $zona[$i]->NOMBRE_INFRAESTRUCTURA . "<br>";
// }
$arreglo = array(0 => 1, 1 => 2);
print_r($arreglo);
