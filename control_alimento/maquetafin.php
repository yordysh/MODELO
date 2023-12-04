<?php

require_once '../funciones/f_funcion.php';

date_default_timezone_set('America/Lima');

?>
<?php
// if (session_status() == PHP_SESSION_NONE) {
//   session_start();
// }
// $anexo = $_SESSION['ane'];
// $codusuario = $_SESSION['cod'];
// $nombre = $_SESSION['usu'];
// $oficina = $_SESSION['ofi'];
// $zona = $_SESSION['zon'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="../librerias/fuente-Inconsolata/fontsInconsolata.css">

  <!-- CSS  -->
  <link rel="stylesheet" href="../librerias/bootstrap-5.0.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="../librerias/sweetalert2/css/sweetalert2.min.css">

  <link rel="stylesheet" href="css/estilo1.css">

  <link rel="stylesheet" href="../librerias/jqueryui/css/ui_1.12.1_themes_base_jquery-ui.css">

  <link rel="stylesheet" href="../fontsweb/css/all.css">

  <link rel="stylesheet" href="../librerias/datatable/css/1.10.24_css_jquery.dataTables.css">
  <link rel="stylesheet" href="../librerias/datatable/css/responsive_2.2.9_css_responsive.dataTables.min.css">

  <!-- JavaScript -->

  <script src="../librerias/bootstrap-5.0.2/js/bootstrap.bundle.min.js"></script>

  <script src="../librerias/sweetalert2/js/sweetalert2.all.min.js"></script>

  <script src="../librerias/jquery_ajax/js/ajax_libs_jquery_3.3.1_jquery.min.js"></script>

  <script src="../librerias/jquery_ajax/js/jquery-3.7.0.js"></script>

  <script src="../librerias/jqueryui/js/ui_1.12.1_jquery-ui.min.js"></script>

  <!--
  <script src="../librerias/jspdf/js/jspdf_1.5.3_jspdf.min.js"></script>

  <script src="../librerias/jspdf/js/jspdf-autotable_3.2.3_jspdf.plugin.autotable.min.js"></script>
  -->

  <script src="../librerias/datatable/js/1.10.24_js_jquery.dataTables.js"></script>
  <script src="../librerias/datatable/js/responsive_2.2.9_js_dataTables.responsive.min.js"></script>

  <link rel="stylesheet" href="../fontsweb/css/all.css">


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>

