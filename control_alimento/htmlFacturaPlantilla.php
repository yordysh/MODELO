<?php
require_once "m_almacen.php";

$requerimiento = $_GET['requerimiento'];
$comprobante = '000000001';

$mostrar = new m_almacen();
$proveedor = $mostrar->MostrarFacturaProveedorPDF($requerimiento, $comprobante);
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
            background: #0a4661;
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
            width: 25%;
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
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }

        .round p {
            padding: 0 15px;
        }

        #factura_detalle {
            border-collapse: collapse;
        }

        #factura_detalle thead th {
            background: #058167;
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
    </style>
    <img class="anulada" src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/anulado.png')); ?>" alt="Anulada">
    <div id="page_pdf">
        <table id="factura_head">
            <tr>
                <td class="logo_factura">
                    <div>
                        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents('./images/logo-covifarmaRecorte.png')); ?>">
                    </div>
                </td>
                <td class="info_empresa">
                    <div>
                        <span class="h2">EMPRESA </span>
                        <p>Avenida las américas Zona 13, Perú</p>
                        <p>Teléfono: +((51) 945-451-856)</p>
                        <p>Email: ejemplo@gmail.com</p>
                    </div>
                </td>
                <td class="info_factura">
                    <div class="round">
                        <span class="h3">Factura</span>
                        <p>No. Factura: <strong>000001</strong></p>
                        <p>Fecha: 20/01/2023</p>
                        <p>Hora: 10:30am</p>
                        <p>Proveedor: Jorge Pérez Hernández Cabrera</p>
                    </div>
                </td>
            </tr>
        </table>
        <table id="factura_cliente">
            <tr>
                <td class="info_cliente">
                    <div class="round">
                        <span class="h3">Cliente</span>
                        <table class="datos_cliente">
                            <tr>
                                <!-- <td><label>Nit:</label>
                                    <p>54895468</p>
                                </td> -->
                                <td><label>Teléfono:</label>
                                    <p>7854526</p>
                                </td>
                                <td><label>Nombre:</label>
                                    <p>Angel Arana Cabrera</p>
                                </td>
                            </tr>
                            <tr>

                                <td><label>Dirección:</label>
                                    <p>Callao</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </table>

        <table id="factura_detalle">
            <thead>
                <tr>
                    <th width="50px">Cant.</th>
                    <th class="textleft">Descripción</th>
                    <th class="textright" width="150px">Precio Unitario.</th>
                    <th class="textright" width="150px"> Precio Total</th>
                </tr>
            </thead>
            <tbody id="detalle_productos">
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>
                <tr>
                    <td class="textcenter">1</td>
                    <td>Plancha</td>
                    <td class="textright">516.67</td>
                    <td class="textright">516.67</td>
                </tr>

            </tbody>
            <tfoot id="detalle_totales">
                <tr>
                    <td colspan="3" class="textright"><span>SUBTOTAL Q.</span></td>
                    <td class="textright"><span>516.67</span></td>
                </tr>
                <tr>
                    <td colspan="3" class="textright"><span>IVA (12%)</span></td>
                    <td class="textright"><span>516.67</span></td>
                </tr>
                <tr>
                    <td colspan="3" class="textright"><span>TOTAL Q.</span></td>
                    <td class="textright"><span>516.67</span></td>
                </tr>
            </tfoot>
        </table>
        <div>
            <p class="nota">Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
            <h4 class="label_gracias">¡Gracias por su compra!</h4>
        </div>

    </div>

</body>

</html>