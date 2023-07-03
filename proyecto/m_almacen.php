<?php

require_once("../funciones/DataBaseA.php");
// require_once("../funciones/f_funcion.php");

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
  public function SelectZona($COD_ZONA)
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_ZONA_AREAS WHERE COD_ZONA = :COD_ZONA");
      $stm->bindParam(':COD_ZONA', $COD_ZONA, PDO::PARAM_STR);
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarAlmacenMuestraBusqueda($search)
  {
    try {


      $stm = $this->bd->prepare("SELECT * FROM T_ZONA_AREAS WHERE NOMBRE_T_ZONA_AREAS LIKE '$search%'");

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


  public function generarVersion()
  {

    //$stm = $this->bd->prepare("SELECT top 1 VERSION as VERSION FROM T_VERSION order by COD_VERSION desc");
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

  public function InsertarAlmacen($NOMBRE_T_ZONA_AREAS)
  {
    try {
      if (isset($FECHA)) {

        if (empty($FECHA)) {
          $FECHA = retunrFechaActualphp();
        }
      } else {
        $FECHA = retunrFechaActualphp();
      }


      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_ZONA = $cod->generarCodigo();
      $VERSION = $cod->generarVersion();

      $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);

      if ($repetir == 0) {

        $stm = $this->bd->prepare("INSERT INTO T_ZONA_AREAS (COD_ZONA, NOMBRE_T_ZONA_AREAS, FECHA, VERSION) 
                                  VALUES ( '$COD_ZONA', '$NOMBRE_T_ZONA_AREAS', '$FECHA', '$VERSION')");


        $insert = $stm->execute();

        $fechaDHoy = date('Y-m-d');



        if ($VERSION == '01') {

          $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


          $stmver->execute();
          $valor = $stmver->fetchAll();

          $valor1 = count($valor);

          if ($valor1 == 0) {
            $stm1 = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) VALUES ( :version)");
            $stm1->bindParam(':version', $VERSION, PDO::PARAM_STR);
            $stm1->execute();
          }
        } else {
          $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


          $stmver->execute();
          $valor = $stmver->fetchAll();

          $valor1 = count($valor);

          if ($valor1 == 0) {
            $stm1 = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
            $stm1->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
            $stm1->bindParam(':FECHA_VERSION', $fechaDHoy);
            $stm1->execute();
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

  public function editarAlmacen($NOMBRE_T_ZONA_AREAS, $task_id)
  {
    try {
      $this->bd->beginTransaction();

      $cod = new m_almacen();
      $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);

      if ($repetir == 0) {
        $stmt = $this->bd->prepare("UPDATE T_ZONA_AREAS SET NOMBRE_T_ZONA_AREAS = :NOMBRE_T_ZONA_AREAS, VERSION =:VERSION WHERE COD_ZONA = :COD_ZONA");


        $VERSION = $cod->generarVersion();

        $stmt->bindParam(':NOMBRE_T_ZONA_AREAS', $NOMBRE_T_ZONA_AREAS, PDO::PARAM_STR);
        $stmt->bindParam(':COD_ZONA', $task_id, PDO::PARAM_INT);
        $stmt->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
        $update = $stmt->execute();

        $fechaDHoy = date('Y-m-d');

        if ($VERSION == '01') {
          $stm1 = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) values(:version)");
          $stm1->bindParam(':version', $VERSION, PDO::PARAM_STR);
          $stm1->execute();
        } else {
          $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


          $stmver->execute();
          $valor = $stmver->fetchAll();

          $valor1 = count($valor);

          if ($valor1 == 0) {
            $stm1 = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
            $stm1->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
            $stm1->bindParam(':FECHA_VERSION', $fechaDHoy);
            $stm1->execute();
          }
        }

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


      $stm = $this->bd->prepare("SELECT * FROM T_INFRAESTRUCTURA WHERE NOMBRE_INFRAESTRUCTURA LIKE '$search%'");

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

      $stm = $this->bd->prepare("SELECT * FROM T_INFRAESTRUCTURA WHERE COD_INFRAESTRUCTURA = :COD_INFRAESTRUCTURA");
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
  public function insertarInfraestructura($valorSeleccionado, $NOMBRE_INFRAESTRUCTURA, $NDIAS)
  {
    try {
      if (empty($FECHA)) {
        $FECHA = retunrFechaActualphp();
      }
      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_INFRAESTRUCTURA = $cod->generarCodigoInfraestructura();
      $VERSION = $cod->generarVersion();
      $repetir = $cod->contarRegistrosInfraestructura($NOMBRE_INFRAESTRUCTURA, $valorSeleccionado);


      if ($repetir == 0) {
        $stm = $this->bd->prepare("INSERT INTO T_INFRAESTRUCTURA  (COD_INFRAESTRUCTURA, COD_ZONA,NOMBRE_INFRAESTRUCTURA ,NDIAS, FECHA,VERSION) 
                                  VALUES ('$COD_INFRAESTRUCTURA','$valorSeleccionado', '$NOMBRE_INFRAESTRUCTURA ','$NDIAS', '$FECHA', '$VERSION')");

        $insert = $stm->execute();

        $fechaDHoy = date('Y-m-d');

        if ($VERSION == '01') {
          $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


          $stmver->execute();
          $valor = $stmver->fetchAll();

          $valor1 = count($valor);

          if ($valor1 == 0) {
            $stmVersion = $this->bd->prepare("INSERT INTO T_VERSION(VERSION) values(:version)");
            $stmVersion->bindParam(':version', $VERSION, PDO::PARAM_STR);
            $stmVersion->execute();
          }
        } else {
          $stmver = $this->bd->prepare("SELECT * FROM T_VERSION WHERE cast(FECHA_VERSION as DATE) =cast('$fechaDHoy' as date)");


          $stmver->execute();
          $valor = $stmver->fetchAll();

          $valor1 = count($valor);

          if ($valor1 == 0) {
            $stmVersion = $this->bd->prepare("UPDATE T_VERSION SET VERSION = :VERSION, FECHA_VERSION = :FECHA_VERSION");
            $stmVersion->bindParam(':VERSION', $VERSION, PDO::PARAM_STR);
            $stmVersion->bindParam(':FECHA_VERSION', $fechaDHoy);
            $stmVersion->execute();
          }
        }



        $FECHA = date('Y-m-d');
        $DIAS_DESCUENTO = 2;

        $fechaTotal = date('Y-m-d', strtotime($FECHA . '+' . $NDIAS . 'days'));

        // Verificar si la fecha total cae en domingo
        if (date('N', strtotime($fechaTotal)) == 7) {
          $fechaTotal = date('Y-m-d', strtotime($fechaTotal . '+1 day'));
        }
        $FECHA_TOTAL = retunrFechaSqlphp($fechaTotal);

        if (!($NDIAS == 1 || $NDIAS == 2)) {

          $FECHA_ACORDAR = retunrFechaSqlphp(date('Y-m-d', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days')));
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

      $stmt = $this->bd->prepare("UPDATE T_INFRAESTRUCTURA SET NOMBRE_INFRAESTRUCTURA = :NOMBRE_INFRAESTRUCTURA, NDIAS = :NDIAS  WHERE COD_INFRAESTRUCTURA = :COD_INFRAESTRUCTURA");
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
  public function MostrarUsuario($USUARIO, $CLAVE)
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_USUARIO WHERE USUARIO=:USUARIO AND CLAVE = :CLAVE;");
      $stm->bindParam(':USUARIO', $USUARIO, PDO::PARAM_STR);
      $stm->bindParam(':CLAVE', $CLAVE, PDO::PARAM_STR);
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

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

      // $stm = $this->bd->prepare("SELECT COD_INFRAESTRUCTURA,FECHA_CREACION,FECHA_TOTAL,FECHA_ACORDAR FROM T_ALERTA;");
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
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, FECHA_ACORDAR, N_DIAS_POS,POSTERGACION) VALUES (:COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL, :FECHA_ACORDAR, :N_DIAS_POS,:POSTERGACION)");

    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_CREACION', $fechaActual);
    $stm->bindParam(':FECHA_TOTAL', $fechaPostergacion);
    $stm->bindParam(':FECHA_ACORDAR', $fechaAcordar);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);
    $stm->bindParam(':POSTERGACION', $POSTERGACION);

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

  public function actualizarAlertaCheckBox($estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA)
  {
    $fecha_actualiza = convFecSistema1($FECHA_ACTUALIZA);
    $stmt = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO = :estado, OBSERVACION = :observacion, FECHA_POSTERGACION= :fechaPostergacion, FECHA_TOTAL = :FECHA_ACTUALIZA WHERE COD_ALERTA = :COD_ALERTA");


    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':COD_ALERTA', $taskId, PDO::PARAM_STR);
    $stmt->bindParam(':observacion', $observacion, PDO::PARAM_STR);
    $stmt->bindParam(':fechaPostergacion',  $FECHA_POSTERGACION);
    $stmt->bindParam(':FECHA_ACTUALIZA', $fecha_actualiza);
    $stmt->execute();
    return $stmt;
  }

  public function actualizarAlertaCheckBoxSinPOS($estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA)
  {
    $fecha_actualiza = convFecSistema1($FECHA_ACTUALIZA);
    $stmt = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO = :estado, OBSERVACION = :observacionTextArea, FECHA_TOTAL = :FECHA_ACTUALIZA WHERE COD_ALERTA = :COD_ALERTA");


    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':observacionTextArea', $observacionTextArea, PDO::PARAM_STR);
    $stmt->bindParam(':COD_ALERTA', $taskId, PDO::PARAM_STR);
    $stmt->bindParam(':FECHA_ACTUALIZA', $fecha_actualiza);
    $stmt->execute();
    return $stmt;
  }


  public function MostrarInfraestructuraPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {

      $stm = $this->bd->prepare("SELECT Z.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                               I.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA, A.N_DIAS_POS,
                               A.ESTADO AS ESTADO, A.FECHA_TOTAL AS FECHA_TOTAL, A.OBSERVACION AS OBSERVACION
                               FROM T_ALERTA A
                               INNER JOIN T_INFRAESTRUCTURA AS I ON A.COD_INFRAESTRUCTURA = I.COD_INFRAESTRUCTURA
                               INNER JOIN T_ZONA_AREAS AS Z ON Z.COD_ZONA = I.COD_ZONA
                               WHERE MONTH(A.FECHA_TOTAL) = :mesSeleccionado AND YEAR(A.FECHA_TOTAL) = :anioSeleccionado AND ESTADO != 'P'");
      $stm->bindParam(':mesSeleccionado', $mesSeleccionado);
      $stm->bindParam(':anioSeleccionado', $anioSeleccionado);
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

  public function insertarCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL)
  {
    try {



      $stm = $this->bd->prepare("INSERT INTO T_UNION(NOMBRE_INSUMOS, NOMBRE_PREPARACION,CANTIDAD_PORCENTAJE,CANTIDAD_MILILITROS, CANTIDAD_LITROS) 
                                  VALUES ('$selectSolucion','$selectPreparacion', '$selectCantidad','$selectML', '$selectL')");

      $insert = $stm->execute();


      return $insert;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function MostrarUnion()
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT * FROM T_UNION"
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
}
