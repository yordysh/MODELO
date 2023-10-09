<div class="modal fade" id="mostrarfacturasubir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tomar foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkfoto">
                        <label class="form-check-label" for="flexCheckDefault"> Subir imagen de galeria</label>
                    </div>
                    <div class="mb-3">
                        <select id="selectdispositivo" class="form-select" aria-label="Default select example">
                            <option value="E" selected>DroidCam Source3</option>
                        </select>

                    </div>
                    <button>Tomar foto</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id='ponerproveedor'>GUARDAR</button>
            </div>
        </div>
    </div>
</div>