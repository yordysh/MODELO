<?php
require_once("./m_almacen.php");
include("../funciones/f_funcion.php");

if ($_POST['accion'] == 'insertar') {

    $nombrezonaArea = strtoupper(trim($_POST['nombrezonaArea']));
    $respuesta = c_almacen::c_insertar_zona($nombrezonaArea);
    echo $respuesta;
}
if ($_POST['accion'] == 'editar') {
    $cod_zona = trim($_POST['cod_zona']);
    $respuesta = c_almacen::c_editar_zona($cod_zona);
    echo $respuesta;
}

if ($_POST['accion'] == 'actualizar') {
    $codzona = trim($_POST['codzona']);
    $nombrezonaArea = trim($_POST['nombrezonaArea']);
    $respuesta = c_almacen::c_actualizar_zona($codzona, $nombrezonaArea);
    echo $respuesta;
}
if ($_POST['accion'] == 'eliminarzona') {

    $codzona = trim($_POST['codzona']);

    $respuesta = c_almacen::c_eliminar_zona($codzona);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarzona') {

    $buscarzona = trim($_POST['buscarzona']);

    $respuesta = c_almacen::c_buscar_zona($buscarzona);
    echo $respuesta;
}




if ($_POST['accion'] == 'insertarinfra') {
    $nombreinfraestructura = strtoupper(trim($_POST['nombreinfraestructura']));
    $ndias = trim($_POST['ndias']);
    $valorSeleccionado = trim($_POST['valorSeleccionado']);

    $respuesta = c_almacen::c_insertar_infra($valorSeleccionado, $nombreinfraestructura, $ndias);

    echo $respuesta;
}
if ($_POST['accion'] == 'editarinfra') {

    $codinfra = trim($_POST['codinfra']);

    $respuesta = c_almacen::c_editar_infra($codinfra);
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizarinfra') {
    $codinfra = trim($_POST["codinfra"]);
    $nombreinfraestructura = trim($_POST['nombreinfraestructura']);
    $ndias = trim($_POST['ndias']);

    $respuesta = c_almacen::c_actualizar_infra($nombreinfraestructura, $ndias, $codinfra);
    echo $respuesta;
}
if ($_POST['accion'] == 'eliminarinfra') {

    $codinfra = trim($_POST['codinfra']);

    $respuesta = c_almacen::c_eliminar_infra($codinfra);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarinfra') {
    $buscarinfra = trim($_POST['buscarinfra']);

    $respuesta = c_almacen::c_buscar_infra($buscarinfra);
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizarcombozona') {

    $respuesta = c_almacen::c_actualizar_combo();
    echo $respuesta;
}



if ($_POST['accion'] == 'fechaalertamensaje') {

    $respuesta = c_almacen::c_fecha_alerta_mensaje();
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizaalerta') {
    $respuesta = c_almacen::c_checkbox_confirma();
    echo $respuesta;
}
if ($_POST['accion'] == 'insertaralertamix') {
    $respuesta = c_almacen::c_insertar_alertamix();
    echo $respuesta;
}
if ($_POST['accion'] == 'fechaalerta') {
    $respuesta = c_almacen::c_fecha_alerta();
    echo $respuesta;
}


if ($_POST['accion'] == 'seleccionarPreparacion') {

    $respuesta = c_almacen::c_selectproductos();
    echo $respuesta;
}

if ($_POST['accion'] == 'seleccionarCantidad') {

    $respuesta = c_almacen::c_selectcantidad();
    echo $respuesta;
}

if ($_POST['accion'] == 'seleccionarML') {

    $respuesta = c_almacen::c_selectML();
    echo $respuesta;
}

if ($_POST['accion'] == 'seleccionarL') {

    $respuesta = c_almacen::c_selectL();
    echo $respuesta;
}

if ($_POST['accion'] == 'enviarSelectCombo') {
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
}

if ($_POST['accion'] == 'buscarprepararacion') {

    $buscarPrepa = trim($_POST['buscarPrepa']);

    $respuesta = c_almacen::c_buscar_preparacion($buscarPrepa);
    echo $respuesta;
}




