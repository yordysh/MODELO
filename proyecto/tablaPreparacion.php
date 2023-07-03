<?php

require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";


$mostrar = new m_almacen();
$dataInsumos = $mostrar->MostrarUnion();


?>

<table id="tbInsumos" class="table table-sm mb-3 table-hover">
    <thead>
        <tr>

            <th class="thtitulo" scope="col">INSUMOS</th>
            <th class="thtitulo" scope="col">PRODUCTOS</th>
            <th class="thtitulo" scope="col">CANTIDAD("%" o "ppm")</th>
            <th class="thtitulo" scope="col">NÚMERO EN ML</th>
            <th class="thtitulo" scope="col">NÚMERO EN L</th>
            <th class="thtitulo" scope="col">FECHA</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($dataInsumos)) {
        ?>
            <?php foreach ($dataInsumos as $listado) { ?>
                <tr taskId="<?php echo $listado['ID_UNION']; ?>">

                    <td><?php echo $listado['NOMBRE_INSUMOS']; ?></td>
                    <td><?php echo $listado['NOMBRE_PREPARACION']; ?></td>
                    <td style="text-align: center;"><?php echo $listado['CANTIDAD_PORCENTAJE']; ?></td>
                    <td style="text-align: center;"><?php echo $listado['CANTIDAD_MILILITROS']; ?></td>
                    <td style="text-align: center;"><?php echo $listado['CANTIDAD_LITROS']; ?></td>
                    <td><?php $FECHA = convFecSistema($listado['FECHA']);
                        echo $FECHA; ?></td>


                </tr>
            <?php
            }
            ?>
        <?php } else { ?>
            <tr>
                <td class="mostrar" colspan="7">No se encontro lista...</td>
            </tr>
        <?php } ?>
    </tbody>
</table>