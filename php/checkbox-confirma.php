<?php
require_once "./registrar.php";
$c = new DataBase();
$conn = $c->Conectar();
if (isset($_POST['observacion'])) {
    $estado = $_POST['estado'];
    $taskId = $_POST['taskId'];
    $observacion = $_POST['observacion'];
    $FECHA_POSTERGACION = $_POST['fechaPostergacion'];

    $stmt = $conn->prepare("UPDATE T_ALERTA SET ESTADO = :estado, OBSERVACION = :observacion, FECHA_POSTERGACION= :fechaPostergacion WHERE COD_ALERTA = :COD_ALERTA");

    // Vincular los parámetros a los marcadores de posición
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':COD_ALERTA', $taskId, PDO::PARAM_STR);
    $stmt->bindParam(':observacion', $observacion, PDO::PARAM_STR);
    $stmt->bindParam(':fechaPostergacion',  $FECHA_POSTERGACION);
} else {
    $estado = $_POST['estado'];
    $taskId = $_POST['taskId'];
    $observacionTextArea = $_POST['observacionTextArea'];

    $stmt = $conn->prepare("UPDATE T_ALERTA SET ESTADO = :estado, OBSERVACION = :observacionTextArea WHERE COD_ALERTA = :COD_ALERTA");

    // Vincular los parámetros a los marcadores de posición
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':observacionTextArea', $observacionTextArea, PDO::PARAM_STR);
    $stmt->bindParam(':COD_ALERTA', $taskId, PDO::PARAM_STR);
}


// Ejecutar la consulta
if ($stmt->execute()) {
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
// Devolver una respuesta JSON
echo json_encode($response);
