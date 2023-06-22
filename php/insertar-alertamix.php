<?php

require_once "m_almacen.php";
require_once("../funciones/f_funcion.php");

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

    $insert = $mostrar->InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias);

    if ($insert) {
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

        $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

        if ($insert) {
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

        $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

        if ($insert) {
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

        $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

        if ($insert) {
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

        $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

        if ($insert) {
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

        $insert = $mostrar->InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION);

        if ($insert) {
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

        $insert = $mostrar->InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias);

        if ($insert) {
            echo "Inserción exitosa";
        } else {
            echo "Error en la inserción: " . $stm->errorInfo()[2];
        }
    }
}
