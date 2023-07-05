<?php

require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";


$mostrar = new m_almacen();
$dataLimpieza = $mostrar->MostrarLimpieza();


?>

<table id="tbLimpieza" class="table table-sm mb-3 table-hover">
    <thead>
        <tr>
            <th class="thtitulo" scope="col">COD. FRECUENCIA</th>
            <th class="thtitulo" scope="col">ZONA/ÁREA</th>
            <th class="thtitulo" scope="col">ÍTEM(FRECUENCIA)</th>
            <th class="thtitulo" scope="col">FECHA</th>
            <th class="thtitulo" scope="col">VERSION</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($dataLimpieza)) {
        ?>
            <?php foreach ($dataLimpieza as $listado) { ?>
                <tr taskId="<?php echo $listado['COD_FRECUENCIA']; ?>">
                    <td><?php echo $listado['COD_FRECUENCIA']; ?></td>
                    <td><?php echo $listado['NOMBRE_T_ZONA_AREAS']; ?></td>
                    <td style="text-align: center;"><?php echo $listado['NOMBRE_FRECUENCIA']; ?></td>
                    <td><?php $FECHA = convFecSistema($listado['FECHA']);
                        echo $FECHA; ?></td>
                    <td style="text-align: center;"><?php echo $listado['VERSION']; ?></td>
                    <td><button class="btn btn-success task-update" name="editar" id="edit" data-COD_FRECUENCIA="<?php echo $listado['COD_FRECUENCIA'] ?>"><i class="icon-edit"></i></button></td>
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