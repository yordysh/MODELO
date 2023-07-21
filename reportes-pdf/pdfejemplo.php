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
        text-align: center;
    }

    .cabecera-fila td,
    .cabecera {
        text-align: center;
    }

    .column-1:nth-child(1),
    .column-2:nth-child(2) {
        width: 320px;

    }

    td.estado-vacio {
        background-color: #f2f2f2;

    }

    td.estado-R {
        background-color: #0a5e9c;
        color: #f2f2f2;
        text-align: center;

    }

    td.estado-NR {
        background-color: #E72b3c;
        color: #f2f2f2;
        text-align: center;
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

        <?php

        // $grupos = array();

        // foreach ($datos as $fila) {
        //     $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
        //     $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];
        //     $ndiaspos = $fila['N_DIAS_POS'];
        //     $estado = $fila['ESTADO'];
        //     $fechaTotal = $fila['FECHA_TOTAL'];

        //     if (!isset($grupos[$nombreZona])) {
        //         $grupos[$nombreZona] = array();
        //     }

        //     $grupos[$nombreZona][] = array(
        //         'nombreInfraestructura' => $nombreInfraestructura,
        //         'estado' => $estado,
        //         'ndiaspos' => $ndiaspos,
        //         'fechaTotal' => $fechaTotal
        //     );
        // }

        // foreach ($grupos as $nombreZona => $valores) {
        //     echo '<tr class="cabecera">';
        //     echo '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
        //     echo '<td>' . $valores[0]['nombreInfraestructura'] . '</td>';
        //     if ($valores[0]['ndiaspos'] == 1) {
        //         echo '<td>Diaria</td>';
        //     } elseif ($valores[0]['ndiaspos'] == 2) {
        //         echo '<td>Interdiaria</td>';
        //     } elseif ($valores[0]['ndiaspos'] == 7) {
        //         echo '<td>Semanal</td>';
        //     } elseif ($valores[0]['ndiaspos'] == 15) {
        //         echo '<td>Quincenal</td>';
        //     } elseif ($valores[0]['ndiaspos'] == 30) {
        //         echo '<td>Mensual</td>';
        //     } else {
        //         echo '<td>' . $valores[0]['ndiaspos'] . '</td>';
        //     }

        //     // Añadir las columnas de acuerdo a la FECHA_TOTAL
        //     $fechaTotal = $valores[0]['fechaTotal'];
        //     $numeroDiasMes = date('t', strtotime($fechaTotal));
        //     $columnasFechaTotal = $numeroDiasMes;

        //     $dias = date('d', strtotime($fechaTotal));

        //     for ($i = 1; $i <= $columnasFechaTotal; $i++) {
        //         if ($i == $dias) {
        //             // Aquí defines el estado que deseas imprimir en la columna correspondiente a $dias
        //             echo '<td>' . $valores[0]['estado'] . '</td>';
        //         } else {
        //             echo '<td></td>';
        //         }
        //     }

        //     // Agrega columna en blanco si el mes tiene 30 días
        //     if ($columnasFechaTotal == 30) {
        //         echo '<td></td>';
        //     }

        //     echo '</tr>';

        //     for ($i = 1; $i < count($valores); $i++) {
        //         echo '<tr>';
        //         echo '<td class="cabecera">' . $valores[$i]['nombreInfraestructura'] . '</td>';
        //         if ($valores[$i]['ndiaspos'] == 1) {
        //             echo '<td class="cabecera">Diaria</td>';
        //         } elseif ($valores[$i]['ndiaspos'] == 2) {
        //             echo '<td class="cabecera">Interdiaria</td>';
        //         } elseif ($valores[$i]['ndiaspos'] == 7) {
        //             echo '<td class="cabecera">Semanal</td>';
        //         } elseif ($valores[$i]['ndiaspos'] == 15) {
        //             echo '<td class="cabecera">Quincenal</td>';
        //         } elseif ($valores[$i]['ndiaspos'] == 30) {
        //             echo '<td class="cabecera">Mensual</td>';
        //         } else {
        //             echo '<td>' . $valores[$i]['ndiaspos'] . '</td>';
        //         }

        //         // Añadir las columnas de acuerdo a la FECHA_TOTAL
        //         $fechaTotal = $valores[$i]['fechaTotal'];
        //         $numeroDiasMes = date('t', strtotime($fechaTotal));
        //         $columnasFechaTotal = $numeroDiasMes;

        //         $dias = date('d', strtotime($fechaTotal));



        //         for ($j = 1; $j <= $columnasFechaTotal; $j++) {
        //             if ($j == $dias) {
        //                 // Aquí defines el estado que deseas imprimir en la columna correspondiente a $dias
        //                 echo '<td>' . $valores[$i]['estado'] . '</td>';
        //             } else {
        //                 echo '<td></td>';
        //             }
        //         }

        //         // Agrega columna en blanco si el mes tiene 30 días
        //         if ($columnasFechaTotal == 30) {
        //             echo '<td></td>';
        //         }

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

            $existingIndex = -1;
            foreach ($grupos[$nombreZona] as $index => $value) {
                if ($value['nombreInfraestructura'] === $nombreInfraestructura) {
                    $existingIndex = $index;
                    break;
                }
            }

            if ($existingIndex !== -1) {
                $grupos[$nombreZona][$existingIndex]['estados'][$fechaTotal] = $estado;
            } else {
                $grupos[$nombreZona][] = array(
                    'nombreInfraestructura' => $nombreInfraestructura,
                    'estados' => array($fechaTotal => $estado),
                    'ndiaspos' => $ndiaspos,
                    'fechaTotal' => $fechaTotal
                );
            }
        }

        $numeroDiasMe = date('t', strtotime($fechaTotal));
        $columnasFechaTotales = $numeroDiasMe;

        echo '<tr>';
        echo '<td class="cabecera-fila column-1" rowspan="2">Zonas/areas</td>';
        echo '<td class="cabecera-fila column-2" rowspan="2">Infraestructura, accesorios complementarios</td>';
        echo '<td class="cabecera-fila" rowspan="2">Frecuencia</td>';
        echo '<td class="cabecera-fila" colspan="' . $columnasFechaTotales . '">Dias</td>';
        echo '<td class="cabecera-fila" rowspan="2">Responsable de ejecucion</td>';
        echo '</tr>';

        echo '<tr>';

        for ($l = 1; $l <= $columnasFechaTotales; $l++) {
            if ($l == $columnasFechaTotales) {
                echo '<td class="cabecera-fila borde">' . $l . '</td>';
            } else {
                echo '<td class="cabecera-fila">' . $l . '</td>';
            }
        }

        echo '</tr>';


        foreach ($grupos as $nombreZona => $valores) {
            echo '<tr">';
            echo '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';

            foreach ($valores as $index => $valor) {
                if ($index !== 0) {
                    echo '<tr>';
                }

                echo '<td class="cabecera">' . $valor['nombreInfraestructura'] . '</td>';
                if ($valor['ndiaspos'] == 1) {
                    echo '<td class="cabecera">Diaria</td>';
                } elseif ($valor['ndiaspos'] == 2) {
                    echo '<td class="cabecera">Interdiaria</td>';
                } elseif ($valor['ndiaspos'] == 7) {
                    echo '<td class="cabecera">Semanal</td>';
                } elseif ($valor['ndiaspos'] == 15) {
                    echo '<td class="cabecera">Quincenal</td>';
                } elseif ($valor['ndiaspos'] == 30) {
                    echo '<td class="cabecera">Mensual</td>';
                } else {
                    echo '<td class="cabecera">' . $valor['ndiaspos'] . '</td>';
                }

                // Crear array con columnas de acuerdo a la FECHA_TOTAL
                $fechaTotal = $valor['fechaTotal'];
                $numeroDiasMes = date('t', strtotime($fechaTotal));
                $columnasFechaTotal = $numeroDiasMes;
                $dias = date('d', strtotime($fechaTotal));

                $columnas = array();
                for ($i = 1; $i <= $columnasFechaTotal; $i++) {
                    if ($i == $dias) {
                        $columnas[$i] = '';
                    } else {
                        $columnas[$i] = '';
                    }
                }

                // Agregar columna en blanco si el mes tiene 30 días
                if ($columnasFechaTotal == 30) {
                    $columnas[31] = '';
                }

                // Asignar los estados a las columnas correspondientes
                foreach ($valor['estados'] as $fecha => $estado) {
                    $dia = date('d', strtotime($fecha));
                    if (isset($columnas[$dia])) {
                        if ($columnas[$dia] === '') {
                            $columnas[$dia] = $estado;
                        } else {
                            $columnas[$dia] .= '' . $estado;
                        }
                    }
                }

                // Imprimir los estados en las columnas correspondientes
                foreach ($columnas as $columna) {
                    $estadoClass = $columna !== '' ? 'estado-' . $columna : 'estado-vacio';
                    echo '<td class="' . $estadoClass . '">' . $columna . '</td>';
                    // echo '<td class="cabecera">' . $columna . '</td>';
                }
                //Colocar este td para que rellene de responsable de ejecucion
                echo '<td></td>';
                if ($index !== 0) {
                    echo '</tr>';
                }
            }

            echo '</tr>';
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