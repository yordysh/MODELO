<?php
require_once("./php/m_almacen.php");
include("./funciones/f_funcion.php");

if ($_POST['accion'] == 'insertar') {
    $respuesta = c_almacen::c_insertar_zona();
    echo $respuesta;
}

if ($_POST['accion'] == 'actualizar') {
    $var1 = $_POST['codzona'];
    $var2 = $_POST['nombrezonaArea'];
    $respuesta = c_almacen::c_actualizar_zona($var1, $var2);
    echo $respuesta;
}
class c_almacen
{

    static function c_balamcen($cod, $oficina)
    {
        $m_formula = new m_almacen();
        $produccion = $m_formula->MostrarAlmacenMuestra(trim($cod), $oficina);

        $dato = array('dato' => $produccion);
        echo json_encode($dato, JSON_FORCE_OBJECT);
    }

    static function c_insertar_zona()
    {
        $m_formula = new m_almacen();
        if (isset($_POST["nombrezonaArea"])) {
            $NOMBRE_T_ZONA_AREAS = trim($_POST['nombrezonaArea']);

            $m_formula->InsertarAlmacen($NOMBRE_T_ZONA_AREAS);

            if (!$m_formula) {
                return "error";
            }

            return "ok";
        }
    }

    function c_actualizar_infra()
    {
        $m_formula = new m_almacen();
        if (isset($_POST["COD_INFRAESTRUCTURA"])) {
            $task_id = $_POST["COD_INFRAESTRUCTURA"];
            $NOMBRE_INFRAESTRUCTURA = $_POST["NOMBRE_INFRAESTRUCTURA"];
            $NDIAS = $_POST["NDIAS"];

            $m_formula->editarInfraestructura($NOMBRE_INFRAESTRUCTURA, $NDIAS, $task_id);

            if ($m_formula) {
                echo "La tarea ha sido actualizada";
            } else {
                echo "Error al actualizar la tarea";
            }
        }
    }

    static function c_actualizar_zona($var1, $var2)
    {

        $m_formula = new m_almacen();

        // if (isset($_POST["codzona"])) {
        if (isset($var1)) {
            // $task_id = $_POST["codzona"];
            // $NOMBRE_T_ZONA_AREAS = $_POST["nombrezonaArea"];

            // $respuesta = $m_formula->editarAlmacen($NOMBRE_T_ZONA_AREAS, $task_id);
            $respuesta = $m_formula->editarAlmacen($var2, $var1);
            if ($respuesta) {
                return "ok";
            } else {
                return "error";
            };
        }
    }

    function c_buscar_infra()
    {
        try {

            $search = $_POST["search"];

            if (!empty($search)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarInfraestructuraBusqueda($search);

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

    function c_buscar_tarea()
    {
        try {
            $search = $_POST["search"];

            if (!empty($search)) {
                $mostrar = new m_almacen();
                $datos = $mostrar->MostrarAlmacenMuestraBusqueda($search);

                if (!$datos) {
                    throw new Exception("Hubo un error en la consulta");
                }

                $json = array();
                foreach ($datos as $row) {
                    $json[] = array(
                        "COD_ZONA" => $row->COD_ZONA,
                        "NOMBRE_T_ZONA_AREAS" => $row->NOMBRE_T_ZONA_AREAS,
                    );
                }
                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function c_checkbox_confirma()
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

    function c_editar_infra()
    {
        $mostrar = new m_almacen();


        if (isset($_POST["COD_INFRAESTRUCTURA"])) {

            $COD_INFRAESTRUCTURA = $_POST["COD_INFRAESTRUCTURA"];

            $select = $mostrar->SelectInfra($COD_INFRAESTRUCTURA);


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

    function c_editar_zona()
    {
        $mostrar = new m_almacen();


        if (isset($_POST["COD_ZONA"])) {
            $COD_ZONA = $_POST["COD_ZONA"];

            $selectZ = $mostrar->SelectZona($COD_ZONA);

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

    function c_eliminar_infra()
    {
        $mostrar = new m_almacen();

        if (isset($_POST['COD_INFRAESTRUCTURA'])) {
            $COD_INFRAESTRUCTURA = $_POST['COD_INFRAESTRUCTURA'];
            $mostrar->eliminarInfraestructura($COD_INFRAESTRUCTURA);
        }
    }

    function c_eliminar_zona()
    {
        $mostrar = new m_almacen();

        if (isset($_POST['COD_ZONA'])) {
            $COD_ZONA = $_POST['COD_ZONA'];
            $mostrar->eliminarAlmacen($COD_ZONA);
        }
    }
    function c_fecha_alerta()
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
            echo "Error: " . $e->getMessage();
        }
    }

    function c_insertar_alertamix()
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
}
