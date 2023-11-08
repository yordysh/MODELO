<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("./m_insumos.php");
require_once("./m_basedinamica.php");
date_default_timezone_set('America/Lima');

if (isset($_POST['action']) && $_POST['action'] == 'trae_nombre_personal_mezclado1') {
    $dato1 = new controlador_seguimiento();
    $dato1->trae_nombre_personal_mezclado();
} else if (isset($_POST['action']) && $_POST['action'] == 'GuardarDatosMaqueta1') {
    $dato1 = new controlador_seguimiento();
    $dato1->GuardarDatosMaqueta();
}
////////////
else if (isset($_POST['action']) && $_POST['action'] == 'pre_carga_datos_pendientes1') {
    $dato1 = new controlador_seguimiento();
    $dato1->pre_carga_datos_pendientes1();
} else if (isset($_POST['action']) && $_POST['action'] == 'traer_dato_maqueta_1') {
    $dato1 = new controlador_seguimiento();
    $dato1->traer_dato_maqueta_1();
} else if (isset($_POST['action']) && $_POST['action'] == 'traer_datos_cod_producto_produccion1') {
    $dato1 = new controlador_seguimiento();
    $dato1->traer_datos_cod_producto_produccion();
} else if (isset($_POST['action']) && $_POST['action'] == 'traer_datos_reporte_pdf1') {
    $dato1 = new controlador_seguimiento();
    $dato1->traer_datos_reporte_pdf();
} else {
}

class controlador_seguimiento
{

