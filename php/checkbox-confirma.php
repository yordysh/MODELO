<?php

require_once "./m_almacen.php";
$mostrar = new m_almacen();

if (isset($_POST['observacion'])) {
    $estado = $_POST['estado'];
    $taskId = $_POST['taskId'];
    $observacion = $_POST['observacion'];
    $FECHA_POSTERGACION = $_POST['fechaPostergacion'];

    $alert = $mostrar->actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION);
} else {
    $estado = $_POST['estado'];
    $taskId = $_POST['taskId'];
    $observacionTextArea = $_POST['observacionTextArea'];

    $alert = $mostrar->actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea);
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
