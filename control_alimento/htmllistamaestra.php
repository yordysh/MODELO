<?php
require_once "m_almacen.php";
// require_once "../funciones/f_funcion.php";


$mostrar = new m_almacen();
$datalista = $mostrar->MostrarListaMaestraPDF();


// $versionEnvasesLab = $mostrar->VersionMostrarEnvasesLab();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envases Labsabell</title>
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

        .cabecera-rigth {
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            padding: 10px 98px;
        }

        .cabecera-version {
            background-color: #ffff;
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            /* padding: 1px 98px; */

        }

        .cabecera {
            text-align: center;
            font-weight: 300;
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

        .thlabsabell {
            background-color: #ed8ad8;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            width: 20px;
            padding: 5px 0 5px 100px;
            border-right: none;
        }

        .thlab {
            background-color: #ed8ad8;
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            padding: 5px 28px 5px 0;
            border-left: none;
        }

        body {
            margin: 30mm 8mm 30mm 8mm;
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

            <tr>
                <td rowspan="3" style="text-align: center;"><img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/img_lab.jpg')); ?>" alt="" width="100" height="50"></td>

                <td rowspan="3" style="text-align: center; font-size:15px; font-weight:200; width:400px;">LISTA MAESTRA DE ENVASES Y ACCESORIOS COMPLEMENTARIOS</td>
                <td>LBS-OP-FR-02</th>
            </tr>
            <tr>
                <td>Versión: 03</td>
            </tr>
            </tr>
            <tr>
                <td>Fecha: Agosto 2023</td>
            </tr>

        </table>
    </header>
    <!-- Table INSUMOS LABSABELL -->
    <table>

        <?php
        echo '<thead>';
        echo '<th class="thlabsabell">ABREVIATURA</th>';
        echo '<th class="thlab">PRODUCTO</th>';
        echo '</thead>';

        echo '<tbody class="columns">';

        foreach ($datalista as $row) {
            echo '<tr>';

            echo '<td class="cabecera">' . $row["ABR_PRODUCTO"] . '</td>';
            echo '<td class="cabecera">' . $row["DES_PRODUCTO"] . '</td>';

            echo '</tr>';
        }
        echo '</tbody>'
        ?>

    </table>


</body>

</html>