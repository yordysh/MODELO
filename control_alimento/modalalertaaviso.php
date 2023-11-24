<div class="modal fade" id="modalalertaaviso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">MONITOREO DE L & D DE ESTRUCTURAS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formmodal">
                    <div id="tablaavisoalerta" class="" style="overflow: scroll;height: 400px;margin-top:20px;">
                        <table id="tbavisoalerta" class="table table-sm mb-3">

                            <!-- <thead>
                       

                                $fecha = date("d-m-Y");
                                $numeroDiasMe = date('t', strtotime($fecha));
                                echo '<tr>';
                                echo '<th class="thtitulo" rowspan="2" scope="col">ZONA</th>';
                                echo '<th class="thtitulo" rowspan="2" scope="col">INFRAESTRUCTURA</th>';
                                echo '<th class="thtitulo" rowspan="2" scope="col">FRECUENCIA</th>';
                                echo '<th class="thtitulo" colspan="' . $numeroDiasMe . '" scope="col" style="text-align: center;">DIAS</th>';
                                echo '</tr>';

                                echo '<tr>';
                                for ($i = 1; $i <= $numeroDiasMe; $i++) {
                                    echo "<th>" . $i . "</th>";
                                }
                                echo '</tr>';
                                ?>
                            </thead> -->
                            <tbody id="tablaavisoalerta">

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-primary confirm-button">GUARDAR</button>
            </div>
        </div>
    </div>

</div>