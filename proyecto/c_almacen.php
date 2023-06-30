<?php
require_once("./m_almacen.php");
include("../funciones/f_funcion.php");

if ($_POST['accion'] == 'insertar') {

    $nombrezonaArea = trim($_POST['nombrezonaArea']);
    $respuesta = c_almacen::c_insertar_zona($nombrezonaArea);
    echo $respuesta;
}
if ($_POST['accion'] == 'editar') {
    $codzona = trim($_POST['codzona']);
    $respuesta = c_almacen::c_editar_zona($codzona);
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

    $nombreinfraestructura = trim($_POST['nombreinfraestructura']);
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

    static function c_editar_zona($codzona)
    {
        $mostrar = new m_almacen();

        if (isset($codzona)) {
            $selectZ = $mostrar->SelectZona($codzona);

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
                // $data = '';
                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_ZONA" => $row->COD_ZONA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                        "FECHA" => $row->FECHA,
                        "VERSION" => $row->VERSION,
                    );
                    //     $data .= "<tr><td>" . $row->COD_ZONA .
                    //         "</td><td>" . $row->NOMBRE_T_ZONA_AREAS .
                    //         "</td><td>" . $row->FECHA .
                    //         "</td><td>" . $row->VERSION .
                    //         "</td><td><button></button></td><td><button></button></td></tr>";
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
                // echo $data;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    static function c_insertar_infra($valorSeleccionado, $nombreinfraestructura, $ndias)
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

    static function c_editar_infra($codinfra)
    {
        $mostrar = new m_almacen();


        if (isset($codinfra)) {



            $select = $mostrar->SelectInfra($codinfra);


            $json = array();

            foreach ($select as $row) {
                $json[] = array(
                    "COD_INFRAESTRUCTURA" => $row['COD_INFRAESTRUCTURA'],
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
                        "NOMBRE_INFRAESTRUCTURA" => $row->NOMBRE_INFRAESTRUCTURA,
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
            $FECHA_POSTERGACION = $_POST['fechaPostergacion'];
            $FECHA_TOTAL = $_POST['taskFecha'];

            $fechaActual = new DateTime();
            $fechadHoy = $fechaActual->format('d/m/Y');

            if ($FECHA_TOTAL != $fechadHoy) {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alert = $mostrar->actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA);
            } else {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert = $mostrar->actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA);
            }
        } else {
            $estado = $_POST['estado'];
            $taskId = $_POST['taskId'];
            $observacionTextArea = $_POST['observacionTextArea'];
            $FECHA_TOTAL = $_POST['taskFecha'];



            $fechaActual = new DateTime();
            $fechadHoy = $fechaActual->format('d/m/Y');


            if ($FECHA_TOTAL != $fechadHoy) {
                $FECHA_ACTUALIZA = $fechadHoy;
                $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA);
            } else {
                $FECHA_ACTUALIZA = $FECHA_TOTAL;
                $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA);
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

            $fechaCreacion = $_POST['fechaCreacion'];
            $codInfraestructura = $_POST['codInfraestructura'];

            $fechaCreacion = new DateTime();
            $fechaCrea = $fechaCreacion->format('Y-m-d');

            $FECHA_CREACION = retunrFechaSqlphp($fechaCrea);

            $fechaTotal = date('Y-m-d', strtotime($fechaCrea . '+' . $taskNdias . ' days'));

            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($fechaTotal)) == 7) {
                $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
            }

            $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            $insert = $mostrar->InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        } else if ($taskNdias == 2) {
            $fechaCreacion = $_POST['fechaCreacion'];
            $codInfraestructura = $_POST['codInfraestructura'];

            $fechaCreacion = new DateTime();
            $fechaCreacion = $fechaCreacion->format('Y-m-d');

            $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

            $fechaTotal = date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days'));

            // Verificar si la fecha total cae en domingo
            if (date('N', strtotime($fechaTotal)) == 7) {
                $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
            }

            $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

            $insert = $mostrar->InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias);

            if ($insert) {
                echo "Inserción exitosa";
            } else {
                echo "Error en la inserción: ";
            }
        } elseif ($taskNdias == 7) {

            if (isset($_POST['fechaPostergacion'])) {

                $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];
                $fechaPostergacion = $_POST['fechaPostergacion'];

                // Verify and format the dates
                $fechaActual = date('Y-m-d');
                $fechaPostergacion = date('Y-m-d', strtotime($fechaPostergacion));

                // Calculate the difference in days
                //$diferenciaDias = (strtotime($fechaPostergacion) - strtotime($fechaActual)) / (60 * 60 * 24);

                $DIAS_DESCUENTO = 2;
                $fechaAcordar = date('Y-m-d', strtotime($fechaPostergacion . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];


                $fechaCreacion = new DateTime();
                $fechaCreacion = $fechaCreacion->format('Y-m-d');

                $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

                $fechaTotal = date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days'));

                // Verificar si la fecha total cae en domingo
                if (date('N', strtotime($fechaTotal)) == 7) {
                    $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
                }

                $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

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

                $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];
                $fechaPostergacion = $_POST['fechaPostergacion'];

                // Verify and format the dates
                $fechaActual = date('Y-m-d');
                $fechaPostergacion = date('Y-m-d', strtotime($fechaPostergacion));

                // Calculate the difference in days
                //$diferenciaDias = (strtotime($fechaPostergacion) - strtotime($fechaActual)) / (60 * 60 * 24);

                $DIAS_DESCUENTO = 2;
                $fechaAcordar = date('Y-m-d', strtotime($fechaPostergacion . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];


                $fechaCreacion = new DateTime();
                $fechaCreacion = $fechaCreacion->format('Y-m-d');

                $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

                $fechaTotal = date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days'));

                // Verificar si la fecha total cae en domingo
                if (date('N', strtotime($fechaTotal)) == 7) {
                    $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
                }

                $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

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

                $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];
                $fechaPostergacion = $_POST['fechaPostergacion'];

                // Verify and format the dates
                $fechaActual = date('Y-m-d');
                $fechaPostergacion = date('Y-m-d', strtotime($fechaPostergacion));

                // Calculate the difference in days
                //$diferenciaDias = (strtotime($fechaPostergacion) - strtotime($fechaActual)) / (60 * 60 * 24);

                $DIAS_DESCUENTO = 2;
                $fechaAcordar = date('Y-m-d', strtotime($fechaPostergacion . '-' . $DIAS_DESCUENTO . ' days'));

                $POSTERGACION = 'SI';

                $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

                if ($insert) {
                    echo "Inserción exitosa";
                } else {
                    echo "Error en la inserción: ";
                }
            } else {
                $fechaCreacion = $_POST['fechaCreacion'];
                $codInfraestructura = $_POST['codInfraestructura'];


                $fechaCreacion = new DateTime();
                $fechaCreacion = $fechaCreacion->format('Y-m-d');

                $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

                $fechaTotal = date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days'));

                // Verificar si la fecha total cae en domingo
                if (date('N', strtotime($fechaTotal)) == 7) {
                    $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
                }

                $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

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
}
