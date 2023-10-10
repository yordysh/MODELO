<div class="modal fade" id="mostrarfacturasubir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tomar foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <div>
                        <!-- <img src="https://stonegatesl.com/wp-content/uploads/2021/01/avatar-300x300.jpg" alt="avatar" id="img" /> -->
                        <img class="icon-camera" id='img' />
                        <input type="file" name="foto" id="foto" accept="image/*" />
                        <!-- <input type="text" id="foto"> -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary" id='guardardatosfacturaproveedor'>GUARDAR</button>
            </div>
        </div>
    </div>
</div>