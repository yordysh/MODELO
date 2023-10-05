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

    $respuesta = c_almacen::c_insertar_infra($valorSeleccionado, $nombreinfraestructura, $ndias);

    echo $respuesta;
} elseif ($accion == 'editarinfra') {

    $codinfra = trim($_POST['codinfra']);

    $respuesta = c_almacen::c_editar_infra($codinfra);
    echo $respuesta;
} elseif ($accion == 'actualizarinfra') {
    $codinfra = trim($_POST["codinfra"]);
    $nombreinfraestructura = trim($_POST['nombreinfraestructura']);
    $ndias = trim($_POST['ndias']);

    $respuesta = c_almacen::c_actualizar_infra($nombreinfraestructura, $ndias, $codinfra);
    echo $respuesta;
} elseif ($accion == 'eliminarinfra') {

    $codinfra = trim($_POST['codinfra']);

    $respuesta = c_almacen::c_eliminar_infra($codinfra);
    echo $respuesta;
} elseif ($accion == 'buscarinfra') {
    $buscarinfra = trim($_POST['buscarinfra']);

    $respuesta = c_almacen::c_buscar_infra($buscarinfra);
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

    $respuesta = c_almacen::c_selectCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion);
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
} elseif ($accion == 'insertarcontrol') {

    $nombrecontrol = strtoupper(trim($_POST['nombrecontrol']));
    $ndiascontrol = trim($_POST['ndiascontrol']);
    $valorSeleccionado = trim($_POST['valorSeleccionado']);

    $respuesta = c_almacen::c_insertar_control($valorSeleccionado, $nombrecontrol, $ndiascontrol);

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
} elseif ($accion == 'fechaalertacontrol') {
    $respuesta = c_almacen::c_fecha_alerta_control();
    echo $respuesta;
} elseif ($accion == 'actualizaalertacontrol') {
    $respuesta = c_almacen::c_checkbox_confirma_control();
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
    // $selectProductoCombo = $_POST['selectProductoCombo'];
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

    $respuesta = c_almacen::c_mostrar_envase($seleccionadoinsumoenvases, $cantidadesinsumoenvases);
    echo $respuesta;
} elseif ($accion == 'guardarvalorescapturadosinsumos') {

    $codpersonal = ($_POST['codpersonal']);
    $union = ($_POST['union']);
    $unionEnvase = ($_POST['unionEnvase']);
    $unionItem = ($_POST['unionItem']);


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
    if (isset($_POST['union'])) {
        $union = $_POST['union'];
        $idRequerimiento = $_POST['idRequerimiento'];
        $codpersonal = $_POST['codpersonal'];
        $respuesta = c_almacen::c_insertar_orden_compra_item($union, $idRequerimiento,  $codpersonal);
        echo $respuesta;
    } else {
        $respuesta = c_almacen::c_actualizar_orden_compra_item($idRequerimiento);
        echo $respuesta;
    }
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
    $observacion = strtoupper(trim($_POST['observacion']));
    $respuesta = c_almacen::c_rechazar_pendiente_requerimiento($cod_requerimiento_pedido, $codpersonal, $observacion);
    echo $respuesta;
} elseif ($accion == 'mostrarregistrosporenvases') {
    $codigoproduccion = trim($_POST['codigoproduccion']);
    $codigoproducto = trim($_POST['codigoproducto']);
    $cantidad = trim($_POST['cantidad']);
    $respuesta = c_almacen::c_mostrar_envases_por_produccion($codigoproducto, $codigoproduccion, $cantidad);
    echo $respuesta;
} elseif ($accion == 'guardarvalordeinsumosporregistro') {
    $valoresCapturadosProduccion = ($_POST['valoresCapturadosProduccion']);
    $codigoproducto = trim($_POST['codigoproducto']);
    $codigoproduccion = trim($_POST['codigoproduccion']);
    $cantidad = trim($_POST['cantidad']);
    $codpersonal = trim($_POST['codpersonal']);
    $respuesta = c_almacen::c_guardar_valor_insumo_registro($valoresCapturadosProduccion, $codigoproducto, $codigoproduccion, $cantidad, $codpersonal);
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
    $codpersonal = trim($_POST['codpersonal']);

    $idcodordencompra = trim($_POST['idcodordencompra']);

    $respuesta = c_almacen::c_aprobar_orden_compra($idcodordencompra, $codpersonal);
    echo $respuesta;
} elseif ($accion == 'mostrarordencompraalmacen') {
    // $idcodordencompra = trim($_POST['idcodordencompra']);
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
    $respuesta = c_almacen::c_mostrar_orden_compra_aprobada();
    echo $respuesta;
} elseif ($accion == 'mostrarinsumoscompras') {
    $idcompraaprobada = trim($_POST['idcompraaprobada']);
    $respuesta = c_almacen::c_mostrar_insumos_compras($idcompraaprobada);
    echo $respuesta;
} elseif ($accion == 'guardarinsumoscompras') {
    $fecha = trim($_POST['fecha']);
    $empresa = trim($_POST['empresa']);
    $personal = trim($_POST['personal']);
    $oficina = trim($_POST['oficina']);
    $proveedor = strtoupper(trim($_POST['proveedor']));
    $proveedordireccion = trim($_POST['proveedordireccion']);
    $proveedorruc = trim($_POST['proveedorruc']);
    $proveedordni = trim($_POST['proveedordni']);
    $formapago = trim($_POST['formapago']);
    $moneda = trim($_POST['moneda']);
    $datosSeleccionadosInsumos = $_POST['datosSeleccionadosInsumos'];
    $idcompraaprobada = $_POST['idcompraaprobada'];

    $respuesta = c_almacen::c_guardar_insumos_compras($fecha, $empresa,  $personal,  $oficina,  $proveedor, $proveedordireccion, $proveedorruc, $proveedordni, $formapago, $moneda, $datosSeleccionadosInsumos, $idcompraaprobada);
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

    static function c_insertar_infra($valorSeleccionado, $nombreinfraestructura, $ndias)
    {
        $mostrar = new m_almacen();
        if (isset($nombreinfraestructura) && isset($ndias) && isset($valorSeleccionado)) {

            $respuesta = $mostrar->insertarInfraestructura($valorSeleccionado, $nombreinfraestructura,  $ndias);
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
                    "COD_INFRAESTRUCTURA" => $row['COD_INFRAESTRUCTURA'],
                    "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                    "NOMBRE_INFRAESTRUCTURA" => $row['NOMBRE_INFRAESTRUCTURA'],
                    "NDIAS" => $row['NDIAS']
                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }

    static function c_actualizar_infra($nombreinfraestructura, $ndias, $codinfra)
    {
        $m_formula = new m_almacen();

        if (isset($nombreinfraestructura) && isset($ndias) && isset($codinfra)) {
            $resultado = $m_formula->editarInfraestructura($nombreinfraestructura, $ndias, $codinfra);

            if ($resultado) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    static function c_actualizar_combo()
    {
        try {

            $mostrar = new m_almacen();

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

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }

                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
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


    static function c_fecha_alerta_mensaje()
    {

        $mostrar = new m_almacen();
        $datos = $mostrar->AlertaMensaje();
        try {
            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }

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
        } catch (Exception $e) {
            echo "Error: ";
        }
    }

    static function c_checkbox_confirma()
    {
        $mostrar = new m_almacen();

        if (isset($_POST['observacion'])) {
            $estado = $_POST['estado'];
            $taskId = $_POST['taskId'];
            $observacion = $_POST['observacion'];
            $fechaPosterga = $_POST['fechaPostergacion'];
            $FECHA_POSTERGACION =  convFecSistema($fechaPosterga);
            $FECHA_TOTAL = $_POST['taskFecha'];

            $accionCorrectiva = $_POST['accionCorrectiva'];
            $selectVerificacion = $_POST['selectVerificacion'];

            $fechadHoy  = $mostrar->c_horaserversql('F');
            // echo "FECHAHOY" . $fechadHoy;
            // echo "FECHATOTAL" . $FECHA_TOTAL;
            // echo "FECHAPOSTERGA" . $FECHA_POSTERGACION;



            if ($FECHA_TOTAL != $fechadHoy) {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alert = $mostrar->actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion);
            } else {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert = $mostrar->actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion);
            }
        } else {
            $estado = $_POST['estado'];
            // var_dump($estado);
            $taskId = $_POST['taskId'];
            $observacionTextArea = $_POST['observacionTextArea'];
            $FECHA_TOTAL = $_POST['taskFecha'];
            $accionCorrectiva = $_POST['accionCorrectiva'];
            $selectVerificacion = $_POST['selectVerificacion'];



            $fechadHoy  = $mostrar->c_horaserversql('F');
            // $fechaActual = new DateTime();
            // $fechadHoy = $fechaActual->format('d/m/Y');


            if ($FECHA_TOTAL != $fechadHoy) {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion);
            } else {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion);
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

            $codInfraestructura = $_POST['codInfraestructura'];

            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');

            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            $insert = $mostrar->InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias);

            if ($insert) {

                return "ok";
            } else {
                return "error";
            }
        } else if ($taskNdias == 2) {


            $codInfraestructura = $_POST['codInfraestructura'];

            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');


            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            $insert = $mostrar->InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "ok";
            } else {
                echo "error";
            }
        } elseif ($taskNdias == 7) {

            if (isset($_POST['fechaPostergacion'])) {

                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);

                $fechaActual = $mostrar->c_horaserversql('F');

                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                // $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];



                $FECHA_CREACION  = $mostrar->c_horaserversql('F');
                $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA_CREACION);
                $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');



                // Verificar si la fecha total cae en domingo
                if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                    $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
                }


                $DIAS_DESCUENTO = 2;
                $FECHA_ACORDAR = retunrFechaSqlphp(date('Y-m-d', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days')));

                $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        } elseif ($taskNdias == 15) {

            if (isset($_POST['fechaPostergacion'])) {

                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);
                // echo "aqui";
                // echo "FechaPOSTERGACION" . $fechaPostergacion;


                $fechaActual = $mostrar->c_horaserversql('F');


                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                // echo "FECHASS" . $fechaAcordar;
                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                // $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];



                $FECHA_CREACION  = $mostrar->c_horaserversql('F');
                $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA_CREACION);
                $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');



                // Verificar si la fecha total cae en domingo
                if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                    $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
                }


                $DIAS_DESCUENTO = 2;
                $FECHA_ACORDAR = retunrFechaSqlphp(date('Y-m-d', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days')));

                $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            }
        } elseif ($taskNdias == 30) {


            if (isset($_POST['fechaPostergacion'])) {

                $codInfraestructura = $_POST['codInfraestructura'];

                $fechaPostergacion =  convFecSistema($_POST['fechaPostergacion']);
                // echo "aqui";
                // echo "FechaPOSTERGACION" . $fechaPostergacion;


                $fechaActual = $mostrar->c_horaserversql('F');


                $DIAS_DESCUENTO = 1;

                $fechaPost = DateTime::createFromFormat('d/m/Y', $fechaPostergacion);
                $formattedDate = $fechaPost->format('d-m-Y');
                $fechaAcordar = date('d-m-Y', strtotime($formattedDate . '-' . $DIAS_DESCUENTO . ' days'));

                // echo "FECHASS" . $fechaAcordar;
                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                // $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];



                $FECHA_CREACION  = $mostrar->c_horaserversql('F');
                $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA_CREACION);
                $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');



                // Verificar si la fecha total cae en domingo
                if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                    $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
                }


                $DIAS_DESCUENTO = 2;
                $FECHA_ACORDAR = retunrFechaSqlphp(date('Y-m-d', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days')));

                $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

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
                throw new Exception("Hubo un error en la consulta");
            }

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
                    "N_DIAS_POS" =>  $row->N_DIAS_POS,
                    "POSTERGACION" =>  $row->POSTERGACION,

                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
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
    static function c_selectCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion)
    {
        $mostrar = new m_almacen();
        if (isset($selectSolucion) && isset($selectPreparacion) && isset($selectCantidad) && isset($selectML) && isset($selectL) && isset($textAreaObservacion) && isset($textAreaAccion) && isset($selectVerificacion)) {

            $respuesta = $mostrar->insertarCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion);
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
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "NOMBRE_CONTROL_MAQUINA" => $row->NOMBRE_CONTROL_MAQUINA,
                        "N_DIAS_CONTROL" => $row->N_DIAS_CONTROL,
                        "FECHA" =>  convFecSistema($row->FECHA),
                        "OBSERVACION" => $row->OBSERVACION,
                        "ACCION_CORRECTIVA" => $row->ACCION_CORRECTIVA,
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
                        "COD_CONTROL_MAQUINA" => $row->COD_CONTROL_MAQUINA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "NOMBRE_CONTROL_MAQUINA" => $row->NOMBRE_CONTROL_MAQUINA,
                        "N_DIAS_CONTROL" => $row->N_DIAS_CONTROL,
                        "FECHA" =>  convFecSistema($row->FECHA),
                        "OBSERVACION" => $row->OBSERVACION,
                        "ACCION_CORRECTIVA" => $row->ACCION_CORRECTIVA,
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
    static function c_insertar_control($valorSeleccionado, $nombrecontrol, $ndiascontrol)
    {
        $mostrar = new m_almacen();
        if (isset($nombrecontrol) && isset($ndiascontrol) && isset($valorSeleccionado)) {

            $respuesta = $mostrar->insertarControl($valorSeleccionado, $nombrecontrol, $ndiascontrol);
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
                    "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
                    "NOMBRE_CONTROL_MAQUINA" => $row['NOMBRE_CONTROL_MAQUINA'],
                    "N_DIAS_CONTROL" => $row['N_DIAS_CONTROL']

                );
            }

            $jsonstring = json_encode($json[0]);
            echo $jsonstring;
        }
    }
    static function c_actualizar_control_maquina($nombrecontrol, $ndiascontrol,  $codcontrol)
    {
        $m_formula = new m_almacen();

        if (isset($nombrecontrol) && isset($ndiascontrol) && isset($codcontrol)) {
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
    static function c_fecha_alerta_control()
    {
        $mostrar = new m_almacen();

        $datos = $mostrar->MostrarAlertaControl();
        try {
            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }

            $json = array();
            foreach ($datos as $row) {
                $json[] = array(

                    "COD_ALERTA_CONTROL_MAQUINA" => $row->COD_ALERTA_CONTROL_MAQUINA,
                    "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                    "COD_CONTROL_MAQUINA" => $row->COD_CONTROL_MAQUINA,
                    "NOMBRE_CONTROL_MAQUINA" => $row->NOMBRE_CONTROL_MAQUINA,
                    "FECHA_CREACION" =>  convFecSistema($row->FECHA_CREACION),
                    "FECHA_TOTAL" =>  convFecSistema($row->FECHA_TOTAL),
                    "FECHA_ACORDAR" =>  convFecSistema($row->FECHA_ACORDAR),
                    "N_DIAS_POS" =>  $row->N_DIAS_POS,
                    "ACCION_CORRECTIVA" =>  $row->ACCION_CORRECTIVA,


                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: ";
        }
    }
    static function c_checkbox_confirma_control()
    {
        $mostrar = new m_almacen();

        $estado = $_POST['estado'];
        $taskId = $_POST['taskId'];
        $observacionTextArea = $_POST['observacionTextArea'];
        $accionCorrectiva = $_POST['accionCorrectiva'];

        $fechadHoy  = $mostrar->c_horaserversql('F');

        $alert = $mostrar->actualizarAlertaCheckControl($estado, $taskId, $observacionTextArea, $accionCorrectiva);


        $alert->execute();
        return $alert;

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

        echo json_encode($alert);
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


            // var_dump($FECHA_TOTAL);

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
        // var_dump($datos);
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

    static function c_mostrar_envase($seleccionadoinsumoenvases, $cantidadesinsumoenvases)
    {
        try {
            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarDatosEnvases($seleccionadoinsumoenvases);

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $calculo = ($row->CANTIDA * $cantidadesinsumoenvases) / $row->CAN_FORMULACION;
                $total = ceil($calculo);
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
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "COD_PRODUCTO" => trim($row->COD_PRODUCTO),
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD" => $row->CANTIDAD,
                    "STOCK_ACTUAL" => $row->STOCK_ACTUAL,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                );
            }

            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_insertar_orden_compra_item($union, $idRequerimiento, $codpersonal)
    {
        $m_formula = new m_almacen();

        if (isset($idRequerimiento)) {
            $respuesta = $m_formula->InsertarOrdenCompraItem($union, $idRequerimiento, $codpersonal);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
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
            $datos = $mostrar->MostrarProductoInsumoPorRequerimiento($cod_formulacion);
            // var_dump($datos);
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

    static function  c_rechazar_pendiente_requerimiento($cod_requerimiento_pedido, $codpersonal, $observacion)
    {
        $mostrar = new m_almacen();

        if (isset($cod_requerimiento_pedido)) {
            $respuesta = $mostrar->RechazarPendienteRequerimiento($cod_requerimiento_pedido, $codpersonal, $observacion);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }




    static function c_mostrar_envases_por_produccion($codigoproducto, $codigoproduccion, $cantidad)
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarEnvasesPorProduccion($codigoproducto, $codigoproduccion, $cantidad);

            if ($datos['tipo'] == 0) {
                $json = array();
                foreach ($datos['respuesta'] as $row) {
                    $json['respuesta'][] = array(
                        "COD_COD_FORMULACION" => $row->COD_FORMULACION,
                        "COD_PRODUCTO" => $row->COD_PRODUCTO,
                        "DES_PRODUCTO" => $row->DES_PRODUCTO,

                        $CANTIDAD_TOTAL = ceil(($row->CANTIDA * $cantidad) / $row->CANTIDAD_FORMULACION),
                        "CANTIDAD_TOTAL" => $CANTIDAD_TOTAL,

                    );
                }
                $json['tipo'] = 0;
            } else {
                $json = array();
                foreach ($datos['respuesta'] as $row) {
                    $json['respuesta'] = array(
                        "COD_PRODUCCION" => $row->COD_PRODUCCION,
                        "CANTIDAD_PRODUCIDA" => $row->CANTIDAD_PRODUCIDA,
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


    static function c_guardar_valor_insumo_registro($valoresCapturadosProduccion, $codigoproducto, $codigoproduccion, $cantidad, $codpersonal)
    {
        $m_formula = new m_almacen();

        if (isset($valoresCapturadosProduccion) && isset($codigoproducto) && isset($codigoproduccion) && isset($cantidad)) {
            $respuesta = $m_formula->InsertarValorInsumoRegistro($valoresCapturadosProduccion, $codigoproducto, $codigoproduccion, $cantidad, $codpersonal);

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
    static function c_aprobar_orden_compra($idcodordencompra, $codpersonal)
    {
        $m_formula = new m_almacen();


        $respuesta = $m_formula->AprobarOrdenCompra($idcodordencompra, $codpersonal);

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
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();

            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "ABR_PRODUCTO" => $row->ABR_PRODUCTO,

                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
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



    static function c_mostrar_orden_compra_aprobada()
    {
        try {

            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarOrdenDeCompraAprobada();

            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_REQUERIMIENTO" => $row->COD_REQUERIMIENTO,
                    "FECHA" => convFecSistema($row->FECHA),
                    "NOM_PERSONAL" => $row->NOM_PERSONAL,
                    "OFICINA" => $row->OFICINA,
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
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $json[] = array(
                    "COD_ORDEN_COMPRA" => $row->COD_ORDEN_COMPRA,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
                    "DES_PRODUCTO" => $row->DES_PRODUCTO,
                    "CANTIDAD_MINIMA" => $row->CANTIDAD_MINIMA,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    static function c_guardar_insumos_compras($fecha, $empresa,  $personal,  $oficina,  $proveedor, $proveedordireccion, $proveedorruc, $proveedordni, $formapago, $moneda, $datosSeleccionadosInsumos, $idcompraaprobada)
    {
        $m_formula = new m_almacen();


        $respuesta = $m_formula->GuardarInsumosCompras($fecha, $empresa,  $personal,  $oficina,  $proveedor, $proveedordireccion, $proveedorruc, $proveedordni, $formapago, $moneda, $datosSeleccionadosInsumos, $idcompraaprobada);

        if ($respuesta) {
            return "ok";
        } else {
            return "error";
        };
    }
}
