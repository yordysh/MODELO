<?php

require_once './php/m_almacen.php';
// require_once './php/DataBaseA.php';
session_start();



// $q = new DataBase();
$q = new m_almacen();
// $conn = $q->Conectar();
if (isset($_POST['insert'])) {
    $USUARIO = $_POST['usuario'];
    $CLAVE = $_POST['clave'];
    $query = $q->MostrarUsuario($USUARIO, $CLAVE);


    if ($query == true) {
        $_SESSION['usuario'] = true;
        $_SESSION['clave'] = $USUARIO;
        header('Location: index.php');
        die();
    } else {
        header('Location: error.html');
        die();
    }
}
