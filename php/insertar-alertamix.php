<?php

require_once "DataBaseA.php";
require_once("../funciones/f_funcion.php");
$c = new DataBase();
$conn = $c->Conectar();


$taskNdias = $_POST['taskNdias'];
if ($taskNdias == 1) {
    // $fechaCreacion = $_POST['fechaCreacion'];
    // $codInfraestructura = $_POST['codInfraestructura'];

    // $fechaCreacion = new DateTime();
    // $fechaCreacion = $fechaCreacion->format('Y-m-d');

    // // Verifica si la fecha de creación es sábado
    // // if (date("l", strtotime($fechaCreacion)) === "Saturday") {
    // //     $taskNdias = 2;
    // // }


    // $FECHA_CREACION = retunrFechaSqlphp($fechaCreacion);

    // $fechaTotal = retunrFechaSqlphp(date('Y-m-d', strtotime($fechaCreacion . '+' . $taskNdias . ' days')));
    // if (date('N', strtotime($fechaTotal)) == 7) {
    //     $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
    // }
    // $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

    // $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:N_DIAS_POS)");


    // $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    // $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    // $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    // $stm->bindParam(':N_DIAS_POS', $taskNdias);


    // $insert = $stm->execute();
    // return $insert;

    // if ($insert) {
    //     echo "Inserción exitosa";
    // } else {
    //     echo "Error en la inserción: " . $stm->errorInfo()[2];
    // }
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

    $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:N_DIAS_POS)");


    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert1 = $stm->execute();
    return $insert1;

    if ($insert1) {
        echo "Inserción exitosa";
    } else {
        echo "Error en la inserción: " . $stm->errorInfo()[2];
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

    $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:N_DIAS_POS)");


    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert1 = $stm->execute();
    return $insert1;

    if ($insert1) {
        echo "Inserción exitosa";
    } else {
        echo "Error en la inserción: " . $stm->errorInfo()[2];
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

        $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR, N_DIAS_POS,POSTERGACION) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL, :FECHA_ACORDAR, :N_DIAS_POS,:POSTERGACION)");

        $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
        $stm->bindParam(':FECHA_CREACION', $fechaActual);
        $stm->bindParam(':FECHA_TOTAL', $fechaPostergacion);
        $stm->bindParam(':FECHA_ACORDAR', $fechaAcordar);
        $stm->bindParam(':N_DIAS_POS', $taskNdias);
        $stm->bindParam(':POSTERGACION', $POSTERGACION);

        $insert2 = $stm->execute();

        if ($insert2) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
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

        $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:FECHA_ACORDAR,:N_DIAS_POS)");


        $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
        $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
        $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
        $stm->bindParam(':FECHA_ACORDAR', $FECHA_ACORDAR);
        $stm->bindParam(':N_DIAS_POS', $taskNdias);

        $insert2 = $stm->execute();
        return $insert2;

        if ($insert2) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
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

        $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR, N_DIAS_POS,POSTERGACION) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL, :FECHA_ACORDAR, :N_DIAS_POS,:POSTERGACION)");

        $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
        $stm->bindParam(':FECHA_CREACION', $fechaActual);
        $stm->bindParam(':FECHA_TOTAL', $fechaPostergacion);
        $stm->bindParam(':FECHA_ACORDAR', $fechaAcordar);
        $stm->bindParam(':N_DIAS_POS', $taskNdias);
        $stm->bindParam(':POSTERGACION', $POSTERGACION);

        $insert2 = $stm->execute();

        if ($insert2) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
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

        $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:FECHA_ACORDAR,:N_DIAS_POS)");


        $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
        $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
        $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
        $stm->bindParam(':FECHA_ACORDAR', $FECHA_ACORDAR);
        $stm->bindParam(':N_DIAS_POS', $taskNdias);

        $insert2 = $stm->execute();
        return $insert2;

        if ($insert2) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
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

        $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR, N_DIAS_POS,POSTERGACION) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL, :FECHA_ACORDAR, :N_DIAS_POS,:POSTERGACION)");

        $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
        $stm->bindParam(':FECHA_CREACION', $fechaActual);
        $stm->bindParam(':FECHA_TOTAL', $fechaPostergacion);
        $stm->bindParam(':FECHA_ACORDAR', $fechaAcordar);
        $stm->bindParam(':N_DIAS_POS', $taskNdias);
        $stm->bindParam(':POSTERGACION', $POSTERGACION);

        $insert2 = $stm->execute();

        if ($insert2) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
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

        $stm = $conn->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:FECHA_ACORDAR,:N_DIAS_POS)");


        $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
        $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
        $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
        $stm->bindParam(':FECHA_ACORDAR', $FECHA_ACORDAR);
        $stm->bindParam(':N_DIAS_POS', $taskNdias);

        $insert2 = $stm->execute();
        return $insert2;

        if ($insert2) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
        }
    }
}
