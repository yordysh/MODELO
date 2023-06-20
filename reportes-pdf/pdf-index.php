<?php
ob_start();
require_once "../php/m_almacen.php";

$anioSeleccionado = $_GET['anio'];
$mesSeleccionado = $_GET['mes'];

$mostrar = new m_almacen();
$datos = $mostrar->MostrarInfraestructuraPDF($anioSeleccionado, $mesSeleccionado);
// $datos = $mostrar->MostrarInfraestructuraPDF();;
// $countInfra = $mostrar->contarInfraestructuraPDF();

// var_dump($datos);
// for ($i = 0; $i < count($datos); $i++) {
//     var_dump($datos[$i][1]);
// }
// $countZona = $mostrar->contarZonaAreasPDF();

?>


<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    thead {
        width: 100%;
    }

    thead th {
        border: 1px solid black;
    }

    tbody td {
        border: 1px solid black;
    }

    .cabecera-fila {
        background-color: #9dcdec;
    }

    .cabecera-fila td,
    .cabecera {
        text-align: center;
    }

    .tabla-ajustada td:nth-child(1),
    .tabla-ajustada td:nth-child(2) {
        width: 180px;
        /* Ajusta el valor de ancho según tus necesidades */
    }
</style>

<table style="margin-bottom: 50px;">
    <tbody>
        <tr>
            <td rowspan="4"><img src="../assets/images/logo-covifarmaRecorte.png" alt=""></td>
            <td rowspan="4" style="text-align: center;">MONITOREO DE L & D DE ESTRUCTURAS FISICAS Y ACCESORIOS</td>
            <td>LBS-PHS-FR-01</td>

        </tr>
        <tr>
            <td>Versión:04</td>
        </tr>
        <tr>
            <td>Página:01</td>
        </tr>
        <tr>
            <td>Fecha:Enero 2023</td>
        </tr>
    </tbody>
</table>
<table class="tabla-ajustada">
    <tbody>

        <tr>
            <td>Zonas/areas</td>
            <td class="infraestructura">Infraestructura, accesorios complementarios</td>
            <td>Frecuencia</td>

            <td colspan="31">Dias</td>

        </tr>

        <?php

        // $grupos = array();
        // foreach ($datos as $fila) {
        //     $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
        //     $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];

        //     if (!isset($grupos[$nombreZona])) {
        //         $grupos[$nombreZona] = array();
        //     }

        //     $grupos[$nombreZona][] = $nombreInfraestructura;
        // }
        // foreach ($grupos as $nombreZona => $valores) {
        //     echo '<tr class="cabecera">';
        //     echo '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
        //     echo '<td >' . $valores[0] . '</td>';
        //     echo '</tr>';

        //     for ($i = 1; $i < count($valores); $i++) {
        //         echo '<tr>';
        //         echo '<td class="cabecera">' . $valores[$i] . '</td>';
        //         echo '</tr>';
        //     }
        // }

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
            echo '<tr class="cabecera">';
            echo '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
            echo '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';
            if ($valores[0]['ndiaspos'] == 1) {
                echo '<td>Diaria</td>';
            } elseif ($valores[0]['ndiaspos'] == 2) {
                echo '<td>Interdiaria</td>';
            } elseif ($valores[0]['ndiaspos'] == 7) {
                echo '<td>Semanal</td>';
            } elseif ($valores[0]['ndiaspos'] == 15) {
                echo '<td>Quincenal</td>';
            } elseif ($valores[0]['ndiaspos'] == 30) {
                echo '<td>Mensual</td>';
            } else {
                echo '<td>' . $valores[0]['ndiaspos'] . '</td>';
            }

            // Añadir las columnas de acuerdo a la FECHA_TOTAL
            $fechaTotal = $valores[0]['fechaTotal'];
            $numeroDiasMes = date('t', strtotime($fechaTotal));
            $columnasFechaTotal = $numeroDiasMes;

            $dias = date('d', strtotime($fechaTotal));

            for ($i = 1; $i <= $columnasFechaTotal; $i++) {
                if ($i == $dias) {
                    // Aquí defines el estado que deseas imprimir en la columna correspondiente a $dias
                    echo '<td>' . $valores[0]['estado'] . '</td>';
                } else {
                    echo '<td></td>';
                }
            }

            // Agrega columna en blanco si el mes tiene 30 días
            if ($columnasFechaTotal == 30) {
                echo '<td></td>';
            }

            echo '</tr>';

            for ($i = 1; $i < count($valores); $i++) {
                echo '<tr>';
                echo '<td class="cabecera">' . $valores[$i]['nombreInfraestructura'] . '</td>';
                if ($valores[$i]['ndiaspos'] == 1) {
                    echo '<td class="cabecera">Diaria</td>';
                } elseif ($valores[$i]['ndiaspos'] == 2) {
                    echo '<td class="cabecera">Interdiaria</td>';
                } elseif ($valores[$i]['ndiaspos'] == 7) {
                    echo '<td class="cabecera">Semanal</td>';
                } elseif ($valores[$i]['ndiaspos'] == 15) {
                    echo '<td class="cabecera">Quincenal</td>';
                } elseif ($valores[$i]['ndiaspos'] == 30) {
                    echo '<td class="cabecera">Mensual</td>';
                } else {
                    echo '<td>' . $valores[$i]['ndiaspos'] . '</td>';
                }

                // Añadir las columnas de acuerdo a la FECHA_TOTAL
                $fechaTotal = $valores[$i]['fechaTotal'];
                $numeroDiasMes = date('t', strtotime($fechaTotal));
                $columnasFechaTotal = $numeroDiasMes;

                $dias = date('d', strtotime($fechaTotal));



                for ($j = 1; $j <= $columnasFechaTotal; $j++) {
                    if ($j == $dias) {
                        // Aquí defines el estado que deseas imprimir en la columna correspondiente a $dias
                        echo '<td>' . $valores[$i]['estado'] . '</td>';
                    } else {
                        echo '<td></td>';
                    }
                }

                // Agrega columna en blanco si el mes tiene 30 días
                if ($columnasFechaTotal == 30) {
                    echo '<td></td>';
                }

                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>
<!-- <table style="margin-top: 50px;">
    <tbody>
        <?php
        foreach ($datos as $fila) {
            echo '<tr>
            <td>' . $fila['NOMBRE_T_ZONA_AREAS'] .  '</td>
            <td>' . $fila['NOMBRE_INFRAESTRUCTURA'] .  '</td>
            </tr>';
        }

        ?>
    </tbody>
</table> -->

<?php
$html = ob_get_clean();

require_once '../assets/DomPDF/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new DOMPDF($options);

// Create an instance of Dompdf
$dompdf = new Dompdf();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);
// $dompdf->loadHtml("<img src='logo-covifarmaRecorte.png'");
// Set the paper size and orientation
$dompdf->setPaper('A2', 'landscape');

// Render the HTML content to PDF
$dompdf->render();

// Display the PDF in the browser
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="profesionales.pdf"');
header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Pragma: public');
header('Content-Length: ' . $dompdf->output(null, true));

echo $dompdf->output(null, true);
?>