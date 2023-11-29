<div class="modal fade" id="modalcontrolalertas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title control">CONTROL DE L&D DE MAQUINAS Y UTENSILIOS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <main class="mainmodal">
                    <div id="tablacontrol" class="">
                        <table id="tbcontrol" class="table table-sm mb-3 table-hover">
                            <?php
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th class="thtitulo" scope="col">#</th>';
                            echo '<th class="thtitulo">MAQUINAS,EQUIPOS Y UTENSILIOS DE TRABAJO</th>';
                            echo '<th class="thtitulo">FRECUENCIA</th>';
                            echo '<th class="thtitulo">FECHA ANTERIOR</th>';
                            echo '<th class="thtitulo">' . $fechaactualservidor . '</th>';
                            echo '<th class="thtitulo" scope="col">OBSERVACION</th>';
                            echo '<th class="thtitulo" scope="col">ACCION CORRECTIVA</th>';
                            echo '<th class="thtitulo" scope="col">V°B°</th>';
                            echo '</tr>';
                            echo '</thead>';

                            echo '<tbody id="tablacontrolalerta">';

                            $s = 1;
                            foreach ($datacontroles as $row) {
                                $codigocontrolalerta = $row->COD_ALERTA_CONTROL_MAQUINA;
                                $codigomaquina = $row->COD_CONTROL_MAQUINA;
                                $nombremaquina = $row->NOMBRE_CONTROL_MAQUINA;
                                $fechaanterior = $row->FECHA_CREACION;
                                $estadoverificacontrol = $row->ESTADO;
                                $fechatotal = $row->FECHA_TOTAL;

                                $frecuencia = $row->N_DIAS_POS;
                                if ($frecuencia == '1') {
                                    $nombrefrecuencia = 'Diario(*)';
                                } else if ($frecuencia == '7') {
                                    $nombrefrecuencia = 'Semanal';
                                } else if ($frecuencia == '30') {
                                    $nombrefrecuencia = 'Mensual';
                                }
                                $formatofecha = date("d/m/Y", strtotime($fechaanterior));
                                echo '<tr>';
                                echo '<td style="visibility:collapse; display:none;"><input class="codigocontrolalerta" type="text" value="' . $codigocontrolalerta . '" /></td>';
                                echo '<td style="visibility:collapse; display:none;"><input class="estadoverificacontrol" type="text" value="' . $estadoverificacontrol . '" /></td>';
                                echo '<td style="visibility:collapse; display:none;"><input class="fechatotal" type="text" value="' . $fechatotal . '" /></td>';

                                echo '<td class="titulotd">' . $s . '</td>';
                                echo '<td class="nombremaquina titulotd" idcontrol="' . $codigomaquina . '">' . $nombremaquina . '</td>';
                                echo '<td class="nombrefrecuencia titulotd" frecuencia="' . $frecuencia . '">' . $nombrefrecuencia . '</td>';
                                echo '<td class="formatofecha titulotd" >' . $formatofecha . '</td>';
                                echo '<td class="titulotd"><input class="checkcontrol" type="checkbox"/></td>';
                                echo '<td><textarea class="form-control observacioncontrol" id="observacioncontrol" rows="2"></textarea></td>';
                                echo '<td><textarea class="form-control accioncorrectivacontrol" id="accioncorrectivacontrol" rows="2"></textarea></td>';
                                echo '<td>
                                            <select id="selectVerificacionControl" class="form-select selectVerificacionControl" style="width:150px;" aria-label="Default select example">
                                                    <option selected>Seleccione V°B</option>
                                                    <option value="1">J.A.C</option>
                                                    <option value="2">A.A.C</option>
                                            </select></td>';
                                echo '</tr>';
                                $s++;
                            }
                            echo '</tbody>';
                            ?>
                        </table>
                    </div>
                </main>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" id="botoncontrolalerta">GUARDAR</button>
            </div>
        </div>
    </div>

</div>