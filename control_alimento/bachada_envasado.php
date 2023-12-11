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
<?php
require_once('../menulista/index.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Envasados</title>

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


  <div class="container" id="contenido_pdf_control_bachada2">
    <h5 class="report-title" style="text-align: center;">Reporte control de bachadas seleccionadas para envasado</h5>
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
          <button class="generar_pdf_reporte_control_bachada2 btn btn-danger"><i class="fas fa-file-pdf"></i></button>
        </div>
      </div>
    </div>
  </div>

  <br>

  <div class="container busca-container" id="contenido_busca">
    <h5 class="busca-title" style="text-align: center;">Control de bachadas seleccionadas para envasado</h5>
    <div class="row mt-3 align-items-end">
      <div class="col-md-3">
        <div class="form-group">
          <label>Producto</label>
          <input type="text" name="nombre_producto_busca" id="nombre_producto_busca" class="form-control">
          <input type="hidden" name="cod_producto_busca" id="cod_producto_busca" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>Lote de producción</label>
          <input type="text" name="nombre_lote_busca" id="nombre_lote_busca" class="form-control">
          <input type="hidden" name="cod_lote_busca" id="cod_lote_busca" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <button class="generar_datos_busqueda btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
      </div>
    </div>
  </div>

  <br>

  <div class="container" id="contenido1" style="display: none;">
    <table class='table' id='tablaDatosPendientes_Bachadas' style='width:100%'>
      <thead>
        <tr>
          <th>ITEM</th>
          <th>PRODUCTO</th>
          <th>Nº BACHADA</th>
          <th>LOTE</th>
          <th>FECHA DE MEZCLADO</th>
          <th>PESO</th>
          <th>CHECK</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
        <!-- Aquí se agregarán los datos -->
      </tbody>
    </table>
  </div>


  <div class="container" id="contenido_maqueta_bachada" style="display: none;">

    <form method="POST" id="myFormMaquetaBachada" enctype="multipart/form-data">

      <div id="contenedor_control_mezclado">
        <input type="hidden" class="form-control" name="codigo_id_kardex" id="codigo_id_kardex" readonly>
        <input type="hidden" class="form-control" name="codigo_id_kardex_sobrante" id="codigo_id_kardex_sobrante" readonly>

        <input type="hidden" class="form-control" name="peso_neto_producto" id="peso_neto_producto" readonly>

        <input type="hidden" class="form-control" name="valida_bachada_obligatoria" id="valida_bachada_obligatoria" readonly>

        <hr>
        <div>
          <div class="row mt-3">
            <div class="col-md-6">
              <div class="form-group">
                <label>Responsable</label>
                <input type="text" name="nombre_encargado" id="nombre_encargado" class="form-control">
                <input type="hidden" name="codigo_encargado" id="codigo_encargado" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <label>Bachada anterior</label>
              <input type="text" class="form-control" name="bachada_anterior" id="bachada_anterior" readonly>
            </div>

          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Producto</label>
              <input type="text" class="form-control" name="producto_bachada" id="producto_bachada" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Fecha de mezclado</label>
                <input type="text" class="form-control" name="fecha_mezclado" id="fecha_mezclado" readonly>
              </div>
            </div>

          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>Nº bachada</label>
              <input type="text" class="form-control" name="numero_bachada" id="numero_bachada" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Peso total obtenido</label>
                <input type="text" class="form-control" name="peso_total_obtenido" id="peso_total_obtenido" readonly>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label>Cantidad de bolsas (CTB)</label>
              <input type="text" class="form-control" name="cantidad_de_bolsas" id="cantidad_de_bolsas" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Cantidad programada (unidades)</label>
                <input type="text" class="form-control" name="cantidad_programada_unidades" id="cantidad_programada_unidades" maxlength="9">
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>Peso estimado (Kg)</label>
              <input type="text" class="form-control" name="peso_estimado_kg" id="peso_estimado_kg" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Bolsas seleccionadas (cantidad)</label>
                <input type="text" class="form-control" name="bolsas_seleccionadas_cantidad" id="bolsas_seleccionadas_cantidad" maxlength="9">
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>Bolsas seleccionadas (peso total (Kg))</label>
              <input type="text" class="form-control" name="bolsas_seleccionadas_peso_total_kg" id="bolsas_seleccionadas_peso_total_kg" maxlength="9">
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Bolsa incompleta (mezcla seleccionada (Kg))</label>
                <input type="text" class="form-control" name="bolsa_incompleta_mezcla_seleccionada" id="bolsa_incompleta_mezcla_seleccionada" maxlength="9">
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>Mezcla sobrante (Kg)</label>
              <input type="text" class="form-control" name="mezcla_sobrante" id="mezcla_sobrante" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Mezcla total a envasar</label>
                <input type="text" class="form-control" name="mezcla_total_envasar" id="mezcla_total_envasar" readonly>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>Cantidad estimada (unidades)</label>
              <input type="text" class="form-control" name="cantidad_estimada_unidad" id="cantidad_estimada_unidad" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Bolsas sobrantes (cantidad)</label>
                <input type="text" class="form-control" name="bolsas_sobrantes_cantidad" id="bolsas_sobrantes_cantidad" readonly>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>Bolsas sobrantes (peso total)</label>
              <input type="text" class="form-control" name="bolsas_sobrante_peso_total" id="bolsas_sobrante_peso_total" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Lote</label>
                <input type="text" class="form-control" name="lote_bachada" id="lote_bachada" readonly>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <label>F.P.</label>
              <input type="text" class="form-control" name="fecha_de_produccion" id="fecha_de_produccion" readonly>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>F.V.</label>
                <input type="text" class="form-control" name="fecha_de_vencimiento" id="fecha_de_vencimiento" readonly>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6">
              <div class="form-group">
                <label>Observaciones</label>
                <textarea type="text" name="observaciones_envasado" id="observaciones_envasado" class="form-control" maxlength="100" style="resize: none;"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Acciones correctivas</label>
                <textarea type="text" name="acc_correctiva_envasado" id="acc_correctiva_envasado" class="form-control" maxlength="100" style="resize: none;"></textarea>
              </div>
            </div>
          </div>

        </div>

      </div>
      <br>



      <input class="btn btn-success" type="hidden" name="action" value="GuardarDatosBachada1">
      <button class="btn btn-success form-control" type="">Guardar datos</button>

    </form>





  </div>

  <br>




  <div class="modal" tabindex="-1" role="dialog" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false">
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

  <script type="text/javascript" src="js/maquetaenvasado.js"></script>


</body>

</html>