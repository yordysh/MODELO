<?php
require_once "DataBaseA.php";
require_once "registrar.php";
require_once "../funciones/f_funcion.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();

$mostrar = new m_almacen();
$dataInfra = $mostrar->MostrarInfraestructura();


?>

<table id="tbInfra" class="table table-sm mb-3 table-hover">
    <thead>
        <tr>

            <th class="thtitulo" scope="col">CODIGO INFRAESTRUCTURA</th>
            <th class="thtitulo" scope="col">CODIGO ZONA</th>
            <th class="thtitulo" scope="col">NOMBRE DE INFRAESTRUCTURA</th>
            <th class="thtitulo" scope="col">N°DIAS</th>
            <th class="thtitulo" scope="col">FECHA</th>
            <th class="thtitulo" scope="col">USUARIO</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($dataInfra)) {
        ?>
            <?php foreach ($dataInfra as $listado) { ?>
                <tr taskId="<?php echo $listado->COD_INFRAESTRUCTURA; ?>">
                    <td><?php echo $listado->COD_INFRAESTRUCTURA ?></td>
                    <td><?php echo $listado->COD_ZONA ?></td>
                    <td class="NOMBRE_INFRAESTRUCTURA"><?php echo $listado->NOMBRE_INFRAESTRUCTURA ?></td>
                    <td id="numerodias"><?php echo $listado->NDIAS; ?></td>
                    <td><?php $FECHA = $listado->FECHA;
                        echo convFecSistema($FECHA) ?>
                    </td>
                    <td><?php echo $listado->USUARIO; ?></td>
                    <td><button class="btn btn-success task-update" name="editar" id="edit" data-COD_INFRAESTRUCTURA="<?php echo $listado->COD_INFRAESTRUCTURA; ?>"><i class="icon-edit"></i></button></td>
                    <td><button class="btn btn-danger task-delete" name="eliminar" id="delete" data-COD_INFRAESTRUCTURA="<?php echo $listado->COD_INFRAESTRUCTURA; ?>"><i class="icon-trash"></i></button></td>

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
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->