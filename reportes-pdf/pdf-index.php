<?php
ob_start();
require_once "../php/m_almacen.php";

$mostrar = new m_almacen();
$datos = $mostrar->MostrarInfraestructuraPDF();;
$countInfra = $mostrar->contarInfraestructuraPDF();

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
<table>
    <tbody>

        <tr class="cabecera-fila">
            <td rowspan="2">Zonas/areas</td>
            <td rowspan="2">Infraestructura, accesorios complementarios</td>
            <td colspan="24">Diario</td>
            <td colspan="16">Interdiario</td>
            <td colspan="4">Semanal</td>
            <td colspan="4">Quincenal</td>
            <td colspan="4">Mensual</td>
            <td rowspan="2">Responsable de ejecución</td>
        </tr>
        <tr class="cabecera-fila">
            <td colspan="6">S1</td>
            <td colspan="6">S2</td>
            <td colspan="6">S3</td>
            <td colspan="6">S4</td>
            <td colspan="4">S1</td>
            <td colspan="4">S2</td>
            <td colspan="4">S3</td>
            <td colspan="4">S4</td>
            <td>S1</td>
            <td>S2</td>
            <td>S3</td>
            <td>S4</td>
            <td>S1</td>
            <td>S2</td>
            <td>S3</td>
            <td>S4</td>
            <td>S1</td>
            <td>S2</td>
            <td>S3</td>
            <td>S4</td>
        </tr>
        <?php

        // $num_filas = $countInfra;
        // $rowspan_variable = 2;

        // for ($i = 1; $i <= $num_filas; $i++) {
        //     echo '<tr>';

        //     if ($i === 1 || ($i - 1) % $rowspan_variable === 0) {
        //         echo "<td rowspan=\"$rowspan_variable\">Zona $i</td>";

        //         for ($j = 0; $j < 54; $j++) {
        //             echo "<td >FilaJ $j</td>";
        //         }
        //     } else {
        //         for ($j = 0; $j < 54; $j++) {
        //             echo "<td >Fila $j</td>";
        //         }
        //         // $html .= "<td>Filax $i</td>";
        //     }

        //     echo '</tr>';
        // }
        $grupos = array();
        foreach ($datos as $fila) {
            $nombreZona = $fila['NOMBRE_T_ZONA_AREAS'];
            $nombreInfraestructura = $fila['NOMBRE_INFRAESTRUCTURA'];

            if (!isset($grupos[$nombreZona])) {
                $grupos[$nombreZona] = array();
            }

            $grupos[$nombreZona][] = $nombreInfraestructura;
        }
        foreach ($grupos as $nombreZona => $valores) {
            echo '<tr class="cabecera">';
            echo '<td rowspan="' . count($valores) . '">' . $nombreZona . '</td>';
            echo '<td >' . $valores[0] . '</td>';
            echo '</tr>';

            for ($i = 1; $i < count($valores); $i++) {
                echo '<tr>';
                echo '<td class="cabecera">' . $valores[$i] . '</td>';
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

// Create an instance of Dompdf
$dompdf = new Dompdf();

// Load the HTML content into Dompdf
$dompdf->loadHtml($html);

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