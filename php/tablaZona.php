<?php

require_once "m_almacen.php";
require_once "../funciones/f_funcion.php";

$conexion = new DataBase();
$dats = $conexion->Conectar();

$mostrar = new m_almacen();
$data = $mostrar->MostrarAlmacenMuestra();


?>

<table id="tbalmacen" class="table table-sm mb-3 table-hover">
    <thead>
        <tr>

            <th class="thtitulo" scope="col">CODIGO</th>
            <th class="thtitulo" scope="col">NOMBRE DE AREA</th>
            <th class="thtitulo" scope="col">FECHA</th>
            <th class="thtitulo" scope="col">VERSION</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($data)) {
            // foreach ($data as $lista) {  
        ?>
            <?php foreach ($data as $lista) { ?>
                <tr taskId="<?php echo $lista->COD_ZONA ?>">
                    <td class="codigo"><?php echo $lista->COD_ZONA ?></td>

                    <td class="NOMBRE_T_ZONA_AREAS"><?php echo $lista->NOMBRE_T_ZONA_AREAS ?></td>
                    <td><?php $FECHA = $lista->FECHA;
                        echo convFecSistema($FECHA) ?>
                    </td>
                    <td><?php echo $lista->VERSION ?></td>

                    <td><button class="btn btn-danger task-delete" data-COD_ZONA="<?php echo $lista->COD_ZONA; ?>"><i class="icon-trash"></i></button></td>
                    <td><button class="btn btn-success task-update" name="editar" id="edit" data-COD_ZONA="<?php echo $lista->COD_ZONA; ?>"><i class="icon-edit"></i></button></td>

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

<!-- <script>
    $(document).ready(function() {
        $('#tbalmacen').Tabledit({
            deleteButton: false,
            editButton: false,
            columns: {
                identifier: [0, 'taskId'],
                editable: [
                    [2, 'nombreArea']
                ]
            },
            hideIdentifier: true,
            url: 'actualizar-zona.php',
            onSuccess: function(data, textStatus, jqXHR) {
                console.log(data);
                if (data == 1) {

                    Swal.fire('¡Éxito!', 'Se ha editado exitosamente', 'success');
                }
            }

        });
    });
</script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->