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

    $respuesta = c_almacen::c_insertar_infra($valorSeleccionado, $nombrecontrol, $ndiascontrol);

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

    static function c_insertar_infra($valorSeleccionado, $nombrecontrol, $ndiascontrol)
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
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
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
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
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

            // if (isset($_POST['fechaPostergacion'])) {

            //     $fechaCreacion = $_POST['fechaCreacion'];
            //     $codInfraestructura = $_POST['codInfraestructura'];
            //     $fechaPostergacion = $_POST['fechaPostergacion'];

            //     // Verify and format the dates
            //     $fechaActual = date('Y-m-d');
            //     $fechaPostergacion = date('Y-m-d', strtotime($fechaPostergacion));

            //     // Calculate the difference in days
            //     //$diferenciaDias = (strtotime($fechaPostergacion) - strtotime($fechaActual)) / (60 * 60 * 24);

            //     $DIAS_DESCUENTO = 2;
            //     $fechaAcordar = date('Y-m-d', strtotime($fechaPostergacion . '-' . $DIAS_DESCUENTO . ' days'));

            //     $POSTERGACION = 'SI';

            //     $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

            //     if ($insert) {
            //         echo "Inserción exitosa";
            //     } else {
            //         echo "Error en la inserción: ";
            //     }
            // } else {
            //     $fechaCreacion = $_POST['fechaCreacion'];
            //     $codInfraestructura = $_POST['codInfraestructura'];


            //     $fechaCreacion = new DateTime();
            //     $fechaCreacion = $fechaCreacion->format('Y-m-d');

            //     $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

            //     $fechaTotal = date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days'));

            //     // Verificar si la fecha total cae en domingo
            //     if (date('N', strtotime($fechaTotal)) == 7) {
            //         $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
            //     }

            //     $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            //     $DIAS_DESCUENTO = 2;
            //     $FECHA_ACORDAR = retunrFechaSqlphp(date('Y-m-d', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days')));

            //     $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

            //     if ($insert) {
            //         echo "Inserción exitosa";
            //     } else {
            //         echo "Error en la inserción: ";
            //     }
            // }
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

            // if (isset($_POST['fechaPostergacion'])) {

            //     $fechaCreacion = $_POST['fechaCreacion'];
            //     $codInfraestructura = $_POST['codInfraestructura'];
            //     $fechaPostergacion = $_POST['fechaPostergacion'];

            //     // Verify and format the dates
            //     $fechaActual = date('Y-m-d');
            //     $fechaPostergacion = date('Y-m-d', strtotime($fechaPostergacion));

            //     // Calculate the difference in days
            //     //$diferenciaDias = (strtotime($fechaPostergacion) - strtotime($fechaActual)) / (60 * 60 * 24);

            //     $DIAS_DESCUENTO = 2;
            //     $fechaAcordar = date('Y-m-d', strtotime($fechaPostergacion . '-' . $DIAS_DESCUENTO . ' days'));

            //     $POSTERGACION = 'SI';

            //     $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

            //     if ($insert) {
            //         echo "Inserción exitosa";
            //     } else {
            //         echo "Error en la inserción: ";
            //     }
            // } else {
            //     $fechaCreacion = $_POST['fechaCreacion'];
            //     $codInfraestructura = $_POST['codInfraestructura'];


            //     $fechaCreacion = new DateTime();
            //     $fechaCreacion = $fechaCreacion->format('Y-m-d');

            //     $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

            //     $fechaTotal = date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days'));

            //     // Verificar si la fecha total cae en domingo
            //     if (date('N', strtotime($fechaTotal)) == 7) {
            //         $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
            //     }

            //     $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            //     $DIAS_DESCUENTO = 2;
            //     $FECHA_ACORDAR = retunrFechaSqlphp(date('Y-m-d', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days')));

            //     $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

            //     if ($insert) {
            //         echo "Inserción exitosa";
            //     } else {
            //         echo "Error en la inserción: ";
            //     }
            // }

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
    static function c_insertar_control($valorSeleccionado, $nombreinfraestructura, $ndias)
    {
        $mostrar = new m_almacen();
        if (isset($nombreinfraestructura) && isset($ndias) && isset($valorSeleccionado)) {

            $respuesta = $mostrar->insertarInfraestructura($valorSeleccionado, $nombreinfraestructura, $ndias);
            if ($respuesta) {

                return "ok";
            } else {
                return "error";
            };
        }
    }
}
