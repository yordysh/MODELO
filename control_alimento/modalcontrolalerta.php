<div class="modal fade" id="modalcontrolalertas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Fecha a postergar pendiente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="mb-3">
                        <label for="fecha_postergacion" class="form-label">Selecciona una fecha:</label>
                        <input type="date" id="fecha_postergacion_control" name="fecha_postergacion_control" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary guardar">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    var fechaPostergacionInput = document.getElementById("fecha_postergacion_control");

    var fechaActual = new Date();
    var fechaMinima = new Date(fechaActual);
    fechaMinima.setDate(fechaActual.getDate() + 1);

    var fechaMaxima = new Date(fechaActual);
    fechaMaxima.setDate(fechaActual.getDate() + 3);


    var fechaMinimaString = fechaMinima.toISOString().split('T')[0];
    var fechaMaximaString = fechaMaxima.toISOString().split('T')[0];

    fechaPostergacionInput.setAttribute("min", fechaMinimaString);
    fechaPostergacionInput.setAttribute("max", fechaMaximaString);
</script>