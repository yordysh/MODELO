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
$anexo = '1010';
$codusuario = '00002';
$oficina = 'SMP2';
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
  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="./images/icon/covifarma-ico.ico" type="images/png">
  <title>Insumos</title>

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

  <div class="container" id="contenido_pdf">

    <div class="row mt-3">
      <div class="col-md-4">
        <div class="form-group">
          <label>Producto</label>
          <input type="text" name="nombre_producto_pdf" id="nombre_producto_pdf" class="form-control">
          <input type="hidden" name="cod_producto_pdf" id="cod_producto_pdf" class="form-control">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Lote de producción</label>
          <input type="text" name="nombre_lote_pdf" id="nombre_lote_pdf" class="form-control">
          <input type="hidden" name="cod_lote_pdf" id="cod_lote_pdf" class="form-control">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <pre></pre>
          <button class="generar_pdf_reporte btn btn-danger"><i class="fas fa-file-pdf"></i> Generar PDF</button>
        </div>
      </div>
    </div>

  </div>

  <div class="container" id="contenido">

    <table class='table table-hover' id='tablaDatosPendientes' style='width:100%'>
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
            <input type="text" class="form-control" name="fecha_dato" id="fecha_dato" readonly>
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

      <table class='table table-hover' id='tablaDetalleInsumos' style='width:100%'>
        <thead>
          <tr>
            <th>ITEM</th>
            <th>CODIGO INTERNO DE BOLSAS</th>
            <th>HORA INICIAL</th>
            <th>HORA FINAL</th>
            <th>PESO</th>
            <th>OBSERVACIONES</th>
            <th>ACCIONES CORRECTIVAS</th>
            <th>ELIMINAR</th>
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se agregarán los registros de forma dinamica -->
        </tbody>
      </table>

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

      <input class="btn btn-success" type="hidden" name="action" value="GuardarDatosMaqueta1">
      <button class="btn btn-success form-control" type="">Guardar datos</button>

    </form>

  </div>

  <br><br>


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

  <script type="text/javascript" src="../control_alimento/js/maquetafin.js"></script>
  <script src="../js/menu_a.js"></script>
</body>

</html>