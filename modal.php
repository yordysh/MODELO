<div class="modal fade" id="myModalExito" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Postergo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="mb-3">
                        <?php
                        $fechaActual = date('Y-m-d');
                        $fechaMaxima = date('Y-m-d', strtotime('+3 days'));
                        ?>
                        <label for="fecha_postergacion" class="form-label">Selecciona una fecha:</label>
                        <input type="date" id="fecha_postergacion" name="fecha_postergacion" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary confirm-button">Send message</button>
            </div>
        </div>
    </div>
</div>
<script>
    var fechaActual = new Date();
    fechaActual.setDate(fechaActual.getDate() + 1);

    var fechaLimite = new Date();
    fechaLimite.setDate(fechaLimite.getDate() + 3);

    var inputFecha = document.getElementById('fecha_postergacion');
    inputFecha.setAttribute('min', fechaActual.toISOString().split('T')[0]);
    inputFecha.setAttribute('max', fechaLimite.toISOString().split('T')[0]);
</script>