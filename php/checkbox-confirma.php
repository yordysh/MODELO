<?php

require_once "./m_almacen.php";
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