<body>

  <input type="hidden" class="form-control" name="vranexo" id="vranexo" value="<?php echo $anexo ?>" readonly>
  <input type="hidden" class="form-control" name="vrcodpersonal" id="vrcodpersonal" value="<?php echo $codusuario ?>" readonly>
  <input type="hidden" class="form-control" name="vroficina" id="vroficina" value="<?php echo $oficina ?>" readonly>

  <?php
  require_once('../menulista/index.php');
  ?>
  <div class="container report-container" id="contenido_pdf">
    <h5 class="report-title" style="text-align: center;">Reporte de control de mezclado y cernido</h5>
    <div class="row mt-3 align-items-end">
      <div class="col-md-3">
        <div class="form-group">
          <label>Producto</label>
          <input type="text" name="nombre_producto_pdf" id="nombre_producto_pdf" class="form-control">
          <input type="hidden" name="cod_producto_pdf" id="cod_producto_pdf" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Lote de producción</label>
          <input type="text" name="nombre_lote_pdf" id="nombre_lote_pdf" class="form-control">
          <input type="hidden" name="cod_lote_pdf" id="cod_lote_pdf" class="form-control">
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <label>Nº Bachada</label>
          <input type="text" name="numero_bachada_pdf" id="numero_bachada_pdf" class="form-control">
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <pre></pre>
          <button class="generar_pdf_reporte btn btn-danger"><i class="fas fa-file-pdf"></i> </button>
        </div>
      </div>

    </div>

  </div>


  <div class="container report-container" id="contenido_sensorial_pdf">
    <h5 class="report-title" style="text-align: center;">Reporte de evaluación sensorial</h5>
    <div class="row mt-3 align-items-end">
      <div class="col-md-3">
        <div class="form-group">
          <label>Producto</label>
          <input type="text" name="nom_producto_sensorial_pdf" id="nom_producto_sensorial_pdf" class="form-control">
          <input type="hidden" name="cod_producto_sensorial_pdf" id="cod_producto_sensorial_pdf" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Lote de producción</label>
          <input type="text" name="nombre_lote_sensorial_pdf" id="nombre_lote_sensorial_pdf" class="form-control">
          <input type="hidden" name="cod_lote_sensorial_pdf" id="cod_lote_sensorial_pdf" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Nº Bachada</label>
          <input type="text" name="numero_bachada_sensorial_pdf" id="numero_bachada_sensorial_pdf" class="form-control">
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <pre></pre>
          <button class="generar_pdf_sensorial btn btn-danger"><i class="fas fa-file-pdf"></i></button>
        </div>
      </div>

    </div>
  </div>

  <br>

  <div class="container" id="contenido">
    <table class='table' id='tablaDatosPendientes' style='width:100%'>
      <thead>
        <tr>
          <th>ITEM</th>
          <th>PRODUCTO</th>
          <th>Nº BACHADA</th>
          <th>LOTE</th>
          <th>FECHA</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        <!-- Aquí se agregarán los datos -->
      </tbody>
    </table>
  </div>


  <div class="container" id="contenido_maqueta" style="display: none;">

    <form method="POST" id="myFormMaqueta" enctype="multipart/form-data">

      <div id="contenedor_control_mezclado">
        <input type="hidden" class="form-control" name="codigo_avance_insumo" id="codigo_avance_insumo" readonly>

        <div class="row mt-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Encargado del Mezclado</label>
              <input type="text" name="nombre_encargado" id="nombre_encargado" class="form-control">
              <input type="hidden" name="codigo_encargado" id="codigo_encargado" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Fecha</label>
              <input type="text" class="form-control" name="fecha_dato" id="fecha_dato" value="<?php echo date("d/m/Y") ?>" readonly>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Producto</label>
              <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Nº Bachada</label>
              <input type="text" name="numero_bachada" id="numero_bachada" class="form-control" readonly>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Peso de mezcla (Kg)</label>
              <input type="text" name="peso_mezcla" id="peso_mezcla" class="form-control" readonly>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Lote de producción</label>
              <input type="text" name="lote" id="lote" class="form-control" readonly>
            </div>
          </div>
        </div>

        <br>

        <button id="agregarFila" class="btn btn-success" type="button"><i class='fas fa-plus'></i>Agregar fila</button>

        <div style="overflow-x: auto;">
          <table class='table table-hover' id='tablaDetalleInsumos' style='width:100%'>
            <thead>
              <tr>
                <th style="text-align: center;">ITEM</th>
                <th style="text-align: center;">CODIGO INTERNO DE BOLSAS</th>
                <th style="text-align: center;">HORA INICIAL</th>
                <th style="text-align: center;">HORA FINAL</th>
                <th style="text-align: center;">PESO</th>
                <th style="text-align: center;">OBSERVACIONES</th>
                <th style="text-align: center;">ACCIONES CORRECTIVAS</th>
                <th style="text-align: center;">ELIMINAR</th>
              </tr>
            </thead>
            <tbody>
              <!-- Aquí se agregarán los registros de forma dinamica -->
            </tbody>
          </table>
        </div>

        <div style="overflow-x: auto;">
          <table class='table' id='tablaTotales'>
            <thead>
              <tr>
                <th>TOTAL MEZCLA</th>
                <th>TOTAL MERMA</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" name="totalMezcla" id="totalMezcla" class="form-control" readonly></td>
                <td><input type="text" name="totalMerma" id="totalMerma" class="form-control" maxlength="8"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>



      <div id="contenedor_sensorial">
        <!-- Título para la sección -->
        <h4 style="text-align: center;">Evaluación sensorial para liberación en línea</h4>
        <div style="overflow-x: auto;">
          <table class="table" id="tablaEvaluacionSensorial">
            <thead>
              <tr>
                <th colspan="3" style="text-align: center;">Evaluación sensorial (Producto en polvo)</th>
                <th colspan="5" style="text-align: center;">Evaluación sensorial producto reconstituido</th>
              </tr>
              <tr>
                <th>Color</th>
                <th>Olor</th>
                <th>Apariencia</th>

                <th>Color</th>
                <th>Olor</th>
                <th>Sabor</th>
                <th>Apariencia</th>
                <th>Textura</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input class="form-check-input" type="checkbox" id="EVA_POL_COL" name="EVA_POL_COL" checked></td>
                <td><input class="form-check-input" type="checkbox" id="EVA_POL_OLO" name="EVA_POL_OLO" checked></td>
                <td><input class="form-check-input" type="checkbox" id="EVA_POL_APA" name="EVA_POL_APA" checked></td>

                <td><input class="form-check-input" type="checkbox" id="EVA_REC_COL" name="EVA_REC_COL" checked></td>
                <td><input class="form-check-input" type="checkbox" id="EVA_REC_OLO" name="EVA_REC_OLO" checked></td>
                <td><input class="form-check-input" type="checkbox" id="EVA_REC_SAB" name="EVA_REC_SAB" checked></td>
                <td><input class="form-check-input" type="checkbox" id="EVA_REC_APA" name="EVA_REC_APA" checked></td>
                <td><input class="form-check-input" type="checkbox" id="EVA_REC_TEX" name="EVA_REC_TEX" checked></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mt-3">
          <div class="col-md-3">
            <div class="form-group">
              <label>Fecha</label>
              <input type="text" name="fecha_sensorial" id="fecha_sensorial" class="form-control" value="<?php echo date("d/m/Y") ?>" readonly>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Hora</label>
              <input type="time" name="hora_analisis_sensorial" id="hora_analisis_sensorial" class="form-control">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Aceptado o rechazado</label>
              <input type="text" name="txt_acetado_rechazado" id="txt_acetado_rechazado" class="form-control" maxlength="1">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Analista</label>
              <input type="text" name="txt_analista" id="txt_analista" class="form-control" maxlength="10">
            </div>
          </div>
        </div>


        <div class="row mt-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Observaciones</label>
              <textarea type="text" name="observaciones_sensorial" id="observaciones_sensorial" class="form-control" maxlength="100" style="resize: none;"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Acciones correctivas</label>
              <textarea type="text" name="acc_correctiva_sensorial" id="acc_correctiva_sensorial" class="form-control" maxlength="100" style="resize: none;"></textarea>
            </div>
          </div>
        </div>

      </div>

      <br>

      <!--<input type="text" name="txt_cod_avance_insumo" id="txt_cod_avance_insumo" class="form-control" readonly>-->
      <input type="hidden" name="txt_cod_produccion" id="txt_cod_produccion" class="form-control" readonly>
      <input type="hidden" name="txt_fecha_produccion" id="txt_fecha_produccion" class="form-control" readonly>
      <input type="hidden" name="txt_cod_producto" id="txt_cod_producto" class="form-control" readonly>
      <input type="hidden" name="txt_fecha_vencimiento" id="txt_fecha_vencimiento" class="form-control" readonly>

      <!--<input type="text" name="txt_filas_total_item_bolsas" id="txt_filas_total_item_bolsas" class="form-control" readonly>-->

      <input class="btn btn-success" type="hidden" name="action" value="GuardarDatosMaqueta1">
      <button class="btn btn-success form-control" type="">Guardar datos</button>

    </form>

  </div>

  <br>


  <div class="modal" tabindex="-1" role="dialog" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando pendientes...</span>
          </div>
          <p>Cargando pendientes...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="loadingModalMaqueta" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando datos...</span>
          </div>
          <p>Cargando datos...</p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="loadingGeneral" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
          <p>Cargando...</p>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="js/maquetafin.js"></script>



</body>

</html>