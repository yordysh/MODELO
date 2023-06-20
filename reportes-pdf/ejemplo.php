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




$grupos = array();

foreach ($datos as $fila) {
    $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
    $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
    $ndiaspos = $fila['N_DIAS_POS'];
    $estado = $fila['ESTADO'];
    $fechaTotal = $fila['FECHA_TOTAL'];

    if (!isset($grupos[$nombreZona])) {
        $grupos[$nombreZona] = array();
    }

    $grupos[$nombreZona][] = array(
        'nombreInfraestructura' => $nombreInfraestructura,
        'estado' => $estado,
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