if ($_POST['accion'] == 'insertarLimpieza') {


    $selectZona = trim($_POST['selectZona']);
    $textfrecuencia = strtoupper(trim($_POST['textfrecuencia']));

    $textAreaObservacion = trim($_POST['textAreaObservacion']);
    $textAreaAccion = trim($_POST['textAreaAccion']);
    $selectVerificacion = trim($_POST['selectVerificacion']);


    $respuesta = c_almacen::c_insertar_limpieza($selectZona, $textfrecuencia,  $textAreaObservacion,  $textAreaAccion, $selectVerificacion);
    echo $respuesta;
}
if ($_POST['accion'] == 'editarLimpieza') {

    $cod_frecuencia = trim($_POST['cod_frecuencia']);

    $respuesta = c_almacen::c_editar_limpieza($cod_frecuencia);
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizarLimpieza') {
    $codfre = trim($_POST["codfre"]);
    $textfrecuencia = trim($_POST['textfrecuencia']);


    $respuesta = c_almacen::c_actualizar_limpieza($codfre, $textfrecuencia);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarlimpieza') {

    $buscarLimpieza = trim($_POST['buscarLimpieza']);

    $respuesta = c_almacen::c_buscar_limpieza($buscarLimpieza);
    echo $respuesta;
}



if ($_POST['accion'] == 'buscarcontrol') {
    $buscarcontrol = trim($_POST['buscarcontrol']);

    $respuesta = c_almacen::c_buscar_control($buscarcontrol);
    echo $respuesta;
}
if ($_POST['accion'] == 'insertarcontrol') {

    $nombrecontrol = strtoupper(trim($_POST['nombrecontrol']));
    $ndiascontrol = trim($_POST['ndiascontrol']);
    $valorSeleccionado = trim($_POST['valorSeleccionado']);

    $respuesta = c_almacen::c_insertar_control($valorSeleccionado, $nombrecontrol, $ndiascontrol);

    echo $respuesta;
}
if ($_POST['accion'] == 'editarcontrolmaquina') {

    $codcontrolmaquina = trim($_POST['codcontrolmaquina']);

    $respuesta = c_almacen::c_editar_control_maquina($codcontrolmaquina);
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizarcontrol') {
    $codcontrol = trim($_POST["codcontrol"]);
    $nombrecontrol = trim($_POST['nombrecontrol']);
    $ndiascontrol = trim($_POST['ndiascontrol']);

    $respuesta = c_almacen::c_actualizar_control_maquina($nombrecontrol, $ndiascontrol,  $codcontrol);
    echo $respuesta;
}
if ($_POST['accion'] == 'eliminarcontrolmaquina') {

    $codcontrolmaquina = trim($_POST['codcontrolmaquina']);

    $respuesta = c_almacen::c_eliminar_control_maquina($codcontrolmaquina);
    echo $respuesta;
}

if ($_POST['accion'] == 'fechaalertacontrol') {
    $respuesta = c_almacen::c_fecha_alerta_control();
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizaalertacontrol') {
    $respuesta = c_almacen::c_checkbox_confirma_control();
    echo $respuesta;
}
if ($_POST['accion'] == 'insertaralertamixcontrolmaquina') {
    $respuesta = c_almacen::c_insertar_alertamix_control_maquina();
    echo $respuesta;
}

if ($_POST['accion'] == 'buscarZonaCombo') {
    $term = $_POST['term'];
    $respuesta = c_almacen::c_buscar_zona_combo($term);
    echo $respuesta;
}





if ($_POST['accion'] == 'insertarlabsabell') {

    $codigolabsabell = trim($_POST['codigolabsabell']);
    $valorSeleccionado = ($_POST['valorSeleccionado']);
    $respuesta = c_almacen::c_insertar_labsabell($codigolabsabell, $valorSeleccionado);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarlabsabell') {

    $buscarlab = trim($_POST['buscarlab']);

    $respuesta = c_almacen::c_buscar_labsabell($buscarlab);
    echo $respuesta;
}
if ($_POST['accion'] == 'editarLabsabell') {
    $cod_producto_envase = trim($_POST['cod_producto_envase']);
    $respuesta = c_almacen::c_editar_envases_labsabel($cod_producto_envase);
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizarlabsabell') {
    $codlab = trim($_POST['codlab']);
    $codigolab = trim($_POST['codigolab']);
    $respuesta = c_almacen::c_actualizar_envases_labsabell($codlab, $codigolab);
    echo $respuesta;
}
if ($_POST['accion'] == 'eliminarproductoenvase') {

    $codenvaselabsabell = trim($_POST['codenvaselabsabell']);

    $respuesta = c_almacen::c_eliminar_envases_labsabell($codenvaselabsabell);
    echo $respuesta;
}











