<?php
require_once "m_almacen.php";

$requerimiento = $_GET['requerimiento'];

$mostrar = new m_almacen();
$proveedor = $mostrar->MostrarFacturaProveedorPDF($requerimiento);
$productoscompra = $mostrar->MostrarFacturaPDF();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
</head>

<body>
    <style>
        @import url('fonts/BrixSansRegular.css');
        @import url('fonts/BrixSansBlack.css');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        p,
        label,
        span,
        table {
            font-family: 'BrixSansRegular';
            font-size: 9pt;
        }

        .h2 {
            font-family: 'BrixSansBlack';
            font-size: 16pt;
        }

        .h3 {
            font-family: 'BrixSansBlack';
            font-size: 12pt;
            display: block;
            background: #814092;
            color: #FFF;
            text-align: center;
            padding: 3px;
            margin-bottom: 5px;
        }

        #page_pdf {
            width: 95%;
            margin: 15px auto 10px auto;
        }

        #factura_head,
        #factura_cliente,
        #factura_detalle {
            width: 100%;
            margin-bottom: 10px;
        }

        .logo_factura {
            width: 25%;
        }

        .info_empresa {
            width: 50%;
            text-align: center;
        }

        .info_factura {
            width: 15%;
        }

        .info_cliente {
            width: 100%;
        }

        .datos_cliente {
            width: 100%;
        }

        .datos_cliente tr td {
            width: 50%;
        }

        .datos_cliente {
            padding: 10px 10px 0 10px;
        }

        .datos_cliente label {
            width: 75px;
            display: inline-block;
        }

        .datos_cliente p {
            display: inline-block;
        }

        .textright {
            text-align: right;
        }

        .textleft {
            text-align: left;
        }

        .textcenter {
            text-align: center;
        }

        .round {
            border-radius: 10px;
            border: 1px solid #814092;
            overflow: hidden;
            padding-bottom: 15px;
            margin-left: 150px;
            margin-right: 150px;
        }

        .round p {
            padding: 0 15px;
        }

        #factura_detalle {
            border-collapse: collapse;
        }

        #factura_detalle thead th {
            background: #2670bf;
            color: #FFF;
            padding: 5px;
        }

        #detalle_productos tr:nth-child(even) {
            background: #ededed;
        }

        #detalle_totales span {
            font-family: 'BrixSansBlack';
        }

        .nota {
            font-size: 8pt;
        }

        .label_gracias {
            font-family: verdana;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            margin-top: 20px;
        }

        .anulada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        body {
            margin: 10mm 8mm 2mm 8mm;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }
    </style>


    <?php
    foreach ($proveedor as $filasproveedor) {


        // echo '<img class="anulada" src="data:image/png;base64,' . base64_encode(file_get_contents('./images/anulado.png')) . '" alt="Anulada">';
        echo '<div id="page_pdf">';
        echo '<table id="factura_head">';
        echo '<tr>';
        // echo '<td class="logo_factura">';
        // echo '<div>';
        // echo '<img src="data:image/png;base64,' . base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')) . '">';
        // echo '</div>';
        // echo '</td>';
        echo '<td class="info_factura">';
        echo '<div class="round">';
        echo '<span class="h3">Orden de compra</span>';
        echo '<p>N°: <strong>' . $filasproveedor->COD_TMPCOMPROBANTE . '</strong></p>';
        echo '<p>Fecha:' . $filasproveedor->FECHA_REALIZADA . '</p>';
        echo '<p>Hora: ' . $filasproveedor->HORA . '</p>';
        echo '<p>Proveedor: ' . $filasproveedor->NOM_PROVEEDOR . '</p>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';

        echo '<table id="factura_detalle">';
        echo '<thead>';
        echo '<tr>';
        echo '<th width="100px">Cant.</th>';
        echo '<th class="textleft">Descripción</th>';
        // echo '<th class="textright" width="150px">Precio Unitario.</th>';
        echo '<th class="textright" width="150px"> Precio Total</th>';
        echo '</tr>';
        echo '</thead>';
        foreach ($productoscompra as $filadata) {
            if ($filadata->COD_TMPCOMPROBANTE == $filasproveedor->COD_TMPCOMPROBANTE) {
                echo '<tbody id="detalle_productos">';
                echo '<tr>';
                echo '<td style="text-align:center;">' . $filadata->CANTIDAD_MINIMA . '</td>';
                echo '<td >' . $filadata->DES_PRODUCTO . '</td>';
                echo '<td class="textright">' . $filadata->MONTO . '</td>';
                echo '</tr>';

                echo '</tbody>';
            }
        }
        echo '<tfoot id="detalle_totales">';
        echo '<tr>';
        echo '<td colspan="2" class="textright"><span>TOTAL</span></td>';
        echo '<td class="textright"><span>' . $filasproveedor->MONTO_TOTAL . '</span></td>';
        echo '</tr>';

        echo '</tfoot>';
        echo '</table>';
        echo '</table>';
    }

    ?>
    </div>

</body>

</html>