<div class="modal fade" id="mostrarmaquinapdf" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CONTROL DE MÁQUINAS,EQUIPOS Y UTENSILIOS DE TRABAJO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div id="tControlmodal" class="table-responsive " style="overflow: scroll;height: 600px; margin-top:20px;">
                        <table id="tbControlmodal" class="table table-sm mb-3 table-hover">
                            <thead>
                                <tr>
                                    <th class="thtitulo" scope="col">MÁQUINA,EQUIPOS Y UTENSILIOS</th>
                                    <th class="thtitulo" scope="col">ACTIVAR</th>
                                </tr>
                            </thead>
                            <tbody id="tablaControlModal">
                                <?php foreach ($datoControl as $row) {
                                    echo '<tr>';
                                    echo '<td idcontrolmaquina=' . $row['COD_CONTROL_MAQUINA'] . '>' . $row['NOMBRE_CONTROL_MAQUINA'] . '</td>';
                                    echo '<td><div class="form-check form-switch" style="padding-left:8.5rem;">
                                                <input class="form-check-input" type="checkbox" id="frecuenciamarca">
                                          </div></td>';
                                    echo '</tr>';
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary" id='guardarcontrolmaquinapdf'>GUARDAR</button>
            </div>
        </div>
    </div>
</div>