if ($_POST['accion'] == 'buscarProductoComboInsumos') {
    $term = $_POST['term'];
    $respuesta = c_almacen::c_buscar_producto_combo_insumos_lab($term);
    echo $respuesta;
}
if ($_POST['accion'] == 'insertarinsumoslab') {

    $codigoInsumosLab = trim($_POST['codigoInsumosLab']);

    $valorSeleccionado = ($_POST['valorSeleccionado']);


    $respuesta = c_almacen::c_insertar_insumos_lab($codigoInsumosLab, $valorSeleccionado);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarInsumosLab') {

    $buscarInsumos = trim($_POST['buscarInsumos']);

    $respuesta = c_almacen::c_buscar_insumos_lab($buscarInsumos);
    echo $respuesta;
}
if ($_POST['accion'] == 'editarInsumosLab') {
    $cod_insumos_lab = trim($_POST['cod_insumos_lab']);
    $respuesta = c_almacen::c_editar_insumos_lab($cod_insumos_lab);
    echo $respuesta;
}
if ($_POST['accion'] == 'actualizarinsumoslab') {
    $codInsu = trim($_POST['codInsu']);
    $codigoInsumo = trim($_POST['codigoInsumo']);
    $respuesta = c_almacen::c_actualizar_insumos_lab($codInsu, $codigoInsumo);
    echo $respuesta;
}
if ($_POST['accion'] == 'eliminarinsumolab') {

    $codinsumoslab = trim($_POST['codinsumoslab']);

    $respuesta = c_almacen::c_eliminar_insumos_lab($codinsumoslab);
    echo $respuesta;
}








if ($_POST['accion'] == 'insertarProductoEnvase') {

    $selectProductoCombo = trim($_POST['selectProductoCombo']);
    $cantidadTotal = trim($_POST['cantidadTotal']);
    $dataInsumo = ($_POST['dataInsumo']);
    $dataEnvase = ($_POST['dataEnvase']);

    $respuesta = c_almacen::c_insertar_producto_combo($selectProductoCombo, $cantidadTotal, $dataInsumo, $dataEnvase);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarenvaseproducto') {
    // $selectProductoCombo = $_POST['selectProductoCombo'];
    $respuesta = c_almacen::c_buscar_producto_envase();
    echo $respuesta;
}









if ($_POST['accion'] == 'seleccionarProduccion') {

    $respuesta = c_almacen::c_select_productos_produccion();
    echo $respuesta;
}










if ($_POST['accion'] == 'insertarrequerimientoproducto') {

    $selectProductoCombo = trim($_POST['selectProductoCombo']);
    $cantidadProducto = trim($_POST['cantidadProducto']);

    $respuesta = c_almacen::c_insertar_requerimiento_producto($selectProductoCombo, $cantidadProducto);
    echo $respuesta;
}
if ($_POST['accion'] == 'buscarrequerimientoproducto') {

    $buscarrequerimiento = trim($_POST['buscarrequerimiento']);

    $respuesta = c_almacen::c_buscar_requerimiento_producto($buscarrequerimiento);
    echo $respuesta;
}




if ($_POST['accion'] == 'mostrardatosinsumos') {

    $selectInsumoEnvase = trim($_POST['selectInsumoEnvase']);

    $cantidadInsumoEnvase = trim($_POST['cantidadInsumoEnvase']);

    $respuesta = c_almacen::c_mostrar_insumo($selectInsumoEnvase, $cantidadInsumoEnvase);
    echo $respuesta;
}

