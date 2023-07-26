<?php
require_once "m_almacen.php";
// require_once "../funciones/f_funcion.php";


$mostrar = new m_almacen();
$dataInsumos = $mostrar->MostrarInsumosLabPDF();

$fechaInsumos = $mostrar->FechaMaxMostrarInsumosLab();
$versionInsumos = $mostrar->VersionMostrarInsumosLab();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insumos labsabell</title>
</head>

<body>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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
            background-color: #e6c20e;
            text-align: center;
            font-weight: 200;
            font-size: 20px;
            width: 20px;
            padding: 1px 32px;
        }

        .cabecera-fila-lab {
            background-color: #EEB4F5;
            text-align: center;
            font-weight: 200;
            font-size: 20px;
            width: 20px;
            padding: 1px 10px;
        }

        .cabecera-version {
            background-color: #ffff;
            text-align: center;
            font-weight: 200;
            font-size: 20px;
            width: 20px;
            padding: 1px 98px;
            border: none;
        }

        .cabecera {
            text-align: center;
        }

        .columns {
            column-count: 2;
            column-gap: 20px;
        }

        body {
            margin: 20mm 1mm 2mm 1mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }
    </style>
    <!-- Table titulo-->
    <header>
        <table>
            <tbody>
                <tr>
                    <td class="cabecera-fila">
                        <?php
                        foreach ($fechaInsumos as $row) {
                            echo $row['FECHA_CREACION'];
                        }
                        ?>
                    </td>

                    <td class="cabecera-fila-lab">LABSABELL</td>
                    <td class="cabecera-version">VERSIÓN
                        <?php
                        foreach ($versionInsumos as $row) {
                            echo $row['VERSION'];
                        }
                        ?>
                    </td>
                </tr>

            </tbody>
        </table>
    </header>

    <!-- Table INSUMOS LABSABELL -->
    <table>

        <?php
        echo '<thead>';
        echo '<th>N°</th>';
        echo '<th>CODIGO</th>';
        echo '<th>ABREVIATURA</th>';
        echo '<th">INSUMOS</th>';
        echo '</thead>';

        echo '<tbody class="columns">';
        $count = 1;
        foreach ($dataInsumos as $row) {
            echo '<tr>';
            echo '<td class="cabecera">' . $count . '</td>';
            $count++;
            echo '<td class="cabecera">' . $row["COD_PRODUCTO_INSUMOS"] . '</td>';
            echo '<td class="cabecera">' . $row["ABR_PRODUCTO"] . '</td>';
            echo '<td >' . $row["DES_PRODUCTO"] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>'
        ?>

    </table>


</body>

</html>