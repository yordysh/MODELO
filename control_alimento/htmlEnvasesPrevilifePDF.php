<?php
require_once "m_almacen.php";
// require_once "../funciones/f_funcion.php";


$mostrar = new m_almacen();
$dataEnvasesPrev = $mostrar->MostrarEnvasesPrevilifePDF();


$versionEnvasesPrev = $mostrar->VersionMostrarEnvasesPrevilife();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envases Previlife</title>
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
            background-color: #e3ac17;
            text-align: center;
            font-weight: 600;
            font-size: 16px;
            width: 20px;
            padding: 5px 0 5px 100px;
            border-right: none;
        }

        .thlab {
            background-color: #e3ac17;
            text-align: center;
            font-weight: 200;
            font-size: 16px;
            width: 20px;
            padding: 5px 28px 5px 0;
            border-left: none;
        }
    </style>
    <!-- Table titulo-->
    <header>
        <table>
            <tbody>
                <tr>
                    <td class="cabecera-rigth">LISTA MAESTRA DE ENVASES Y EMBALAJES</td>
                    <td class="cabecera-version">VERSIÓN
                        <?php
                        foreach ($versionEnvasesPrev as $row) {
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
        echo '<th class="thlabsabell">PREVILIFE</th>';
        echo '<th class="thlab"></th>';
        echo '</thead>';

        echo '<tbody class="columns">';

        foreach ($dataEnvasesPrev as $row) {
            echo '<tr>';

            echo '<td class="cabecera">' . $row["DES_PRODUCTO"] . '</td>';
            echo '<td class="cabecera">' . $row["ABR_PRODUCTO_PREVILIFE"] . '</td>';

            echo '</tr>';
        }
        echo '</tbody>'
        ?>

    </table>


</body>

</html>