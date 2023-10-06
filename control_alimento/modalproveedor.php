<div class="modal fade" id="mostrarproveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos personales proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Buscar proveedor</label>
                        <select id="selectproveedor" class="form-select" aria-label="Default select example">
                            <option value="none" selected>Seleccione un proveedor</option>
                            <?php foreach ($dataProveedores as $data) { ?>
                                <option value="<?php echo $data->COD_PROVEEDOR; ?>" class="option"><?php echo $data->NOM_PROVEEDOR; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre proveedor</label>
                        <input type="text" id="nombreproveedor" name="nombreproveedor" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección proveedor</label>
                        <input type="text" id="direccionproveedor" name="direccionproveedor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="ruc" class="form-label">RUC</label>
                        <input type="text" id="ruc" name="ruc" class="form-control" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" id="dniproveedor" name="dniproveedor" class="form-control" step="1" pattern="[0-9]+" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id='ponerproveedor'>GUARDAR</button>
            </div>
        </div>
    </div>
</div>