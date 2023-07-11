<?php


require_once '../MASTER/funciones/DataBaseA.php';
require_once '../MASTER/funciones/f_funcion.php';

session_start();


$conn = new DataBase();
$conectar = $conn->Conectar();
if (isset($_POST['insert'])) {
    $USUARIO = $_POST['usuario'];
    $CLAVE = $_POST['clave'];

    $stm = $conectar->prepare("SELECT * FROM T_USUARIO WHERE USUARIO=:USUARIO AND CLAVE = :CLAVE;");
    $stm->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
    $stm->bindParam(':CLAVE', $CLAVE, PDO::PARAM_STR);
    $stm->execute();
    $datos = $stm->fetchAll(PDO::FETCH_OBJ);


    if ($datos == true) {
        $_SESSION['usuario'] = true;
        $_SESSION['clave'] = $USUARIO;
        f_regSession($anexo, $codusuario, $nombre, $oficina, $zona);
        // header('Location: ../MASTER/control/');
        $redirectUrl = '../MASTER/control_alimento/?usuario=' . urlencode($USUARIO);
        header('Location: ' . $redirectUrl);
        die();
    } else {
        header('Location: error.html');
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login con sesion</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <br>
        <input type="text" name="usuario" placeholder="Digite usuario">
        <br>
        <br>
        <input type="password" name="clave" placeholder="digite contraseña">
        <br>
        <br>
        <input type="submit" value="Entrar" class="btn" name="insert"> <br>
    </form>
</body>

</html>