if ($_POST['accion'] == 'mostrardatosenvases') {

    $selectInsEnvase = trim($_POST['selectInsEnvase']);

    $cantidInsumoEnvase = trim($_POST['cantidInsumoEnvase']);

    $respuesta = c_almacen::c_mostrar_envase($selectInsEnvase, $cantidInsumoEnvase);
    echo $respuesta;
}




if ($_POST['accion'] == 'guardarvalorescapturadosinsumos') {

    $union = ($_POST['union']);
    $unionEnvase = ($_POST['unionEnvase']);




    $respuesta = c_almacen::c_guardar_InsumoEnvase($union, $unionEnvase);
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
                // $jsonstring = json_encode($datos);
                // echo $jsonstring;
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
                    // "FECHA" =>  convFecSistema($row->FECHA),
                    // "VERSION" => $row->VERSION,
                );
            }
            $jsonstring = json_encode($json);
            echo $jsonstring;
            // $jsonstring = json_encode($datos);
            // echo $jsonstring;

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

            // $fechaCreacion = $_POST['fechaCreacion'];
            $codInfraestructura = $_POST['codInfraestructura'];
            // var_dump($_POST['fechaCreacion']);
            // $fechaCreacion = new DateTime();
            // $fechaCrea = $fechaCreacion->format('Y-m-d');

            // $FECHA_CREACION = retunrFechaSqlphp($fechaCrea);
            $FECHA_CREACION = $mostrar->c_horaserversql('F');
            $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y',  $FECHA_CREACION);
            $FECHA_TOTAL = $FECHA_FORMATO->modify("+$taskNdias days")->format('d-m-Y');

            //$fechaTotal = date('Y-m-d', strtotime($fechaCrea . '+' . $taskNdias . ' days'));

            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($FECHA_TOTAL)) == 7) {
                $FECHA_TOTAL = date('Y-m-d', strtotime($FECHA_TOTAL . '+1 day'));
            }

            // $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            $insert = $mostrar->InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "hola";
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
        // $FECHA_TOTAL = $_POST['taskFecha'];



        $fechadHoy  = $mostrar->c_horaserversql('F');
        // $fechaActual = new DateTime();
        // $fechadHoy = $fechaActual->format('d/m/Y');


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
            // var_dump($_POST['fechaCreacion']);
            // $fechaCreacion = new DateTime();
            // $fechaCrea = $fechaCreacion->format('Y-m-d');

            // $FECHA_CREACION = retunrFechaSqlphp($fechaCrea);
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
        // $json = array();
        // foreach ($respuesta as $row) {
        //     $json[] = array(
        //         "COD_ZONA" => $row['COD_ZONA'],
        //         "NOMBRE_T_ZONA_AREAS" => $row['NOMBRE_T_ZONA_AREAS'],
        //     );
        // }
        // $jsonstring = json_encode($json);
        // echo $jsonstring;

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





    static function c_mostrar_insumo($selectInsumoEnvase, $cantidadInsumoEnvase)
    {
        try {


            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarDatosInsumos($selectInsumoEnvase);



            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $total = ($row->CAN_FORMULACION_INSUMOS * $cantidadInsumoEnvase) / $row->CAN_FORMULACION;

                $json[] = array(
                    "COD_FORMULACION" => $row->COD_FORMULACION,
                    "DES_PRODUCTO_FORMULACION" => $row->DES_PRODUCTO_FORMULACION,
                    "COD_PRODUCTO" => $row->COD_PRODUCTO,
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

    static function c_mostrar_envase($selectInsEnvase, $cantidInsumoEnvase)
    {
        try {


            $mostrar = new m_almacen();
            $datos = $mostrar->MostrarDatosEnvases($selectInsEnvase);



            if (!$datos) {
                throw new Exception("Hubo un error en la consulta");
            }
            $json = array();
            foreach ($datos as $row) {
                $total = ($row->CANTIDA * $cantidInsumoEnvase) / $row->CAN_FORMULACION;
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



    static function c_guardar_InsumoEnvase($union, $unionEnvase)
    {
        $m_formula = new m_almacen();

        if (isset($union) && isset($unionEnvase)) {
            $respuesta = $m_formula->InsertarInsumEnvas($union, $unionEnvase);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }
}
