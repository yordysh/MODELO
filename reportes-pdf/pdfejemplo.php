<?php

require_once '../assets/DomPDF/autoload.inc.php';

require_once "../php/m_almacen.php";
// require_once "../funciones/f_funcion.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];

$mostrar = new m_almacen();
$datos = $mostrar->MostrarInfraestructuraPDF($anioSeleccionado, $mesSeleccionado);

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

//     // Verifica si la infraestructura ya existe en la zona actual
//     $infraestructuraExistente = -1;
//     foreach ($grupos[$nombreZona]['infraestructuras'] as $index => $infraestructura) {
//         if ($infraestructura === $nombreInfraestructura) {
//             $infraestructuraExistente = $index;
//             break;
//         }
//     }

//     // Agrega la infraestructura solo si no existe en la zona actual
//     if ($infraestructuraExistente === -1) {
//         $grupos[$nombreZona]['infraestructuras'][] = $nombreInfraestructura;
//         $grupos[$nombreZona]['estados'][] = $estado;
//     } elseif ($infraestructuraExistente !== -1) {
//         // Actualiza el estado si la infraestructura ya existe en la zona actual
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
    $ndiaspos = $fila['N_DIAS_POS'];

    $fechaTotal = $fila['FECHA_TOTAL'];

    if (!isset($grupos[$nombreZona])) {
        $grupos[$nombreZona] = array();
    }

    $grupos[$nombreZona][] = array(
        'nombreInfraestructura' => $nombreInfraestructura,

        'ndiaspos' => $ndiaspos,
        'fechaTotal' => $fechaTotal
    );
}



foreach ($grupos as $nombreZona => $valores) {
    $html .= '<tr class="cabecera">';
    $html .= '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
    $html .= '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';
    if ($valores[0]['ndiaspos'] == 1) {
        $html .= '<td>Diaria</td>';
    } elseif ($valores[0]['ndiaspos'] == 2) {
        $html .= '<td>Interdiaria</td>';
    } elseif ($valores[0]['ndiaspos'] == 7) {
        $html .= '<td>Semanal</td>';
    } elseif ($valores[0]['ndiaspos'] == 15) {
        $html .= '<td>Quincenal</td>';
    } elseif ($valores[0]['ndiaspos'] == 30) {
        $html .= '<td>Mensual</td>';
    } else {
        $html .= '<td>' . $valores[0]['ndiaspos'] . '</td>';
    }

    // Añadir las columnas de acuerdo a la FECHA_TOTAL
    $fechaTotal = $valores[0]['fechaTotal'];
    $numeroDiasMes = date('t', strtotime($fechaTotal));
    $columnasFechaTotal = $numeroDiasMes;

    for ($i = 1; $i <= $columnasFechaTotal; $i++) {
        $html .= '<td>' . $i . '</td>';
    }

    // Agrega columna en blanco si el mes tiene 30 días
    if ($columnasFechaTotal == 30) {
        $html .= '<td></td>';
    }

    $html .= '</tr>';

    for ($i = 1; $i < count($valores); $i++) {
        $html .= '<tr>';
        $html .= '<td class="cabecera">' . $valores[$i]['nombreInfraestructura'] . '</td>';
        if ($valores[$i]['ndiaspos'] == 1) {
            $html .= '<td>Diaria</td>';
        } elseif ($valores[$i]['ndiaspos'] == 2) {
            $html .= '<td>Interdiaria</td>';
        } elseif ($valores[$i]['ndiaspos'] == 7) {
            $html .= '<td>Semanal</td>';
        } elseif ($valores[$i]['ndiaspos'] == 15) {
            $html .= '<td>Quincenal</td>';
        } elseif ($valores[$i]['ndiaspos'] == 30) {
            $html .= '<td>Mensual</td>';
        } else {
            $html .= '<td>' . $valores[0]['ndiaspos'] . '</td>';
        }

        // Añadir las columnas de acuerdo a la FECHA_TOTAL
        $fechaTotal = $valores[$i]['fechaTotal'];
        $numeroDiasMes = date('t', strtotime($fechaTotal));
        $columnasFechaTotal = $numeroDiasMes;

        for ($j = 1; $j <= $columnasFechaTotal; $j++) {
            $html .= '<td>' . $j . '</td>';
        }

        // Agrega columna en blanco si el mes tiene 30 días
        if ($columnasFechaTotal == 30) {
            $html .= '<td></td>';
        }

        $html .= '</tr>';
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
