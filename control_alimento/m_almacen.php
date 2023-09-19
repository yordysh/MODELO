<?php

require_once("../funciones/DataBaseA.php");

class m_almacen
{
  private $bd;
  public function __construct()
  {
    $this->bd = DataBase::Conectar();
  }



  public function MostrarAlmacenMuestra()
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_ZONA_AREAS");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function SelectZona($cod_zona)
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_ZONA_AREAS WHERE COD_ZONA = :COD_ZONA");
      $stm->bindParam(':COD_ZONA', $cod_zona, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarAlmacenMuestraBusqueda($search)
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_ZONA_AREAS WHERE NOMBRE_T_ZONA_AREAS LIKE '$search%' OR COD_ZONA LIKE '$search%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function generarCodigo()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_ZONA) as COD_ZONA FROM T_ZONA_AREAS");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_ZONA']);

    $nuevoCodigo = $maxCodigo + 1;

    $codigoAumento = str_pad($nuevoCodigo, 2, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }

  public function generarCodigoInfraestructura()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_INFRAESTRUCTURA) as COD_INFRAESTRUCTURA FROM T_INFRAESTRUCTURA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_INFRAESTRUCTURA']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 2, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }

  public function generarCodigoControlMaquina()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_CONTROL_MAQUINA) as COD_CONTROL_MAQUINA FROM T_CONTROL_MAQUINA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_CONTROL_MAQUINA']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 3, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }

  public function generarCodigoLimpieza()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_FRECUENCIA) as COD_FRECUENCIA FROM T_FRECUENCIA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_FRECUENCIA']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 2, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function MostrarVersionGeneral($nombre)
  {
    try {

      $stm = $this->bd->prepare("SELECT MAX(VERSION) AS VERSION FROM T_VERSION_GENERAL WHERE NOMBRE ='$nombre'");

      $stm->execute();
      $resultado = $stm->fetch(PDO::FETCH_ASSOC);
      $versionGeneral = $resultado['VERSION'];

      return $versionGeneral;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function generarVersionGeneral($nombre)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_VERSION_GENERAL WHERE NOMBRE = '$nombre'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    $cod = new m_almacen();
    $FECHA_VERSION = $cod->c_horaserversql('F');
    // $FECHA_VERSION = '11/09/2023';

    if ($count == 0) {
      $stm = $this->bd->prepare("SELECT MAX(VERSION) AS VERSION FROM T_VERSION_GENERAL WHERE NOMBRE='$nombre'");
      $stm->execute();
      $resultado = $stm->fetch(PDO::FETCH_ASSOC);
      $maxContador = intval($resultado['VERSION']);

      if ($maxContador == 0) {
        $max = 1;

        $codPrefix = str_pad($max, 2, '0', STR_PAD_LEFT);

        $stm = $this->bd->prepare("INSERT INTO T_VERSION_GENERAL (VERSION,NOMBRE,FECHA_VERSION)
        VALUES ('$codPrefix','$nombre','$FECHA_VERSION')");
        $stm->execute();
      }
    } else {

      $stm = $this->bd->prepare("SELECT MAX(VERSION) AS VERSION FROM T_VERSION_GENERAL WHERE NOMBRE='$nombre'");

      $stm->execute();
      $resultado = $stm->fetch(PDO::FETCH_ASSOC);
      $maxContador = intval($resultado['VERSION']);
      // echo "else" . $maxContador;
      $maxContador =  $maxContador + 1;

      $codPrefix = str_pad($maxContador, 2, '0', STR_PAD_LEFT);

      $mesAnioHoy = date('Y-m', strtotime(str_replace('/', '-',  $FECHA_VERSION)));

      $stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE CONVERT(VARCHAR(7), FECHA_VERSION, 126) = '$mesAnioHoy' AND NOMBRE = '$nombre'");
      $stmver->execute();
      $valor = $stmver->fetchAll();
      $valor1 = count($valor);
      // echo "FECHA" . $valor1;
      if ($valor1 === 0) {
        $stmVersion = $this->bd->prepare("UPDATE T_VERSION_GENERAL SET VERSION = '$codPrefix', FECHA_VERSION='$FECHA_VERSION'  WHERE NOMBRE='$nombre'");
        $stmVersion->execute();
      }
    }
  }



  public function generarVersion()
  {

    $stm = $this->bd->prepare("SELECT MAX(VERSION) as VERSION FROM T_VERSION");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxContadorVersion = $resultado['VERSION'];
    if ($maxContadorVersion == null) {
      $maxContadorVersion = 0;
    }

    $fechaDHoy = date('Y-m-d');
    $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");
    $stmver->execute();
    $valor = $stmver->fetchAll();

    $valor1 = count($valor);
    if ($valor1 == 0) {
      $nuevaversion = $maxContadorVersion + 1;
      $versionAumento = str_pad($nuevaversion, 2, '0', STR_PAD_LEFT);
    } else {
      $maxContadorVersion;

      $versionAumento = str_pad($maxContadorVersion, 2, '0', STR_PAD_LEFT);
    }

    return $versionAumento;
  }

  public function contarRegistrosZona($NOMBRE_T_ZONA_AREAS)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_ZONA_AREAS WHERE NOMBRE_T_ZONA_AREAS = :NOMBRE_T_ZONA_AREAS");
    $repetir->bindParam(':NOMBRE_T_ZONA_AREAS', $NOMBRE_T_ZONA_AREAS, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function contarRegistrosInfraestructura($NOMBRE_INFRAESTRUCTURA, $valorSeleccionado)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_INFRAESTRUCTURA WHERE NOMBRE_INFRAESTRUCTURA = :NOMBRE_INFRAESTRUCTURA AND COD_ZONA = :COD_ZONA");
    $repetir->bindParam(':NOMBRE_INFRAESTRUCTURA', $NOMBRE_INFRAESTRUCTURA, PDO::PARAM_STR);
    $repetir->bindParam(':COD_ZONA', $valorSeleccionado, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function contarRegistrosControl($NOMBRE_CONTROL_MAQUINA, $valorSeleccionado)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_CONTROL_MAQUINA WHERE NOMBRE_CONTROL_MAQUINA = :NOMBRE_CONTROL_MAQUINA AND COD_ZONA= :COD_ZONA");
    $repetir->bindParam(':NOMBRE_CONTROL_MAQUINA', $NOMBRE_CONTROL_MAQUINA, PDO::PARAM_STR);
    $repetir->bindParam(':COD_ZONA', $valorSeleccionado, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }

  public function contarRegistrosLimpieza($textfrecuencia, $selectZona)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_FRECUENCIA WHERE NOMBRE_FRECUENCIA = :NOMBRE_FRECUENCIA AND COD_ZONA=:COD_ZONA");
    $repetir->bindParam(':NOMBRE_FRECUENCIA', $textfrecuencia, PDO::PARAM_STR);
    $repetir->bindParam(':COD_ZONA', $selectZona, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }

  public function InsertarAlmacen($NOMBRE_T_ZONA_AREAS)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_ZONA = $cod->generarCodigo();
      // $VERSION = $cod->generarVersion();
      $nombre = 'LBS-PHS-FR-01';


      $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);

      $FECHA = $cod->c_horaserversql('F');
      // $FECHA = '02/09/2023';
      //$FECHA = date('Y-m-d');
      $mesAnioHoy = date('Y-m', strtotime(str_replace('/', '-',  $FECHA)));
      if ($repetir == 0) {
        $VERSION = $cod->generarVersionGeneral($nombre);

        $stm = $this->bd->prepare("INSERT INTO T_ZONA_AREAS (COD_ZONA, NOMBRE_T_ZONA_AREAS, FECHA)
                                  VALUES ( '$COD_ZONA', '$NOMBRE_T_ZONA_AREAS', '$FECHA')");


        $insert = $stm->execute();

        //$fechaDHoy = date('Y-m-d');
        // $fechaDHoy = $cod->c_horaserversql('F');


        // if ($VERSION == '01') {
        //   // $stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE CONVERT(VARCHAR(7), FECHA_VERSION, 126) = '$mesAnioHoy' AND NOMBRE = '$nombre'");
        //   // //$stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE cast(FECHA_VERSION as DATE) =cast('$FECHA_CREACION' as date) AND NOMBRE='$nombre'");
        //   // $stmver->execute();
        //   // $valor = $stmver->fetchAll();

        //   // $valor1 = count($valor);

        //   // if ($valor1 == 0) {
        //   $stmVersion = $this->bd->prepare("UPDATE T_VERSION_GENERAL SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION WHERE NOMBRE=:nombre");
        //   $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        //   $stmVersion->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        //   $stmVersion->bindParam(':FECHA_VERSION', $FECHA);

        //   $stmVersion->execute();
        //   // }
        // } else {

        //   // $stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE CONVERT(VARCHAR(7), FECHA_VERSION, 126) = '$mesAnioHoy' AND NOMBRE = '$nombre'");
        //   // $stmver->execute();
        //   // $valor = $stmver->fetchAll();

        //   // $valor1 = count($valor);

        //   // if ($valor1 == 0) {
        //   $stmVersion = $this->bd->prepare("UPDATE T_VERSION_GENERAL SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION WHERE NOMBRE=:nombre");
        //   $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        //   $stmVersion->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        //   $stmVersion->bindParam(':FECHA_VERSION', $FECHA);

        //   $stmVersion->execute();
        //   // }
        // }

        $insert = $this->bd->commit();

        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function editarAlmacen($NOMBRE_T_ZONA_AREAS, $task_id)
  {
    try {
      $this->bd->beginTransaction();

      $cod = new m_almacen();
      $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);
      $nombre = 'LBS-PHS-FR-01';

      if ($repetir == 0) {
        $stmt = $this->bd->prepare("UPDATE T_ZONA_AREAS SET NOMBRE_T_ZONA_AREAS = UPPER(:NOMBRE_T_ZONA_AREAS), VERSION =:VERSION WHERE COD_ZONA = :COD_ZONA");


        $VERSION = $cod->generarVersion();

        $stmt->bindParam(':NOMBRE_T_ZONA_AREAS', $NOMBRE_T_ZONA_AREAS, PDO::PARAM_STR);
        $stmt->bindParam(':COD_ZONA', $task_id, PDO::PARAM_INT);
        $stmt->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        $update = $stmt->execute();

        $cod->generarVersionGeneral($nombre);
        // $fechaDHoy = date('Y-m-d');
        // $fechaDHoy = $cod->c_horaserversql('F');

        // if ($VERSION == '01') {
        //   $stm1 = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) values(:version)");
        //   $stm1->bindParam(':version', $VERSION, PDO::PARAM_STR);
        //   $stm1->execute();
        // } else {
        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stm1 = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
        //     $stm1->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        //     $stm1->bindParam(':FECHA_VERSION', $fechaDHoy);
        //     $stm1->execute();
        //   }
        // }

        $update = $this->bd->commit();

        return $update;
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function eliminarAlmacen($COD_ZONA)
  {
    try {

      $stm = $this->bd->prepare("DELETE FROM T_ZONA_AREAS WHERE COD_ZONA = :COD_ZONA");
      $stm->bindParam(':COD_ZONA', $COD_ZONA, PDO::PARAM_INT);

      $delete = $stm->execute();
      return $delete;
    } catch (Exception $e) {
      die("Error al eliminar los datos: " . $e->getMessage());
    }
  }

  public function MostrarInfraestructura()
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_INFRAESTRUCTURA;");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarInfraestructuraTabla()
  {
    try {

      $stm = $this->bd->prepare(" SELECT I.COD_INFRAESTRUCTURA, Z.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS, NOMBRE_INFRAESTRUCTURA, I.NDIAS, I.FECHA,I.VERSION,USUARIO FROM T_INFRAESTRUCTURA AS I
      INNER JOIN T_ZONA_AREAS AS Z ON I.COD_ZONA=Z.COD_ZONA;");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarInfraestructuraBusqueda($search)
  {
    try {


      $stm = $this->bd->prepare("SELECT T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                                 T_INFRAESTRUCTURA.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA, T_INFRAESTRUCTURA.NDIAS AS NDIAS ,T_INFRAESTRUCTURA.FECHA AS FECHA,
                                 T_INFRAESTRUCTURA.USUARIO AS USUARIO  FROM T_INFRAESTRUCTURA
                                 INNER JOIN T_ZONA_AREAS ON T_INFRAESTRUCTURA.COD_ZONA = T_ZONA_AREAS.COD_ZONA WHERE T_INFRAESTRUCTURA.NOMBRE_INFRAESTRUCTURA LIKE '$search%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function SelectInfra($COD_INFRAESTRUCTURA)
  {
    try {

      $stm = $this->bd->prepare("SELECT T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,
                                  T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                                  T_INFRAESTRUCTURA.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA,
                                  T_INFRAESTRUCTURA.NDIAS AS NDIAS,T_INFRAESTRUCTURA.FECHA AS FECHA,
                                  T_INFRAESTRUCTURA.USUARIO AS USUARIO  FROM T_INFRAESTRUCTURA
                                  INNER JOIN T_ZONA_AREAS ON T_INFRAESTRUCTURA.COD_ZONA = T_ZONA_AREAS.COD_ZONA WHERE COD_INFRAESTRUCTURA = :COD_INFRAESTRUCTURA");
      $stm->bindParam(':COD_INFRAESTRUCTURA', $COD_INFRAESTRUCTURA, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarVersion()
  {
    try {


      $stm = $this->bd->prepare("SELECT FECHA_VERSION FROM T_VERSION ");

      $stm->execute();
      $datos = $stm->fetchAll();
      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function c_horaserversql($tipo)
  {
    try {
      $second_name = $tipo;
      $weight = '';
      $stmt = $this->bd->prepare("{CALL SP_FECHASISTEMA (?,?)}");
      $stmt->bindParam(1, $second_name);
      $stmt->bindParam(2, $weight, PDO::PARAM_STR, 10);
      $rpta = $stmt->execute();
      return $weight;
    } catch (Exception $e) {
      print_r("Error al buscar fecha sql" . $e);
    }
  }
  public function insertarInfraestructura($valorSeleccionado, $NOMBRE_INFRAESTRUCTURA, $NDIAS)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_INFRAESTRUCTURA = $cod->generarCodigoInfraestructura();
      $VERSION = $cod->generarVersion();
      $repetir = $cod->contarRegistrosInfraestructura($NOMBRE_INFRAESTRUCTURA, $valorSeleccionado);

      $FECHA = $cod->c_horaserversql('F');
      $nombre = 'LBS-PHS-FR-01';
      // $FECHA = date('Y-m-d');

      if ($repetir == 0) {

        $stm = $this->bd->prepare("INSERT INTO T_INFRAESTRUCTURA  (COD_INFRAESTRUCTURA, COD_ZONA,NOMBRE_INFRAESTRUCTURA ,NDIAS, FECHA,VERSION)
                                  VALUES ('$COD_INFRAESTRUCTURA','$valorSeleccionado', '$NOMBRE_INFRAESTRUCTURA ','$NDIAS', '$FECHA', '$VERSION')");
        // var_dump($stm);
        $insert = $stm->execute();

        // $fechaDHoy = date('Y-m-d');
        //$fechaDHoy = '19/07/2023';
        $fechaDHoy  = $cod->c_horaserversql('F');
        $cod->generarVersionGeneral($nombre);
        // if ($VERSION == '01') {
        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stmVersion = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) values(:version)");
        //     $stmVersion->bindParam(':version', $VERSION, PDO::PARAM_STR);
        //     $stmVersion->execute();
        //   }
        // } else {
        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stmVersion = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
        //     $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        //     $stmVersion->bindParam(':FECHA_VERSION', $fechaDHoy);
        //     $stmVersion->execute();
        //   }
        // }




        $DIAS_DESCUENTO = 2;

        $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA);
        $FECHA_TOTAL = $FECHA_FORMATO->modify("+$NDIAS days")->format('d-m-Y');
        // $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA . '+ ' . $NDIAS));
        // Verificar si la fecha total cae en domingo
        if (date('N', strtotime($FECHA_TOTAL)) == 7) {
          $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA_TOTAL . '+1 day'));
        }

        if (!($NDIAS == 1 || $NDIAS == 2)) {
          $FECHA_ACORDAR = date('d-m-Y', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days'));
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA(COD_INFRAESTRUCTURA,FECHA_CREACION,FECHA_TOTAL,FECHA_ACORDAR,N_DIAS_POS) values('$COD_INFRAESTRUCTURA','$FECHA','$FECHA_TOTAL','$FECHA_ACORDAR','$NDIAS')");
        } else {
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA(COD_INFRAESTRUCTURA,FECHA_CREACION,FECHA_TOTAL,N_DIAS_POS) values('$COD_INFRAESTRUCTURA','$FECHA','$FECHA_TOTAL','$NDIAS')");
        }



        $stm1->execute();
        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function editarInfraestructura($NOMBRE_INFRAESTRUCTURA, $NDIAS, $task_id)
  {
    try {

      $stmt = $this->bd->prepare("UPDATE T_INFRAESTRUCTURA SET NOMBRE_INFRAESTRUCTURA = UPPER(:NOMBRE_INFRAESTRUCTURA), NDIAS = :NDIAS  WHERE COD_INFRAESTRUCTURA = :COD_INFRAESTRUCTURA");
      $stmt->bindParam(':COD_INFRAESTRUCTURA', $task_id, PDO::PARAM_STR);
      $stmt->bindParam(':NOMBRE_INFRAESTRUCTURA', $NOMBRE_INFRAESTRUCTURA, PDO::PARAM_STR);
      $stmt->bindParam(':NDIAS', $NDIAS, PDO::PARAM_STR);
      $update = $stmt->execute();

      return $update;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function eliminarInfraestructura($COD_INFRAESTRUCTURA)
  {
    try {

      $stm = $this->bd->prepare("DELETE FROM T_INFRAESTRUCTURA WHERE COD_INFRAESTRUCTURA = :COD_INFRAESTRUCTURA");
      $stm->bindParam(':COD_INFRAESTRUCTURA', $COD_INFRAESTRUCTURA, PDO::PARAM_STR);

      $delete = $stm->execute();
      return $delete;
    } catch (Exception $e) {
      die("Error al eliminar los datos: " . $e->getMessage());
    }
  }
  // public function MostrarUsuario($USUARIO, $CLAVE)
  // {
  //   try {

  //     $stm = $this->bd->prepare("SELECT * FROM T_USUARIO WHERE USUARIO=:USUARIO AND CLAVE = :CLAVE;");
  //     $stm->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
  //     $stm->bindParam(':CLAVE', $CLAVE, PDO::PARAM_STR);
  //     $stm->execute();
  //     $datos = $stm->fetchAll(PDO::FETCH_OBJ);

  //     return $datos;
  //   } catch (Exception $e) {
  //     die($e->getMessage());
  //   }
  // }

  public function AlertaMensaje()
  {
    try {
      $stm = $this->bd->prepare("SELECT T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_AREA,T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,
      T_INFRAESTRUCTURA.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA,T_INFRAESTRUCTURA.NDIAS AS NDIAS,T_ALERTA.COD_ALERTA AS COD_ALERTA,
      T_ALERTA.FECHA_CREACION AS FECHA_CREACION,T_ALERTA.FECHA_TOTAL AS FECHA_TOTAL, T_ALERTA.FECHA_ACORDAR AS FECHA_ACORDAR, T_ALERTA.ESTADO AS ESTADO FROM T_ALERTA INNER JOIN T_INFRAESTRUCTURA
      ON T_ALERTA.COD_INFRAESTRUCTURA= T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA inner join T_ZONA_AREAS ON
      T_ZONA_AREAS.COD_ZONA= T_INFRAESTRUCTURA.COD_ZONA
      WHERE FECHA_ACORDAR IS NOT NULL AND
    CAST(FECHA_ACORDAR AS DATE) <= CAST(GETDATE() as DATE) AND  CAST(GETDATE() as DATE) < CAST(FECHA_TOTAL AS DATE)");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarAlerta()
  {
    try {

      $stm = $this->bd->prepare("SELECT T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_AREA,T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,
      T_INFRAESTRUCTURA.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA,T_INFRAESTRUCTURA.NDIAS AS NDIAS,T_ALERTA.COD_ALERTA AS COD_ALERTA,
      T_ALERTA.FECHA_CREACION AS FECHA_CREACION,T_ALERTA.FECHA_TOTAL AS FECHA_TOTAL, T_ALERTA.FECHA_ACORDAR AS FECHA_ACORDAR,
      T_ALERTA.ESTADO AS ESTADO, T_ALERTA.N_DIAS_POS AS N_DIAS_POS, T_ALERTA.POSTERGACION AS POSTERGACION FROM T_ALERTA INNER JOIN T_INFRAESTRUCTURA
      ON T_ALERTA.COD_INFRAESTRUCTURA= T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA inner join T_ZONA_AREAS ON
      T_ZONA_AREAS.COD_ZONA= T_INFRAESTRUCTURA.COD_ZONA
      WHERE CAST(FECHA_TOTAL AS DATE)   <= CAST(GETDATE() AS DATE)   AND ESTADO='P' ");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function InsertarAlerta($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $taskNdias)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:N_DIAS_POS)");


    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert1 = $stm->execute();
    return $insert1;
  }

  public function InsertarAlertaMayor($codInfraestructura, $fechaActual, $fechaPostergacion, $fechaAcordar, $taskNdias, $POSTERGACION)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL,FECHA_ACORDAR, N_DIAS_POS,POSTERGACION) VALUES ( '$codInfraestructura','$fechaActual', '$fechaPostergacion','$fechaAcordar','$taskNdias','$POSTERGACION')");

    $insert2 = $stm->execute();
    return $insert2;
  }

  public function InsertarAlertaMayorSinPost($FECHA_CREACION, $codInfraestructura, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR,N_DIAS_POS) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:FECHA_ACORDAR,:N_DIAS_POS)");


    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':FECHA_ACORDAR', $FECHA_ACORDAR);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert2 = $stm->execute();
    return $insert2;
  }

  public function actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion)
  {

    $stmt = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO = '$estado', OBSERVACION = '$observacion', FECHA_POSTERGACION= '$FECHA_POSTERGACION', FECHA_TOTAL = '$FECHA_ACTUALIZA', ACCION_CORRECTIVA = '$accionCorrectiva', VERIFICACION_REALIZADA='$selectVerificacion' WHERE COD_ALERTA = '$taskId'");
    $stmt->execute();
    return $stmt;
  }

  public function actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion)
  {
    // $fecha_actualiza = convFecSistema1($FECHA_ACTUALIZA);
    $stmt = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO = :estado, OBSERVACION = :observacionTextArea, FECHA_TOTAL = :FECHA_ACTUALIZA, ACCION_CORRECTIVA = :ACCION_CORRECTIVA, VERIFICACION_REALIZADA=:VERIFICACION_REALIZADA WHERE COD_ALERTA = :COD_ALERTA");


    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':observacionTextArea', $observacionTextArea, PDO::PARAM_STR);
    $stmt->bindParam(':COD_ALERTA', $taskId, PDO::PARAM_STR);
    $stmt->bindParam(':FECHA_ACTUALIZA', $FECHA_ACTUALIZA);
    $stmt->bindParam(':ACCION_CORRECTIVA', $accionCorrectiva);
    $stmt->bindParam(':VERIFICACION_REALIZADA', $selectVerificacion);
    $stmt->execute();
    return $stmt;
  }


  public function MostrarInfraestructuraPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {
      $stm = $this->bd->prepare("SELECT * FROM V_LISTADO_MONITOREOPDF WHERE MONTH(FECHA_TOTAL) = '$mesSeleccionado' AND YEAR(FECHA_TOTAL) = '$anioSeleccionado'");

      $stm->execute();
      $datos = $stm->fetchAll();
      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function VersionMostrar()
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_VERSION"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }





  public function MostrarSoluciones()
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_SOLUCIONES"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarPreparaciones($ID_SOLUCIONES)
  {
    try {
      $stm = $this->bd->prepare(
        "SELECT * FROM T_PREPARACIONES WHERE ID_SOLUCIONES=:ID_SOLUCIONES"
      );
      $stm->bindParam(':ID_SOLUCIONES', $ID_SOLUCIONES);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarCantidades($ID_PREPARACIONES)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_CANTIDAD WHERE ID_PREPARACIONES=:ID_PREPARACIONES"
      );
      $stm->bindParam(':ID_PREPARACIONES', $ID_PREPARACIONES);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarML($ID_CANTIDAD)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_ML WHERE ID_CANTIDAD=:ID_CANTIDAD"
      );
      $stm->bindParam(':ID_CANTIDAD', $ID_CANTIDAD);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarL($ID_L)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT T_L.ID_L AS ID_LI, T_L.CANTIDAD_LITROS AS CANTIDAD_LITROS  FROM T_ML
        INNER JOIN T_L  ON T_ML.ID_L=T_L.ID_L WHERE ID_ML=:ID_L"
      );
      $stm->bindParam(':ID_L', $ID_L);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarPreparacionSoluciones()
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT TS.NOMBRE_INSUMOS AS NOMBRE_INSUMOS, TP.NOMBRE_PREPARACION AS NOMBRE_PREPARACION,
                                  TC.CANTIDAD_PORCENTAJE AS CANTIDAD_PORCENTAJE,TM.CANTIDAD_MILILITROS AS CANTIDAD_MILILITROS,
                                  TL.CANTIDAD_LITROS AS CANTIDAD_LITROS  FROM T_SOLUCIONES AS TS
                                  INNER JOIN T_PREPARACIONES AS TP ON TP.ID_SOLUCIONES = TS.ID_SOLUCIONES
                                  INNER JOIN T_CANTIDAD AS TC ON TC.ID_PREPARACIONES = TP.ID_PREPARACIONES
                                  INNER JOIN T_ML AS TM ON TM.ID_CANTIDAD=TC.ID_CANTIDAD
                                  INNER JOIN T_L AS TL ON TL.ID_L = TM.ID_L"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function insertarCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion)
  {
    try {
      $cod = new m_almacen();
      $nombre = 'LBS-PHS-FR-02';
      $fechaDHoy = $cod->c_horaserversql('F');
      // $fechaDHoy = date('Y-m-d');

      $stmU = $this->bd->prepare("SELECT * FROM T_UNION WHERE cast(FECHA as DATE) =cast('$fechaDHoy' as date)");
      $stmU->execute();
      $valor = $stmU->fetchAll();

      $valor1 = count($valor);

      if ($valor1 == 0) {
        $stm = $this->bd->prepare("INSERT INTO T_UNION(NOMBRE_INSUMOS, NOMBRE_PREPARACION,CANTIDAD_PORCENTAJE,
                                    CANTIDAD_MILILITROS, CANTIDAD_LITROS, OBSERVACION, ACCION_CORRECTIVA, VERIFICACION)
                                  VALUES ('$selectSolucion','$selectPreparacion', '$selectCantidad','$selectML', '$selectL','$textAreaObservacion','$textAreaAccion','$selectVerificacion')");

        $insert = $stm->execute();
        $cod->generarVersionGeneral($nombre);
      }

      return $insert;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function MostrarUnionBusqueda($search)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_UNION WHERE NOMBRE_PREPARACION LIKE '$search%'"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarPreparacionSolucionPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_UNION WHERE MONTH(FECHA) = :mesSeleccionado AND YEAR(FECHA) = :anioSeleccionado"
      );
      $stm->bindParam(':mesSeleccionado', $mesSeleccionado);
      $stm->bindParam(':anioSeleccionado', $anioSeleccionado);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function MostrarLimpiezaBusqueda($search)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT T_FRECUENCIA.COD_FRECUENCIA AS COD_FRECUENCIA,
        T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
        T_FRECUENCIA.NOMBRE_FRECUENCIA AS NOMBRE_FRECUENCIA ,T_FRECUENCIA.FECHA AS FECHA,
        T_FRECUENCIA.VERSION AS VERSION  FROM T_FRECUENCIA INNER JOIN T_ZONA_AREAS
        ON T_FRECUENCIA.COD_ZONA=T_ZONA_AREAS.COD_ZONA WHERE T_FRECUENCIA.NOMBRE_FRECUENCIA LIKE '$search%'"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function insertarLimpieza($selectZona, $textfrecuencia,  $textAreaObservacion,  $textAreaAccion, $selectVerificacion)
  {
    try {

      $this->bd->beginTransaction();
      $codGen = new m_almacen();
      $nombre = 'LBS-PHS-FR-04';

      $codFrecuencia = $codGen->generarCodigoLimpieza();
      $version = $codGen->generarVersion();

      $fechaDHoy = $codGen->c_horaserversql('F');
      // $fechaDHoy = date('Y-m-d');

      $stmFre = $this->bd->prepare("SELECT * FROM T_FRECUENCIA WHERE cast(FECHA as DATE) =cast('$fechaDHoy' as date) AND NOMBRE_FRECUENCIA='$textfrecuencia' AND COD_ZONA='$selectZona'");

      $stmFre->execute();
      $valor = $stmFre->fetchAll();

      $contador = count($valor);

      if ($contador == 0) {

        $stm = $this->bd->prepare("INSERT INTO T_FRECUENCIA(COD_FRECUENCIA, COD_ZONA, NOMBRE_FRECUENCIA, VERSION,OBSERVACION,ACCION_CORRECTIVA,VERIFICACION)
                                  VALUES ('$codFrecuencia','$selectZona', '$textfrecuencia','$version','$textAreaObservacion','$textAreaAccion','$selectVerificacion')");

        $insert = $stm->execute();
        $codGen->generarVersionGeneral($nombre);
        // if ($version == '01') {

        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stm1 = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) VALUES ( :version)");
        //     $stm1->bindParam(':version', $version, PDO::PARAM_STR);
        //     $stm1->execute();
        //   }
        // } else {
        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stm1 = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
        //     $stm1->bindParam(':VERSION', $version, PDO::PARAM_STR);
        //     $stm1->bindParam(':FECHA_VERSION', $fechaDHoy);
        //     $stm1->execute();
        //   }
        // }

        $insert = $this->bd->commit();

        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function SelectLimpieza($cod_frecuencia)
  {
    try {

      $stm = $this->bd->prepare("SELECT T_FRECUENCIA.COD_FRECUENCIA AS COD_FRECUENCIA,
      T_FRECUENCIA.NOMBRE_FRECUENCIA AS NOMBRE_FRECUENCIA,
      T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS
      FROM T_FRECUENCIA INNER JOIN T_ZONA_AREAS ON T_FRECUENCIA.COD_ZONA=T_ZONA_AREAS.COD_ZONA WHERE COD_FRECUENCIA=:COD_FRECUENCIA");
      $stm->bindParam(':COD_FRECUENCIA', $cod_frecuencia, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function editarLimpieza($codfre, $textfrecuencia)
  {
    try {

      $codGen = new m_almacen();
      $nombre = 'LBS-PHS-FR-04';

      $stmt = $this->bd->prepare("UPDATE T_FRECUENCIA SET NOMBRE_FRECUENCIA = UPPER(:NOMBRE_FRECUENCIA)  WHERE COD_FRECUENCIA = :COD_FRECUENCIA");
      $stmt->bindParam(':COD_FRECUENCIA', $codfre, PDO::PARAM_STR);
      $stmt->bindParam(':NOMBRE_FRECUENCIA', $textfrecuencia, PDO::PARAM_STR);
      $update = $stmt->execute();
      $codGen->generarVersionGeneral($nombre);
      return $update;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarLimpiezaPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM V_LISTADO_LIMPIEZAPDF WHERE MONTH(FECHA) = :mesSeleccionado AND YEAR(FECHA) = :anioSeleccionado"
      );
      $stm->bindParam(':mesSeleccionado', $mesSeleccionado);
      $stm->bindParam(':anioSeleccionado', $anioSeleccionado);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function MostrarControlMaquinasBusqueda($search)
  {
    try {

      $stm = $this->bd->prepare("SELECT C.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA, Z.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                                  C.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA, C.N_DIAS_CONTROL AS N_DIAS_CONTROL, C.FECHA AS FECHA,
                                  C.OBSERVACION AS OBSERVACION, C.ACCION_CORRECTIVA AS ACCION_CORRECTIVA FROM T_CONTROL_MAQUINA AS C
                                  INNER JOIN T_ZONA_AREAS AS Z ON C.COD_ZONA=Z.COD_ZONA WHERE NOMBRE_CONTROL_MAQUINA LIKE '$search%' OR COD_CONTROL_MAQUINA LIKE '$search%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function insertarControl($valorSeleccionado, $NOMBRE_CONTROL_MAQUINA, $N_DIAS_CONTROL)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_CONTROL_MAQUINA = $cod->generarCodigoControlMaquina();
      $nombre = 'LBS-PHS-FR-03';
      //var_dump("codio" . $COD_CONTROL_MAQUINA);
      $VERSION = $cod->generarVersion();
      $repetir = $cod->contarRegistrosControl($NOMBRE_CONTROL_MAQUINA, $valorSeleccionado);

      $FECHA = $cod->c_horaserversql('F');
      // $FECHA = date('Y-m-d');
      // $FECHA = '24/07/2023';
      // var_dump($FECHA);

      if ($repetir == 0) {

        $stm = $this->bd->prepare("INSERT INTO T_CONTROL_MAQUINA(COD_CONTROL_MAQUINA, COD_ZONA,NOMBRE_CONTROL_MAQUINA ,N_DIAS_CONTROL, FECHA,VERSION)
                                  VALUES ('$COD_CONTROL_MAQUINA','$valorSeleccionado', '$NOMBRE_CONTROL_MAQUINA','$N_DIAS_CONTROL', '$FECHA', '$VERSION')");

        $insert = $stm->execute();
        // $fechaDHoy = date('Y-m-d');
        // $fechaDHoy = '24/07/2023';
        $fechaDHoy  = $cod->c_horaserversql('F');
        $cod->generarVersionGeneral($nombre);
        // if ($VERSION == '01') {
        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stmVersion = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) values(:version)");
        //     $stmVersion->bindParam(':version', $VERSION, PDO::PARAM_STR);
        //     $stmVersion->execute();
        //   }
        // } else {
        //   $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


        //   $stmver->execute();
        //   $valor = $stmver->fetchAll();

        //   $valor1 = count($valor);

        //   if ($valor1 == 0) {
        //     $stmVersion = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
        //     $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        //     $stmVersion->bindParam(':FECHA_VERSION', $fechaDHoy);
        //     $stmVersion->execute();
        //   }
        // }

        $DIAS_DESCUENTO = 2;

        $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA);
        $FECHA_TOTAL = $FECHA_FORMATO->modify("+$N_DIAS_CONTROL days")->format('d-m-Y');
        // $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA . '+ ' . $N_DIAS_CONTROL));
        // Verificar si la fecha total cae en domingo
        if (date('N', strtotime($FECHA_TOTAL)) == 7) {
          $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA_TOTAL . '+1 day'));
        }

        if (!($N_DIAS_CONTROL == 1 || $N_DIAS_CONTROL == 2)) {
          $FECHA_ACORDAR = date('d-m-Y', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days'));
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_CREACION,FECHA_TOTAL,FECHA_ACORDAR,N_DIAS_POS) values('$COD_CONTROL_MAQUINA','$FECHA','$FECHA_TOTAL','$FECHA_ACORDAR','$N_DIAS_CONTROL')");
        } else {
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_CREACION,FECHA_TOTAL,N_DIAS_POS) values('$COD_CONTROL_MAQUINA','$FECHA','$FECHA_TOTAL','$N_DIAS_CONTROL')");
        }



        $stm1->execute();
        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function SelectControlMaquina($COD_CONTROL_MAQUINA)
  {
    try {

      $stm = $this->bd->prepare("SELECT C.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA, Z.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
      C.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA, C.N_DIAS_CONTROL AS N_DIAS_CONTROL, C.FECHA AS FECHA,
      C.OBSERVACION AS OBSERVACION, C.ACCION_CORRECTIVA AS ACCION_CORRECTIVA FROM T_CONTROL_MAQUINA AS C
      INNER JOIN T_ZONA_AREAS AS Z ON C.COD_ZONA=Z.COD_ZONA WHERE COD_CONTROL_MAQUINA = :COD_CONTROL_MAQUINA");
      $stm->bindParam(':COD_CONTROL_MAQUINA', $COD_CONTROL_MAQUINA, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function   editarControlMaquina($NOMBRE_CONTROL, $N_DIAS_CONTROL, $task_id)
  {
    try {

      $cod = new m_almacen();
      $nombre = 'LBS-PHS-FR-03';

      $stmt = $this->bd->prepare("UPDATE T_CONTROL_MAQUINA SET NOMBRE_CONTROL_MAQUINA= UPPER(:NOMBRE_CONTROL_MAQUINA), N_DIAS_CONTROL = :N_DIAS_CONTROL  WHERE COD_CONTROL_MAQUINA = :COD_CONTROL_MAQUINA");
      $stmt->bindParam(':COD_CONTROL_MAQUINA', $task_id, PDO::PARAM_STR);
      $stmt->bindParam(':NOMBRE_CONTROL_MAQUINA', $NOMBRE_CONTROL, PDO::PARAM_STR);
      $stmt->bindParam(':N_DIAS_CONTROL', $N_DIAS_CONTROL, PDO::PARAM_STR);
      $update = $stmt->execute();

      $cod->generarVersionGeneral($nombre);
      return $update;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function eliminarControlMaquina($COD_CONTROL_MAQUINA)
  {
    try {

      $stm = $this->bd->prepare("DELETE FROM T_CONTROL_MAQUINA WHERE COD_CONTROL_MAQUINA = :COD_CONTROL_MAQUINA");
      $stm->bindParam(':COD_CONTROL_MAQUINA', $COD_CONTROL_MAQUINA, PDO::PARAM_STR);

      $delete = $stm->execute();
      return $delete;
    } catch (Exception $e) {
      die("Error al eliminar los datos: " . $e->getMessage());
    }
  }

  public function MostrarAlertaControl()
  {
    try {

      $stm = $this->bd->prepare("SELECT Z.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS, C.COD_CONTROL_MAQUINA AS  COD_CONTROL_MAQUINA, C.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,
      A.COD_ALERTA_CONTROL_MAQUINA AS COD_ALERTA_CONTROL_MAQUINA, A.N_DIAS_POS AS N_DIAS_POS, A.FECHA_TOTAL, 
      A.FECHA_CREACION AS FECHA_CREACION,A.FECHA_ACORDAR AS FECHA_ACORDAR, A.ESTADO AS ESTADO, A.OBSERVACION AS OBSERVACION,
      A.ACCION_CORRECTIVA AS ACCION_CORRECTIVA  FROM T_ALERTA_CONTROL_MAQUINA AS A 
      INNER JOIN T_CONTROL_MAQUINA AS C ON A.COD_CONTROL_MAQUINA = C.COD_CONTROL_MAQUINA
      INNER JOIN T_ZONA_AREAS AS Z ON C.COD_ZONA = Z.COD_ZONA
      WHERE  ESTADO='P' AND CAST(FECHA_TOTAL AS DATE)   <= CAST(GETDATE() AS DATE)");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function actualizarAlertaCheckControl($estado, $taskId, $observacion, $accionCorrectiva)
  {
    // var_dump($taskId);
    $stmt = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET ESTADO = '$estado', OBSERVACION = '$observacion', ACCION_CORRECTIVA ='$accionCorrectiva' WHERE COD_ALERTA_CONTROL_MAQUINA = '$taskId'");
    // var_dump($stmt);
    $stmt->execute();
    return $stmt;
  }
  public function InsertarAlertaControlMaquina($FECHA_CREACION,  $codControlMaquina, $FECHA_TOTAL, $taskNdias)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA, FECHA_CREACION, FECHA_TOTAL,N_DIAS_POS) VALUES (:COD_CONTROL_MAQUINA, :FECHA_CREACION, :FECHA_TOTAL,:N_DIAS_POS)");


    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':COD_CONTROL_MAQUINA', $codControlMaquina);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert1 = $stm->execute();
    return $insert1;
  }
  public function MostrarControlMaquinaPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {


      $stm = $this->bd->prepare(
        " SELECT Z.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS, C.COD_CONTROL_MAQUINA AS  COD_CONTROL_MAQUINA, C.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,
        A.COD_ALERTA_CONTROL_MAQUINA AS COD_ALERTA_CONTROL_MAQUINA, A.N_DIAS_POS AS N_DIAS_POS, A.FECHA_TOTAL, 
        A.FECHA_CREACION AS FECHA_CREACION,A.FECHA_ACORDAR AS FECHA_ACORDAR, A.ESTADO AS ESTADO, A.OBSERVACION AS OBSERVACION,
        A.ACCION_CORRECTIVA AS ACCION_CORRECTIVA  FROM T_ALERTA_CONTROL_MAQUINA AS A 
        INNER JOIN T_CONTROL_MAQUINA AS C ON A.COD_CONTROL_MAQUINA = C.COD_CONTROL_MAQUINA
        INNER JOIN T_ZONA_AREAS AS Z ON C.COD_ZONA = Z.COD_ZONA
        WHERE  ESTADO='R'
        AND MONTH(FECHA_TOTAL) = :mesSeleccionado AND YEAR(FECHA_TOTAL) = :anioSeleccionado"
      );
      $stm->bindParam(':mesSeleccionado', $mesSeleccionado);
      $stm->bindParam(':anioSeleccionado', $anioSeleccionado);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarZonaCombo($term)
  {
    try {

      // $stm = $this->bd->prepare("SELECT COD_ZONA,NOMBRE_T_ZONA_AREAS FROM T_ZONA_AREAS");
      // $stm->execute();
      // $datos = $stm->fetchAll();
      // return $datos;
      $stm = $this->bd->prepare("SELECT COD_ZONA, NOMBRE_T_ZONA_AREAS FROM T_ZONA_AREAS WHERE NOMBRE_T_ZONA_AREAS LIKE '$term%' ");
      $stm->execute();
      $datos = $stm->fetchAll();

      $json = array();
      foreach ($datos as $dato) {
        $json[] = array(
          "id" => $dato['COD_ZONA'],
          "label" => $dato['NOMBRE_T_ZONA_AREAS']
        );
      }

      return $json;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function  MostrarProductoCombo($term)
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE DES_PRODUCTO LIKE '$term%' ");
      $stm->execute();
      $datos = $stm->fetchAll();

      $json = array();
      foreach ($datos as $dato) {
        $json[] = array(
          "id" => $dato['COD_PRODUCTO'],
          "label" => $dato['DES_PRODUCTO'],
          "abreviatura" => $dato['ABR_PRODUCTO']
        );
      }

      return $json;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  MostrarProductoSelect()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO ");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  // public function  MostrarProductoabreviaturaCombo($term)
  // {
  //   try {

  //     $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE ABR_PRODUCTO LIKE '$term%' ");
  //     $stm->execute();
  //     $datos = $stm->fetchAll();

  //     $json = array();
  //     foreach ($datos as $dato) {
  //       $json[] = array(
  //         "id" => $dato['COD_PRODUCTO'],
  //         "nombre" => $dato['DES_PRODUCTO'],
  //         "label" => $dato['ABR_PRODUCTO']
  //       );
  //     }

  //     return $json;
  //   } catch (Exception $e) {
  //     die($e->getMessage());
  //   }
  // }

  public function contarRegistrosLabsabell($cod_labsabell, $valorSel)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_PRODUCTO_ENVASES WHERE COD_PRODUCTO_ENVASE = :COD_PRODUCTO_ENVASE AND COD_PRODUCTO = :COD_PRODUCTO");
    $repetir->bindParam(':COD_PRODUCTO_ENVASE', $cod_labsabell, PDO::PARAM_STR);
    $repetir->bindParam(':COD_PRODUCTO', $valorSel, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function InsertarLabsabell($codigolabsabell, $valorSeleccionado)
  {
    try {
      $this->bd->beginTransaction();

      $fecha = new m_almacen();
      $nombre = 'p_envases';


      $VERSION = $fecha->generarVersionGeneral($nombre);

      $repetir = $fecha->contarRegistrosLabsabell($codigolabsabell, $valorSeleccionado);
      $FECHA_CREACION = $fecha->c_horaserversql('F');
      // $FECHA_CREACION = '03/09/2023';
      $mesAnioHoy = date('Y-m', strtotime(str_replace('/', '-',  $FECHA_CREACION)));

      if ($repetir == 0) {
        $stm = $this->bd->prepare("INSERT INTO T_PRODUCTO_ENVASES (COD_PRODUCTO_ENVASE, COD_PRODUCTO, FECHA_CREACION)
                                  VALUES ( '$codigolabsabell', '$valorSeleccionado', '$FECHA_CREACION')");

        $insert = $stm->execute();

        if ($VERSION == '01') {
          // $stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE CONVERT(VARCHAR(7), FECHA_VERSION, 126) = '$mesAnioHoy' AND NOMBRE = '$nombre'");
          // //$stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE cast(FECHA_VERSION as DATE) =cast('$FECHA_CREACION' as date) AND NOMBRE='$nombre'");
          // $stmver->execute();
          // $valor = $stmver->fetchAll();

          // $valor1 = count($valor);

          // if ($valor1 == 0) {
          $stmVersion = $this->bd->prepare("UPDATE T_VERSION_GENERAL SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION WHERE NOMBRE=:nombre");
          $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
          $stmVersion->bindParam(':nombre', $nombre, PDO::PARAM_STR);
          $stmVersion->bindParam(':FECHA_VERSION', $FECHA_CREACION);

          $stmVersion->execute();
          // }
        } else {

          $stmver = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE CONVERT(VARCHAR(7), FECHA_VERSION, 126) = '$mesAnioHoy' AND NOMBRE = '$nombre'");
          $stmver->execute();
          $valor = $stmver->fetchAll();

          $valor1 = count($valor);

          if ($valor1 == 0) {
            $stmVersion = $this->bd->prepare("UPDATE T_VERSION_GENERAL SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION WHERE NOMBRE=:nombre");
            $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
            $stmVersion->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmVersion->bindParam(':FECHA_VERSION', $FECHA_CREACION);

            $stmVersion->execute();
          }
        }

        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarEnvasesLabsabel($buscarlab)
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, COD_CATEGORIA,DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO
                                 WHERE DES_PRODUCTO LIKE '$buscarlab%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function SelectEnvasesLabsabell($cod_producto_envase)
  {
    try {

      $stm = $this->bd->prepare("SELECT E.COD_PRODUCTO_ENVASE AS COD_PRODUCTO_ENVASE, P.DES_PRODUCTO AS DES_PRODUCTO, P.ABR_PRODUCTO AS ABR_PRODUCTO,
      E.FECHA_CREACION AS FECHA_CREACION, E.VERSION AS VERSION FROM T_PRODUCTO_ENVASES AS E 
      INNER JOIN T_PRODUCTO AS P ON E.COD_PRODUCTO=P.COD_PRODUCTO WHERE COD_PRODUCTO_ENVASE= :COD_PRODUCTO_ENVASE");
      $stm->bindParam(':COD_PRODUCTO_ENVASE', $cod_producto_envase, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  editarEnvasesLabsabell($codlab, $codigolab)
  {
    try {



      $stmt = $this->bd->prepare("UPDATE T_PRODUCTO_ENVASES SET COD_PRODUCTO_ENVASE  =:COD_PRODUCTO  WHERE COD_PRODUCTO_ENVASE = :COD_PRODUCTO_ENVASE");
      $stmt->bindParam(':COD_PRODUCTO', $codigolab, PDO::PARAM_STR);
      $stmt->bindParam(':COD_PRODUCTO_ENVASE', $codlab);
      $update = $stmt->execute();



      return $update;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function eliminarEnvasesLabsabel($codenvaselabsabell)
  {
    try {

      $stm = $this->bd->prepare("DELETE FROM T_PRODUCTO_ENVASES WHERE COD_PRODUCTO_ENVASE= :COD_PRODUCTO_ENVASE");
      $stm->bindParam(':COD_PRODUCTO_ENVASE', $codenvaselabsabell, PDO::PARAM_STR);

      $delete = $stm->execute();
      return $delete;
    } catch (Exception $e) {
      die("Error al eliminar los datos: " . $e->getMessage());
    }
  }
  public function MostrarEnvasesLabPDF()
  {
    try {
      $stm = $this->bd->prepare(
        "SELECT E.COD_PRODUCTO_ENVASE AS COD_PRODUCTO_ENVASE, P.DES_PRODUCTO AS DES_PRODUCTO, P.ABR_PRODUCTO AS ABR_PRODUCTO,
        E.FECHA_CREACION AS FECHA_CREACION, E.VERSION AS VERSION FROM T_PRODUCTO_ENVASES AS E 
        INNER JOIN T_PRODUCTO AS P ON E.COD_PRODUCTO=P.COD_PRODUCTO"
      );
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function VersionMostrarEnvasesLab()
  {
    try {
      $stm = $this->bd->prepare("SELECT MAX(VERSION) AS VERSION FROM T_PRODUCTO_ENVASES");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }















  public function generarVersionInsumosLab()
  {

    $stm = $this->bd->prepare("SELECT MAX(VERSION) as VERSION FROM T_PRODUCTO_INSUMOS");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxContadorVersion = intval($resultado['VERSION']);
    if ($maxContadorVersion == null) {
      $maxContadorVersion = 0;
    }

    $fecha = new m_almacen();

    $fechaDHoy = $fecha->c_horaserversql('F');
    $stmver = $this->bd->prepare("SELECT * FROM T_PRODUCTO_INSUMOS WHERE cast(FECHA_CREACION as DATE) =cast('$fechaDHoy' as date)");
    $stmver->execute();
    $valor = $stmver->fetchAll();

    $valor1 = count($valor);
    if ($valor1 == 0) {
      $nuevaversion = $maxContadorVersion + 1;
      $versionAumento = str_pad($nuevaversion, 2, '0', STR_PAD_LEFT);
    } else {
      $maxContadorVersion;

      $versionAumento = str_pad($maxContadorVersion, 2, '0', STR_PAD_LEFT);
    }

    return $versionAumento;
  }
  public function contarRegistrosInsumosLab($codigoInsumosLab, $valorSeleccionado)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_PRODUCTO_INSUMOS WHERE COD_PORDUCTO_INSUMOS = :COD_PRODUCTO_INSUMOS AND COD_PRODUCTO = :COD_PRODUCTO");
    $repetir->bindParam(':COD_PRODUCTO_INSUMOS', $codigoInsumosLab, PDO::PARAM_STR);
    $repetir->bindParam(':COD_PRODUCTO', $valorSeleccionado, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function  MostrarProductoComboInsumosLab($term)
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO FROM T_PRODUCTO WHERE DES_PRODUCTO LIKE '$term%' ");
      $stm->execute();
      $datos = $stm->fetchAll();

      $json = array();
      foreach ($datos as $dato) {
        $json[] = array(
          "id" => $dato['COD_PRODUCTO'],
          "label" => $dato['DES_PRODUCTO'],
        );
      }

      return $json;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function InsertarInsumoslab($codigoInsumosLab, $valorSeleccionado)
  {
    try {
      $fecha = new m_almacen();
      $VERSION = $fecha->generarVersionInsumosLab();
      $repetir = $fecha->contarRegistrosInsumosLab($codigoInsumosLab, $valorSeleccionado);
      $FECHA_CREACION = $fecha->c_horaserversql('F');

      if ($repetir == 0) {
        $stm = $this->bd->prepare("INSERT INTO T_PRODUCTO_INSUMOS(COD_PORDUCTO_INSUMOS, COD_PRODUCTO, FECHA_CREACION, VERSION)
                                  VALUES ( '$codigoInsumosLab', '$valorSeleccionado','$FECHA_CREACION','$VERSION')");

        $insert = $stm->execute();
        return $insert;
      }
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }
  public function MostrarInsumosLab($buscarInsumos)
  {
    try {

      $stm = $this->bd->prepare("SELECT I.COD_PORDUCTO_INSUMOS AS COD_PRODUCTO_INSUMOS, P.ABR_PRODUCTO AS ABR_PRODUCTO,
                                 P.DES_PRODUCTO AS DES_PRODUCTO, I.FECHA_CREACION AS FECHA_CREACION, I.VERSION AS VERSION FROM T_PRODUCTO_INSUMOS AS I 
                                 INNER JOIN T_PRODUCTO AS P ON I.COD_PRODUCTO=P.COD_PRODUCTO WHERE DES_PRODUCTO LIKE '$buscarInsumos%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function SelectInsumosLab($cod_insumos_lab)
  {
    try {

      $stm = $this->bd->prepare("SELECT I.COD_PRODUCTO_INSUMOS AS COD_PRODUCTO_INSUMOS, P.ABR_PRODUCTO AS ABR_PRODUCTO,
                                  P.DES_PRODUCTO AS DES_PRODUCTO, I.FECHA_CREACION, I.VERSION AS VERSION, 
                                  P.COD_PRODUCTO AS COD_PRODUCTO  FROM T_PRODUCTO_INSUMOS AS I 
                                  INNER JOIN T_PRODUCTO AS P ON I.COD_PRODUCTO=P.COD_PRODUCTO WHERE COD_PRODUCTO_INSUMOS= :COD_PRODUCTO_INSUMOS");
      $stm->bindParam(':COD_PRODUCTO_INSUMOS', $cod_insumos_lab, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  editarInsumoLab($codInsu, $codigoInsumo)
  {
    try {

      $stmt = $this->bd->prepare("UPDATE T_PRODUCTO_INSUMOS SET COD_PRODUCTO_INSUMOS  ='$codigoInsumo'  WHERE COD_PRODUCTO_INSUMOS = '$codInsu'");
      $update = $stmt->execute();

      return $update;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  eliminarInsumosLab($codinsumoslab)
  {
    try {

      $stm = $this->bd->prepare("DELETE FROM T_PRODUCTO_INSUMOS WHERE COD_PRODUCTO_INSUMOS= :COD_PRODUCTO_INSUMOS");
      $stm->bindParam(':COD_PRODUCTO_INSUMOS', $codinsumoslab, PDO::PARAM_STR);

      $delete = $stm->execute();
      return $delete;
    } catch (Exception $e) {
      die("Error al eliminar los datos: " . $e->getMessage());
    }
  }
  public function MostrarInsumosLabPDF()
  {
    try {
      $stm = $this->bd->prepare(
        "  SELECT I.COD_PRODUCTO_INSUMOS AS COD_PRODUCTO_INSUMOS, P.ABR_PRODUCTO AS ABR_PRODUCTO,
        P.DES_PRODUCTO AS DES_PRODUCTO, I.FECHA_CREACION, I.VERSION AS VERSION, 
        P.COD_PRODUCTO AS COD_PRODUCTO  FROM T_PRODUCTO_INSUMOS AS I 
        INNER JOIN T_PRODUCTO AS P ON I.COD_PRODUCTO=P.COD_PRODUCTO"
      );
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function VersionMostrarInsumosLab()
  {
    try {
      $stm = $this->bd->prepare("SELECT MAX(VERSION) AS VERSION FROM T_PRODUCTO_INSUMOS");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function FechaMaxMostrarInsumosLab()
  {
    try {
      $stm = $this->bd->prepare("SELECT YEAR(MAX(FECHA_CREACION)) AS FECHA_CREACION FROM T_PRODUCTO_INSUMOS");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }










  public function  MostrarProductoTerminado()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_CATEGORIA='00004'");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  MostrarProductoInsumos()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_CATEGORIA='00002'");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  MostrarProductoEnvases()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_CATEGORIA='00008'");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }



  public function  MostrarProductoComboRegistro()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function generarCodigoFormulacion()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_FORMULACION) as COD_FORMULACION FROM T_TMPFORMULACION");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_FORMULACION']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 5, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function generarCodigoCategoriaProducto($codigoproducto)
  {
    $stm = $this->bd->prepare("SELECT COD_CATEGORIA FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoproducto'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $codigo_generado_categoria = $resultado['COD_CATEGORIA'];

    return $codigo_generado_categoria;
  }
  public function generarCodigoUnidadMedida($codigoProducto)
  {
    $stm = $this->bd->prepare("SELECT UNI_MEDIDA FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoProducto'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $codigo_generado_unidadMedida = $resultado['UNI_MEDIDA'];

    return $codigo_generado_unidadMedida;
  }
  public function generarCodigoFormulacionProducto($codigoFormulacionEnvase)
  {
    $stm = $this->bd->prepare("SELECT COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoFormulacionEnvase'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $codigo_generado_formulacionEnvase = $resultado['COD_FORMULACION'];

    return $codigo_generado_formulacionEnvase;
  }
  public function contarCodigoFormulacion($selectProductoCombo)
  {
    $stm = $this->bd->prepare("SELECT COUNT(*) AS count FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$selectProductoCombo'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $count = $resultado['count'];

    return $count;
  }
  public function InsertarProductoCombo($selectProductoCombo, $cantidadTotal, $dataInsumo, $dataEnvase)
  {
    try {
      $this->bd->beginTransaction();
      $codigoform = new m_almacen();




      $fecha_generado = $codigoform->c_horaserversql('F');
      // $fecha_actual = '01/09/2023';
      //echo $fecha_generado;
      // $fecha_generado = date_create_from_format('d/m/Y', $fecha_actual)->format('Y-m-d');

      $codigo_formulacion = $codigoform->generarCodigoFormulacion();
      $codigo_categoria = $codigoform->generarCodigoCategoriaProducto($selectProductoCombo);
      $unidad_medida = $codigoform->generarCodigoUnidadMedida($selectProductoCombo);
      $contar_tmpformulacion = $codigoform->contarCodigoFormulacion($selectProductoCombo);

      if ($contar_tmpformulacion == 0) {

        $stm = $this->bd->prepare("INSERT INTO T_TMPFORMULACION(COD_FORMULACION, COD_CATEGORIA, COD_PRODUCTO, FEC_GENERADO, CAN_FORMULACION, UNI_MEDIDA)
                                  VALUES ('$codigo_formulacion','$codigo_categoria','$selectProductoCombo','$fecha_generado','$cantidadTotal','UNIDAD')");

        $insert = $stm->execute();

        foreach ($dataInsumo as $item) {
          $insumo = $item['insumo'];
          $cantidadInsumo = $item['cantidad'];
          $stmInsumo = $this->bd->prepare("INSERT INTO T_TMPFORMULACION_ITEM(COD_FORMULACION, COD_PRODUCTO, CAN_FORMULACION)
                                        VALUES ('$codigo_formulacion','$insumo','$cantidadInsumo')");

          $stmInsumo->execute();
        }

        foreach ($dataEnvase as $item) {
          $envase = $item['envase'];
          $cantidadEnvase = $item['cantidadEnvase'];
          $stmEnvase = $this->bd->prepare("INSERT INTO T_TMPFORMULACION_ENVASE(COD_FORMULACION, COD_PRODUCTO, CANTIDA)
                                 VALUES ('$codigo_formulacion','$envase','$cantidadEnvase')");

          $stmEnvase->execute();
        }

        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarProductoEnvase()
  {
    try {

      $stm = $this->bd->prepare("SELECT P.DES_PRODUCTO AS DES_PRODUCTO, F.CAN_FORMULACION AS CAN_FORMULACION
                                 FROM T_PRODUCTO AS P INNER JOIN T_TMPFORMULACION AS F ON P.COD_PRODUCTO=F.COD_PRODUCTO");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }







  public function MostrarProduccion($COD_PRODUCTO)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_TMPPRODUCCION WHERE COD_PRODUCTO=:COD_PRODUCTO"
      );
      $stm->bindParam(':COD_PRODUCTO', $COD_PRODUCTO);
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }







  public function CodigoFormulacionProducto($codigoFormulacionProducto)
  {
    $stm = $this->bd->prepare("SELECT COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoFormulacionProducto'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $codigo_generado_formulacionIn = $resultado['COD_FORMULACION'];

    return $codigo_generado_formulacionIn;
  }
  public function generarCodigoRequerimientoProducto()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_TMPREQUERIMIENTO");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_REQUERIMIENTO']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function valorFormulacion($selectProductoCombo)
  {
    $stm = $this->bd->prepare("SELECT MAX(CAN_FORMULACION) as CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$selectProductoCombo'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['CAN_FORMULACION']);

    return $maxCodigo;
  }
  public function InsertarRequerimientoProducto($selectProductoCombo, $cantidadProducto)
  {
    try {
      $this->bd->beginTransaction();
      $requerimientoProd = new m_almacen();

      $codigo_requerimiento_producto = $requerimientoProd->generarCodigoRequerimientoProducto();
      $cantidad_formulacion = $requerimientoProd->valorFormulacion($selectProductoCombo);

      $codigo_formulacion_ins = $requerimientoProd->CodigoFormulacionProducto($selectProductoCombo);


      $stmRequeItem = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_ITEM(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
                                          VALUES ('$codigo_requerimiento_producto','$selectProductoCombo','$cantidadProducto')");

      $insert = $stmRequeItem->execute();


      $formulacion = $this->bd->prepare("SELECT CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$selectProductoCombo'");
      $formulacion->execute();
      $resultado = $formulacion->fetch(PDO::FETCH_ASSOC);
      $cantidad_formula = $resultado['CAN_FORMULACION'];


      $formulacionItem = $this->bd->prepare("SELECT COD_PRODUCTO, CAN_FORMULACION FROM T_TMPFORMULACION_ITEM WHERE COD_FORMULACION='$codigo_formulacion_ins'");
      $formulacionItem->execute();
      $resultados = $formulacionItem->fetchAll(PDO::FETCH_ASSOC);
      foreach ($resultados as $resultado) {
        $codigo_producto_forIt = $resultado['COD_PRODUCTO'];
        $cantida_forIns = $resultado['CAN_FORMULACION'];

        $totalCanti = (($cantidadProducto *  $cantida_forIns) / $cantidad_formula);
        $totalCantiInsum = number_format($totalCanti, 4);

        $stmRequeIns = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_INSUMO(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
                                            VALUES ('$codigo_requerimiento_producto','$codigo_producto_forIt',' $totalCantiInsum')");
        $stmRequeIns->execute();
      }

      $formulacionEnv = $this->bd->prepare("SELECT COD_PRODUCTO, CANTIDA FROM T_TMPFORMULACION_ENVASE WHERE COD_FORMULACION='$codigo_formulacion_ins'");
      $formulacionEnv->execute();
      $resultados = $formulacionEnv->fetchAll(PDO::FETCH_ASSOC);



      foreach ($resultados as $resultado) {
        $codigo_producto_forEnv = $resultado['COD_PRODUCTO'];
        $cantida_forEnv = $resultado['CANTIDA'];
        $totalCantienv = ceil(($cantidadProducto * $cantida_forEnv) / $cantidad_formula);
        $stmRequeEnv = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_ENVASE(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
                                            VALUES ('$codigo_requerimiento_producto','$codigo_producto_forEnv','$totalCantienv')");
        $stmRequeEnv->execute();
      }

      $insert = $this->bd->commit();
      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function MostrarRequermientoProducto($buscarrequerimiento)
  {
    try {

      $stm = $this->bd->prepare("SELECT TRI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TRI.CANTIDAD AS CANTIDAD
                                  FROM T_TMPREQUERIMIENTO_ITEM AS TRI
                                  JOIN T_PRODUCTO AS TP ON TRI.COD_PRODUCTO = TP.COD_PRODUCTO
                                  WHERE TP.DES_PRODUCTO LIKE '$buscarrequerimiento%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }










  public function  MostrarDatosInsumos($selectinsumoenvase)
  {
    try {

      $codigoFormulacionInsumoEnvase = new m_almacen();
      $codigo_corresponde_formulacion = $codigoFormulacionInsumoEnvase->CodigoFormulacionProducto($selectinsumoenvase);

      $stm = $this->bd->prepare("SELECT TMP.COD_FORMULACION AS COD_FORMULACION, (SELECT TPR.DES_PRODUCTO FROM T_PRODUCTO TPR INNER JOIN T_TMPFORMULACION TFOR 
                                  ON TPR.COD_PRODUCTO=TFOR.COD_PRODUCTO WHERE TFOR.COD_FORMULACION='$codigo_corresponde_formulacion') AS DES_PRODUCTO_FORMULACION,
                                  TFI.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TFI.CAN_FORMULACION AS CAN_FORMULACION_INSUMOS,TMP.CAN_FORMULACION AS CAN_FORMULACION
                                  FROM T_TMPFORMULACION_ITEM AS TFI INNER JOIN T_PRODUCTO AS TP ON TFI.COD_PRODUCTO=TP.COD_PRODUCTO 
                                  INNER JOIN T_TMPFORMULACION AS TMP ON TMP.COD_FORMULACION=TFI.COD_FORMULACION
                                  WHERE TFI.COD_FORMULACION='$codigo_corresponde_formulacion'");
      // var_dump($stm);
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);
      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarDatosEnvases($seleccionadoinsumoenvases)
  {
    try {

      $codigoFormulacionInsumoEnvase = new m_almacen();
      $codigo_genera_formulacion = $codigoFormulacionInsumoEnvase->CodigoFormulacionProducto($seleccionadoinsumoenvases);

      $stm = $this->bd->prepare("SELECT TE.COD_FORMULACION AS COD_FORMULACIONES, TE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TE.CANTIDA AS CANTIDA, 
                                (SELECT CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_FORMULACION='$codigo_genera_formulacion') AS CAN_FORMULACION
                                FROM T_TMPFORMULACION_ENVASE TE 
                                INNER JOIN T_PRODUCTO AS TP ON TE.COD_PRODUCTO= TP.COD_PRODUCTO  WHERE TE.COD_FORMULACION='$codigo_genera_formulacion'");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }



  public function VerificarProductoFormula($selectinsumoenvase)
  {
    try {

      $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$selectinsumoenvase'");

      $repetir->execute();
      $result = $repetir->fetch(PDO::FETCH_ASSOC);
      $count = $result['count'];
      return $count;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function InsertarInsumEnvas($codpersonal, $union, $unionEnvase, $unionItem)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $codRequerimiento = $cod->generarCodigoRequerimientoProducto();


      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaMinutosSegundosRequerimiento = $horaActualPeruRequerimiento->format('H:i:s');


      $stmRequerimiento = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO(COD_REQUERIMIENTO,COD_PERSONAL,HORA)
      VALUES ('$codRequerimiento','$codpersonal','$horaMinutosSegundosRequerimiento')");
      // var_dump($stmRequerimiento);
      $insert = $stmRequerimiento->execute();

      $sumaTotalInEn = 0;
      for ($i = 0; $i < count($unionItem); $i += 2) {

        $codProductoTotal = $unionItem[$i];
        $canInsuTotal = $unionItem[$i + 1];
        $sumaTotalInEn =  $sumaTotalInEn + $canInsuTotal;


        $stmRequeItem = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_ITEM(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
        VALUES ('$codRequerimiento', '$codProductoTotal', '$canInsuTotal')");
        $stmRequeItem->execute();
      }
      $stmSumRequerimiento = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET CANTIDAD='$sumaTotalInEn' WHERE COD_REQUERIMIENTO='$codRequerimiento'");
      $stmSumRequerimiento->execute();




      for ($i = 0; $i < count($union); $i += 2) {
        $codProducto = ($union[$i]);
        $canInsu = $union[$i + 1];
        // $cod_producto_item = $union[$i + 2];

        $stmRequeInsumo = $this->bd->prepare("INSERT  INTO T_TMPREQUERIMIENTO_INSUMO(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
        VALUES ('$codRequerimiento','$codProducto', '$canInsu')");

        $stmRequeInsumo->execute();
      }

      for ($j = 0; $j < count($unionEnvase); $j += 2) {

        $codProductoEnvase = trim($unionEnvase[$j]);
        $canEnvase = $unionEnvase[$j + 1];
        // $cod_producto_item_envase = $unionEnvase[$j + 2];

        $stmRequeEnvase = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_ENVASE(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
        VALUES ('$codRequerimiento', '$codProductoEnvase', '$canEnvase')");
        $stmRequeEnvase->execute();
      }






      $insert = $this->bd->commit();

      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }









  public function MostrarPendientesRequerimientos()
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_TMPREQUERIMIENTO WHERE ESTADO='P'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function  MostrarSiCompra($cod_formulacion)
  {
    try {
      $stm = $this->bd->prepare("SELECT TI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
                                  TI.CANTIDAD AS CANTIDAD, TA.STOCK_ACTUAL AS STOCK_ACTUAL, COALESCE(TC.CANTIDAD_MINIMA, 0) AS CANTIDAD_MINIMA 
                                  FROM T_TMPREQUERIMIENTO_INSUMO TI INNER JOIN T_PRODUCTO TP ON TI.COD_PRODUCTO = TP.COD_PRODUCTO 
                                  LEFT JOIN T_TMPCANTIDAD_MINIMA TC ON TI.COD_PRODUCTO = TC.COD_PRODUCTO
                                  LEFT JOIN T_TMPALMACEN_INSUMOS TA ON TA.COD_PRODUCTO=TP.COD_PRODUCTO
                                  WHERE TI.COD_REQUERIMIENTO = '$cod_formulacion'
                                  UNION ALL
                                  SELECT TE.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TE.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
                                  TE.CANTIDAD AS CANTIDAD, TA.STOCK_ACTUAL AS STOCK_ACTUAL, COALESCE(TC.CANTIDAD_MINIMA, 0) AS CANTIDAD_MINIMA 
                                  FROM T_TMPREQUERIMIENTO_ENVASE TE INNER JOIN T_PRODUCTO TP ON TE.COD_PRODUCTO = TP.COD_PRODUCTO 
                                  LEFT JOIN T_TMPCANTIDAD_MINIMA TC ON TE.COD_PRODUCTO = TC.COD_PRODUCTO
                                  LEFT JOIN T_TMPALMACEN_INSUMOS TA ON TA.COD_PRODUCTO=TP.COD_PRODUCTO
                                  WHERE TE.COD_REQUERIMIENTO = '$cod_formulacion'
                                  ");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage() . "<br>";
      echo "SQL: " . $stm;
      die();
    }
  }
  public function generarCodigoOrdenCompra()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function InsertarOrdenCompraItem($union, $idRequerimiento)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();

      $codigo_orden_compra = $cod->generarCodigoOrdenCompra();


      $fecha_actual = $cod->c_horaserversql('F');
      $fecha_convertida  = DateTime::createFromFormat('d/m/Y', $fecha_actual);
      $fecha_generado_orden_compra  = $fecha_convertida->format('d/m/Y');
      // $fecha_actual = '14/09/2023';
      //echo $fecha_generado;
      //$fecha_generado_orden_compra = date_create_from_format('d/m/Y', $fecha_actual)->format('Y-m-d');

      $stmPedidoCompras = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,FECHA)
                                                VALUES ('$codigo_orden_compra','$idRequerimiento','$fecha_generado_orden_compra')");
      $insert = $stmPedidoCompras->execute();

      for ($i = 0; $i < count($union); $i += 3) {
        $codProducto = $union[$i];
        $canInsu = ($union[$i + 1]);
        $canMinInsu = $union[$i + 2];


        $stmPedidoOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEM(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_MINIMA,CANTIDAD_INSUMO_ENVASE)
                                                  VALUES ('$codigo_orden_compra','$codProducto', '$canMinInsu','$canInsu')");
        $insert = $stmPedidoOrden->execute();
      }

      $fecha_actual = $cod->c_horaserversql('F');
      $fecha_convertida  = DateTime::createFromFormat('d/m/Y', $fecha_actual);
      $fecha_generado  = $fecha_convertida->format('d/m/Y');


      // $fecha_actual = '19/09/2023';
      // $fecha_generado = date_create_from_format('d/m/Y', $fecha_actual)->format('Y-m-d');

      $stmActualizar = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET ESTADO='A',FECHA='$fecha_generado' WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $stmActualizar->execute();

      $stmupdate = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='C' WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $stmupdate->execute();


      $insert = $this->bd->commit();

      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function ActualizarOrdenCompraItem($idRequerimiento)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $fecha_generado = $cod->c_horaserversql('F');
      // $fecha_actual = '18/09/2023';
      //echo $fecha_generado;
      //$fecha_generado = date_create_from_format('d/m/Y', $fecha_actual)->format('Y-m-d');

      $stmActualizarOrden = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET ESTADO='A',FECHA='$fecha_generado' WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $insertar = $stmActualizarOrden->execute();

      $stmupdate = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='A' WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $stmupdate->execute();

      $insertar = $this->bd->commit();
      return $insertar;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function generarCodigoCantidadMinima()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_CANTIDAD_MINIMA) as COD_CANTIDAD_MINIMA FROM T_TMPCANTIDAD_MINIMA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_CANTIDAD_MINIMA']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 7, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function contarCantidadMinima($idproducto)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_TMPCANTIDAD_MINIMA WHERE  COD_PRODUCTO='$idproducto' ");

    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function InsertarCantidadMinima($selectCantidadminima, $cantidadMinima)
  {
    try {

      $cod = new m_almacen();

      $codigo_cantidad_minima = $cod->generarCodigoCantidadMinima();
      $repetir = $cod->contarCantidadMinima($selectCantidadminima);


      if ($repetir == 0) {
        $stmMinimoCantidad = $this->bd->prepare("INSERT INTO T_TMPCANTIDAD_MINIMA(COD_CANTIDAD_MINIMA,COD_PRODUCTO, CANTIDAD_MINIMA)
        VALUES ('$codigo_cantidad_minima','$selectCantidadminima', '$cantidadMinima')");
        $insert = $stmMinimoCantidad->execute();
        return $insert;
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarCantidadMinima($buscarcantidadminimasearch)
  {
    try {

      $stm = $this->bd->prepare("SELECT TCM.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA, TCM.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO,
      TCM.CANTIDAD_MINIMA AS CANTIDAD_MINIMA FROM T_TMPCANTIDAD_MINIMA TCM INNER JOIN T_PRODUCTO TP ON TCM.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TP.DES_PRODUCTO LIKE '$buscarcantidadminimasearch%'");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function SelectCantidadMinima($cod_mini)
  {
    try {

      $stm = $this->bd->prepare("SELECT TCM.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA, TCM.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO,
      TCM.CANTIDAD_MINIMA AS CANTIDAD_MINIMA FROM T_TMPCANTIDAD_MINIMA TCM INNER JOIN T_PRODUCTO TP ON TCM.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TCM.COD_CANTIDAD_MINIMA = :COD_CANTIDAD_MINIMA");
      $stm->bindParam(':COD_CANTIDAD_MINIMA', $cod_mini, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function EditarCantidadMinima($codminimo, $selectCantidadminima, $cantidadMinima)
  {
    try {
      $this->bd->beginTransaction();

      $cod = new m_almacen();
      // $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);
      // $nombre = 'LBS-PHS-FR-01';

      // if ($repetir == 0) {
      $stmt = $this->bd->prepare("UPDATE T_TMPCANTIDAD_MINIMA SET CANTIDAD_MINIMA ='$cantidadMinima' WHERE COD_CANTIDAD_MINIMA = '$codminimo'");

      $update = $stmt->execute();

      $update = $this->bd->commit();

      return $update;
      // }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function eliminarCantidadMinima($cod_cantidad_min)
  {
    try {
      $stm = $this->bd->prepare("DELETE FROM T_TMPCANTIDAD_MINIMA WHERE COD_CANTIDAD_MINIMA='$cod_cantidad_min'");
      $delete = $stm->execute();
      return $delete;
    } catch (Exception $e) {
      die("Error al eliminar los datos: " . $e->getMessage());
    }
  }














  public function MostrarCalculoRegistroEnvase($seleccionarproductoregistro)
  {
    try {
      $codigoformula = new m_almacen();
      $codigo_de_formulacion = $codigoformula->CodigoFormulacionProducto($seleccionarproductoregistro);
      $stmCalculo = $this->bd->prepare("SELECT TE.COD_FORMULACION AS COD_FORMULACIONES, TE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TE.CANTIDA AS CANTIDA, 
                                        (SELECT CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_FORMULACION='$codigo_de_formulacion') AS CAN_FORMULACION
                                        FROM T_TMPFORMULACION_ENVASE TE 
                                        INNER JOIN T_PRODUCTO AS TP ON TE.COD_PRODUCTO= TP.COD_PRODUCTO  WHERE TE.COD_FORMULACION='$codigo_de_formulacion'");

      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarTotalPendientesRequeridos()
  {
    try {

      $stmCalculo = $this->bd->prepare(" SELECT * FROM T_TMPREQUERIMIENTO WHERE ESTADO='P'");
      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarSegunCodFormulacion($cod_formulacion)
  {
    try {

      $stmCalculo = $this->bd->prepare("");

      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function  MostrarProductoPorRequerimiento($cod_formulacion)
  {
    try {

      $stmCalculo = $this->bd->prepare("SELECT TRI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TRI.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO, TRI.CANTIDAD AS CANTIDAD
      FROM T_TMPREQUERIMIENTO_ITEM TRI INNER JOIN T_PRODUCTO TP ON TRI.COD_PRODUCTO=TP.COD_PRODUCTO WHERE COD_REQUERIMIENTO='$cod_formulacion'");

      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarProductoInsumoPorRequerimiento($cod_formulacion)
  {
    try {

      // $stmCalculo = $this->bd->prepare("SELECT TRI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TRI.COD_PRODUCTO AS COD_PRODUCTO,
      //                                   TP.DES_PRODUCTO AS DES_PRODUCTO, TRI.CANTIDAD AS CANTIDAD
      //                                   FROM T_TMPREQUERIMIENTO_INSUMO TRI INNER JOIN T_PRODUCTO TP ON TRI.COD_PRODUCTO=TP.COD_PRODUCTO
      //                                   WHERE TRI.COD_REQUERIMIENTO='$cod_formulacion'");
      $stmCalculo = $this->bd->prepare("SELECT TI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,TI.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TI.CANTIDAD AS CANTIDAD   
                                        FROM T_TMPREQUERIMIENTO_INSUMO TI INNER JOIN T_PRODUCTO TP ON TI.COD_PRODUCTO=TP.COD_PRODUCTO
                                        WHERE TI.COD_REQUERIMIENTO = '$cod_formulacion'
                                        UNION ALL
                                        SELECT TE.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TE.CANTIDAD AS CANTIDAD 
                                        FROM T_TMPREQUERIMIENTO_ENVASE TE INNER JOIN T_PRODUCTO TP ON TE.COD_PRODUCTO=TP.COD_PRODUCTO
                                        WHERE TE.COD_REQUERIMIENTO = '$cod_formulacion'
                                        ");
      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }



  public function CodigoProduccionGenerado()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_PRODUCCION) as COD_PRODUCCION FROM T_TMPPRODUCCION");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['COD_PRODUCCION']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }

  public function CodigoCategoriaProducto($codproductoproduccion)
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_CATEGORIA) as COD_CATEGORIA FROM T_PRODUCTO WHERE COD_PRODUCTO='$codproductoproduccion'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);

    $maxCodigo = $resultado['COD_CATEGORIA'];
    return $maxCodigo;
  }
  public function MostrarProduccionRequerimiento()
  {
    try {

      $stmCalculo = $this->bd->prepare("SELECT TRI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TRI.COD_PRODUCTO AS COD_PRODUCTO, 
                                          TP.DES_PRODUCTO AS DES_PRODUCTO, TRI.CANTIDAD AS CANTIDAD FROM T_TMPREQUERIMIENTO_ITEM TRI 
                                          INNER JOIN T_PRODUCTO TP ON TRI.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TRI.ESTADO='A'");

      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function InsertarProduccionTotalRequerimiento($codpersonal, $codrequerimientoproduccion, $codproductoproduccion, $numeroproduccion, $cantidadtotalproduccion, $fechainicio, $fechavencimiento,  $textAreaObservacion, $cantidadcaja)
  {
    try {
      $this->bd->beginTransaction();


      // $dateTInicio = $fechainicio;
      // $dateTVencimiento = $fechavencimiento;
      $fechaFormateadaIncio = DateTime::createFromFormat('Y-m-d', $fechainicio);
      $dateTInicio = $fechaFormateadaIncio->format('d/m/Y');


      $fechaFormateadaVencimiento = DateTime::createFromFormat('Y-m-d', $fechavencimiento);
      $dateTVencimiento = $fechaFormateadaVencimiento->format('d/m/Y');


      $zonaHorariaPeru = new DateTimeZone('America/Lima');
      $horaActualPeru = new DateTime('now', $zonaHorariaPeru);
      $horaMinutosSegundos = $horaActualPeru->format('H:i:s');



      $stmCodProducto = $this->bd->prepare("SELECT MAX(COD_FORMULACION) AS COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codproductoproduccion'");
      $stmCodProducto->execute();
      $consultacodigo = $stmCodProducto->fetch(PDO::FETCH_ASSOC);
      $resultado = $consultacodigo['COD_FORMULACION'];


      $stmCantidad = $this->bd->prepare("SELECT MAX(CAN_FORMULACION) AS CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codproductoproduccion'");
      $stmCantidad->execute();
      $consultacantidad = $stmCantidad->fetch(PDO::FETCH_ASSOC);
      $resultadoCantidad = intval($consultacantidad['CAN_FORMULACION']);


      $stmConsulta = $this->bd->prepare("SELECT TFI.COD_FORMULACION AS COD_FORMULACION, TFI.COD_PRODUCTO AS COD_PRODUCTO, 
                                          TFI.CAN_FORMULACION AS CAN_FORMULACION, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ITEM TFI 
                                          INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFI.COD_FORMULACION
                                          WHERE TFI.COD_FORMULACION='$resultado'");

      $stmConsulta->execute();
      $consulta = $stmConsulta->fetchAll(PDO::FETCH_OBJ);




      $stmConsultaEnvase = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION, TFE.COD_PRODUCTO AS COD_PRODUCTO,
                                                TFE.CANTIDA AS CANTIDA, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ENVASE TFE 
                                                INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFE.COD_FORMULACION
                                                WHERE TFE.COD_FORMULACION='$resultado'");

      $stmConsultaEnvase->execute();
      $consultaEnvase = $stmConsultaEnvase->fetchAll(PDO::FETCH_OBJ);



      $codigoformula = new m_almacen();
      $codigo_de_produccion_generado = $codigoformula->CodigoProduccionGenerado();
      $codigo_categoria = $codigoformula->CodigoCategoriaProducto($codproductoproduccion);

      $stmabrevia = $this->bd->prepare("SELECT ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCTO='$codproductoproduccion'");
      $stmabrevia->execute();
      $consultaabrevia =  $stmabrevia->fetch(PDO::FETCH_ASSOC);
      $resultadoabrevia = trim($consultaabrevia['ABR_PRODUCTO']);

      $stmBarraI = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE FROM T_ALMACEN_PRODUCTOS WHERE COD_PRODUCTO='$codproductoproduccion'");
      $stmBarraI->execute();
      $consultaBarraI = $stmBarraI->fetch(PDO::FETCH_ASSOC);
      $resultadoBarraI = $consultaBarraI['NUM_LOTE'];
      $BarraExtracI = intval(substr($resultadoBarraI, 3));
      $barraSumaI = ($BarraExtracI + 1);
      $barraI = str_pad($barraSumaI, 6, '0', STR_PAD_LEFT);


      $barraF = $barraSumaI + ($cantidadtotalproduccion - 1);
      $resultadoF = str_pad($barraF, 6, '0', STR_PAD_LEFT);

      $resultadoFinalI = trim($resultadoabrevia . $barraI);
      $resultadoFinalFin = trim($resultadoabrevia . ($resultadoF));


      $maquina = gethostname();


      $stmProducciontototal = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION(COD_PRODUCCION, COD_REQUERIMIENTO, COD_CATEGORIA, COD_PRODUCTO, NUM_PRODUCION_LOTE, CAN_PRODUCCION,CANTIDAD_PRODUCIDA, FEC_GENERADO,HOR_GENERADO,FEC_VENCIMIENTO, OBSERVACION,UNI_MEDIDA,BARRA_INICIO,BARRA_FIN, USU_REGISTRO,MAQUINA, COD_ALMACEN,CAN_CAJA)
      VALUES ('$codigo_de_produccion_generado','$codrequerimientoproduccion', '$codigo_categoria','$codproductoproduccion','$numeroproduccion','$cantidadtotalproduccion','$cantidadtotalproduccion','$dateTInicio','$horaMinutosSegundos','$dateTVencimiento','$textAreaObservacion','UNIDAD','$resultadoFinalI','$resultadoFinalFin','$codpersonal','$maquina','00017','$cantidadcaja')");

      $insert = $stmProducciontototal->execute();




      foreach ($consulta as $row) {

        $codProductoitem = $row->COD_PRODUCTO;
        $cantidadInsumos = $row->CAN_FORMULACION;
        $cantidadformulacion = $row->CANTIDAD_FORMULACION;
        $totalInsumos =  round((($cantidadInsumos * $cantidadtotalproduccion) / $cantidadformulacion), 3);

        $stmProduccionitem = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_ITEM(COD_PRODUCCION, COD_PRODUCTO,  CAN_PRODUCCION)
                                                  VALUES ('$codigo_de_produccion_generado','$codProductoitem','$totalInsumos')");

        $stmProduccionitem->execute();
      }

      foreach ($consultaEnvase as $rowEnvase) {

        $codProductoenvase = $rowEnvase->COD_PRODUCTO;
        $cantidadEnvases = $rowEnvase->CANTIDA;
        $cantidadformulacion = $row->CANTIDAD_FORMULACION;
        $totalEnvases =  ceil(($cantidadEnvases * $cantidadtotalproduccion) / $cantidadformulacion);

        $stmProduccionenvases = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_ENVASE(COD_PRODUCCION, COD_PRODUCTO,  CAN_PRODUCCION_ENVASE)
                                                  VALUES ('$codigo_de_produccion_generado','$codProductoenvase','$totalEnvases')");

        $stmProduccionenvases->execute();
      }

      $stmActualiza = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='T' WHERE COD_REQUERIMIENTO='$codrequerimientoproduccion' AND COD_PRODUCTO='$codproductoproduccion'");
      $stmActualiza->execute();



      $insert = $this->bd->commit();
      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function RechazarPendienteRequerimiento($cod_requerimiento_pedido)
  {
    try {
      $this->bd->beginTransaction();
      $stm = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET ESTADO='R' WHERE COD_REQUERIMIENTO = '$cod_requerimiento_pedido'");
      $actualizarRequerimiento = $stm->execute();

      $stmActualizar = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='R' WHERE COD_REQUERIMIENTO = '$cod_requerimiento_pedido'");
      $stmActualizar->execute();

      $actualizarRequerimiento = $this->bd->commit();
      return $actualizarRequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }






  public function  MostrarProductoRegistroEnvase()
  {
    try {

      $stm = $this->bd->prepare("SELECT TRI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TRI.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TP.ABR_PRODUCTO AS ABR_PRODUCTO, 
                                  TRI.ESTADO AS ESTADO FROM T_TMPREQUERIMIENTO_ITEM TRI INNER JOIN T_PRODUCTO TP ON TRI.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TRI.ESTADO='T'");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function  MostrarProduccionEnvase()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCCION,COD_REQUERIMIENTO,NUM_PRODUCION_LOTE FROM T_TMPPRODUCCION WHERE ESTADO='P' OR ESTADO='A'");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }





  public function  MostrarEnvasesPorProduccion($codigoproducto, $codigoproduccion, $cantidad)
  {
    try {
      $this->bd->beginTransaction();

      $stmCodigoFormula = $this->bd->prepare("SELECT MAX(COD_FORMULACION) AS COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoproducto'");
      $stmCodigoFormula->execute();
      $consultacodigoformula = $stmCodigoFormula->fetch(PDO::FETCH_ASSOC);
      $resultadoformula = $consultacodigoformula['COD_FORMULACION'];

      $stmverificardatos = $this->bd->prepare("SELECT MAX(CANTIDAD_PRODUCIDA) AS CANTIDAD_PRODUCIDA FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
      $stmverificardatos->execute();
      $consultacodigoformulacion = $stmverificardatos->fetch(PDO::FETCH_ASSOC);
      $resultadoCantidadFormulacion = intval($consultacodigoformulacion['CANTIDAD_PRODUCIDA']);

      if ($cantidad <= $resultadoCantidadFormulacion) {
        $stmformulacionenvase = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION, TFE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, 
                                                      TFE.CANTIDA AS CANTIDA, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ENVASE TFE 
                                                      INNER JOIN T_PRODUCTO TP ON TFE.COD_PRODUCTO=TP.COD_PRODUCTO
                                                      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFE.COD_FORMULACION
                                                      WHERE TFE.COD_FORMULACION='$resultadoformula'");
        $stmformulacionenvase->execute();
        $datosEnvases = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);
      }



      $this->bd->commit();
      return $datosEnvases;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function CodigoAvanceInsumo()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_AVANCE_INSUMOS) as COD_AVANCE_INSUMOS FROM T_TMPAVANCE_INSUMOS_PRODUCTOS");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['COD_AVANCE_INSUMOS']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function NumeroBachadaGenerado()
  {
    $stm = $this->bd->prepare("SELECT MAX(N_BACHADA) as N_BACHADA FROM T_TMPAVANCE_INSUMOS_PRODUCTOS");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['N_BACHADA']);

    $nuevoCodigo = $maxCodigo + 1;
    return $nuevoCodigo;
  }
  public function CodigoGenBarras()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_PRODUCCION_BARRAS) as COD_PRODUCCION_BARRAS FROM T_TMPPRODUCCION_BARRAS");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_PRODUCCION_BARRAS']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function  InsertarValorInsumoRegistro($valoresCapturadosProduccion, $codigoproducto, $codigoproduccion, $cantidad)
  {
    try {
      $this->bd->beginTransaction();

      $codigoInsumosAvances = new m_almacen();
      $codigo_de_avance_insumo = $codigoInsumosAvances->CodigoAvanceInsumo();
      $numero_generado_bachada = $codigoInsumosAvances->NumeroBachadaGenerado();

      $nombre = 'LBS-OP-FR-01';
      $VERSION = $codigoInsumosAvances->generarVersionGeneral($nombre);



      $stmCantidad = $this->bd->prepare("SELECT MAX(CANTIDAD_PRODUCIDA) AS CANTIDAD_PRODUCIDA FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
      $stmCantidad->execute();
      $consultacantidad = $stmCantidad->fetch(PDO::FETCH_ASSOC);
      $insert = intval($consultacantidad['CANTIDAD_PRODUCIDA']);


      $stmFormu = $this->bd->prepare("SELECT  COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoproducto'");
      $stmFormu->execute();
      $consultaFormulac = $stmFormu->fetch(PDO::FETCH_ASSOC);
      $Codigoformula = $consultaFormulac['COD_FORMULACION'];

      $stmCanFormu = $this->bd->prepare("SELECT  CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoproducto'");
      $stmCanFormu->execute();
      $cantidadformula = $stmCanFormu->fetch(PDO::FETCH_ASSOC);
      $cantidadformulait = $cantidadformula['CAN_FORMULACION'];

      $stmCanFormu = $this->bd->prepare("SELECT COD_PRODUCTO, CAN_FORMULACION FROM T_TMPFORMULACION_ITEM WHERE COD_FORMULACION='$Codigoformula'");
      $stmCanFormu->execute();
      $cantidadformula = $stmCanFormu->fetchAll();
      // $cantidadformulait = $cantidadformula['CAN_FORMULACION'];



      $stmCodForm = $this->bd->prepare("SELECT BARRA_INICIO FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
      $stmCodForm->execute();
      $codigobarrainicio = $stmCodForm->fetch(PDO::FETCH_ASSOC);
      $valoriniciobarra = $codigobarrainicio['BARRA_INICIO'];



      $updatetotal = $insert  - $cantidad;

      if ($insert  > 0) {
        $stmActualizaproduccion = $this->bd->prepare("UPDATE T_TMPPRODUCCION SET CANTIDAD_PRODUCIDA='$updatetotal',ESTADO='A' WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
        $stmActualizaproduccion->execute();

        $stmInsertarInsumoAvance = $this->bd->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS(COD_AVANCE_INSUMOS,N_BACHADA,COD_PRODUCTO,COD_PRODUCCION,CANTIDAD)
          VALUES ('$codigo_de_avance_insumo','$numero_generado_bachada','$codigoproducto','$codigoproduccion','$cantidad')");

        $stmInsertarInsumoAvance->execute();

        for ($i = 0; $i < count($valoresCapturadosProduccion); $i += 3) {
          $codProductoAvance = trim($valoresCapturadosProduccion[$i]);
          $cantidadcaptura = trim($valoresCapturadosProduccion[$i + 1]);
          $cantidadlote = ($valoresCapturadosProduccion[$i + 2]);

          $stmInsumoAvance = $this->bd->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASES(COD_AVANCE_INSUMOS,COD_PRODUCTO,CANTIDAD,LOTE)
                                                      VALUES ('$codigo_de_avance_insumo','$codProductoAvance','$cantidadcaptura','$cantidadlote')");
          $stmInsumoAvance->execute();
        }

        foreach ($cantidadformula as $insumos) {
          $codProducto = $insumos['COD_PRODUCTO'];
          $canFormulacion = $insumos['CAN_FORMULACION'];

          $resultadoformula = round((($cantidad * $canFormulacion) / $cantidadformulait), 3);


          $stmInsertarInsumo = $this->bd->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ITEM(COD_AVANCE_INSUMOS,COD_PRODUCTO,CANTIDAD)
          VALUES ('$codigo_de_avance_insumo','$codProducto','$resultadoformula')");

          $stmInsertarInsumo->execute();
        }

        $stmContienevalor = $this->bd->prepare("SELECT MAX(NUM_LOTE) NUM_LOTE FROM T_TMPPRODUCCION_BARRAS WHERE COD_PRODUCCION='$codigoproduccion'");
        $stmContienevalor->execute();
        $existeNum = $stmContienevalor->fetch(PDO::FETCH_ASSOC);
        $valorexistente = $existeNum['NUM_LOTE'];

        $codigo_gen_barras = $codigoInsumosAvances->CodigoGenBarras();
        if ($valorexistente == null) {

          $stmCodForm = $this->bd->prepare("SELECT BARRA_INICIO FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
          $stmCodForm->execute();
          $codigobarrainicio = $stmCodForm->fetch(PDO::FETCH_ASSOC);
          $valoriniciobarra = $codigobarrainicio['BARRA_INICIO'];



          $stm = $this->bd->prepare("SELECT MAX(COD_PRODUCCION_BARRAS) as COD_PRODUCCION_BARRAS FROM T_TMPPRODUCCION_BARRAS");
          $stm->execute();
          $resultado = $stm->fetch(PDO::FETCH_ASSOC);
          $maxCodigo = intval($resultado['COD_PRODUCCION_BARRAS']);
          $c = 1;
          for ($e = 0; $e < $cantidad; $e++) {


            $nuevoCodigo = $maxCodigo + $c;
            $codigo_gen_barrasIf = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
            $c++;


            $codigonum = intval(substr($valoriniciobarra, 3));
            $codigogenerado = ($codigonum + $e);
            $valorFINAL = str_pad($codigogenerado, 6, '0', STR_PAD_LEFT);

            $valorINICIAL = substr($codigobarrainicio['BARRA_INICIO'], 0, 3);
            $respuestaTotalNumlote = $valorINICIAL . $valorFINAL;

            $insertarproduc = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS(COD_PRODUCCION_BARRAS,COD_PRODUCCION,NUM_LOTE)
            VALUES('$codigo_gen_barrasIf','$codigoproduccion','$respuestaTotalNumlote')");
            $insertarproduc->execute();
          }
        } else {
          $stmcodigoAum = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE  FROM T_TMPPRODUCCION_BARRAS WHERE COD_PRODUCCION='$codigoproduccion'");
          $stmcodigoAum->execute();
          $codigogen = $stmcodigoAum->fetch(PDO::FETCH_ASSOC);
          $valorpuesto = $codigogen['NUM_LOTE'];



          $stmEl = $this->bd->prepare("SELECT MAX(COD_PRODUCCION_BARRAS) as COD_PRODUCCION_BARRAS FROM T_TMPPRODUCCION_BARRAS");
          $stmEl->execute();
          $resultadoEl = $stmEl->fetch(PDO::FETCH_ASSOC);
          $maxCodigoEl = intval($resultadoEl['COD_PRODUCCION_BARRAS']);
          $con = 1;

          for ($ex = 1; $ex <= $cantidad; $ex++) {

            $nuevoCodigoEl = $maxCodigoEl + $con;
            $codigo_gen_barrasEl = str_pad($nuevoCodigoEl, 9, '0', STR_PAD_LEFT);
            $con++;

            $codigonumero = intval(substr($valorpuesto, 3));
            $codigo_generar = ($codigonumero + $ex);
            $valorFINALE = str_pad($codigo_generar, 6, '0', STR_PAD_LEFT);

            $valorINICIALE = substr($codigogen['NUM_LOTE'], 0, 3);
            $respuestaTotalNumloteE = $valorINICIALE . $valorFINALE;



            $insertarproduc = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS(COD_PRODUCCION_BARRAS,COD_PRODUCCION,NUM_LOTE)
            VALUES('$codigo_gen_barrasEl','$codigoproduccion','$respuestaTotalNumloteE')");
            $insertarproduc->execute();
          }
        }
        if ($updatetotal == 0) {
          $stmVerificaCodReque = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) AS COD_REQUERIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
          $stmVerificaCodReque->execute();
          $consultarequerimientocod = $stmVerificaCodReque->fetch(PDO::FETCH_ASSOC);
          $valorcodrequerimiento = ($consultarequerimientocod['COD_REQUERIMIENTO']);


          $actualizaComboProducto = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='C' WHERE COD_PRODUCTO='$codigoproducto' AND COD_REQUERIMIENTO='$valorcodrequerimiento'");
          $actualizaComboProducto->execute();

          $actualizarRequerimientoItem = $this->bd->prepare("UPDATE T_TMPPRODUCCION SET ESTADO='C' WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
          $actualizarRequerimientoItem->execute();
        }
      } else {

        $stmVerificaCodReque = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) AS COD_REQUERIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
        $stmVerificaCodReque->execute();
        $consultarequerimientocod = $stmVerificaCodReque->fetch(PDO::FETCH_ASSOC);
        $valorcodrequerimiento = ($consultarequerimientocod['COD_REQUERIMIENTO']);


        $actualizaComboProducto = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='C' WHERE COD_PRODUCTO='$codigoproducto' AND COD_REQUERIMIENTO='$valorcodrequerimiento'");
        $actualizaComboProducto->execute();

        $actualizarRequerimientoItem = $this->bd->prepare("UPDATE T_TMPPRODUCCION SET ESTADO='C' WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
        $actualizarRequerimientoItem->execute();
      }




      $insert = $this->bd->commit();
      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function MostrarRegistroProduccionPorCodInsumoPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {
      $stmMostrar = $this->bd->prepare("SELECT TAI.COD_AVANCE_INSUMOS AS COD_AVANCE_INSUMOS,TAI.N_BACHADA AS N_BACHADA,TPRO.NUM_PRODUCION_LOTE AS NUM_PRODUCION_LOTE,
                                          TP.DES_PRODUCTO AS DES_PRODUCTO, TAI.CANTIDAD AS CANTIDAD,  CONVERT(varchar, TAI.FECHA, 103) AS FECHA
                                          FROM T_TMPAVANCE_INSUMOS_PRODUCTOS TAI 
                                          INNER JOIN T_PRODUCTO TP ON TAI.COD_PRODUCTO=TP.COD_PRODUCTO
                                          INNER JOIN T_TMPPRODUCCION TPRO ON TPRO.COD_PRODUCCION=TAI.COD_PRODUCCION WHERE MONTH(FECHA) = '$mesSeleccionado' AND YEAR(FECHA) = '$anioSeleccionado'");
      $stmMostrar->execute();
      $datos = $stmMostrar->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function MostrarRegistroProduccionPDF()
  {
    try {
      $stmMostrar = $this->bd->prepare("SELECT TAIP.COD_AVANCE_INSUMOS AS COD_AVANCE_INSUMOS, TP.DES_PRODUCTO AS DES_PRODUCTO,
                                          TAIP.CANTIDAD AS CANTIDAD, TAIP.LOTE AS LOTE FROM T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASES TAIP 
                                          INNER JOIN T_PRODUCTO TP ON TAIP.COD_PRODUCTO=TP.COD_PRODUCTO");
      $stmMostrar->execute();
      $datos = $stmMostrar->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function VerificarRegistroMenorProducto($idrequerimiento, $codigoproductoverifica)
  {
    try {

      $stm = $this->bd->prepare("SELECT MIN(COD_REQUERIMIENTO) AS COD_REQUERIMIENTO FROM T_TMPREQUERIMIENTO_ITEM WHERE COD_PRODUCTO='$codigoproductoverifica' AND  ESTADO='T'");
      $stm->execute();
      $respuesta = $stm->fetch();
      $insert = $respuesta['COD_REQUERIMIENTO'];
      // var_dump($insert);
      if ($insert == $idrequerimiento) {
        return $insert;
      }


      // $insert = $this->bd->commit();

      // return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }


  public function MostrarOrdenDeCompra()
  {
    try {
      $stmMostrar = $this->bd->prepare("  SELECT OC.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO,OC.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE,
      OC.CANTIDAD_MINIMA AS CANTIDAD_MINIMA FROM T_TMPORDEN_COMPRA_ITEM OC INNER JOIN T_PRODUCTO TP ON OC.COD_PRODUCTO=TP.COD_PRODUCTO");
      $stmMostrar->execute();
      $datos = $stmMostrar->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }


  public function  MostrarProduccionProductoEnvase($ID_PRODUCTO_COMBO)
  {
    try {

      $stm = $this->bd->prepare(
        "SELECT COD_PRODUCCION, CONVERT(VARCHAR, FEC_GENERADO, 103) AS FEC_GENERADO,
                                  COD_PRODUCTO,NUM_PRODUCION_LOTE,ESTADO FROM T_TMPPRODUCCION WHERE COD_REQUERIMIENTO='$ID_PRODUCTO_COMBO' 
                                  AND ESTADO='P' OR ESTADO='A'"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
}
