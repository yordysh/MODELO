<div class="modal fade" id="mostrarlitros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Insertar litros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formularioZona">
                    <input type="hidden" id="taskId">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Litros</label>
                        <input type="text" id="litrosadd" name="litrosadd" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id='ponerlitros'>GUARDAR</button>
            </div>
        </div>
    </div>
</div>