    public function trae_nombre_personal_mezclado()
    {
        $oficina = "SMP2";
        $modeloDinamico = new M_BaseDinamica($oficina);
        $data = $modeloDinamico->buscar_personal();
        //header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
    public function pre_carga_datos_pendientes1()
    {
        $modelo = new m_seguimiento();
        $data = $modelo->pre_carga_datos_pendientes();
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
    public function traer_dato_maqueta_1()
    {
        $modelo = new m_seguimiento();
        $cod_avance_insumos = $_POST['cod_avance_insumos'];
        //var_dump($cod_avance_insumos);
        $data = $modelo->traer_dato_maqueta_1($cod_avance_insumos);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    public function GuardarDatosMaqueta()
    {
        $codigo_avance_insumo = $_POST['codigo_avance_insumo'];
        if (empty($codigo_avance_insumo)) {
            echo json_encode(['status' => 'error', 'message' => 'No se cargo el avance.']);
            exit;
        }
        $cod_encargado = $_POST['codigo_encargado'];
        if (empty($cod_encargado)) {
            echo json_encode(['status' => 'error', 'message' => 'Selecciona un encargado.']);
            exit;
        }
        $nombre_producto = $_POST['nombre_producto'];
        if (empty($nombre_producto)) {
            echo json_encode(['status' => 'error', 'message' => 'No se cargo el producto.']);
            exit;
        }
        $numero_bachada = $_POST['numero_bachada'];
        if (empty($numero_bachada)) {
            echo json_encode(['status' => 'error', 'message' => 'No se cargo el numero de bachada.']);
            exit;
        }
        $peso_mezcla = $_POST['peso_mezcla'];
        if (empty($peso_mezcla)) {
            echo json_encode(['status' => 'error', 'message' => 'No se cargo el peso de mezcla.']);
            exit;
        }
        $lote = $_POST['lote'];
        if (empty($lote)) {
            echo json_encode(['status' => 'error', 'message' => 'No se cargo el lote.']);
            exit;
        }

        $regex_peso = "/^\d{1,4}(\.\d{0,2})?$/";

        if (isset($_POST['contadorFilas'])) {
            $contadorFilas = $_POST['contadorFilas'];

            // Definir mensajes personalizados para cada campo
            $mensajesPersonalizados = [
                'codigo_interno' => 'Código Interno',
                'hora_inicial' => 'Hora Inicial',
                'hora_final' => 'Hora Final',
                'peso' => 'Peso',
                'observaciones' => 'Observaciones',
                'acciones_correctivas' => 'Acciones correctivas',
            ];

            $arrayValidar = array_keys($mensajesPersonalizados);
            $errores = [];

            foreach ($arrayValidar as $campo) {
                if (!isset($_POST[$campo]) || !is_array($_POST[$campo])) {
                    $errores[] = "El campo '{$mensajesPersonalizados[$campo]}' no está completo o está ausente para todas las filas.";
                } else {
                    foreach ($_POST[$campo] as $indice => $valor) {
                        $numFila = $contadorFilas[$indice]; // Usa el valor del contador de filas en lugar del índice directamente

                        if ($campo === 'peso') {
                            if (!preg_match($regex_peso, $valor)) {
                                $errores[] = "El campo '{$mensajesPersonalizados[$campo]}' en el item $numFila debe ser un numero de maximo 4 digitos y 2 decimales.";
                            }
                        } elseif ($campo === 'observaciones') {
                            // Validación para el campo 'observaciones'
                            if (!empty($valor)) {
                                $accionesCorrectivas = $_POST['acciones_correctivas'][$indice];
                                if (empty($accionesCorrectivas)) {
                                    $errores[] = "El campo '{$mensajesPersonalizados['acciones_correctivas']}' en el item $numFila es obligatorio cuando existe '{$mensajesPersonalizados['observaciones']}' .";
                                }
                            }
                        } elseif ($campo === 'hora_inicial') {
                            $horaInicial = $_POST['hora_inicial'][$indice];
                            $horaFinal = $_POST['hora_final'][$indice];

                            if (empty($horaInicial)) {
                                $errores[] = "Debes llenar la 'Hora Inicial' en el ítem $numFila.";
                            }
                            if (empty($horaFinal)) {
                                $errores[] = "Debes llenar la 'Hora Final' en el ítem $numFila.";
                            } else {
                                if (!empty($horaInicial) && !empty($horaFinal)) {
                                    $horaInicialObj = DateTime::createFromFormat('H:i', $horaInicial);
                                    $horaFinalObj = DateTime::createFromFormat('H:i', $horaFinal);

                                    if ($horaFinalObj < $horaInicialObj) {
                                        $errores[] = "La 'Hora Final' en el ítem $numFila no puede ser menor que la 'Hora Inicial'.";
                                    }
                                }
                            }
                        } elseif ($campo === 'codigo_interno' || $campo === 'peso') {
                            if ($valor === null || $valor === "" || empty($valor)) {
                                $errores[] = "El campo '{$mensajesPersonalizados[$campo]}' en el item $numFila está vacío o ausente.";
                            }
                        }
                    }
                }
            }

            if (count($errores) > 0) {
                $mensajeError = implode("<br>", $errores);
                echo json_encode(['status' => 'error', 'message' => $mensajeError]);
                exit;
            }
            // Si no hay errores, los datos son válidos y pueden ser procesados.
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se agregó ninguna fila, debes agregar al menos una fila.']);
            exit;
        }

        $codigo_interno = array_map('strtoupper', $_POST['codigo_interno']);
        $hora_inicial = $_POST['hora_inicial'];
        $hora_final = $_POST['hora_final'];
        $peso = $_POST['peso'];

        if (empty($codigo_interno) || empty($hora_inicial) || empty($hora_final) || empty($peso)) {
            echo json_encode(['status' => 'error', 'message' => 'Al menos uno de los campos está vacío o ausente en alguna(s) fila(s).']);
            exit;
        }
        $contadorFilas = $_POST['contadorFilas'];

        // Verificar la existencia de observaciones y acciones_correctivas en cada fila
        $observaciones = isset($_POST['observaciones']) ? array_map('strtoupper', $_POST['observaciones']) : array_fill(0, count($contadorFilas), null);
        $acciones_correctivas = isset($_POST['acciones_correctivas']) ? array_map('strtoupper', $_POST['acciones_correctivas']) : array_fill(0, count($contadorFilas), null);
        // Reemplaza valores vacíos con null
        $observaciones = array_map(function ($value) {
            return ($value === "") ? null : $value;
        }, $observaciones);
        $acciones_correctivas = array_map(function ($value) {
            return ($value === "") ? null : $value;
        }, $acciones_correctivas);



        $regex_mezcla = "/^\d{1,5}(\.\d{0,3})?$/";
        $totalMezcla = $_POST['totalMezcla'];
        if (empty($totalMezcla) || !preg_match($regex_mezcla, $totalMezcla)) {
            echo json_encode(['status' => 'error', 'message' => 'Campo total de mezcla invalido, debe ser un numero de maximo 5 digitos, y 3 decimales.']);
            exit;
        }
        $regex_merma = "/^\d{1,5}(\.\d{0,3})?$/";
        $totalMerma = $_POST['totalMerma'];
        if (empty($totalMerma) || !preg_match($regex_merma, $totalMerma)) {
            echo json_encode(['status' => 'error', 'message' => 'Campo de merma invalido, debe ser un numero de maximo 5 digitos, y 3 decimales.']);
            exit;
        }

        $modelo = new m_seguimiento();
        $modelo->GuardarDatosMaqueta($codigo_avance_insumo, $cod_encargado, $totalMerma, $codigo_interno, $hora_inicial, $hora_final, $peso, $observaciones, $acciones_correctivas, $contadorFilas, $totalMezcla);
        echo json_encode(array('status' => 'success', 'message' => 'Registro guardado correctamente.'));
    }

    public function traer_datos_cod_producto_produccion()
    {
        $modelo = new m_seguimiento();
        $resultados = $modelo->traer_datos_cod_producto_produccion();
        //var_dump($resultados);

        $response = [];
        foreach ($resultados as $resultado) {
            $cod_producto = $resultado['COD_PRODUCTO'];
            $cod_produccion = $resultado['COD_PRODUCCION'];

            $datosproducto = $modelo->buscar_producto($cod_producto);
            $datosproduccion = $modelo->buscar_produccion($cod_produccion);

            // Aquí combina los resultados de ambos métodos en un array de respuesta
            $response[] = [
                'datos_producto' => $datosproducto,
                'datos_produccion' => $datosproduccion
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    public function traer_datos_reporte_pdf()
    {
        $modelo = new m_seguimiento();
        $modeloDinamico = new M_BaseDinamica('SMP2');

        $cod_producto = $_POST['cod_producto_pdf'];
        $cod_produccion = $_POST['cod_lote_pdf'];

        $resultadosgenerales = $modelo->traer_datos_generales_insumo($cod_producto, $cod_produccion);

        $meses_ingles_espanol = array(
            "January" => "ENERO",
            "February" => "FEBRERO",
            "March" => "MARZO",
            "April" => "ABRIL",
            "May" => "MAYO",
            "June" => "JUNIO",
            "July" => "JULIO",
            "August" => "AGOSTO",
            "September" => "SEPTIEMBRE",
            "October" => "OCTUBRE",
            "November" => "NOVIEMBRE",
            "December" => "DICIEMBRE"
        );

        foreach ($resultadosgenerales as &$resultado) {
            $cod_personal = $resultado['COD_PERSONAL'];
            $nombre_personal = $modeloDinamico->obtener_nombre_personal($cod_personal);
            $resultado['NOM_PERSONAL'] = $nombre_personal; // Agrega el nombre al resultado general

            $cod_avance_insumo = $resultado['COD_AVANCE_INSUMOS'];
            $resultadositem = $modelo->traer_datos_item_insumo($cod_avance_insumo);
            $resultado['items'] = $resultadositem; // Agregar los detalles de los ítems al resultado general

            $dato_version = $modelo->traer_datos_insumo_version();
            $resultado['DATO_VERSION'] = $dato_version;

            $fecha_prueba = $dato_version['FECHA_VERSION'];
            $nombre_mes_ingles = date("F", strtotime($fecha_prueba)); // Obtiene el nombre del mes
            $nombre_mes_espanol = $meses_ingles_espanol[$nombre_mes_ingles];

            $anio = date("Y", strtotime($fecha_prueba)); // Obtiene el año

            $resultado['NOMBRE_MES'] = $nombre_mes_espanol;
            $resultado['ANIO'] = $anio;
        }

        header('Content-Type: application/json');
        echo json_encode($resultadosgenerales, JSON_PRETTY_PRINT);
        exit;
    }
}
