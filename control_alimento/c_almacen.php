<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("./m_almacen.php");

include("../funciones/f_funcion.php");


$accion = $_POST['accion'];

if ($accion == 'insertar') {

    $nombrezonaArea = strtoupper(trim($_POST['nombrezonaArea']));
    $respuesta = c_almacen::c_insertar_zona($nombrezonaArea);
    echo $respuesta;
} elseif ($accion == 'editar') {
    $cod_zona = trim($_POST['cod_zona']);
    $respuesta = c_almacen::c_editar_zona($cod_zona);
    echo $respuesta;
} elseif ($accion == 'actualizar') {
    $codzona = trim($_POST['codzona']);
    $nombrezonaArea = trim($_POST['nombrezonaArea']);
    $respuesta = c_almacen::c_actualizar_zona($codzona, $nombrezonaArea);
    echo $respuesta;
} elseif ($accion == 'eliminarzona') {

    $codzona = trim($_POST['codzona']);

    $respuesta = c_almacen::c_eliminar_zona($codzona);
    echo $respuesta;
} elseif ($accion == 'buscarzona') {

    $buscarzona = trim($_POST['buscarzona']);

    $respuesta = c_almacen::c_buscar_zona($buscarzona);
    echo $respuesta;
} elseif ($accion == 'insertarinfra') {

    $nombreinfraestructura = strtoupper(trim($_POST['nombreinfraestructura']));
    $ndias = trim($_POST['ndias']);
    $valorSeleccionado = trim($_POST['valorSeleccionado']);
    $codpersonal = trim($_POST['codpersonal']);

    $respuesta = c_almacen::c_insertar_infra($valorSeleccionado, $nombreinfraestructura, $ndias, $codpersonal);

    echo $respuesta;
} elseif ($accion == 'editarinfra') {

    $codinfra = trim($_POST['codinfra']);

    $respuesta = c_almacen::c_editar_infra($codinfra);
    echo $respuesta;
} elseif ($accion == 'actualizarinfra') {
    $codinfra = trim($_POST["codinfra"]);
    $valorSeleccionado = trim($_POST['valorSeleccionado']);
    $nombreinfraestructurax = trim($_POST['nombreinfraestructura']);

    $ndias = trim($_POST['ndias']);

    $respuesta = c_almacen::c_actualizar_infra($valorSeleccionado, $nombreinfraestructurax, $ndias, $codinfra);
    echo $respuesta;
} elseif ($accion == 'eliminarinfra') {

    $codinfra = trim($_POST['codinfra']);

    $respuesta = c_almacen::c_eliminar_infra($codinfra);
    echo $respuesta;
} elseif ($accion == 'buscarinfra') {
    $buscarinfra = trim($_POST['buscarinfra']);

    $respuesta = c_almacen::c_buscar_infra($buscarinfra);
    echo $respuesta;
} elseif ($accion == 'buscarporcodigoalertainf') {
    $codigoalerta = trim($_POST['codigoalerta']);

    $respuesta = c_almacen::c_buscar_infra_alerta($codigoalerta);
    echo $respuesta;
} elseif ($accion == 'seleccionarzonainfra') {
    // $idzona = $_POST['idzona'];
    $respuesta = c_almacen::c_mostrar_infraestructura_zona();
    echo $respuesta;
} elseif ($accion == 'guardarinfraestructura') {
    $nombreinfraestructuraz =  strtoupper($_POST['nombreinfraestructuraz']);
    $nombrezonain = trim($_POST['nombrezonain']);

    $respuesta = c_almacen::c_insertar_infraestructura_zona($nombreinfraestructuraz, $nombrezonain);
    echo $respuesta;
} elseif ($accion == 'buscarporcodzona') {
    $codzonainfraes =  $_POST['codzonainfraes'];

    $respuesta = c_almacen::c_buscar_por_codzona($codzonainfraes);
    echo $respuesta;
} elseif ($accion == 'actualizarcomboinfraestructura') {
    $nombrezonain = trim($_POST['nombrezonain']);
    $respuesta = c_almacen::c_actualizar_combo_infraestructura($nombrezonain);
    echo $respuesta;
} elseif ($accion == 'actualizarcombozona') {

    $respuesta = c_almacen::c_actualizar_combo();
    echo $respuesta;
} elseif ($accion == 'fechaalertamensaje') {

    $respuesta = c_almacen::c_fecha_alerta_mensaje();
    echo $respuesta;
} elseif ($accion == 'actualizaalerta') {
    $respuesta = c_almacen::c_checkbox_confirma();
    echo $respuesta;
} elseif ($accion == 'insertaralertamix') {

    $respuesta = c_almacen::c_insertar_alertamix();

    echo $respuesta;
} elseif ($accion == 'fechaalerta') {
    $respuesta = c_almacen::c_fecha_alerta();
    echo $respuesta;
} elseif ($accion == 'seleccionarPreparacion') {

    $respuesta = c_almacen::c_selectproductos();
    echo $respuesta;
} elseif ($accion == 'seleccionarCantidad') {

    $respuesta = c_almacen::c_selectcantidad();
    echo $respuesta;
} elseif ($accion == 'seleccionarML') {

    $respuesta = c_almacen::c_selectML();
    echo $respuesta;
} elseif ($accion == 'seleccionarL') {

    $respuesta = c_almacen::c_selectL();
    echo $respuesta;
} elseif ($accion == 'enviarSelectCombo') {
    $selectSolucion = trim($_POST['selectSolucion']);
    $selectPreparacion = trim($_POST['selectPreparacion']);
    $selectCantidad = trim($_POST['selectCantidad']);
    $selectML = trim($_POST['selectML']);
    $selectL = trim($_POST['selectL']);
    $textAreaObservacion = trim($_POST['textAreaObservacion']);
    $textAreaAccion = trim($_POST['textAreaAccion']);
    $selectVerificacion = trim($_POST['selectVerificacion']);
    $valorextra = trim($_POST['valorextra']);

    $respuesta = c_almacen::c_selectCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion, $valorextra);
    echo $respuesta;
} elseif ($accion == 'buscarprepararacion') {

    $buscarPrepa = trim($_POST['buscarPrepa']);

    $respuesta = c_almacen::c_buscar_preparacion($buscarPrepa);
    echo $respuesta;
} elseif ($accion == 'insertarLimpieza') {


    $selectZona = trim($_POST['selectZona']);
    $textfrecuencia = strtoupper(trim($_POST['textfrecuencia']));

    $textAreaObservacion = trim($_POST['textAreaObservacion']);
    $textAreaAccion = trim($_POST['textAreaAccion']);
    $selectVerificacion = trim($_POST['selectVerificacion']);


    $respuesta = c_almacen::c_insertar_limpieza($selectZona, $textfrecuencia,  $textAreaObservacion,  $textAreaAccion, $selectVerificacion);
    echo $respuesta;
} elseif ($accion == 'editarLimpieza') {

    $cod_frecuencia = trim($_POST['cod_frecuencia']);

    $respuesta = c_almacen::c_editar_limpieza($cod_frecuencia);
    echo $respuesta;
} elseif ($accion == 'actualizarLimpieza') {
    $codfre = trim($_POST["codfre"]);
    $textfrecuencia = trim($_POST['textfrecuencia']);


    $respuesta = c_almacen::c_actualizar_limpieza($codfre, $textfrecuencia);
    echo $respuesta;
} elseif ($accion == 'buscarlimpieza') {

    $buscarLimpieza = trim($_POST['buscarLimpieza']);

    $respuesta = c_almacen::c_buscar_limpieza($buscarLimpieza);
    echo $respuesta;
} elseif ($accion == 'buscarcontrol') {
    $buscarcontrol = trim($_POST['buscarcontrol']);

    $respuesta = c_almacen::c_buscar_control($buscarcontrol);
    echo $respuesta;
} elseif ($accion == 'insertarcontrolmaquina') {

    $nombrecontrolmaquina = strtoupper(trim($_POST['nombrecontrolmaquina']));
    $respuesta = c_almacen::c_insertar_control_maquina($nombrecontrolmaquina);

    echo $respuesta;
} elseif ($accion == 'actualizarcombocontrol') {

    $respuesta = c_almacen::c_mostrar_combo_control();

    echo $respuesta;
} elseif ($accion == 'insertarcontrol') {

    $nombrecontrol = trim($_POST['nombrecontrol']);
    $ndiascontrol = trim($_POST['ndiascontrol']);


    $respuesta = c_almacen::c_insertar_control($nombrecontrol, $ndiascontrol);

    echo $respuesta;
} elseif ($accion == 'editarcontrolmaquina') {

    $codcontrolmaquina = trim($_POST['codcontrolmaquina']);

    $respuesta = c_almacen::c_editar_control_maquina($codcontrolmaquina);
    echo $respuesta;
} elseif ($accion == 'actualizarcontrol') {
    $codcontrol = trim($_POST["codcontrol"]);
    $nombrecontrol = trim($_POST['nombrecontrol']);
    $ndiascontrol = trim($_POST['ndiascontrol']);

    $respuesta = c_almacen::c_actualizar_control_maquina($nombrecontrol, $ndiascontrol,  $codcontrol);
    echo $respuesta;
} elseif ($accion == 'eliminarcontrolmaquina') {

    $codcontrolmaquina = trim($_POST['codcontrolmaquina']);

    $respuesta = c_almacen::c_eliminar_control_maquina($codcontrolmaquina);
    echo $respuesta;
} elseif ($accion == 'actualizardatoscontrolpdf') {

    $valorcapturadocontrol = $_POST['valorcapturadocontrol'];

    $respuesta = c_almacen::c_guardar_control_pdf_diario($valorcapturadocontrol);
    echo $respuesta;
} elseif ($accion == 'fechaalertacontrol') {
    $respuesta = c_almacen::c_fecha_alerta_control();
    echo $respuesta;
} elseif ($accion == 'actualizaalertacontrol') {
    $respuesta = c_almacen::c_checkbox_confirma_control();
    echo $respuesta;
} elseif ($accion == 'actualizaalertacontrolpos') {

    $respuesta = c_almacen::c_checkbox_confirma_control_pos();
    echo $respuesta;
} elseif ($accion == 'insertaralertamixcontrolmaquina') {
    $respuesta = c_almacen::c_insertar_alertamix_control_maquina();
    echo $respuesta;
} elseif ($accion == 'buscarZonaCombo') {
    $term = $_POST['term'];
    $respuesta = c_almacen::c_buscar_zona_combo($term);
    echo $respuesta;
} elseif ($accion == 'insertarlabsabell') {

    $codigolabsabell = trim($_POST['codigolabsabell']);
    $valorSeleccionado = ($_POST['valorSeleccionado']);
    $respuesta = c_almacen::c_insertar_labsabell($codigolabsabell, $valorSeleccionado);
    echo $respuesta;
} elseif ($accion == 'buscarlabsabell') {

    $buscarlab = trim($_POST['buscarlab']);

    $respuesta = c_almacen::c_buscar_labsabell($buscarlab);
    echo $respuesta;
} elseif ($accion == 'editarLabsabell') {
    $cod_producto_envase = trim($_POST['cod_producto_envase']);
    $respuesta = c_almacen::c_editar_envases_labsabel($cod_producto_envase);
    echo $respuesta;
} elseif ($accion == 'actualizarlabsabell') {
    $codlab = trim($_POST['codlab']);
    $codigolab = trim($_POST['codigolab']);
    $respuesta = c_almacen::c_actualizar_envases_labsabell($codlab, $codigolab);
    echo $respuesta;
} elseif ($accion == 'eliminarproductoenvase') {

    $codenvaselabsabell = trim($_POST['codenvaselabsabell']);

    $respuesta = c_almacen::c_eliminar_envases_labsabell($codenvaselabsabell);
    echo $respuesta;
} elseif ($accion == 'buscarProductoComboInsumos') {
    $term = $_POST['term'];
    $respuesta = c_almacen::c_buscar_producto_combo_insumos_lab($term);
    echo $respuesta;
} elseif ($accion == 'insertarinsumoslab') {

    $codigoInsumosLab = trim($_POST['codigoInsumosLab']);

    $valorSeleccionado = ($_POST['valorSeleccionado']);


    $respuesta = c_almacen::c_insertar_insumos_lab($codigoInsumosLab, $valorSeleccionado);
    echo $respuesta;
} elseif ($accion == 'buscarInsumosLab') {

    $buscarInsumos = trim($_POST['buscarInsumos']);

    $respuesta = c_almacen::c_buscar_insumos_lab($buscarInsumos);
    echo $respuesta;
} elseif ($accion == 'editarInsumosLab') {
    $cod_insumos_lab = trim($_POST['cod_insumos_lab']);
    $respuesta = c_almacen::c_editar_insumos_lab($cod_insumos_lab);
    echo $respuesta;
} elseif ($accion == 'actualizarinsumoslab') {
    $codInsu = trim($_POST['codInsu']);
    $codigoInsumo = trim($_POST['codigoInsumo']);
    $respuesta = c_almacen::c_actualizar_insumos_lab($codInsu, $codigoInsumo);
    echo $respuesta;
} elseif ($accion == 'eliminarinsumolab') {

    $codinsumoslab = trim($_POST['codinsumoslab']);

    $respuesta = c_almacen::c_eliminar_insumos_lab($codinsumoslab);
    echo $respuesta;
} elseif ($accion == 'insertarProductoEnvase') {

    $selectProductoCombo = trim($_POST['selectProductoCombo']);
    $cantidadTotal = trim($_POST['cantidadTotal']);
    $dataInsumo = ($_POST['dataInsumo']);
    $dataEnvase = ($_POST['dataEnvase']);

    $respuesta = c_almacen::c_insertar_producto_combo($selectProductoCombo, $cantidadTotal, $dataInsumo, $dataEnvase);
    echo $respuesta;
} elseif ($accion == 'buscarenvaseproducto') {
    $respuesta = c_almacen::c_buscar_producto_envase();
    echo $respuesta;
} elseif ($accion == 'seleccionarProduccion') {

    $respuesta = c_almacen::c_select_productos_produccion();
    echo $respuesta;
} elseif ($accion == 'insertarrequerimientoproducto') {

    $selectProductoCombo = trim($_POST['selectProductoCombo']);
    $cantidadProducto = trim($_POST['cantidadProducto']);

    $respuesta = c_almacen::c_insertar_requerimiento_producto($selectProductoCombo, $cantidadProducto);
    echo $respuesta;
} elseif ($accion == 'buscarrequerimientoproducto') {

    $buscarrequerimiento = trim($_POST['buscarrequerimiento']);

    $respuesta = c_almacen::c_buscar_requerimiento_producto($buscarrequerimiento);
    echo $respuesta;
} elseif ($accion == 'verificaproductoformulacion') {

    $selectinsumoenvase = trim($_POST['selectinsumoenvase']);
    $respuesta = c_almacen::c_vista_producto_formulacion($selectinsumoenvase);
    echo $respuesta;
} elseif ($accion == 'mostrardatosinsumos') {

    $selectinsumoenvase = trim($_POST['selectinsumoenvase']);
    $cantidadinsumoenvase = intval(trim($_POST['cantidadinsumoenvase']));


    $respuesta = c_almacen::c_mostrar_insumo($selectinsumoenvase, $cantidadinsumoenvase);
    echo $respuesta;
} elseif ($accion == 'mostrardatosenvases') {

    $seleccionadoinsumoenvases = trim($_POST['seleccionadoinsumoenvases']);

    $cantidadesinsumoenvases = intval(trim($_POST['cantidadesinsumoenvases']));
    $cantidadkg = intval(trim($_POST['cantidadkg']));

    $respuesta = c_almacen::c_mostrar_envase($seleccionadoinsumoenvases, $cantidadesinsumoenvases, $cantidadkg);
    echo $respuesta;
} elseif ($accion == 'guardarvalorescapturadosinsumos') {

    $codpersonal = ($_POST['codpersonal']);
    $union = ($_POST['union']);
    $unionEnvase = ($_POST['unionEnvase']);
    // $unionItem = ($_POST['unionItem']);
    $unionItem = json_decode($_POST['unionItem']);


    $respuesta = c_almacen::c_guardar_InsumoEnvase($codpersonal, $union, $unionEnvase, $unionItem);
    echo $respuesta;
} elseif ($accion == 'buscarpendientestotal') {

    $buscarpendiente = trim($_POST['buscarpendiente']);

    $respuesta = c_almacen::c_buscar_pendientes_requerimiento($buscarpendiente);
    echo $respuesta;
} elseif ($accion == 'insertarcantidadminima') {

    $selectCantidadminima = trim($_POST['selectCantidadminima']);
    $cantidadMinima = trim($_POST['cantidadMinima']);

    $respuesta = c_almacen::c_insertar_cantidad_minima($selectCantidadminima, $cantidadMinima);
    echo $respuesta;
} elseif ($accion == 'buscarCantidadminima') {
    $buscarcantidadminimasearch = $_POST['buscarcantidadminimasearch'];
    $respuesta = c_almacen::c_buscar_cantidad_minima($buscarcantidadminimasearch);
    echo $respuesta;
} elseif ($accion == 'editarcantidadminima') {
    $cod_mini = trim($_POST['cod_mini']);
    $respuesta = c_almacen::c_editar_cantidad_minima($cod_mini);
    echo $respuesta;
} elseif ($accion == 'actualizarcantidadminima') {
    $codminimo = trim($_POST['codminimo']);
    $selectCantidadminima = trim($_POST['selectCantidadminima']);
    $cantidadMinima = trim($_POST['cantidadMinima']);
    $respuesta = c_almacen::c_actualizar_cantidades_minima($codminimo, $selectCantidadminima, $cantidadMinima);
    echo $respuesta;
} elseif ($accion == 'eliminarcantidadminima') {

    $cod_cantidad_min = trim($_POST['cod_cantidad_min']);

    $respuesta = c_almacen::c_eliminar_cantidad_minima($cod_cantidad_min);
    echo $respuesta;
} elseif ($accion == 'mostrarcalculoderegistro') {
    $seleccionarproductoregistro = trim($_POST['seleccionarproductoregistro']);
    $cantidad = intval(trim($_POST['cantidad']));

    $respuesta = c_almacen::c_mostrar_calculo_registro_envases($seleccionarproductoregistro, $cantidad);
    echo $respuesta;
} elseif ($accion == 'buscarpendientesrequeridostotal') {

    $respuesta = c_almacen::c_mostrar_total_pendientes_requeridos();
    echo $respuesta;
} elseif ($accion == 'mostrarseguncodformulacion') {
    $cod_formulacion = trim($_POST['cod_formulacion']);

    $respuesta = c_almacen::c_mostrar_segun_codformulacion($cod_formulacion);
    echo $respuesta;
} elseif ($accion == 'mostrarproductoporrequerimiento') {
    $cod_formulacion = trim($_POST['cod_formulacion']);

    $respuesta = c_almacen::c_mostrar_producto_por_requerimiento($cod_formulacion);
    echo $respuesta;
} elseif ($accion == 'mostrarproductoinsumorequerimiento') {
    $cod_formulacion = trim($_POST['cod_formulacion']);

    $respuesta = c_almacen::c_mostrar_producto_por_insumo_requerimiento($cod_formulacion);
    echo $respuesta;
} elseif ($accion == 'mostrarsihaycompra') {

    $cod_formulacion = trim($_POST['cod_formulacion']);

    $respuesta = c_almacen::c_mostrar_si_hay_compra($cod_formulacion);
    echo $respuesta;
} elseif ($accion == 'insertarordencompraitem') {

    $idRequerimiento = trim($_POST['idRequerimiento']);
    // var_dump($_POST['codigoproveedorimagenes']$_FILES['file']);

    // var_dump($file);
    // exit();

    if (isset($_POST['union'])) {
        $union = $_POST['union'];
        $idRequerimiento = $_POST['idRequerimiento'];
        $codpersonal = $_POST['codpersonal'];



        if (isset($_FILES['file'])) {

            $dataimagenesfile = $_FILES['file'];
            $codigoproveedorimagenes = $_POST['codigoproveedorimagenes'];
            $respuesta = c_almacen::c_insertar_orden_compra_item($union, $dataimagenesfile, $codigoproveedorimagenes, $idRequerimiento,  $codpersonal);
        } else {
            $respuesta = c_almacen::c_insertar_orden_compra_item_sinimagen($union, $idRequerimiento,  $codpersonal);
        }
        // $respuesta = c_almacen::c_insertar_orden_compra_item($union, $file, $idRequerimiento,  $codpersonal);
        // echo $respuesta;
    } else {
        $respuesta = c_almacen::c_actualizar_orden_compra_item($idRequerimiento);
        echo $respuesta;
    }
} elseif ($accion == 'insertarordencompraitemtemporal') {
    $idRequerimiento = $_POST['idRequerimiento'];
    $valorcapturado = $_POST['valorcapturado'];

    $respuesta = c_almacen::c_insertar_orden_compra_temp($idRequerimiento, $valorcapturado);
    echo $respuesta;
} elseif ($accion == 'mostrarproduccionrequerimiento') {

    // $cod_formulacion = trim($_POST['cod_formulacion']);

    $respuesta = c_almacen::c_mostrar_producccion_por_requerimiento();
    echo $respuesta;
} elseif ($accion == 'insertarproducciontotal') {
    $codpersonal = trim($_POST['codpersonal']);
    $codrequerimientoproduccion = trim($_POST['codrequerimientoproduccion']);
    $codproductoproduccion = trim($_POST['codproductoproduccion']);
    $numeroproduccion = strtoupper(trim($_POST['numeroproduccion']));
    $cantidadtotalproduccion = trim($_POST['cantidadtotalproduccion']);
    $fechainicio = trim($_POST['fechainicio']);
    $fechavencimiento = trim($_POST['fechavencimiento']);
    $textAreaObservacion =  strtoupper(trim($_POST['textAreaObservacion']));
    $cantidadcaja = trim($_POST['cantidadcaja']);

    $respuesta = c_almacen::c_insertar_produccion_total($codpersonal, $codrequerimientoproduccion, $codproductoproduccion, $numeroproduccion, $cantidadtotalproduccion, $fechainicio, $fechavencimiento,  $textAreaObservacion, $cantidadcaja);
    echo $respuesta;
} elseif ($accion == 'rechazarpendienterequerimiento') {
    $cod_requerimiento_pedido = trim($_POST['cod_requerimiento_pedido']);
    $codpersonal = trim($_POST['codpersonal']);
    // $observacion = strtoupper(trim($_POST['observacion']));
    $respuesta = c_almacen::c_rechazar_pendiente_requerimiento($cod_requerimiento_pedido, $codpersonal);
    echo $respuesta;
} elseif ($accion == 'convalidocantidadproduccion') {

    $codigoproduccion = trim($_POST['codigoproduccion']);
    $codigoproducto = trim($_POST['codigoproducto']);
    $cantidadenvase = trim($_POST['cantidadenvase']);
    $cantidadinsumo = trim($_POST['cantidadinsumo']);
    $respuesta = c_almacen::c_consultar_cantidad_produccion($codigoproducto, $codigoproduccion, $cantidadinsumo, $cantidadenvase);
    echo $respuesta;
} elseif ($accion == 'mostrarregistrosporenvases') {
    $codigoproduccion = trim($_POST['codigoproduccion']);
    $codigoproducto = trim($_POST['codigoproducto']);
    $cantidadenvase = trim($_POST['cantidadenvase']);
    $cantidadinsumo = trim($_POST['cantidadinsumo']);
    $respuesta = c_almacen::c_mostrar_envases_por_produccion($codigoproducto, $codigoproduccion, $cantidadenvase, $cantidadinsumo);
    echo $respuesta;
} elseif ($accion == 'mostrarinsumostotales') {
    $codigoproduccion = trim($_POST['codigoproduccion']);
    $codigoproducto = trim($_POST['codigoproducto']);
    $cantidadenvase = trim($_POST['cantidadenvase']);
    $cantidadinsumo = trim($_POST['cantidadinsumo']);

    $respuesta = c_almacen::c_mostrar_insumos_totales_avance($codigoproducto, $codigoproduccion, $cantidadenvase, $cantidadinsumo);
    echo $respuesta;
} elseif ($accion == 'guardarvalordeinsumosporregistro') {

    $valoresCapturadosProduccion = ($_POST['valoresCapturadosProduccion']);
    $valoresCapturadosProduccioninsumo = ($_POST['valoresCapturadosProduccioninsumo']);
    $codigoproducto = trim($_POST['codigoproducto']);
    $codigoproduccion = trim($_POST['codigoproduccion']);
    $cantidad = trim($_POST['cantidad']);
    $cantidadtotalenvases = trim($_POST['cantidadtotalenvases']);
    $codpersonal = trim($_POST['codpersonal']);
    $codoperario = trim($_POST['codoperario']);

    $respuesta = c_almacen::c_guardar_valor_insumo_registro($valoresCapturadosProduccion, $valoresCapturadosProduccioninsumo, $codigoproducto, $codigoproduccion, $cantidad, $cantidadtotalenvases, $codpersonal, $codoperario);
    echo $respuesta;
} elseif ($accion == 'verificaregistromenorconproducto') {
    $codigoproductoverifica = trim($_POST['codigoproductoverifica']);
    $idrequerimiento = trim($_POST['idrequerimiento']);
    $respuesta = c_almacen::c_verifica_registro_menor_producto($idrequerimiento, $codigoproductoverifica);
    echo $respuesta;
} elseif ($accion == 'mostrarordencompra') {

    $respuesta = c_almacen::c_mostrar_orden_de_compra();
    echo $respuesta;
} elseif ($accion == 'mirarordencompra') {
    // $codpersonal = trim($_POST['codpersonal']);
    $idcodordencompra = trim($_POST['idcodordencompra']);

    $respuesta = c_almacen::c_mirar_orden_compra($idcodordencompra);
    echo $respuesta;
} elseif ($accion == 'aprobarordencompra') {
    $codigopersonal = trim($_POST['codigopersonal']);
    $idcodordencompra = trim($_POST['idcodordencompra']);

    $respuesta = c_almacen::c_aprobar_orden_compra($idcodordencompra, $codigopersonal);
    echo $respuesta;
} elseif ($accion == 'mostrarordencompraalmacenalerta') {
    $respuesta = c_almacen::c_mostrar_orden_compra_alerta();
    echo $respuesta;
} elseif ($accion == 'seleccionarProductoCombo') {
    $idp = $_POST['idp'];
    $respuesta = c_almacen::c_mostrar_produccion_producto($idp);
    echo $respuesta;
} elseif ($accion == 'actualizarcomboproduccionproducto') {

    $respuesta = c_almacen::c_actualizar_combo_produccion_producto();
    echo $respuesta;
} elseif ($accion == 'mostrarordencompraaprobada') {
    $codigopersonalsmp2 = trim($_POST['codigopersonal']);
    $oficinasmp2 = trim($_POST['oficina']);

    $respuesta = c_almacen::c_mostrar_orden_compra_aprobada($codigopersonalsmp2, $oficinasmp2);
    echo $respuesta;
} elseif ($accion == 'mostrarlistaproveedores') {
    $id = trim($_POST['idprovee']);
    $respuesta = c_almacen::c_mostrar_lista_proveedores($id);
    echo $respuesta;
} elseif ($accion == 'mostrarinsumoscompras') {
    $idcompraaprobada = trim($_POST['idcompraaprobada']);
    $respuesta = c_almacen::c_mostrar_insumos_compras($idcompraaprobada);
    echo $respuesta;
} elseif ($accion == 'mostrarproveedoresporproducto') {
    $codigoProducto = trim($_POST['codigoProducto']);
    $respuesta = c_almacen::c_mostrar_proveedores_por_producto($codigoProducto);
    echo $respuesta;
} elseif ($accion == 'mostrarprecioporcantidad') {
    $codproducto = trim($_POST['codproducto']);
    $cantidad = ($_POST['cantidad']);
    $codProveedor = $_POST['codProveedor'];
    $respuesta = c_almacen::c_mostrar_precios_por_cantidad($codproducto, $cantidad, $codProveedor);
    echo $respuesta;
} elseif ($accion == 'guardarinsumoscompras') {
    $fecha = trim($_POST['fecha']);
    $empresa = trim($_POST['empresa']);
    $personalcod = trim($_POST['personalcod']);
    $oficina = trim($_POST['oficina']);
    // $proveedor = strtoupper(trim($_POST['proveedor']));
    // $proveedordireccion = trim($_POST['proveedordireccion']);
    // $proveedorruc = trim($_POST['proveedorruc']);
    // $proveedordni = trim($_POST['proveedordni']);
    // $formapago = trim($_POST['formapago']);
    // $moneda = trim($_POST['moneda']);
    $observacion = strtoupper(trim($_POST['observacion']));
    $datosSeleccionadosInsumos = $_POST['datosSeleccionadosInsumos'];
    $idcompraaprobada = $_POST['idcompraaprobada'];
    // $dataimagenesfile = $_FILES['file']['name'];
    // var_dump($_FILES['file']);
    // exit;
    if (isset($_FILES['file'])) {

        $dataimagenesfile = $_FILES['file'];
        $respuesta = c_almacen::c_guardar_insumos_compras_imagen($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada, $dataimagenesfile);
    } else {
        $respuesta = c_almacen::c_guardar_insumos_compras($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada);
    }

    // var_dump($_FILES['file']);
    // exit;
    echo $respuesta;
} elseif ($accion == 'reporteordencompra') {
    $idrequerimientotemp = trim($_POST['idrequerimientotemp']);

    $respuesta = c_almacen::c_generar_reporte_orden_compra($idrequerimientotemp);
    echo $respuesta;
} elseif ($accion == 'reporteordencomprapdf') {
    $idrequerimientotemp = trim($_POST['idrequerimientotemp']);

    $respuesta = c_almacen::c_generar_reporte_orden_compra_pdf($idrequerimientotemp);
    echo $respuesta;
} elseif ($accion == 'mostrarcompracomprobante') {
    $respuesta = c_almacen::c_mostrar_compra_comprobante();
    echo $respuesta;
} elseif ($accion == 'ponercomprobantefactura') {
    $codigoComprobante = trim($_POST['codigoComprobante']);
    $codigopersonalsmp2 = trim($_POST['codigopersonal']);
    $oficinasmp2 = trim($_POST['oficina']);

    $respuesta = c_almacen::c_poner_comprobantefactura($codigoComprobante, $codigopersonalsmp2, $oficinasmp2);
    echo $respuesta;
} elseif ($accion == 'ponerpersonalentrante') {
    $codpersonalusu = trim($_POST['codpersonalusu']);
    $respuesta = c_almacen::c_poner_personal_usu($codpersonalusu);
    echo $respuesta;
} elseif ($accion == 'ponervaloresacomprarfactura') {
    $codigoComprobantemostrar = trim($_POST['codigoComprobantemostrar']);
    $respuesta = c_almacen::c_poner_valores_comprar_factura($codigoComprobantemostrar);
    echo $respuesta;
} elseif ($accion == 'consultatipodecambiosunat') {
    $respuesta = c_almacen::c_consulta_de_tipo_cambio_sunat();
    echo $respuesta;
} elseif ($accion == 'guardadatosfactura') {
    $idcomprobantecaptura = trim($_POST['idcomprobantecaptura']);
    $empresa = trim($_POST['empresa']);
    $fecha_emision = $_POST['fecha_emision'];
    $hora = $_POST['hora'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $codusu = trim($_POST['codusu']);
    $selecttipocompro = trim($_POST['selecttipocompro']);
    $selectformapago = trim($_POST['selectformapago']);
    $selectmoneda = trim($_POST['selectmoneda']);
    $tipocambio = trim($_POST['tipocambio']);
    $serie = trim($_POST['serie']);
    $correlativo = trim($_POST['correlativo']);
    $observacion = trim($_POST['observacion']);

    if (isset($_FILES['foto'])) {
        // Validar que se haya seleccionado una imagen
        if (empty($_FILES['foto']['name'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Debe seleccionar una imagen.'));
            exit;
        }

        // Obtener la información sobre el archivo
        $imagen_info = getimagesize($_FILES['foto']['tmp_name']);
        $imagen_tipo = $imagen_info['mime'];

        // Verificar que el tipo de archivo sea JPEG o PNG
        if ($imagen_tipo !== 'image/jpeg' && $imagen_tipo !== 'image/png') {
            echo json_encode(array('status' => 'error', 'message' => 'Formato de imagen no válido. Solo se permiten imágenes JPEG, JPG, PNG.'));
            exit;
        }

        // Verificar el tipo de archivo y usar la función adecuada para crear el recurso de imagen
        if ($imagen_tipo === 'image/jpeg') {
            $calidad = 30;
            $imagen_comprimida = imagecreatefromjpeg($_FILES['foto']['tmp_name']);
            ob_start();
            imagejpeg($imagen_comprimida, null, $calidad);
            $imagen_comprimida_binaria = ob_get_contents();
            ob_end_clean();
            $hex = bin2hex($imagen_comprimida_binaria);
            $imagen = '0x' . $hex;
            imagedestroy($imagen_comprimida);
        } elseif ($imagen_tipo === 'image/png') {
            $calidad = 5;
            $imagen_comprimida = imagecreatefrompng($_FILES['foto']['tmp_name']);
            ob_start();
            imagepng($imagen_comprimida, null, $calidad);
            $imagen_comprimida_binaria = ob_get_contents();
            ob_end_clean();
            $hex = bin2hex($imagen_comprimida_binaria);
            $imagen = '0x' . $hex;
            imagedestroy($imagen_comprimida);
        }
    } else {
        // La variable imagen no existe
        $imagen = null;
        echo json_encode(array('status' => 'error', 'message' => 'No hay imagen seleccionada.'));
        exit;
    }

    $respuesta = c_almacen::c_guardar_datos_factura($idcomprobantecaptura, $empresa,  $fecha_emision, $hora, $fecha_entrega, $codusu, $selecttipocompro,  $selectformapago, $selectmoneda, $tipocambio, $serie, $correlativo, $observacion, $imagen);
    echo $respuesta;
} elseif ($accion == 'actualizarrequerimientoitem') {
    $codrequerimiento  = trim($_POST['codrequerimiento']);
    $valoresorden  = $_POST['valoresorden'];
    $respuesta = c_almacen::c_actualizar_requerimiento_item($codrequerimiento, $valoresorden);
    echo $respuesta;
} elseif ($accion == 'mostrarvaloresporcodigorequerimiento') {
    $selectrequerimiento = trim($_POST['selectrequerimiento']);

    $respuesta = c_almacen::c_mostrar_valores_por_codigo_requerimiento($selectrequerimiento);
    echo $respuesta;
} elseif ($accion == 'fechaactualservidor') {
    $respuesta = c_almacen::c_mostrar_fecha_actual_servidor();
    echo $respuesta;
} elseif ($accion == 'mostrartotaldeinsumosporcomprar') {
    $selectrequerimiento = trim($_POST['selectrequerimiento']);
    $respuesta = c_almacen::c_mostrar_valores_comprobante($selectrequerimiento);
    echo $respuesta;
} elseif ($accion == 'insertardatoscontrolrecepcion') {
    $datos = $_POST['datos'];
    if (isset($_POST['datosTabla'])) {

        $datosTabla = $_POST['datosTabla'];
    } else {
        $datosTabla = null;
    }
    $idrequerimiento = trim($_POST['idrequerimiento']);
    $codpersonal = trim($_POST['codpersonal']);

    $respuesta = c_almacen::c_guardar_control_recepcion($datos, $datosTabla, $idrequerimiento, $codpersonal);
    echo $respuesta;
} elseif ($accion == 'insertaryactualizaralerta') {

    $capturavalor = $_POST['capturavalor'];

    $respuesta = c_almacen::c_guardar_actualizar_alerta($capturavalor);
    echo $respuesta;
} elseif ($accion == 'insertaryactualizaralertacontrol') {

    $capturavalorcontrol = $_POST['capturavalorcontrol'];

    $respuesta = c_almacen::c_guardar_actualizar_alerta_control($capturavalorcontrol);
    echo $respuesta;
} else if ($accion == "reportekardex") {
    $producto = $_POST['producto'];
    $fechaini = $_POST['fechaini'];
    $fechafin = $_POST['fechafin'];
    $lote = $_POST['lote'];
    c_almacen::c_reportekardex($producto, $fechaini, $fechafin, $lote);
} else if ($accion == 'productoselect') {
    c_almacen::c_producto();
} else if ($accion == 'slclotes') {
    $producto = $_POST['producto'];
    c_almacen::c_lotesproducto($producto);
} else if ($accion == 'consultadecajas') {
    $cantidadenvases = trim($_POST['cantidadenvases']);
    $codigoproducto = trim($_POST['codigoproducto']);
    // $codigorequerimiento = trim($_POST['codigorequerimiento']);
    c_almacen::c_consulta_cajas($cantidadenvases, $codigoproducto);
} else if ($accion == 'insertarproveedorproducto') {
    $selectprovedores = trim($_POST['selectprovedores']);
    $selectproductosproveedores = trim($_POST['selectproductosproveedores']);
    $cantidadMinima = trim($_POST['cantidadMinima']);
    $precioproducto = trim($_POST['precioproducto']);
    $selectmoneda = $_POST['selectmoneda'];

    c_almacen::c_insertar_proveedor_producto($selectmoneda, $precioproducto, $cantidadMinima, $selectprovedores, $selectproductosproveedores);
} else if ($accion == 'buscarProveedorPrecios') {
    $buscarProveedorPrecios = $_POST['buscarProveedorPrecios'];

    c_almacen::c_buscar_listar_proveedor_producto($buscarProveedorPrecios);
} else if ($accion == 'cambiarestadocantidadminima') {
    $taskId = $_POST['taskId'];

    c_almacen::c_cambiar_estado_cantidad_minima($taskId);
} else if ($accion == 'cambiarestado') {
    $id = $_POST['id'];

    c_almacen::c_cambiar_estado($id);
} elseif ($accion == 'editarproveedorprecios') {
    $cod_mini = trim($_POST['cod_mini']);
    $respuesta = c_almacen::c_editar_proveedor_precios($cod_mini);
    echo $respuesta;
} elseif ($accion == 'actualizarproveedorproducto') {
    $codminimo = trim($_POST['codminimo']);
    $selectproductosproveedores = trim($_POST['selectproductosproveedores']);
    $selectprovedores = trim($_POST['selectprovedores']);
    $cantidadMinima = trim($_POST['cantidadMinima']);
    $precioproducto = trim($_POST['precioproducto']);
    $selectmoneda = trim($_POST['selectmoneda']);

    $respuesta = c_almacen::c_actualizar_proveedores_productos($codminimo, $selectproductosproveedores, $selectprovedores, $cantidadMinima, $precioproducto, $selectmoneda);
    echo $respuesta;
}












class c_almacen
{


    static function c_insertar_zona($nombrezonaArea)
    {
        $m_formula = new m_almacen();

        if (isset($nombrezonaArea)) {
            $respuesta = $m_formula->InsertarAlmacen($nombrezonaArea);

            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_editar_zona($cod_zona)
    {
        $mostrar = new m_almacen();

        if (isset($cod_zona)) {
            $selectZ = $mostrar->SelectZona($cod_zona);

            $json = array();
            foreach ($selectZ as $row) {
                $json[] = array(
                    "COD_ZONA" => $row['COD_ZONA'],
                    "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }

    static function c_actualizar_zona($codzona, $nombrezonaArea)
    {

        $m_formula = new m_almacen();


        if (isset($codzona)) {

            $respuesta = $m_formula->editarAlmacen($nombrezonaArea, $codzona);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_eliminar_zona($codzona)
    {
        $mostrar = new m_almacen();

        if (isset($codzona)) {
            $respuesta = $mostrar->eliminarAlmacen($codzona);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_buscar_zona($buscarzona)
    {
        try {

            if (!empty($buscarzona)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarAlmacenMuestraBusqueda($buscarzona);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_ZONA" => $row->COD_ZONA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "FECHA" =>  convFecSistema($row->FECHA),
                        "VERSION" => $row->VERSION,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarAlmacenMuestra();
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_ZONA" => $row->COD_ZONA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "FECHA" =>  convFecSistema($row->FECHA),
                        "VERSION" => $row->VERSION,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_insertar_infra($valorSeleccionado, $nombreinfraestructura, $ndias, $codpersonal)
    {
        $mostrar = new m_almacen();
        if (isset($nombreinfraestructura) && isset($ndias) && isset($valorSeleccionado)) {

            $respuesta = $mostrar->insertarInfraestructura($valorSeleccionado, $nombreinfraestructura,  $ndias, $codpersonal);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_editar_infra($codinfra)
    {
        $mostrar = new m_almacen();


        if (isset($codinfra)) {

            $select = $mostrar->SelectInfra($codinfra);


            $json = array();

            foreach ($select as $row) {
                $json[] = array(
                    "CODIGO" => $row['CODIGO'],
                    "COD_INFRAESTRUCTURA" => trim($row['COD_INFRAESTRUCTURA']),
                    "COD_ZONA" => trim($row['COD_ZONA']),
                    "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                    "NOMBRE_INFRAESTRUCTURA" => $row['NOMBRE_INFRAESTRUCTURA'],
                    "NDIAS" => $row['NDIAS']
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }

    static function c_actualizar_infra($valorSeleccionado, $nombreinfraestructurax, $ndias, $codinfra)
    {
        $m_formula = new m_almacen();

        if (isset($codinfra)) {

            $resultado = $m_formula->editarInfraestructura($valorSeleccionado, $nombreinfraestructurax, $ndias, $codinfra);

            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_actualizar_combo_infraestructura($nombrezonain)
    {
        try {

            $mostrar = new m_almacen();

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarInfraestructuraID($nombrezonain);
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_INFRAESTRUCTURA" => $row->COD_INFRAESTRUCTURA,
                    "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_actualizar_combo()
    {
        try {

            $mostrar = new m_almacen();

            $datos = $mostrar->MostrarAlmacenMuestra();
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ZONA" => $row->COD_ZONA,
                    "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_insertar_infraestructura_zona($nombreinfraestructuraz, $nombrezonain)
    {
        $mostrar = new m_almacen();
        if (isset($nombrezonain)) {

            $respuesta = $mostrar->insertarInfraestructuraZona($nombreinfraestructuraz, $nombrezonain);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_buscar_por_codzona($codzonainfraes)
    {
        try {

            $mostrar = new m_almacen();

            $datos = $mostrar->buscarPorCodZona($codzonainfraes);
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ZONA" => trim($row->COD_ZONA),
                    "COD_INFRAESTRUCTURA" => trim($row->COD_INFRAESTRUCTURA),
                    "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_buscar_infra_alerta($codigoalerta)
    {
        try {

            $mostrar = new m_almacen();

            $datos = $mostrar->buscarPorCodZonaAler($codigoalerta);

            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ZONA" => trim($row->COD_ZONA),
                    "COD_INFRAESTRUCTURA" => trim($row->COD_INFRAESTRUCTURA),
                    "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_eliminar_infra($codinfra)
    {
        $mostrar = new m_almacen();

        if (isset($codinfra)) {

            $resultado = $mostrar->eliminarInfraestructura($codinfra);
            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_buscar_infra($buscarinfra)
    {
        try {

            if (!empty($buscarinfra)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarInfraestructuraBusqueda($buscarinfra);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "CODIGO" => $row->CODIGO,
                        "COD_INFRAESTRUCTURA" => $row->COD_INFRAESTRUCTURA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,
                        "NDIAS" => $row->NDIAS,
                        "FECHA" =>  convFecSistema($row->FECHA),
                        "USUARIO" => $row->USUARIO,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarInfraestructuraBusqueda($buscarinfra);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "CODIGO" => $row->CODIGO,
                        "COD_INFRAESTRUCTURA" => $row->COD_INFRAESTRUCTURA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,
                        "NDIAS" => $row->NDIAS,
                        "FECHA" =>  convFecSistema($row->FECHA),
                        "USUARIO" => $row->USUARIO,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_infraestructura_zona()
    {
        $consulta = new m_almacen();
        $idzona = filter_input(INPUT_POST, 'idzona');

        $datos = $consulta->Mostrarzonainfraestructura($idzona);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en infraestructura</option>';
        }
        echo '<option value="none" selected disabled>Seleccione infraestructura</option>';
        for ($i = 0; $i < count($datos); $i++) {

            echo '<option value="' . $datos[$i]["COD_INFRAESTRUCTURA"] . '">' . $datos[$i]["NOMBRE_INFRAESTRUCTURA"] . '</option>';
        }
    }

    static function c_fecha_alerta_mensaje()
    {

        $mostrar = new m_almacen();
        $datos = $mostrar->AlertaMensaje();
        try {
            if (!$datos) {
                $json = array();
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {

                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_ALERTA" => $row->COD_ALERTA,
                        "NDIAS" => $row->NDIAS,
                        "NOMBRE_AREA" => $row->NOMBRE_AREA,
                        "COD_INFRAESTRUCTURA" => $row->COD_INFRAESTRUCTURA,
                        "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,
                        "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
                        "FECHA_TOTAL" =>  convFecSistema($row->FECHA_TOTAL),
                        "FECHA_ACORDAR" =>  convFecSistema($row->FECHA_ACORDAR),

                    );
                }

                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e;
            // $response = array(
            //     'success' => true,
            //     'message' => $e->getMessage()
            // );
            // echo $response;
        }
    }

    static function c_checkbox_confirma()
    {
        $mostrar = new m_almacen();

        // if (isset($_POST['observacion'])) {
        if (isset($_POST['fechaPostergacion'])) {
            $codigozonaalerta = trim($_POST['codigozonaalerta']);
            $estado = $_POST['estado'];
            $taskId = $_POST['taskId'];
            $observacion = $_POST['observacion'];
            $fechaPosterga = $_POST['fechaPostergacion'];
            $FECHA_POSTERGACION =  convFecSistema($fechaPosterga);

            $FECHA_TOTAL = $_POST['taskFecha'];

            $accionCorrectiva = $_POST['accionCorrectiva'];
            $selectVerificacion = $_POST['selectVerificacion'];
            $selectVB = $_POST['selectVB'];

            $fechadHoy  = $mostrar->c_horaserversql('F');
            // echo "FECHAHOY" . $fechadHoy;
            // echo "FECHATOTAL" . $FECHA_TOTAL;
            // echo "FECHAPOSTERGA" . $FECHA_POSTERGACION;



            if ($FECHA_TOTAL != $fechadHoy) {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alert = $mostrar->actualizarAlertaCheckBox($codigozonaalerta, $estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion, $selectVB);
            } else {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert = $mostrar->actualizarAlertaCheckBox($codigozonaalerta, $estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion, $selectVB);
            }
        } else {
            $codigozonaalerta = trim($_POST['codigozonaalerta']);

            $estado = $_POST['estado'];
            $taskId = $_POST['taskId'];
            $observacionTextArea = $_POST['observacionTextArea'];
            $FECHA_TOTAL = $_POST['taskFecha'];
            $accionCorrectiva = $_POST['accionCorrectiva'];
            $selectVerificacion = $_POST['selectVerificacion'];
            $selectVB = $_POST['selectVB'];

            $fechadHoy  = $mostrar->c_horaserversql('F');
            // $fechaActual = new DateTime();
            // $fechadHoy = $fechaActual->format('d/m/Y');


            if ($FECHA_TOTAL != $fechadHoy) {
                $FECHA_ACTUALIZA = $fechadHoy;

                $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($codigozonaalerta, $estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion, $selectVB);
            } else {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($codigozonaalerta, $estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion, $selectVB);
            }
        }
        $insert2 = $alert->execute();

        if ($insert2) {
            $response = array(
                'success' => true,
                'message' => 'Estado actualizado correctamente'
            );
        } else {
            $response = array(
                'success' => false,
                // 'message' => 'Error al actualizar el estado: ' . $conn->error
            );
        }

        echo json_encode($response);
    }

    static function c_insertar_alertamix()
    {
        $mostrar = new m_almacen();


        $taskNdias = $_POST['taskNdias'];

        if ($taskNdias == 1) {

            if (isset($_POST['fechaPostergacion'])) {

                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);

                $fechaActual = $mostrar->c_horaserversql('F');

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                // $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                // $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $formattedDate, $taskNdias, $POSTERGACION);
                $insert = $mostrar->InsertarAlertaMayor($codigozona, $codInfraestructura, $fechaActual, $formattedDate, $taskNdias, $POSTERGACION);
                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $FECHA_CREACION  = $mostrar->c_horaserversql('F');


                $conversionfecha = strtotime(str_replace('/', '-',  $FECHA_CREACION));
                $fechasumadias = strtotime("+$taskNdias days", $conversionfecha);
                $fechadomingo = date('w', $fechasumadias);

                if ($fechadomingo == 0) {
                    $fechasumadias = strtotime('+1 day', $fechasumadias);
                }
                $FECHA_TOTAL = date("d/m/Y", $fechasumadias);

                $insert = $mostrar->InsertarAlerta($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $taskNdias);
                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        } else if ($taskNdias == 2) {

            if (isset($_POST['fechaPostergacion'])) {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);


                $fechaActual = $mostrar->c_horaserversql('F');

                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                // $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codigozona, $codInfraestructura, $fechaActual, $formattedDate, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $FECHA_CREACION  = $mostrar->c_horaserversql('F');



                $conversionfecha = strtotime(str_replace('/', '-',  $FECHA_CREACION));
                if (date('N', $conversionfecha) == 6) {
                    $timestamp = strtotime('+3 days', $conversionfecha);
                    $FECHA_TOTAL = date("d/m/Y", $timestamp);
                } else {
                    $fechasumadias = strtotime("+$taskNdias days", $conversionfecha);
                    $fechadomingo = date('w', $fechasumadias);

                    if ($fechadomingo == 0) {
                        $fechasumadias = strtotime('+1 day', $fechasumadias);
                    }
                    $FECHA_TOTAL = date("d/m/Y", $fechasumadias);
                }


                $insert = $mostrar->InsertarAlerta($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $taskNdias);
                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        } elseif ($taskNdias == 7) {

            if (isset($_POST['fechaPostergacion'])) {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];
                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);
                $fechaActual = $mostrar->c_horaserversql('F');

                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                // $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codigozona, $codInfraestructura, $fechaActual, $fechaPostergacion, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                // $fechaCreacion = $_POST['fechaCreacion'];
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $FECHA_CREACION  = $mostrar->c_horaserversql('F');
                // $FECHA_CREACION  = '05/11/2023';

                $conversionfecha = strtotime(str_replace('/', '-',  $FECHA_CREACION));
                $fechasumadias = strtotime("+$taskNdias days", $conversionfecha);
                $fechadomingo = date('w', $fechasumadias);

                if ($fechadomingo == 0) {
                    $fechasumadias = strtotime('+1 day', $fechasumadias);
                }
                $FECHA_TOTAL = date("d/m/Y", $fechasumadias);
                $fechamenosdias = strtotime("-2 days", $fechasumadias);
                $FECHA_ACORDAR = date("d/m/Y", $fechamenosdias);

                $insert = $mostrar->InsertarAlertaMayorSinPost($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        } elseif ($taskNdias == 15) {

            if (isset($_POST['fechaPostergacion'])) {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);
                // echo "aqui";
                // echo "FechaPOSTERGACION" . $fechaPostergacion;


                $fechaActual = $mostrar->c_horaserversql('F');


                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                // $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                // echo "FECHASS" . $fechaAcordar;
                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codigozona, $codInfraestructura, $fechaActual, $fechaPostergacion, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $FECHA_CREACION  = $mostrar->c_horaserversql('F');

                $conversionfecha = strtotime(str_replace('/', '-',  $FECHA_CREACION));
                $fechasumadias = strtotime("+$taskNdias days", $conversionfecha);
                $fechadomingo = date('w', $fechasumadias);

                if ($fechadomingo == 0) {
                    $fechasumadias = strtotime('+1 day', $fechasumadias);
                }
                $FECHA_TOTAL = date("d/m/Y", $fechasumadias);
                $fechamenosdias = strtotime("-2 days", $fechasumadias);
                $FECHA_ACORDAR = date("d/m/Y", $fechamenosdias);

                $insert = $mostrar->InsertarAlertaMayorSinPost($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        } elseif ($taskNdias == 30) {

            if (isset($_POST['fechaPostergacion'])) {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);
                // echo "aqui";
                // echo "FechaPOSTERGACION" . $fechaPostergacion;

                $fechaActual = $mostrar->c_horaserversql('F');

                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                // $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                // echo "FECHASS" . $fechaAcordar;
                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codigozona, $codInfraestructura, $fechaActual, $fechaPostergacion, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $codigozona = trim($_POST['codigozona']);
                $codInfraestructura = $_POST['codInfraestructura'];

                $FECHA_CREACION  = $mostrar->c_horaserversql('F');

                $conversionfecha = strtotime(str_replace('/', '-',  $FECHA_CREACION));
                $fechasumadias = strtotime("+$taskNdias days", $conversionfecha);
                $fechadomingo = date('w', $fechasumadias);

                if ($fechadomingo == 0) {
                    $fechasumadias = strtotime('+1 day', $fechasumadias);
                }
                $FECHA_TOTAL = date("d/m/Y", $fechasumadias);
                $fechamenosdias = strtotime("-2 days", $fechasumadias);
                $FECHA_ACORDAR = date("d/m/Y", $fechamenosdias);

                $insert = $mostrar->InsertarAlertaMayorSinPost($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        }
    }

    static function c_fecha_alerta()
    {
        $mostrar = new m_almacen();


        $datos = $mostrar->MostrarAlerta();

        try {
            if (!$datos) {
                $json = "datosno";
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $json = "datossi";
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: ";
        }
    }


    static function c_selectproductos()
    {
        $consulta = new m_almacen();
        $ID_SOLUCIONES = filter_input(INPUT_POST, 'idSolucion');

        $datos = $consulta->MostrarPreparaciones($ID_SOLUCIONES);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en soluciones</option>';
        }
        echo '<option value="0" selected disabled>Seleccione Preparación</option>';
        for ($i = 0; $i < count($datos); $i++) {

            echo '<option value="' . $datos[$i]["ID_PREPARACIONES"] . '">' . $datos[$i]["NOMBRE_PREPARACION"] . '</option>';
        }
    }

    static function c_selectcantidad()
    {
        $consulta = new m_almacen();
        $ID_PREPARACIONES = filter_input(INPUT_POST, 'idPreparacion');

        $datos = $consulta->MostrarCantidades($ID_PREPARACIONES);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en preparaciones</option>';
        }
        echo '<option value="0" selected disabled>Seleccione Cantidad</option>';
        for ($i = 0; $i < count($datos); $i++) {
            echo '<option value="' . $datos[$i]["ID_CANTIDAD"] . '">' . $datos[$i]["CANTIDAD_PORCENTAJE"] . '</option>';
        }
    }

    static function c_selectML()
    {

        $consulta = new m_almacen();
        $ID_CANTIDAD = filter_input(INPUT_POST, 'idCantidad');

        $datos = $consulta->MostrarML($ID_CANTIDAD);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en mililitros</option>';
        }
        echo '<option value="0" selected disabled>Seleccione cantidad ML</option>';
        for ($i = 0; $i < count($datos); $i++) {
            echo '<option value="' . $datos[$i]["ID_ML"] . '">' . $datos[$i]["CANTIDAD_MILILITROS"] . '</option>';
        }
    }
    static function c_selectL()
    {

        $consulta = new m_almacen();
        $ID_L = filter_input(INPUT_POST, 'idMililitros');

        $datos = $consulta->MostrarL($ID_L);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en Litros</option>';
        }
        echo '<option value="0" selected disabled>Seleccione cantidad Litros</option>';
        for ($i = 0; $i < count($datos); $i++) {
            echo '<option value="' . $datos[$i]["ID_LI"] . '">' . $datos[$i]["CANTIDAD_LITROS"] . '</option>';
        }
    }
    // static function c_insertar_litros($litrosadd)
    // {
    //     $mostrar = new m_almacen();
    //     if (isset($litrosadd) ) {

    //         $respuesta = $mostrar->insertarLitros($litrosadd);
    //         if ($respuesta) {

    //             return "ok";
    //         } else {
    //             return "error";
    //         };
    //     }
    // }
    static function c_selectCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion, $valorextra)
    {
        $mostrar = new m_almacen();
        if (isset($selectSolucion) && isset($selectPreparacion)) {

            $respuesta = $mostrar->insertarCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion, $valorextra);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_buscar_preparacion($buscarPrepa)
    {
        try {

            if (!empty($buscarPrepa)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarUnionBusqueda($buscarPrepa);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "ID_UNION" => $row['ID_UNION'],
                        "NOMBRE_INSUMOS" => $row['NOMBRE_INSUMOS'],
                        "NOMBRE_PREPARACION" => $row['NOMBRE_PREPARACION'],
                        "CANTIDAD_PORCENTAJE" => $row['CANTIDAD_PORCENTAJE'],
                        "CANTIDAD_MILILITROS" => $row['CANTIDAD_MILILITROS'],
                        "CANTIDAD_LITROS" => $row['CANTIDAD_LITROS'],
                        "FECHA" =>  convFecSistema($row['FECHA']),
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // $jsonstring = json_encode($datos);
                // echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarUnionBusqueda($buscarPrepa);

                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "ID_UNION" => $row['ID_UNION'],
                        "NOMBRE_INSUMOS" => $row['NOMBRE_INSUMOS'],
                        "NOMBRE_PREPARACION" => $row['NOMBRE_PREPARACION'],
                        "CANTIDAD_PORCENTAJE" => $row['CANTIDAD_PORCENTAJE'],
                        "CANTIDAD_MILILITROS" => $row['CANTIDAD_MILILITROS'],
                        "CANTIDAD_LITROS" => $row['CANTIDAD_LITROS'],
                        "FECHA" =>  convFecSistema($row['FECHA']),

                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // $jsonstring = json_encode($datos);
                // echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }




    static function c_insertar_limpieza($selectZona, $textfrecuencia,  $textAreaObservacion,  $textAreaAccion, $selectVerificacion)
    {
        $mostrar = new m_almacen();
        if (isset($selectZona) && isset($textfrecuencia) && isset($textAreaObservacion) && isset($textAreaAccion) && isset($selectVerificacion)) {

            $respuesta = $mostrar->insertarLimpieza($selectZona, $textfrecuencia,  $textAreaObservacion,  $textAreaAccion, $selectVerificacion);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_editar_limpieza($cod_frecuencia)
    {
        $mostrar = new m_almacen();


        if (isset($cod_frecuencia)) {

            $select = $mostrar->SelectLimpieza($cod_frecuencia);

            $json = array();

            foreach ($select as $row) {
                $json[] = array(
                    "COD_FRECUENCIA" => $row['COD_FRECUENCIA'],
                    "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                    "NOMBRE_FRECUENCIA" => $row['NOMBRE_FRECUENCIA'],

                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    static function c_actualizar_limpieza($codfre, $textfrecuencia)
    {
        $m_formula = new m_almacen();

        if (isset($textfrecuencia) &&  isset($codfre)) {
            $resultado = $m_formula->editarLimpieza($codfre, $textfrecuencia);

            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_buscar_limpieza($buscarLimpieza)
    {
        try {

            if (!empty($buscarLimpieza)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarLimpiezaBusqueda($buscarLimpieza);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_FRECUENCIA" => $row['COD_FRECUENCIA'],
                        "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                        "NOMBRE_FRECUENCIA" => $row['NOMBRE_FRECUENCIA'],
                        "FECHA" =>  convFecSistema($row['FECHA']),
                        "VERSION" => $row['VERSION'],
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarLimpiezaBusqueda($buscarLimpieza);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_FRECUENCIA" => $row['COD_FRECUENCIA'],
                        "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                        "NOMBRE_FRECUENCIA" => $row['NOMBRE_FRECUENCIA'],
                        "FECHA" =>  convFecSistema($row['FECHA']),
                        "VERSION" => $row['VERSION'],
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // $jsonstring = json_encode($datos);
                // echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }



    static function c_buscar_control($buscarcontrol)
    {
        try {

            if (!empty($buscarcontrol)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarControlMaquinasBusqueda($buscarcontrol);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_CONTROL_MAQUINA" => $row->COD_CONTROL_MAQUINA,
                        "NOMBRE_CONTROL_MAQUINA" => $row->NOMBRE_CONTROL_MAQUINA,
                        "N_DIAS_POS" => $row->N_DIAS_POS,
                        "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarControlMaquinasBusqueda($buscarcontrol);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "CODIGO" => $row->CODIGO,
                        "COD_CONTROL_MAQUINA" => $row->COD_CONTROL_MAQUINA,
                        "NOMBRE_CONTROL_MAQUINA" => $row->NOMBRE_CONTROL_MAQUINA,
                        "N_DIAS_POS" => $row->N_DIAS_POS,
                        "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
                        // "OBSERVACION" => $row->OBSERVACION,
                        // "ACCION_CORRECTIVA" => $row->ACCION_CORRECTIVA,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // $jsonstring = json_encode($datos);
                // echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_insertar_control_maquina($nombrecontrolmaquina)
    {
        $mostrar = new m_almacen();
        if (isset($nombrecontrolmaquina)) {

            $respuesta = $mostrar->insertarControlMaquina($nombrecontrolmaquina);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_mostrar_combo_control()
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarControlMaquina();

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_CONTROL_MAQUINA" => $row->COD_CONTROL_MAQUINA,
                    "NOMBRE_CONTROL_MAQUINA" => $row->NOMBRE_CONTROL_MAQUINA,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_insertar_control($nombrecontrol, $ndiascontrol)
    {
        $mostrar = new m_almacen();
        if (isset($nombrecontrol)) {

            $respuesta = $mostrar->insertarControl($nombrecontrol, $ndiascontrol);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_editar_control_maquina($codcontrolmaquina)
    {
        $mostrar = new m_almacen();

        if (isset($codcontrolmaquina)) {

            $select = $mostrar->SelectControlMaquina($codcontrolmaquina);
            $json = array();
            foreach ($select as $row) {
                $json[] = array(
                    "COD_CONTROL_MAQUINA" => $row['COD_CONTROL_MAQUINA'],
                    "NOMBRE_CONTROL_MAQUINA" => $row['NOMBRE_CONTROL_MAQUINA'],
                    "N_DIAS_POS" => $row['N_DIAS_POS']

                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }

    static function c_actualizar_control_maquina($nombrecontrol, $ndiascontrol,  $codcontrol)
    {
        $m_formula = new m_almacen();

        if (isset($codcontrol)) {
            $resultado = $m_formula->editarControlMaquina($nombrecontrol, $ndiascontrol,  $codcontrol);

            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_eliminar_control_maquina($codcontrolmaquina)
    {
        $mostrar = new m_almacen();

        if (isset($codcontrolmaquina)) {

            $resultado = $mostrar->eliminarControlMaquina($codcontrolmaquina);
            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_guardar_control_pdf_diario($valorcapturadocontrol)
    {
        $mostrar = new m_almacen();

        // if (isset($codcontrolmaquina)) {

        $resultado = $mostrar->guardarControlPdfDiario($valorcapturadocontrol);
        if ($resultado) {
            return "ok";
        } else {
            return "error";
        };
        // }
    }
    static function c_fecha_alerta_control()
    {
        $mostrar = new m_almacen();

        $datos = $mostrar->MostrarAlertaControl();
        try {
            if (!$datos) {
                $json = "controlno";
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // throw new Exception("Hubo un error en la consulta");
            } else {
                $json = "controlsi";
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: ";
        }
    }
    static function c_checkbox_confirma_control()
    {
        $mostrar = new m_almacen();

        if ($_POST['fechapostergacioncontrol'] != "") {
            $estado = $_POST['estado'];
            $codigocontrolmaquina = $_POST['codigocontrolmaquina'];
            $taskId = $_POST['taskId'];
            $ndiaspos = $_POST['ndiaspos'];
            $observacion = $_POST['observacionTextArea'];
            $fechaPostergacontrol = $_POST['fechapostergacioncontrol'];
            $FECHA_POSTERGACION =  convFecSistema($fechaPostergacontrol);

            $FECHA_TOTAL = $_POST['taskFecha'];

            $accionCorrectiva = $_POST['accionCorrectiva'];

            $selectVB = $_POST['selectVB'];

            $fechadHoy  = $mostrar->c_horaserversql('F');

            $nombreDia = date('l', strtotime($FECHA_TOTAL));


            if ($nombreDia  != 'Saturday') {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alertif = $mostrar->actualizarAlertaCheckControlPos($codigocontrolmaquina, $ndiaspos, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB);
                // header('Content-Type: application/json');
                if ($alertif) {
                    return "ok";
                    // echo json_encode(['status' => 'ok']);
                } else {
                    return "error";
                    // echo json_encode(['status' => 'error']);
                };
            } elseif ($nombreDia  == 'Saturday') {


                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alertif = $mostrar->actualizarAlertaCheckControlPos($codigocontrolmaquina, $ndiaspos, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB);
                // header('Content-Type: application/json');
                if ($alertif) {
                    return "ok";
                    // echo json_encode(['status' => 'ok']);
                } else {
                    return "error";
                    // echo json_encode(['status' => 'error']);
                };
            }
        } else {
            $estado = $_POST['estado'];

            $codigocontrolmaquina = $_POST['codigocontrolmaquina'];
            $taskId = $_POST['taskId'];
            $ndiaspos = $_POST['ndiaspos'];
            $observacionTextArea = $_POST['observacionTextArea'];
            $FECHA_TOTAL = $_POST['taskFecha'];
            $accionCorrectiva = $_POST['accionCorrectiva'];

            $selectVB = $_POST['selectVB'];

            $nombreDia = date('l', strtotime($FECHA_TOTAL));

            $fechadHoy  = $mostrar->c_horaserversql('F');

            if ($nombreDia != 'Saturday') {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alert = $mostrar->actualizarAlertaControlCheckBox($codigocontrolmaquina, $estado, $ndiaspos, $taskId,  $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB);

                // header('Content-Type: application/json');
                if ($alert) {
                    return "ok";
                    // echo json_encode(['status' => 'ok']);
                } else {
                    return "error";
                    // echo json_encode(['status' => 'error']);
                };
            } elseif ($nombreDia  == 'Saturday') {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert1 = $mostrar->actualizarAlertaControlCheckBox($codigocontrolmaquina, $estado, $ndiaspos, $taskId,  $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB);
                if ($alert1) {
                    return "ok";
                    // echo json_encode(['status' => 'ok']);
                } else {
                    return "error";
                    // echo json_encode(['status' => 'error']);
                };
            }
        }

        // $insert2 = $alert->execute();

        // if ($insert2) {
        //     $response = array(
        //         'success' => true,
        //         'message' => 'Estado actualizado correctamente'
        //     );
        // } else {
        //     $response = array(
        //         'success' => false,
        //         // 'message' => 'Error al actualizar el estado: ' . $conn->error
        //     );
        // }

        // echo json_encode($response);

    }
    static function c_checkbox_confirma_control_pos()
    {
        $mostrar = new m_almacen();

        if (isset($_POST['fechapostergacioncontrol'])) {

            $estado = $_POST['estado'];
            $codigocontrolmaquina = $_POST['codigocontrolmaquina'];
            $taskId = $_POST['taskId'];
            $ndiaspos = $_POST['ndiaspos'];
            $observacion = $_POST['observacionTextArea'];
            $fechaPostergacontrol = $_POST['fechapostergacioncontrol'];
            $FECHA_POSTERGACION =  convFecSistema($fechaPostergacontrol);

            $FECHA_TOTAL = $_POST['taskFecha'];

            $accionCorrectiva = $_POST['accionCorrectiva'];

            $selectVB = $_POST['selectVB'];

            $fechadHoy  = $mostrar->c_horaserversql('F');

            $nombreDia = date('l', strtotime($FECHA_TOTAL));


            if ($nombreDia  != 'Saturday') {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alertif = $mostrar->actualizarAlertaCheckControlPos($codigocontrolmaquina, $ndiaspos, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB);
                // header('Content-Type: application/json');
                if ($alertif) {
                    return "ok";
                    // echo json_encode(['status' => 'ok']);
                } else {
                    return "error";
                    // echo json_encode(['status' => 'error']);
                };
            } elseif ($nombreDia  == 'Saturday') {

                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alertif = $mostrar->actualizarAlertaCheckControlPos($codigocontrolmaquina, $ndiaspos, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB);
                // header('Content-Type: application/json');
                if ($alertif) {
                    return "ok";
                    // echo json_encode(['status' => 'ok']);
                } else {
                    return "error";
                    // echo json_encode(['status' => 'error']);
                };
            }
        }

        // $insert2 = $alert->execute();

        // if ($insert2) {
        //     $response = array(
        //         'success' => true,
        //         'message' => 'Estado actualizado correctamente'
        //     );
        // } else {
        //     $response = array(
        //         'success' => false,
        //         // 'message' => 'Error al actualizar el estado: ' . $conn->error
        //     );
        // }

        // echo json_encode($response);

    }
    static function c_insertar_alertamix_control_maquina()
    {
        $mostrar = new m_almacen();


        $taskNdias = $_POST['taskNdias'];
        if ($taskNdias == 1) {

            // $fechaCreacion = $_POST['fechaCreacion'];
            $codControlMaquina = $_POST['codControlMaquina'];
            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');
            //$fechaTotal = date('Y-m-d', strtotime($fechaCrea . '+' . $taskNdias . ' days'));

            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            // $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            $insert = $mostrar->InsertarAlertaControlMaquina($FECHA_CREACION, $codControlMaquina, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        } else if ($taskNdias == 2) {


            // $fechaCreacion = $_POST['fechaCreacion'];
            $codControlMaquina = $_POST['codControlMaquina'];

            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');
            $FECHA_TOTAL = date('d/m/Y', strtotime($FECHA_TOTAL));


            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            // $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            $insert = $mostrar->InsertarAlertaControlMaquina($FECHA_CREACION, $codControlMaquina, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        } else if ($taskNdias == 7) {


            // $fechaCreacion = $_POST['fechaCreacion'];
            $codControlMaquina = $_POST['codControlMaquina'];

            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');
            $FECHA_TOTAL = date('d/m/Y', strtotime($FECHA_TOTAL));




            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            $insert = $mostrar->InsertarAlertaControlMaquina($FECHA_CREACION, $codControlMaquina, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        } else if ($taskNdias == 15) {


            // $fechaCreacion = $_POST['fechaCreacion'];
            $codControlMaquina = $_POST['codControlMaquina'];

            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');
            $FECHA_TOTAL = date('d/m/Y', strtotime($FECHA_TOTAL));



            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            $insert = $mostrar->InsertarAlertaControlMaquina($FECHA_CREACION, $codControlMaquina, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        } else if ($taskNdias == 30) {


            // $fechaCreacion = $_POST['fechaCreacion'];
            $codControlMaquina = $_POST['codControlMaquina'];

            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');
            $FECHA_TOTAL = date('d/m/Y', strtotime($FECHA_TOTAL));



            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            $insert = $mostrar->InsertarAlertaControlMaquina($FECHA_CREACION, $codControlMaquina, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        }
    }

    static function c_buscar_zona_combo($term)
    {
        $m_formula = new m_almacen();

        $respuesta = $m_formula->MostrarZonaCombo($term);

        echo json_encode($respuesta);
    }


    static function c_insertar_labsabell($codigolabsabell, $valorSeleccionado)
    {
        $m_formula = new m_almacen();

        if (isset($codigolabsabell) && isset($valorSeleccionado)) {
            $respuesta = $m_formula->InsertarLabsabell($codigolabsabell, $valorSeleccionado);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_buscar_labsabell($buscarlab)
    {
        try {

            if (!empty($buscarlab)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarEnvasesLabsabel($buscarlab);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "ABR_PRODUCTO" => $row->ABR_PRODUCTO,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarEnvasesLabsabel($buscarlab);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "ABR_PRODUCTO" => $row->ABR_PRODUCTO,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // $jsonstring = json_encode($datos);
                // echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_editar_envases_labsabel($cod_producto_envase)
    {
        $mostrar = new m_almacen();

        if (isset($cod_producto_envase)) {
            $selectZ = $mostrar->SelectEnvasesLabsabell($cod_producto_envase);

            $json = array();
            foreach ($selectZ as $row) {
                $json[] = array(
                    "COD_PRODUCTO_ENVASE" => $row['COD_PRODUCTO_ENVASE'],
                    "DES_PRODUCTO" => $row['DES_PRODUCTO'],
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    static function c_actualizar_envases_labsabell($codlab, $codigolab)
    {
        $m_formula = new m_almacen();
        if (isset($codlab) && isset($codigolab)) {

            $respuesta = $m_formula->editarEnvasesLabsabell($codlab, $codigolab);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_eliminar_envases_labsabell($codenvaselabsabell)
    {
        $mostrar = new m_almacen();

        if (isset($codenvaselabsabell)) {

            $resultado = $mostrar->eliminarEnvasesLabsabel($codenvaselabsabell);
            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }









    static function c_buscar_producto_combo_insumos_lab($term)
    {
        $m_formula = new m_almacen();

        $respuesta = $m_formula->MostrarProductoComboInsumosLab($term);
        echo json_encode($respuesta);
    }
    static function c_insertar_insumos_lab($codigoInsumosLab, $valorSeleccionado)
    {
        $m_formula = new m_almacen();

        if (isset($codigoInsumosLab) && isset($valorSeleccionado)) {
            $respuesta = $m_formula->InsertarInsumoslab($codigoInsumosLab, $valorSeleccionado);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function   c_buscar_insumos_lab($buscarInsumos)
    {
        try {

            if (!empty($buscarInsumos)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarInsumosLab($buscarInsumos);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_PORDUCTO_INSUMOS" => $row->COD_PRODUCTO_INSUMOS,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "ABR_PRODUCTO" => $row->ABR_PRODUCTO,
                        "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
                        "VERSION" => $row->VERSION,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarInsumosLab($buscarInsumos);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_PORDUCTO_INSUMOS" => $row->COD_PRODUCTO_INSUMOS,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "ABR_PRODUCTO" => $row->ABR_PRODUCTO,
                        "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
                        "VERSION" => $row->VERSION,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_editar_insumos_lab($cod_insumos_lab)
    {
        $mostrar = new m_almacen();

        if (isset($cod_insumos_lab)) {
            $selectZ = $mostrar->SelectInsumosLab($cod_insumos_lab);

            $json = array();
            foreach ($selectZ as $row) {
                $json[] = array(
                    "COD_PRODUCTO_INSUMOS" => $row['COD_PRODUCTO_INSUMOS'],
                    "DES_PRODUCTO" => $row['DES_PRODUCTO'],
                    "ABR_PRODUCTO" => $row['ABR_PRODUCTO'],
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    static function c_actualizar_insumos_lab($codInsu, $codigoInsumo)
    {

        $m_formula = new m_almacen();

        if (isset($codInsu) && isset($codigoInsumo)) {

            $respuesta = $m_formula->editarInsumoLab($codInsu, $codigoInsumo);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_eliminar_insumos_lab($codinsumoslab)
    {
        $mostrar = new m_almacen();

        if (isset($codinsumoslab)) {

            $resultado = $mostrar->eliminarInsumosLab($codinsumoslab);
            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }









    static function c_insertar_producto_combo($selectProductoCombo, $cantidadTotal, $dataInsumo, $dataEnvase)
    {
        $m_formula = new m_almacen();

        if (isset($selectProductoCombo) && isset($cantidadTotal) && isset($dataInsumo) && isset($dataEnvase)) {
            $respuesta = $m_formula->InsertarProductoCombo($selectProductoCombo, $cantidadTotal, $dataInsumo, $dataEnvase);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_buscar_producto_envase()
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarProductoEnvase();

            if ($datos) {
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CAN_FORMULACION" => $row->CAN_FORMULACION,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                echo "No hay datos";
            }
        } catch (Exception $e) {
            echo "[]";
        }
    }







    static function c_select_productos_produccion()
    {
        $consulta = new m_almacen();
        $COD_PRODUCTO = filter_input(INPUT_POST, 'codProducto');

        $datos = $consulta->MostrarProduccion($COD_PRODUCTO);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en soluciones</option>';
        }
        echo '<option value="0" selected disabled>Seleccione produccion</option>';
        for ($i = 0; $i < count($datos); $i++) {

            echo '<option value="' . $datos[$i]["COD_PRODUCCION"] . '">' . $datos[$i]["N_PRODUCCION_G"] . '</option>';
        }
    }












    static function c_insertar_requerimiento_producto($selectProductoCombo, $cantidadProducto)
    {
        $m_formula = new m_almacen();

        if (isset($selectProductoCombo) && isset($cantidadProducto)) {
            $respuesta = $m_formula->InsertarRequerimientoProducto($selectProductoCombo, $cantidadProducto);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_buscar_requerimiento_producto($buscarrequerimiento)
    {
        try {

            if (!empty($buscarrequerimiento)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarRequermientoProducto($buscarrequerimiento);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD" => $row->CANTIDAD,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarRequermientoProducto($buscarrequerimiento);
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD" => $row->CANTIDAD,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }





    static function c_vista_producto_formulacion($selectinsumoenvase)
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->VerificarProductoFormula($selectinsumoenvase);
            if ($datos) {
                echo 'ok';
            } else {
                echo "error";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_mostrar_insumo($selectinsumoenvase, $cantidadinsumoenvase)
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarDatosInsumos($selectinsumoenvase);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $calculoInsumo = ($row->CAN_FORMULACION_INSUMOS * $cantidadinsumoenvase) / $row->CAN_FORMULACION;

                $total = round($calculoInsumo, 3);
                $json[] = array(
                    "COD_FORMULACION" => $row->COD_FORMULACION,
                    "DES_PRODUCTO_FORMULACION" => $row->DES_PRODUCTO_FORMULACION,
                    "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CAN_FORMULACION_INSUMOS" => $row->CAN_FORMULACION_INSUMOS,
                    "TOTAL" => $total,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_envase($seleccionadoinsumoenvases, $cantidadesinsumoenvases, $cantidadkg)
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarDatosEnvases($seleccionadoinsumoenvases);
            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                // $calculo = ($row->CANTIDA * $cantidadesinsumoenvases) / $row->CAN_FORMULACION;
                // $total = ceil($calculo);
                if (trim($row->COD_PRODUCTO) == '00161') {
                    $total = ceil($cantidadesinsumoenvases / $row->CANTIDA);
                } else if (trim($row->COD_PRODUCTO) == '00061') {
                    $total = ceil($cantidadkg / 30);
                } else {
                    $total = $cantidadesinsumoenvases;
                }
                // $total =  bcdiv($calculo, '1', 3);
                $json[] = array(
                    "COD_FORMULACIONES" => $row->COD_FORMULACIONES,
                    "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "TOTAL_ENVASE" => $total,
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }



    static function c_guardar_InsumoEnvase($codpersonal, $union, $unionEnvase, $unionItem)
    {
        $m_formula = new m_almacen();

        if (isset($union) && isset($unionEnvase) && isset($unionItem)) {
            $respuesta = $m_formula->InsertarInsumEnvas($codpersonal, $union, $unionEnvase, $unionItem);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }










    static function c_buscar_pendientes_requerimiento($buscarpendiente)
    {
        try {

            if (!empty($buscarpendiente)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarPendientesRequerimientos($buscarpendiente);

                if (!$datos) {
                    throw new Exception("Error");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                        "CANTIDAD" => $row->CANTIDAD,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarPendientesRequerimientos($buscarpendiente);

                if (!$datos) {
                    return "error";
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                        "CANTIDAD" => $row->CANTIDAD,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_si_hay_compra($cod_formulacion)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarSiCompra($cod_formulacion);

            if (!$datos) {
                // throw new Exception("Hubo un error en la consulta");
                $json = array();
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
            $json = array();
            foreach ($datos as $row) {

                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,
                    "STOCK_ACTUAL" => $row->STOCK_ACTUAL,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
            // $agrupados = array();

            // foreach ($datos as $row) {
            //     $codigo_producto = trim($row->COD_PRODUCTO);

            //     // Verificar si el grupo ya existe
            //     if (!isset($agrupados[$codigo_producto])) {
            //         $agrupados[$codigo_producto] = array(
            //             "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
            //             "COD_PRODUCTO" => $codigo_producto,
            //             "DES_PRODUCTO" => $row->DES_PRODUCTO,
            //             "CANTIDAD" => $row->CANTIDAD,
            //             "STOCK_ACTUAL" => $row->STOCK_ACTUAL,
            //             "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
            //             "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
            //             "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
            //         );
            //     } else {
            //         // Si el grupo ya existe, comparar precios y actualizar si es menor
            //         if ($row->PRECIO_PRODUCTO < $agrupados[$codigo_producto]["PRECIO_PRODUCTO"]) {
            //             $agrupados[$codigo_producto]["PRECIO_PRODUCTO"] = $row->PRECIO_PRODUCTO;
            //             $agrupados[$codigo_producto]["COD_PROVEEDOR"] = $row->COD_PROVEEDOR;
            //         }
            //     }
            // }

            // // Convertir el array agrupado a formato JSON
            // $json = array_values($agrupados); // Reindexar el array para evitar claves no numéricas
            // $jsonstring = json_encode($json);
            // echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_insertar_orden_compra_item($union, $dataimagenesfile, $codigoproveedorimagenes, $idRequerimiento, $codpersonal)
    {
        $m_formula = new m_almacen();

        if (isset($idRequerimiento)) {
            $respuestaordenc = $m_formula->InsertarOrdenCompraItem($union, $dataimagenesfile, $codigoproveedorimagenes, $idRequerimiento, $codpersonal);
            if ($respuestaordenc) {
                echo "ok";
            } else {
                echo "error";
            };
        }
    }
    static function c_insertar_orden_compra_item_sinimagen($union, $idRequerimiento,  $codpersonal)
    {
        $m_formula = new m_almacen();

        if (isset($idRequerimiento)) {
            $respuestasin = $m_formula->InsertarOrdenCompraItemSinImagen($union, $idRequerimiento, $codpersonal);
            if ($respuestasin) {
                echo "ok";
            } else {
                echo "error";
            };
        }
    }

    static function c_actualizar_orden_compra_item($idRequerimiento)
    {
        $m_formula = new m_almacen();

        if (isset($idRequerimiento)) {
            $respuesta = $m_formula->ActualizarOrdenCompraItem($idRequerimiento);

            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_insertar_orden_compra_temp($idRequerimiento, $valorcapturado)
    {
        $m_formula = new m_almacen();
        $respuestaorde = $m_formula->InsertarOrdenCompraTemp($idRequerimiento, $valorcapturado);
        if ($respuestaorde) {
            return "ok";
        } else {
            return "error";
        };
    }

    static function c_insertar_cantidad_minima($selectCantidadminima, $cantidadMinima)
    {
        $m_formula = new m_almacen();

        if (isset($selectCantidadminima) && isset($cantidadMinima)) {
            $respuesta = $m_formula->InsertarCantidadMinima($selectCantidadminima, $cantidadMinima);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function  c_buscar_cantidad_minima($buscarcantidadminimasearch)
    {
        try {

            if (!empty($buscarcantidadminimasearch)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarCantidadMinima($buscarcantidadminimasearch);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_CANTIDAD_MINIMA" => $row->COD_CANTIDAD_MINIMA,
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "ABR_PRODUCTO" => $row->ABR_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                        "ESTADO" => $row->ESTADO,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarCantidadMinima($buscarcantidadminimasearch);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_CANTIDAD_MINIMA" => $row->COD_CANTIDAD_MINIMA,
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                        "ESTADO" => $row->ESTADO,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_editar_cantidad_minima($cod_mini)
    {
        $mostrar = new m_almacen();

        if (isset($cod_mini)) {
            $selectZ = $mostrar->SelectCantidadMinima($cod_mini);

            $json = array();
            foreach ($selectZ as $row) {
                $json[] = array(
                    "COD_CANTIDAD_MINIMA" => $row['COD_CANTIDAD_MINIMA'],
                    "DES_PRODUCTO" => $row['DES_PRODUCTO'],
                    "COD_PRODUCTO" => $row['COD_PRODUCTO'],
                    "CANTIDAD_MINIMA" => $row['CANTIDAD_MINIMA'],
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    static function c_actualizar_cantidades_minima($codminimo, $selectCantidadminima, $cantidadMinima)
    {
        $m_formula = new m_almacen();

        if (isset($codminimo) && isset($selectCantidadminima) && isset($cantidadMinima)) {

            $respuesta = $m_formula->EditarCantidadMinima($codminimo, $selectCantidadminima, $cantidadMinima);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
    static function c_eliminar_cantidad_minima($cod_cantidad_min)
    {
        $mostrar = new m_almacen();

        if (isset($cod_cantidad_min)) {
            $respuesta = $mostrar->eliminarCantidadMinima($cod_cantidad_min);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }















    static function c_mostrar_calculo_registro_envases($seleccionarproductoregistro, $cantidad)
    {
        try {


            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarCalculoRegistroEnvase($seleccionarproductoregistro);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }

            $json = array();
            foreach ($datos as $row) {
                $calculo = ($row->CANTIDA * $cantidad) / $row->CAN_FORMULACION;
                // $total = round($calculo, 3);
                $total =  bcdiv($calculo, '1', 3);

                $json[] = array(
                    "COD_FORMULACIONES" => $row->COD_FORMULACIONES,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "TOTAL_ENVASE" => $total,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function  c_mostrar_total_pendientes_requeridos()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarTotalPendientesRequeridos();

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "CANTIDAD" => $row->CANTIDAD,
                    "FECHA" => convFecSistema($row->FECHA),
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_segun_codformulacion($cod_formulacion)
    {
        try {


            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarSegunCodFormulacion($cod_formulacion);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,
                    "ESTADO" => $row->ESTADO,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_producto_por_requerimiento($cod_formulacion)
    {
        try {


            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarProductoPorRequerimiento($cod_formulacion);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_producto_por_insumo_requerimiento($cod_formulacion)
    {
        try {


            $mostrar = new m_almacen();
            // $datos = $mostrar->MostrarProductoInsumoPorRequerimiento($cod_formulacion);
            $datos = $mostrar->MostrarSiCompra($cod_formulacion);
            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    // "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    // "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    // "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    // "CANTIDAD" => $row->CANTIDAD,
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,
                    "STOCK_ACTUAL" => $row->STOCK_ACTUAL,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_producccion_por_requerimiento()
    {
        try {


            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarProduccionRequerimiento();

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_insertar_produccion_total($codpersonal, $codrequerimientoproduccion, $codproductoproduccion, $numeroproduccion, $cantidadtotalproduccion, $fechainicio, $fechavencimiento,  $textAreaObservacion, $cantidadcaja)
    {
        $m_formula = new m_almacen();

        if (isset($codrequerimientoproduccion) && isset($codproductoproduccion) && isset($numeroproduccion) && isset($cantidadtotalproduccion) && isset($fechainicio) && isset($cantidadcaja)) {
            $respuesta = $m_formula->InsertarProduccionTotalRequerimiento($codpersonal, $codrequerimientoproduccion, $codproductoproduccion, $numeroproduccion, $cantidadtotalproduccion, $fechainicio, $fechavencimiento,  $textAreaObservacion, $cantidadcaja);

            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function  c_rechazar_pendiente_requerimiento($cod_requerimiento_pedido, $codpersonal)
    {
        $mostrar = new m_almacen();

        if (isset($cod_requerimiento_pedido)) {
            $respuesta = $mostrar->RechazarPendienteRequerimiento($cod_requerimiento_pedido, $codpersonal);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_consultar_cantidad_produccion($codigoproducto, $codigoproduccion, $cantidadinsumo, $cantidadenvase)
    {
        try {

            $mostrar = new m_almacen();

            // $datos = $mostrar->ConsultarCantidadProduccion($codigoproducto, $codigoproduccion, $cantidadinsumo);
            $cantidadproduccionkg = $mostrar->ValorProduccionCantidad($codigoproducto, $codigoproduccion);
            // var_dump($cantidadproduccionkg['CANTIDAD_PRODUCIDA']);
            // var_dump($cantidadinsumo);
            // exit();
            $valorunicoproduccion = $cantidadproduccionkg['CANTIDAD_PRODUCIDA'];
            if ($cantidadinsumo > $cantidadproduccionkg['CANTIDAD_PRODUCIDA']) {

                // $json = "estado1";
                // $jsonstring = json_encode($json);
                // echo $jsonstring;
                $response = array('estado' => 'estado1', 'valorunicoproduccion' => $valorunicoproduccion, 'cantidad' => $cantidadinsumo);
                echo json_encode($response);
                exit;
            } elseif ($cantidadinsumo <= $cantidadproduccionkg['CANTIDAD_PRODUCIDA']) {
                $envases = $mostrar->ValoresEnvases($codigoproducto);
                $insumos = $mostrar->ValoresInsumos($codigoproducto);
                // $stock=$mostrar->MostrarAlmaceninsumos($codigoproducto);

                $json = array();
                $errores = [];
                foreach ($envases as $row) {

                    $dataalmacen = $mostrar->MostrarAlmaceninsumos(trim($row->COD_PRODUCTO));
                    // var_dump($dataalmacen);
                    $valor_numerico = floatval($dataalmacen["STOCK_ACTUAL"]);
                    // var_dump($row->COD_PRODUCTO);
                    // var_dump($valor_numerico);

                    if (trim($row->COD_PRODUCTO) == "00161") {
                        $CANTIDAD_TOTAL = ceil($cantidadenvase / $row->CANTIDA);
                    } else if (trim($row->COD_PRODUCTO) == '00061') {
                        $CANTIDAD_TOTAL = ceil($cantidadinsumo / 30);
                    } else {
                        $CANTIDAD_TOTAL = $cantidadenvase;
                    }
                    // echo "h";
                    // var_dump($CANTIDAD_TOTAL);
                    $valor_envase = floatval($CANTIDAD_TOTAL);
                    if ($valor_envase > $valor_numerico) {
                        // $json = "estado2";
                        // $jsonstring = json_encode($json);
                        // echo $jsonstring;
                        $responseenvase = array('estado' => 'estado2', 'descripcionenvase' => $row->DES_PRODUCTO, 'cantidadenvase' => $CANTIDAD_TOTAL);
                        echo json_encode($responseenvase);
                        exit;
                    } else {
                        $json[] = array(

                            "COD_COD_FORMULACION" => $row->COD_FORMULACION,
                            "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                            "DES_PRODUCTO" => $row->DES_PRODUCTO,
                            // $CANTIDAD_TOTAL = ceil(($row->CANTIDA * $cantidadenvase) / $row->CANTIDAD_FORMULACION),
                            "CANTIDAD_TOTAL" => $CANTIDAD_TOTAL,
                            "LOTES" => c_almacen::c_producto_lote($row->COD_PRODUCTO, $CANTIDAD_TOTAL),
                        );
                    }
                }
                // $jsonstring = json_encode($json);
                // echo $jsonstring;

                $jsoninsumo = array();
                foreach ($insumos as $row) {

                    $dataalmacen = $mostrar->MostrarAlmaceninsumos(trim($row->COD_PRODUCTO));
                    $valor_numerico = floatval($dataalmacen["STOCK_ACTUAL"]);

                    $resultado = (($row->CAN_FORMULACION * $cantidadinsumo) / $row->CANTIDAD_FORMULACION);
                    $CANTIDAD_TOTAL = number_format($resultado, 3);

                    if ($CANTIDAD_TOTAL > $valor_numerico) {
                        // $jsoninsumo = "estado3";
                        // $jsonstring = json_encode($jsoninsumo);
                        // echo $jsonstring
                        $responseinsumo = array('estado' => 'estado3', 'descripcioninsumo' => $row->DES_PRODUCTO, 'cantidaddeinsumo' => $CANTIDAD_TOTAL);
                        echo json_encode($responseinsumo);
                        exit;
                    } else {
                        $jsoninsumo[] = array(

                            "COD_COD_FORMULACION" => $row->COD_FORMULACION,
                            "COD_PRODUCTO" => $row->COD_PRODUCTO,
                            "DES_PRODUCTO" => $row->DES_PRODUCTO,
                            "CANTIDAD_TOTAL" => $CANTIDAD_TOTAL,
                            "LOTES" => c_almacen::c_producto_lote($row->COD_PRODUCTO, $CANTIDAD_TOTAL),
                        );
                    }
                }
                // $jsonstring = json_encode($json);
                // echo $jsonstring;
                $datos = array(
                    'json1' => $json,
                    'json2' => $jsoninsumo
                );

                // Convierte el arreglo a JSON
                $datos_json = json_encode($datos);
                echo $datos_json;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    static function c_mostrar_envases_por_produccion($codigoproducto, $codigoproduccion, $cantidadenvase, $cantidadinsumo)
    {
        try {

            $mostrar = new m_almacen();

            $datos = $mostrar->MostrarEnvasesPorProduccion($codigoproducto, $codigoproduccion, $cantidadenvase, $cantidadinsumo);


            if ($datos['tipoe'] == 0) {

                $json = array();
                foreach ($datos['respuestae'] as $row) {
                    // $dataalmacen = $mostrar->MostrarAlmaceninsumos(trim($row->COD_PRODUCTO));
                    // $valor_numerico = floatval($dataalmacen);
                    if (trim($row->COD_PRODUCTO) == "00161") {
                        $CANTIDAD_TOTAL = ceil($cantidadenvase / $row->CANTIDA);
                    } else if (trim($row->COD_PRODUCTO) == '00061') {
                        $CANTIDAD_TOTAL = ceil($cantidadinsumo / 30);
                    } else {
                        $CANTIDAD_TOTAL = $cantidadenvase;
                    }
                    $valor_envase = floatval($CANTIDAD_TOTAL);
                    // var_dump($valor_numerico);

                    // if ($valor_numerico >= $valor_envase) {
                    $json['respuestae'][] = array(

                        "COD_COD_FORMULACION" => $row->COD_FORMULACION,
                        "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        // $CANTIDAD_TOTAL = ceil(($row->CANTIDA * $cantidadenvase) / $row->CANTIDAD_FORMULACION),
                        "CANTIDAD_TOTAL" => $CANTIDAD_TOTAL,
                        "LOTES" => c_almacen::c_producto_lote($row->COD_PRODUCTO, $CANTIDAD_TOTAL),
                    );

                    // }
                    // else {
                    //     $json = "controlno";
                    //     $jsonstring = json_encode($json);
                    //     echo $jsonstring;
                    // }
                }
                $json['tipoe'] = 0;
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $json = array();
                foreach ($datos['respuestae'] as $row) {
                    $json['respuestae'] = array(
                        "COD_PRODUCCION" => $row->COD_PRODUCCION,
                        "CANTIDAD_PRODUCIDA" => $row->CANTIDAD_PRODUCIDA,
                        "VALOR_KG" => $row->VALOR_KG,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,

                    );
                }
                $json['tipoe'] = 1;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function  c_mostrar_insumos_totales_avance($codigoproducto, $codigoproduccion, $cantidadenvase, $cantidadinsumo)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarInsumosTotalesAvance($codigoproducto, $codigoproduccion, $cantidadinsumo);

            if ($datos['tipo'] == 0) {
                $json = array();
                foreach ($datos['respuesta'] as $row) {
                    $json['respuesta'][] = array(
                        "COD_COD_FORMULACION" => $row->COD_FORMULACION,
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,

                        $resultado = (($row->CAN_FORMULACION * $cantidadinsumo) / $row->CANTIDAD_FORMULACION),
                        $CANTIDAD_TOTAL = number_format($resultado, 3),
                        "CANTIDAD_TOTAL" => $CANTIDAD_TOTAL,
                        "LOTES" => c_almacen::c_producto_lote($row->COD_PRODUCTO, $CANTIDAD_TOTAL),
                    );
                }
                $json['tipo'] = 0;
            } else {
                $json = array();
                foreach ($datos['respuesta'] as $row) {
                    $json['respuesta'] = array(
                        // "COD_PRODUCCION" => $row->COD_PRODUCCION,
                        // "CANTIDAD_PRODUCIDA" => $row->CANTIDAD_PRODUCIDA,
                        // "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "COD_PRODUCCION" => $row->COD_PRODUCCION,
                        "CANTIDAD_PRODUCIDA" => $row->CANTIDAD_PRODUCIDA,
                        "VALOR_KG" => $row->VALOR_KG,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    );
                }
                $json['tipo'] = 1;
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {


            echo "Error: " . $e->getMessage();
        }
    }


    static function c_guardar_valor_insumo_registro($valoresCapturadosProduccion, $valoresCapturadosProduccioninsumo, $codigoproducto, $codigoproduccion, $cantidad, $cantidadtotalenvases, $codpersonal, $codoperario)
    {
        $m_formula = new m_almacen();

        if (isset($valoresCapturadosProduccion) && isset($codigoproducto) && isset($codigoproduccion) && isset($cantidad)) {
            if (c_almacen::m_verificarstock($valoresCapturadosProduccion) == 0) {
                return "Error stock insuficiente de plasticos";
            }

            if (c_almacen::m_verificarstock($valoresCapturadosProduccioninsumo) == 0) {
                return "Error stock insuficiente de insumos";
            }

            $respuesta = $m_formula->InsertarValorInsumoRegistro($valoresCapturadosProduccion, $valoresCapturadosProduccioninsumo, $codigoproducto, $codigoproduccion, $cantidad, $cantidadtotalenvases, $codpersonal, $codoperario);


            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_verifica_registro_menor_producto($idrequerimiento, $codigoproductoverifica)
    {

        $mostrar = new m_almacen();

        // if (isset($codigoproductoverifica)) {
        $respuesta = $mostrar->VerificarRegistroMenorProducto($idrequerimiento, $codigoproductoverifica);


        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
        // }
    }



    static function c_mostrar_orden_de_compra()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarOrdenDeCompra();

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "FECHA" => convFecSistema($row->FECHA),
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_mirar_orden_compra($idcodordencompra)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MirarOrdenCompra($idcodordencompra);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD_INSUMO_ENVASE" => $row->CANTIDAD_INSUMO_ENVASE,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_aprobar_orden_compra($idcodordencompra, $codigopersonal)
    {
        $m_formula = new m_almacen();


        $respuesta = $m_formula->AprobarOrdenCompra($idcodordencompra, $codigopersonal);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }

    static function c_mostrar_orden_compra_alerta()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarOrdenDeCompraAlerta();

            if (!$datos) {
                $json = array();
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $json = array();

                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                        "COD_REQUERIMIENTOTEMP" => trim($row->COD_REQUERIMIENTOTEMP),
                        "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                        "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                        "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                        "ABR_PRODUCTO" => trim($row->ABR_PRODUCTO),
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD_INSUMO_ENVASE" => $row->CANTIDAD_INSUMO_ENVASE,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }






    static function c_mostrar_produccion_producto($idp)
    {
        $consulta = new m_almacen();
        $ID_PRODUCTO_COMBO = filter_input(INPUT_POST, 'idProductoCombo');

        $datos = $consulta->MostrarProduccionProductoEnvase($ID_PRODUCTO_COMBO, $idp);

        if (count($datos) == 0) {
            echo '<option value="0">No hay registros en produccion</option>';
        }
        echo '<option value="none" selected disabled>Seleccione produccion</option>';
        for ($i = 0; $i < count($datos); $i++) {

            echo '<option value="' . $datos[$i]["COD_PRODUCCION"] . '">' . $datos[$i]["NUM_PRODUCION_LOTE"] . " " . $datos[$i]["FEC_GENERADO"] . '</option>';
        }
    }


    static function c_actualizar_combo_produccion_producto()
    {
        try {

            $mostrar = new m_almacen();

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarProductoRegistroEnvase();
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row['COD_REQUERIMIENTO'],
                    "COD_PRODUCTO" => $row['COD_PRODUCTO'],
                    "DES_PRODUCTO" => $row['DES_PRODUCTO'],
                    "ABR_PRODUCTO" => $row['ABR_PRODUCTO'],

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }




    static function c_mostrar_orden_compra_aprobada($codigopersonalsmp2, $oficinasmp2)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarOrdenDeCompraAprobada();

            require_once("./m_consulta_personal.php");
            $mostrarpersonal = new m_almacen_consulta($oficinasmp2);


            $datospersonal = $mostrarpersonal->MostrarNomPersonal($codigopersonalsmp2);
            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {

                $item = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_REQUERIMIENTO" => trim($row->COD_REQUERIMIENTO),
                    "FECHA" => convFecSistema($row->FECHA),
                );

                if (count($datospersonal) == 1) {
                    $row = $datospersonal[0];
                    $item["NOM_PERSONAL1"] = $row->NOM_PERSONAL1;
                }

                $json[] = $item;
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_mostrar_lista_proveedores($id)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarProveedoresId($id);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                    "DIR_PROVEEDOR" => $row->DIR_PROVEEDOR,
                    "RUC_PROVEEDOR" => $row->RUC_PROVEEDOR,
                    "DNI_PROVEEDOR" => $row->DNI_PROVEEDOR,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_mostrar_insumos_compras($idcompraaprobada)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarInsumosCompras($idcompraaprobada);


            if (!$datos) {
                // throw new Exception("Hubo un error en la consulta");
                $json = [];
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "STOCK_ACTUAL" => $row->STOCK_ACTUAL,
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_mostrar_proveedores_por_producto($codigoProducto)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarProveedoresPorProducto($codigoProducto);


            if (!$datos) {
                // throw new Exception("Hubo un error en la consulta");
                $json = [];
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_CANTIDAD_MINIMA" => $row->COD_CANTIDAD_MINIMA,
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                    "RUC_PROVEEDOR" => $row->RUC_PROVEEDOR,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_mostrar_precios_por_cantidad($codproducto, $cantidad, $codProveedor)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarPrecioPorCantidad($codproducto, $codProveedor);

            if (!$datos) {

                // throw new Exception("Hubo un error en la consulta");
                $json = array();
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
            $json = array();
            foreach ($datos as $row) {
                // $totalprecio = $row->PRECIO_PRODUCTO;
                $divi = ($cantidad / $row->CANTIDAD_MINIMA);

                $totalprecio = $divi * $row->PRECIO_PRODUCTO;

                $json[] = array(
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => trim($row->DES_PRODUCTO),
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                    "PRECIO_TOTAL" => $totalprecio,
                    "TIPO_MONEDA" => $row->TIPO_MONEDA,
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_guardar_insumos_compras_imagen($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada, $dataimagenesfile)
    {
        $m_formula = new m_almacen();

        $respuesta = $m_formula->GuardarInsumosComprasImagen($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada, $dataimagenesfile);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }
    static function c_guardar_insumos_compras($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada)
    {
        $m_formula = new m_almacen();
        $respuesta = $m_formula->GuardarInsumosCompras($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada);
        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }
    static function c_generar_reporte_orden_compra($idrequerimientotemp)
    {
        try {

            $mostrar = new m_almacen();
            $cab = $mostrar->MostrarReporteOrdenCompra($idrequerimientotemp);
            for ($i = 0; $i < count($cab); $i++) {
                $item = $mostrar->MostrarFacturaItemPDF($cab[$i][0]);
                $valor = $mostrar->MostrarImagenFactura($cab[$i][0]);

                $imagen = [];
                for ($j = 0; $j < count($valor); $j++) {
                    $imagen[] =  base64_encode($valor[$j][2]);
                }

                if (isset($imagen)) {
                    $vg = $imagen;
                } else {
                    $vg = '';
                }
                // var_dump($codigo);
                // var_dump($cab[$i][0]);

                //$imagen = !empty($valor) && isset($valor[$i]["IMAGEN"]) ? base64_encode($valor[$i]["IMAGEN"]) : "";
                $cab[$i][6] = $vg;
                $cab[$i][7] = count($cab);
                array_push($cab[$i], $item);
            }
            $dato = array(
                'd' => $cab,
                // 'c' => count($cab),
            );

            echo json_encode($dato, JSON_FORCE_OBJECT);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_generar_reporte_orden_compra_pdf($idrequerimientotemp)
    {
        try {

            $mostrar = new m_almacen();
            $cabecera = $mostrar->MostrarReporteOrdenCompraPDF($idrequerimientotemp);

            for ($i = 0; $i < count($cabecera); $i++) {
                $cabecera[$i][3] = trim($cabecera[$i][3]);
                $cabecera[$i][2] = convFecSistema($cabecera[$i][2]);
                $item = $mostrar->MostrarFacturaItemTempPDF($cabecera[$i][0]);
                // $valor = $mostrar->MostrarImagenFactura($cabecera[$i][0]);

                // $imagen = [];
                // for ($j = 0; $j < count($valor); $j++) {
                //     $imagen[] =  base64_encode($valor[$j][2]);
                // }

                // if (isset($imagen)) {
                //     $vg = $imagen;
                // } else {
                //     $vg = '';
                // }
                // var_dump($codigo);
                // var_dump($cab[$i][0]);

                // $imagen = !empty($valor) && isset($valor[$i]["IMAGEN"]) ? base64_encode($valor[$i]["IMAGEN"]) : "";
                // $cab[$i][8] = $vg;
                // $cab[$i][7] = count($cab);
                array_push($cabecera[$i], $item);
            }
            $dato = array(
                'cabecera' => $cabecera,
                // 'c' => count($cab),
            );
            var_dump($dato);
            echo json_encode($dato, JSON_FORCE_OBJECT);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }



    static function c_mostrar_compra_comprobante()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarCompraComprobante();

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_TMPCOMPROBANTE" => $row->COD_TMPCOMPROBANTE,
                    "FECHA_REALIZADA" => convFecSistema($row->FECHA_REALIZADA),
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                    "NOMBRE" => $row->NOMBRE,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_poner_comprobantefactura($codigoComprobante, $codigopersonalsmp2, $oficinasmp2)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarValoresOrdenfactura($codigoComprobante);

            require_once("./m_consulta_personal.php");
            $mostrarpersonal = new m_almacen_consulta($oficinasmp2);

            $datospersonal = $mostrarpersonal->MostrarNomPersonal($codigopersonalsmp2);


            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $item = array(
                    "COD_EMPRESA" => $row->COD_EMPRESA,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                    "F_PAGO" => $row->F_PAGO,
                    "TIPO_MONEDA" => $row->TIPO_MONEDA,
                    "OBSERVACION" => $row->OBSERVACION,
                );

                // Verifica si hay resultados en el segundo bucle
                if (count($datospersonal) == 1) {
                    $row = $datospersonal[0];
                    $item["NOM_PERSONAL1"] = $row->NOM_PERSONAL1;
                }

                $json[] = $item;
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_poner_personal_usu($codpersonalusu)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->PonerPersonalUsu($codpersonalusu);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_USUARIO" => $row->COD_USUARIO,
                    "COD_PERSONAL " => $row->COD_PERSONAL,
                    "NOM_PERSONAL" => $row->NOM_PERSONAL,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_poner_valores_comprar_factura($codigoComprobantemostrar)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarPonerValoresComprarFactura($codigoComprobantemostrar);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "MONTO" => $row->MONTO,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function  c_consulta_de_tipo_cambio_sunat()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarTipoCambioSunat();
            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "FECHA" => $row->FECHA,
                    "VENTA" => $row->VENTA,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function  c_guardar_datos_factura($idcomprobantecaptura, $empresa, $fecha_emision, $hora, $fecha_entrega, $codusu, $selecttipocompro,  $selectformapago, $selectmoneda, $tipocambio, $serie, $correlativo, $observacion, $imagen)
    {
        $m_formula = new m_almacen();


        $respuesta = $m_formula->GuardarDatosFactura($idcomprobantecaptura, $empresa, $fecha_emision, $hora, $fecha_entrega, $codusu, $selecttipocompro, $selectformapago, $selectmoneda, $tipocambio, $serie, $correlativo, $observacion, $imagen);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }

    static function  c_actualizar_requerimiento_item($codrequerimiento, $valoresorden)
    {
        $m_formula = new m_almacen();
        $respuesta = $m_formula->actualizar_requerimiento_item($codrequerimiento, $valoresorden);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }


    static function c_mostrar_valores_por_codigo_requerimiento($selectrequerimiento)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarValoresPorCodigoRequerimiento($selectrequerimiento);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_fecha_actual_servidor()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->c_horaserversql('F');
            return $datos;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_mostrar_valores_comprobante($selectrequerimiento)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarValoresComprobante($selectrequerimiento);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_TMPCOMPROBANTE" => $row->COD_TMPCOMPROBANTE,
                    "FECHA_EMISION" => $row->FECHA_EMISION,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                    "SERIE" => $row->SERIE,
                    "CORRELATIVO" => $row->CORRELATIVO,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                    "HORA" => $row->HORA,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_guardar_control_recepcion($datos, $datosTabla, $idrequerimiento, $codpersonal)
    {
        $m_formula = new m_almacen();

        // if (isset($datos)) {
        $respuesta = $m_formula->InsertarControlRecepcion($datos, $datosTabla, $idrequerimiento, $codpersonal);
        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
        // }
    }


    static function c_guardar_actualizar_alerta($capturavalor)
    {
        $m_formula = new m_almacen();


        $respuesta = $m_formula->InsertarActualizarAlerta($capturavalor);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }
    static function c_guardar_actualizar_alerta_control($capturavalorcontrol)
    {
        $m_formula = new m_almacen();


        $respuesta = $m_formula->InsertarActualizarAlertaControl($capturavalorcontrol);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }
    static function c_consulta_cajas($cantidadenvases, $codigoproducto)
    {
        try {

            $mostrar = new m_almacen();

            $envases = $mostrar->ValoresEnvases($codigoproducto);

            if (!$envases) {
                // throw new Exception("Hubo un error en la consulta");
                $json = [];
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
            $json = array();
            foreach ($envases as $row) {

                $dataalmacen = $mostrar->MostrarAlmaceninsumos(trim($row->COD_PRODUCTO));
                // var_dump($dataalmacen);
                $valor_numerico = floatval($dataalmacen["STOCK_ACTUAL"]);
                // var_dump($row->COD_PRODUCTO);
                // var_dump($valor_numerico);

                if (trim($row->COD_PRODUCTO) == "00161") {
                    $CANTIDAD_TOTAL = ceil($cantidadenvases / $row->CANTIDA);
                } else if (trim($row->COD_PRODUCTO) == '00061') {
                    $CANTIDAD_TOTAL = ceil(($cantidadenvases * (0.6)) / 30);
                } else {
                    $CANTIDAD_TOTAL = $cantidadenvases;
                }
                // echo "h";
                // var_dump($CANTIDAD_TOTAL);
                $valor_envase = floatval($CANTIDAD_TOTAL);
                if ($valor_envase > $valor_numerico) {
                    $responseenvase = array('estado' => 'estado2', 'descripcionenvase' => $row->DES_PRODUCTO, 'cantidadenvase' => $CANTIDAD_TOTAL);
                    echo json_encode($responseenvase);
                    exit;
                } else {
                    $json[] = array(

                        "COD_COD_FORMULACION" => $row->COD_FORMULACION,
                        "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        // "CANTIDAD_TOTAL" => $CANTIDAD_TOTAL,
                        // "LOTES" => c_almacen::c_producto_lote($row->COD_PRODUCTO, $CANTIDAD_TOTAL),
                    );
                }
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    static function c_insertar_proveedor_producto($selectmoneda, $precioproducto, $cantidadMinima, $selectprovedores, $selectproductosproveedores)
    {
        $m_formula = new m_almacen();

        $respuestaproveedor = $m_formula->InsertarProveedorProducto($selectmoneda, $precioproducto, $cantidadMinima, $selectprovedores, $selectproductosproveedores);

        if ($respuestaproveedor) {
            echo "ok";
        } else {
            echo "error";
        };
    }
    static function c_buscar_listar_proveedor_producto($buscarProveedorPrecios)
    {
        try {

            if (!empty($buscarProveedorPrecios)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->BuscarListarProveedorProducto($buscarProveedorPrecios);

                if (!$datos) {
                    // throw new Exception("Hubo un error en la consulta");
                    $json = array();
                    $jsonstring = json_encode($json);
                    echo $jsonstring;
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_CANTIDAD_MINIMA" => $row->COD_CANTIDAD_MINIMA,
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                        "ESTADO" => trim($row->ESTADO),
                        "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                        "TIPO_MONEDA" => $row->TIPO_MONEDA,
                        "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                        "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            } else {
                $mostrar = new m_almacen();
                $datos = $mostrar->BuscarListarProveedorProducto($buscarProveedorPrecios);

                if (!$datos) {
                    // throw new Exception("Hubo un error en la consulta");
                    $json = array();
                    $jsonstring = json_encode($json);
                    echo $jsonstring;
                }
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_CANTIDAD_MINIMA" => $row->COD_CANTIDAD_MINIMA,
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,
                        "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                        "ESTADO" => trim($row->ESTADO),
                        "PRECIO_PRODUCTO" => $row->PRECIO_PRODUCTO,
                        "TIPO_MONEDA" => $row->TIPO_MONEDA,
                        "NOM_PROVEEDOR" => $row->NOM_PROVEEDOR,
                        "COD_PROVEEDOR" => $row->COD_PROVEEDOR,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_cambiar_estado_cantidad_minima($taskId)
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->CambiarEstadoCantidadMinima($taskId);

            if ($datos) {
                echo "ok";
            } else {
                echo "error";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_cambiar_estado($id)
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->CambiarEstado($id);

            if ($datos) {
                echo "ok";
            } else {
                echo "error";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_editar_proveedor_precios($cod_mini)
    {
        $mostrar = new m_almacen();

        if (isset($cod_mini)) {
            $selectZ = $mostrar->SelectProveedorPrecios($cod_mini);

            $json = array();
            foreach ($selectZ as $row) {
                $json[] = array(
                    "COD_CANTIDAD_MINIMA" => $row['COD_CANTIDAD_MINIMA'],
                    "DES_PRODUCTO" => $row['DES_PRODUCTO'],
                    "COD_PRODUCTO" => trim($row['COD_PRODUCTO']),
                    "CANTIDAD_MINIMA" => $row['CANTIDAD_MINIMA'],
                    "PRECIO_PRODUCTO" => $row['PRECIO_PRODUCTO'],
                    "TIPO_MONEDA" => $row['TIPO_MONEDA'],
                    "NOM_PROVEEDOR" => $row['NOM_PROVEEDOR'],
                    "COD_PROVEEDOR" => $row['COD_PROVEEDOR'],
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    static function c_actualizar_proveedores_productos($codminimo, $selectproductosproveedores, $selectprovedores, $cantidadMinima, $precioproducto, $selectmoneda)
    {
        $m_formula = new m_almacen();

        if (isset($codminimo) && isset($selectproductosproveedores) && isset($selectprovedores)) {

            $respuestapro = $m_formula->ActualizaTablaProveedorPrecios($codminimo, $cantidadMinima, $precioproducto, $selectmoneda);
            if ($respuestapro) {
                return "ok";
            } else {
                return "error";
            };
        }
    }


    /*funciones agregadas */
    static function c_reportekardex($producto, $fechaini, $fechafin, $lote)
    {
        $m_formula = new m_almacen();
        $mensaje = '';

        if (strlen(trim($producto)) == 0) {
            $mensaje = 'Seleccione el producto';
        } else if (strlen(trim($fechaini)) == 0) {
            $mensaje = 'Seleccione la fecha inicio';
        } else if (strlen(trim($fechafin)) == 0) {
            $mensaje = 'Seleccione la fecha fin';
        }

        if (strlen(trim($mensaje)) == 0) {
            $rpta = $m_formula->m_reportekardex($producto, $fechaini, $fechafin, $lote);
            $totallote = $m_formula->m_total_x_lote($producto, $lote);
            for ($i = 0; $i < count($rpta); $i++) {
                $rpta[$i][8] = convFecSistema($rpta[$i][8]);
                $rpta[$i][5] = (is_null($rpta[$i][5])) ? 0 : $rpta[$i][5];
                $rpta[$i][6] = (is_null($rpta[$i][6])) ? 0 : $rpta[$i][6];
                array_push($rpta[$i], $totallote[0][0]);
            }

            $dato = array('m' => $mensaje, 'c' => count($rpta), 'd' => $rpta);
        } else {
            $dato = array('m' => $mensaje, 'c' => 0);
        }
        echo json_encode($dato, JSON_PRETTY_PRINT);
    }

    static function c_producto()
    {
        $m_formula = new m_almacen();
        $rpta = $m_formula->m_productos();
        $dato = array(
            'd' => $rpta,
            'c' => count($rpta),
        );
        echo json_encode($dato, JSON_FORCE_OBJECT);
    }

    static function c_lotesproducto($producto)
    {
        $m_formula = new m_almacen();
        $rpta = $m_formula->m_loteproducto($producto);
        $dato = array(
            'd' => $rpta,
            'c' => count($rpta),
        );
        echo json_encode($dato, JSON_FORCE_OBJECT);
    }


    static function c_producto_lote($codproducto, $cantidad)
    {
        $array = array();
        $mostrar = new m_almacen();
        $rpta = $mostrar->m_lotes_producto($codproducto);

        $suma = 0;
        for ($i = 0; $i < count($rpta); $i++) {
            // var_dump($rpta[$i]);
            $suma += $rpta[$i][3];
            array_push($array, [$rpta[$i][1], $rpta[$i][2], $rpta[$i][3]]);
            if ($suma >= $cantidad) {
                return $array;
                break;
            }
        }
    }

    static function m_verificarstock($valoresCapturadosProduccion)
    {
        for ($i = 0; $i < count($valoresCapturadosProduccion); $i += 3) {
            $cantidadcaptura = trim($valoresCapturadosProduccion[$i + 1]);
            $cantidadlote = ($valoresCapturadosProduccion[$i + 2]);

            if ($cantidadlote == '0') {

                return 0;
            }
            $total = 0;
            $separa = explode("/", $cantidadlote);
            for ($j = 0; $j < count($separa); $j++) {
                $cant = explode("-", $separa[$j]);
                if (trim($cant[0]) != '') {
                    $total += floatval($cant[1]);
                }
            }

            if ($cantidadcaptura > $total) {
                return 0;
                break;
            }
        }
        return 1;
    }
}
