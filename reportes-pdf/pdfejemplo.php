<?php

require_once '../assets/DomPDF/autoload.inc.php';

require_once "../php/m_almacen.php";
// require_once "../funciones/f_funcion.php";

$mostrar = new m_almacen();
$datos = $mostrar->MostrarInfraestructuraPDF();


// Generar el contenido HTML
$html = '<html>';
$html .= '<head><style>table {border-collapse: collapse;} td, th {border: 1px solid black; padding: 5px;}</style></head>';
$html .= '<body>';
$html .= '<table>';
//$html .= '<thead><tr><th>Columna 1</th></tr></thead>';
$html .= '<tbody>';




// $grupos = array();

// foreach ($datos as $fila) {
//     $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
//     $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
//     $estado = $fila['ESTADO'];
//     $fechaTotal = $fila['FECHA_TOTAL'];

//     if (!isset($grupos[$nombreZona])) {
//         $grupos[$nombreZona] = array(
//             'infraestructuras' => array(),
//             'estados' => array()
//         );
//     }

//     // Verificar si la infraestructura ya existe en la zona actual
//     $infraestructuraExistente = -1;
//     foreach ($grupos[$nombreZona]['infraestructuras'] as $index => $infraestructura) {
//         if ($infraestructura === $nombreInfraestructura) {
//             $infraestructuraExistente = $index;
//             break;
//         }
//     }

//     // Agregar la infraestructura solo si no existe en la zona actual
//     if ($infraestructuraExistente === -1) {
//         $grupos[$nombreZona]['infraestructuras'][] = $nombreInfraestructura;
//         $grupos[$nombreZona]['estados'][] = $estado;
//     } elseif ($infraestructuraExistente !== -1) {
//         // Actualizar el estado si la infraestructura ya existe en la zona actual
//         $grupos[$nombreZona]['estados'][$infraestructuraExistente] = $estado;
//     }
// }

// foreach ($grupos as $nombreZona => $valores) {
//     $fechaEstado = array();
//     foreach ($valores['infraestructuras'] as $index => $infraestructura) {
//         $estado = $valores['estados'][$index];
//         $fechaEstado[$index] = array();

//         foreach ($datos as $fila) {
//             $nombreZonaFila = $fila['NOMBRE_T_ZONA_AREAS'];
//             $nombreInfraestructuraFila = $fila['NOMBRE_INFRAESTRUCTURA'];
//             $estadoFila = $fila['ESTADO'];
//             $fechaTotalFila = $fila['FECHA_TOTAL'];

//             if ($nombreZona === $nombreZonaFila && $infraestructura === $nombreInfraestructuraFila && $estadoFila != 'P') {
//                 $fechaEstado[$index][$fechaTotalFila] = $estadoFila;
//             }
//         }
//     }

//     $html .= '<tr>';
//     $html .= '<td rowspan="' . count($valores['infraestructuras']) . '">' . $nombreZona . '</td>';
//     $html .= '<td>' . $valores['infraestructuras'][0] . '</td>';

//     foreach ($valores['infraestructuras'] as $index => $infraestructura) {
//         $fechaEstadoActual = $fechaEstado[$index];

//         foreach ($fechaEstadoActual as $fecha => $estado) {
//             $html .= '<td>' . $estado . '</td>';
//         }

//         // Imprimir columnas restantes si no hay estado para todas las fechas
//         $diasFaltantes = 31 - count($fechaEstadoActual);
//         for ($i = 0; $i < $diasFaltantes; $i++) {
//             $html .= '<td></td>';
//         }

//         if ($index < count($valores['infraestructuras']) - 1) {
//             $html .= '</tr><tr>';
//             $html .= '<td>' . $valores['infraestructuras'][$index + 1] . '</td>';
//         }
//     }

//     $html .= '</tr>';
// }


$grupos = array();

foreach ($datos as $fila) {
    $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
    $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
    $estado = $fila['ESTADO'];
    $fechaTotal = $fila['FECHA_TOTAL'];

    if (!isset($grupos[$nombreZona])) {
        $grupos[$nombreZona] = array(
            'infraestructuras' => array(),
            'estados' => array()
        );
    }

    // Verificar si la infraestructura ya existe en la zona actual
    $infraestructuraExistente = -1;
    foreach ($grupos[$nombreZona]['infraestructuras'] as $index => $infraestructura) {
        if ($infraestructura === $nombreInfraestructura) {
            $infraestructuraExistente = $index;
            break;
        }
    }

    // Agregar la infraestructura solo si no existe en la zona actual
    if ($infraestructuraExistente === -1) {
        $grupos[$nombreZona]['infraestructuras'][] = $nombreInfraestructura;
        $grupos[$nombreZona]['estados'][] = array();
        $infraestructuraExistente = count($grupos[$nombreZona]['infraestructuras']) - 1;
    }

    // Agregar el estado a la infraestructura actual
    $grupos[$nombreZona]['estados'][$infraestructuraExistente][$fechaTotal] = $estado;
}


foreach ($grupos as $nombreZona => $valores) {
    $infraestructuras = $valores['infraestructuras'];
    $estados = $valores['estados'];

    $html .= '<tr>';
    $html .= '<td rowspan="' . count($infraestructuras) . '">' . $nombreZona . '</td>';

    foreach ($infraestructuras as $index => $infraestructura) {
        $html .= '<td>' . $infraestructura . '</td>';

        for ($dia = 1; $dia <= 31; $dia++) {
            $fecha = sprintf("%02d", $dia);
            $estadoColumna = '';

            foreach ($estados[$index] as $fechaEstado => $estado) {
                if ($fechaEstado === $fecha) {
                    $estadoColumna = $estado;
                    break;
                }
            }

            $html .= '<td>' . $estadoColumna . '</td>';
        }

        $html .= '</tr>';

        if ($index < count($infraestructuras) - 1) {
            $html .= '<tr>';
        }
    }
}



























































































































































$html .= '</tbody>';
$html .= '</table>';
$html .= '</body>';
$html .= '

</html>';


// Generar el PDF con DOMPDF
$dompdf = new Dompdf\Dompdf();
$dompdf->loadHtml($html);

// Set the paper size and orientation
$dompdf->setPaper('A2', 'landscape');

$dompdf->render();

// Guardar el PDF en una ubicación deseada
$dompdf->stream('tabla.pdf', array('Attachment' => 0));
