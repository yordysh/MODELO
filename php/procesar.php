<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $fechaInicio = $_POST['fechaInicio'];
//     $numeroDias = $_POST['numeroDias'];

//     // Validar los datos recibidos si es necesario

//     // Calcular la fecha de fin sumando los días
//     $fechaFin = date('Y-m-d', strtotime($fechaInicio . ' + ' . $numeroDias . ' days'));

//     // Calcular los días restantes hasta la fecha de fin
//     $hoy = date('Y-m-d');
//     $diasFaltantes = (strtotime($fechaFin) - strtotime($hoy)) / (60 * 60 * 24);

//     if ($diasFaltantes < 0) {
//         $respuesta = 'La fecha de fin ya ha pasado.';
//     } else {
//         $respuesta = 'Faltan ' . $diasFaltantes . ' días para llegar a la fecha de fin.';
//     }

//     echo $respuesta;
// }
if (isset($_POST['numerodias'])) {
    $numerodias = intval($_POST['numerodias']);

    // Obtener la fecha actual
    $fechaActual = new DateTime();

    // Calcular la fecha final sumando los días ingresados
    $fechaFinal = clone $fechaActual;
    $fechaFinal->add(new DateInterval("P" . $numerodias . "D"));



    // Calcular los días restantes
    $diasRestantes = $fechaActual->diff($fechaFinal)->days;


    // calculo de dias que faltan
    if ($diasRestantes <= 0) {
        $status = "Mantenimiento vencido";
    } elseif ($diasRestantes <= 2) {
        $status = "Está a " . $diasRestantes . " días de vencer";
    }
    if ($diasRestantes <= 1) {
        $status = "Mañana vence";
    }
    echo $diasRestantes;
}

// session_start();

// if (isset($_POST['numerodias'])) {
//     $numerodias = intval($_POST['numerodias']);

//     // Verificar si la variable de sesión está inicializada
//     if (!isset($_SESSION['diasRestantes'])) {
//         $_SESSION['diasRestantes'] = $numerodias;
//     } else {
//         $_SESSION['diasRestantes'] -= $numerodias;
//     }

//     echo $_SESSION['diasRestantes'];
// }
