<?php

require_once("../funciones/DataBaseA.php");
require_once("../control_alimento/maquina.php");

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
    $stm = $this->bd->prepare("SELECT MAX(CAST(COD_INFRAESTRUCTURA AS int)) as COD_INFRAESTRUCTURA FROM T_INFRAESTRUCTURA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['COD_INFRAESTRUCTURA']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 3, '0', STR_PAD_LEFT);

    return $codigoAumento;
  }

  public function generarcodigoalerta()
  {
    $stm = $this->bd->prepare("SELECT MAX(CODIGO) AS CODIGO FROM T_ALERTA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['CODIGO']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 20, '0', STR_PAD_LEFT);
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
  public function MostrarVersionGeneralFecha($nombre)
  {
    try {

      $stm = $this->bd->prepare("SELECT MAX(FECHA_VERSION) AS FECHA_VERSION FROM T_VERSION_GENERAL WHERE NOMBRE ='$nombre'");

      $stm->execute();
      $resultado = $stm->fetch(PDO::FETCH_ASSOC);
      $versionGeneralFecha = $resultado['FECHA_VERSION'];

      return $versionGeneralFecha;
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
        VALUES ('$codPrefix','$nombre',CONVERT(DATETIME, '$FECHA_VERSION', 103))");
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
        $stmVersion = $this->bd->prepare("UPDATE T_VERSION_GENERAL SET VERSION = '$codPrefix', FECHA_VERSION=CONVERT(DATETIME,'$FECHA_VERSION', 103)  WHERE NOMBRE='$nombre'");
        $stmVersion->execute();
      } else {

        $stm = $this->bd->prepare("SELECT MAX(VERSION) AS VERSION FROM T_VERSION_GENERAL WHERE NOMBRE='$nombre'");
        $stm->execute();
        $resultado = $stm->fetch(PDO::FETCH_ASSOC);
        $maxContador = $resultado['VERSION'];
        return $maxContador;
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
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_INFRAESTRUCTURA WHERE NOMBRE_INFRAESTRUCTURA = '$NOMBRE_INFRAESTRUCTURA' AND COD_ZONA = '$valorSeleccionado'");

    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function contarRegistrosInfraestructuraZona($NOMBRE_INFRAESTRUCTURA, $valorSeleccionado)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_ALERTA WHERE COD_INFRAESTRUCTURA = :NOMBRE_INFRAESTRUCTURA AND COD_ZONA = :COD_ZONA");
    $repetir->bindParam(':NOMBRE_INFRAESTRUCTURA', $NOMBRE_INFRAESTRUCTURA, PDO::PARAM_STR);
    $repetir->bindParam(':COD_ZONA', $valorSeleccionado, PDO::PARAM_STR);
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    return $count;
  }
  public function contarRegistrosControl($NOMBRE_CONTROL_MAQUINA)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) as count FROM T_ALERTA_CONTROL_MAQUINA WHERE COD_CONTROL_MAQUINA ='$NOMBRE_CONTROL_MAQUINA'");
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
      $VERSION = $cod->generarVersion();
      $nombre = 'LBS-PHS-FR-01';


      $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);

      $FECHA = $cod->c_horaserversql('F');
      // $FECHAACTUAL = '19/10/2023';

      // $FECHA = date('Y-m-d', strtotime(str_replace('/', '-', $FECHAACTUAL)));
      if ($repetir == 0) {
        $VERSION = $cod->generarVersionGeneral($nombre);

        $stm = $this->bd->prepare("INSERT INTO T_ZONA_AREAS (COD_ZONA, NOMBRE_T_ZONA_AREAS, FECHA,VERSION)
                                  VALUES ('$COD_ZONA', '$NOMBRE_T_ZONA_AREAS', '$FECHA','$VERSION')");


        $insert = $stm->execute();

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

  public function MostrarInfraestructuraID($nombrezonain)
  {
    try {

      $stm = $this->bd->prepare("SELECT * FROM T_INFRAESTRUCTURA WHERE COD_ZONA='$nombrezonain'");
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


      $stm = $this->bd->prepare("SELECT TA.CODIGO AS CODIGO, TA.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA, TZ.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                                    TI.NOMBRE_INFRAESTRUCTURA,TA.N_DIAS_POS AS NDIAS,TA.FECHA_CREACION AS FECHA, TI.USUARIO AS USUARIO FROM T_ALERTA TA 
                                    INNER JOIN T_INFRAESTRUCTURA TI ON TA.COD_INFRAESTRUCTURA=TI.COD_INFRAESTRUCTURA
                                    INNER JOIN T_ZONA_AREAS TZ ON TZ.COD_ZONA=TA.COD_ZONA WHERE   TA.CODIGO IS NOT NULL AND TI.NOMBRE_INFRAESTRUCTURA LIKE '$search%' ORDER BY CODIGO DESC");

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
      $stm = $this->bd->prepare("SELECT TA.CODIGO AS CODIGO, TI.COD_ZONA AS COD_ZONA,TI.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,TZ.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,TI.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA,
                                  TI.NDIAS AS NDIAS, TI.FECHA AS FECHA FROM T_ZONA_AREAS TZ 
                                  INNER JOIN T_INFRAESTRUCTURA TI ON TI.COD_ZONA=TZ.COD_ZONA
                                  INNER JOIN T_ALERTA TA ON TA.COD_INFRAESTRUCTURA=TI.COD_INFRAESTRUCTURA WHERE TA.CODIGO = '$COD_INFRAESTRUCTURA'");
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function buscarPorCodZonaAler($codigoalerta)
  {
    try {
      $stm = $this->bd->prepare("SELECT TA.CODIGO AS CODIGO, TI.COD_ZONA AS COD_ZONA,TI.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,TZ.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,TI.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA,
      TI.NDIAS AS NDIAS, TI.FECHA AS FECHA FROM T_ZONA_AREAS TZ 
      INNER JOIN T_INFRAESTRUCTURA TI ON TI.COD_ZONA=TZ.COD_ZONA
      INNER JOIN T_ALERTA TA ON TA.COD_INFRAESTRUCTURA=TI.COD_INFRAESTRUCTURA  WHERE TA.CODIGO='$codigoalerta'");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function buscarPorCodZona($codzonainfraes)
  {
    try {
      $stm = $this->bd->prepare("SELECT TI.COD_ZONA AS COD_ZONA, TI.COD_INFRAESTRUCTURA, TZ.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                                  TI.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA FROM T_ZONA_AREAS TZ 
                                  INNER JOIN T_INFRAESTRUCTURA TI ON TI.COD_ZONA=TZ.COD_ZONA 
                                  WHERE TZ.COD_ZONA='$codzonainfraes'");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
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
  public function insertarInfraestructura($valorSeleccionado, $NOMBRE_INFRAESTRUCTURA, $NDIAS, $codpersonal)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $codigo = $cod->generarcodigoalerta();

      $repetir = $cod->contarRegistrosInfraestructuraZona($NOMBRE_INFRAESTRUCTURA, $valorSeleccionado);

      $FECHA = $cod->c_horaserversql('F');
      $nombre = 'LBS-PHS-FR-01';
      // $FECHA = '11/11/2023';

      // $FECHA = date('Y-m-d', strtotime(str_replace('/', '-', $FECHAACTUAL)));
      $VERSION = $cod->generarVersionGeneral($nombre);


      if ($repetir == 0) {

        $DIAS_DESCUENTO = 2;

        $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA);


        if (!($NDIAS == 1 || $NDIAS == 2)) {
          $FECHA_TOTAL = $FECHA_FORMATO->modify("+$NDIAS days")->format('d-m-Y');
          if (date('N', strtotime($FECHA_TOTAL)) == 7) {
            $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA_TOTAL . '+1 day'));
          }
          $FECHA_ACORDAR = date('d-m-Y', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days'));
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,FECHA_CREACION,FECHA_TOTAL,FECHA_ACORDAR,N_DIAS_POS,VERSION,CODIGO,COD_PERSONAL) VALUES('$valorSeleccionado','$NOMBRE_INFRAESTRUCTURA','$FECHA','$FECHA_TOTAL','$FECHA_ACORDAR','$NDIAS','$VERSION','$codigo','$codpersonal')");
        } else {
          if ($NDIAS == 2) {
            if ($FECHA_FORMATO->format('N') == 6) {
              $NDIAS = 3;
            } else {
              $NDIAS;
            }
          } elseif ($NDIAS == 1) {
            $NDIAS = 1;
          }
          $FECHA_TOTAL = $FECHA_FORMATO->modify("+$NDIAS days")->format('d-m-Y');
          if (date('N', strtotime($FECHA_TOTAL)) == 7) {
            $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA_TOTAL . '+1 day'));
          }

          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,FECHA_CREACION,FECHA_TOTAL,N_DIAS_POS,VERSION,CODIGO,COD_PERSONAL) VALUES('$valorSeleccionado','$NOMBRE_INFRAESTRUCTURA','$FECHA','$FECHA_TOTAL','2','$VERSION','$codigo','$codpersonal')");
        }
        $actualizainfra = $this->bd->prepare("UPDATE T_INFRAESTRUCTURA SET NDIAS='$NDIAS' WHERE COD_ZONA='$valorSeleccionado' AND COD_INFRAESTRUCTURA='$NOMBRE_INFRAESTRUCTURA'");
        $actualizainfra->execute();

        $insert = $stm1->execute();

        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function consultasialertacambiaestado($task_id)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_ALERTA WHERE CODIGO='$task_id' AND ESTADO='P'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['COUNT'];

    return $count;
  }
  public function consultarduplicadodealerta($NOMBRE_INFRAESTRUCTURA, $valorSeleccionado)
  {

    $repetir = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_ALERTA WHERE COD_INFRAESTRUCTURA='$NOMBRE_INFRAESTRUCTURA' AND COD_ZONA='$valorSeleccionado'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['COUNT'];
    return $count;
  }
  public function editarInfraestructura($valorSeleccionado, $nombreinfraestructurax, $ndias, $codinfra)
  {
    try {
      // var_dump($codinfra);
      // exit();
      $cod = new m_almacen();
      $verifica = $cod->consultasialertacambiaestado($codinfra);
      $verificaduplica = $cod->consultarduplicadodealerta($nombreinfraestructurax, $valorSeleccionado);

      if ($verifica > 0) {
        if ($verificaduplica == 0) {
          $stmt = $this->bd->prepare("UPDATE T_ALERTA SET COD_ZONA='$valorSeleccionado',COD_INFRAESTRUCTURA='$nombreinfraestructurax',N_DIAS_POS='$ndias' WHERE CODIGO='$codinfra'");
          $update = $stmt->execute();

          return $update;
        }
      }
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
  public function Mostrarzonainfraestructura($idzona)
  {

    try {
      $stm = $this->bd->prepare(
        "SELECT * FROM T_INFRAESTRUCTURA WHERE COD_ZONA='$idzona'"
      );

      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function insertarInfraestructuraZona($nombreinfraestructuraz, $nombrezonain)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_INFRAESTRUCTURA = $cod->generarCodigoInfraestructura();

      $nombre = 'LBS-PHS-FR-01';

      $repetircod = $cod->contarRegistrosInfraestructura($nombreinfraestructuraz, $nombrezonain);

      if ($repetircod == 0) {
        $VERSION = $cod->generarVersionGeneral($nombre);

        $stm = $this->bd->prepare("INSERT INTO T_INFRAESTRUCTURA (COD_INFRAESTRUCTURA, COD_ZONA,NOMBRE_INFRAESTRUCTURA ,VERSION)
                                     VALUES ('$COD_INFRAESTRUCTURA','$nombrezonain', '$nombreinfraestructuraz', '$VERSION')");

        $insert = $stm->execute();
        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
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

      $stm = $this->bd->prepare("SELECT T_ZONA_AREAS.COD_ZONA AS COD_ZONA, T_ZONA_AREAS.NOMBRE_T_ZONA_AREAS AS NOMBRE_AREA,T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA AS COD_INFRAESTRUCTURA,
      T_INFRAESTRUCTURA.NOMBRE_INFRAESTRUCTURA AS NOMBRE_INFRAESTRUCTURA,T_INFRAESTRUCTURA.NDIAS AS NDIAS,T_ALERTA.COD_ALERTA AS COD_ALERTA,
      CONVERT(VARCHAR, T_ALERTA.FECHA_CREACION, 103) AS FECHA_CREACION,CONVERT(DATE, T_ALERTA.FECHA_TOTAL) AS FECHA_TOTAL, CONVERT(DATE,T_ALERTA.FECHA_ACORDAR) AS FECHA_ACORDAR,
      T_ALERTA.ESTADO AS ESTADO, T_ALERTA.N_DIAS_POS AS N_DIAS_POS, T_ALERTA.POSTERGACION AS POSTERGACION FROM T_ALERTA INNER JOIN T_INFRAESTRUCTURA
      ON T_ALERTA.COD_INFRAESTRUCTURA= T_INFRAESTRUCTURA.COD_INFRAESTRUCTURA INNER JOIN T_ZONA_AREAS ON
      T_ZONA_AREAS.COD_ZONA= T_INFRAESTRUCTURA.COD_ZONA
      WHERE CAST(FECHA_TOTAL AS DATE) <= CAST(GETDATE() AS DATE) AND ESTADO='P' ");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function InsertarAlerta($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $taskNdias)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_ZONA,COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL,N_DIAS_POS) VALUES (:COD_ZONA, :COD_INFRAESTRUCTURA, :FECHA_CREACION, :FECHA_TOTAL,:N_DIAS_POS)");


    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':COD_ZONA', $codigozona);
    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert1 = $stm->execute();
    return $insert1;
  }

  public function InsertarAlertaMayor($codigozona, $codInfraestructura, $fechaActual, $fechaPostergacion, $taskNdias, $POSTERGACION)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_ZONA, COD_INFRAESTRUCTURA, FECHA_CREACION, FECHA_TOTAL, N_DIAS_POS,POSTERGACION) VALUES ('$codigozona','$codInfraestructura','$fechaActual', '$fechaPostergacion','$taskNdias','$POSTERGACION')");
    $insert2 = $stm->execute();
    return $insert2;
  }

  public function InsertarAlertaMayorSinPost($codigozona, $codInfraestructura, $FECHA_CREACION, $FECHA_TOTAL, $FECHA_ACORDAR, $taskNdias)
  {
    $stm = $this->bd->prepare("INSERT INTO T_ALERTA (COD_ZONA, COD_INFRAESTRUCTURA, FECHA_CREACION,FECHA_TOTAL,FECHA_ACORDAR,N_DIAS_POS) VALUES (:COD_ZONA, :COD_INFRAESTRUCTURA, :FECHA_CREACION,:FECHA_TOTAL, :FECHA_ACORDAR, :N_DIAS_POS)");


    $stm->bindParam(':COD_ZONA', $codigozona);
    $stm->bindParam(':COD_INFRAESTRUCTURA', $codInfraestructura);
    $stm->bindParam(':FECHA_CREACION', $FECHA_CREACION);
    $stm->bindParam(':FECHA_TOTAL', $FECHA_TOTAL);
    $stm->bindParam(':FECHA_ACORDAR', $FECHA_ACORDAR);
    $stm->bindParam(':N_DIAS_POS', $taskNdias);

    $insert2 = $stm->execute();
    return $insert2;
  }

  public function actualizarAlertaCheckBox($codigozonaalerta, $estado, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion, $selectVB)
  {

    $stmt = $this->bd->prepare("UPDATE T_ALERTA SET COD_ZONA='$codigozonaalerta', ESTADO = '$estado', OBSERVACION = '$observacion', FECHA_POSTERGACION= '$FECHA_POSTERGACION', FECHA_TOTAL = '$FECHA_ACTUALIZA', ACCION_CORRECTIVA = '$accionCorrectiva', VERIFICACION_REALIZADA='$selectVerificacion', VB='$selectVB' WHERE COD_ALERTA = '$taskId'");

    $stmt->execute();
    return $stmt;
  }

  public function actualizarAlertaCheckBoxSinPOS($codigozonaalerta, $estado, $taskId, $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva, $selectVerificacion, $selectVB)
  {
    // $fecha_actualiza = convFecSistema1($FECHA_ACTUALIZA);
    $stmt = $this->bd->prepare("UPDATE T_ALERTA SET COD_ZONA=:COD_ZONA, ESTADO = :estado, OBSERVACION = :observacionTextArea, FECHA_TOTAL = :FECHA_ACTUALIZA, ACCION_CORRECTIVA = :ACCION_CORRECTIVA, VERIFICACION_REALIZADA=:VERIFICACION_REALIZADA,VB=:VB WHERE COD_ALERTA = :COD_ALERTA");

    $stmt->bindParam(':COD_ZONA', $codigozonaalerta, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':observacionTextArea', $observacionTextArea, PDO::PARAM_STR);
    $stmt->bindParam(':COD_ALERTA', $taskId, PDO::PARAM_STR);
    $stmt->bindParam(':FECHA_ACTUALIZA', $FECHA_ACTUALIZA);
    $stmt->bindParam(':ACCION_CORRECTIVA', $accionCorrectiva);
    $stmt->bindParam(':VERIFICACION_REALIZADA', $selectVerificacion);
    $stmt->bindParam(':VB', $selectVB);
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

  public function Mostraralertainfrapdf($anioSeleccionado, $mesSeleccionado)
  {
    try {
      $stm = $this->bd->prepare("SELECT * FROM T_ WHERE MONTH(FECHA_TOTAL) = '$mesSeleccionado' AND YEAR(FECHA_TOTAL) = '$anioSeleccionado'");

      $stm->execute();
      $datos = $stm->fetchAll();
      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarInfraestructuraEstadoPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {
      $stm = $this->bd->prepare("SELECT TA.FECHA_TOTAL AS FECHA_TOTAL,TZ.NOMBRE_T_ZONA_AREAS AS NOMBRE_T_ZONA_AREAS,
                                  TA.OBSERVACION AS OBSERVACION, TA.ACCION_CORRECTIVA AS ACCION_CORRECTIVA,TA.VERIFICACION_REALIZADA AS VERIFICACION_REALIZADA,TA.VB AS VB FROM T_ALERTA TA 
                                  INNER JOIN T_INFRAESTRUCTURA TI ON TA.COD_INFRAESTRUCTURA=TI.COD_INFRAESTRUCTURA
                                  INNER JOIN T_ZONA_AREAS TZ ON TZ.COD_ZONA=TI.COD_ZONA
                                  WHERE ESTADO='OB' OR ESTADO='PE' AND MONTH(FECHA_TOTAL) = '$mesSeleccionado' AND YEAR(FECHA_TOTAL) = '$anioSeleccionado'");

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


  public function insertarCombo($selectSolucion, $selectPreparacion, $selectCantidad, $selectML, $selectL, $textAreaObservacion, $textAreaAccion, $selectVerificacion, $valorextra)
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
      if ($selectCantidad == '5%') {
        $valorcant = '1';
      } elseif ($selectCantidad == '3.9%') {
        $valorcant = '2';
      } elseif ($selectCantidad == 'N°de preparaciones') {
        $valorcant = '3';
      } elseif ($selectCantidad == '50ppm') {
        $valorcant = '4';
      } elseif ($selectCantidad == '100ppm') {
        $valorcant = '5';
      } elseif ($selectCantidad == '200ppm') {
        $valorcant = '6';
      } elseif ($selectCantidad == '300ppm') {
        $valorcant = '7';
      } elseif ($selectCantidad == '400ppm') {
        $valorcant = '8';
      } elseif ($selectCantidad == '200ppm') {
        $valorcant = '9';
      }
      $valormili = $this->bd->prepare("SELECT top 1 (CANTIDAD_MILILITROS) AS CANTIDAD_MILILITROS  FROM T_ML where ID_CANTIDAD='$valorcant'");
      $valormili->execute();
      $result = $valormili->fetch(PDO::FETCH_ASSOC);
      $mili = intval($result['CANTIDAD_MILILITROS']);

      $cod->generarVersionGeneral($nombre);
      // if ($valor1 == 0) {
      if ($valorextra) {
        $valormililitros = ($mili * $valorextra) . "ml";
        $valorlitros = $valorextra . "L";
        $stm = $this->bd->prepare("INSERT INTO T_UNION(NOMBRE_INSUMOS, NOMBRE_PREPARACION,CANTIDAD_PORCENTAJE,
        CANTIDAD_MILILITROS, CANTIDAD_LITROS, OBSERVACION, ACCION_CORRECTIVA, VERIFICACION,CANTIDAD_DIFERENTE)
        VALUES ('$selectSolucion','$selectPreparacion', '$selectCantidad','$valormililitros','$valorlitros','$textAreaObservacion','$textAreaAccion','$selectVerificacion','$valorextra')");

        $insert = $stm->execute();
      } else {
        $stm = $this->bd->prepare("INSERT INTO T_UNION(NOMBRE_INSUMOS, NOMBRE_PREPARACION,CANTIDAD_PORCENTAJE,
                                    CANTIDAD_MILILITROS, CANTIDAD_LITROS, OBSERVACION, ACCION_CORRECTIVA, VERIFICACION)
                                  VALUES ('$selectSolucion','$selectPreparacion', '$selectCantidad','$selectML', '$selectL','$textAreaObservacion','$textAreaAccion','$selectVerificacion')");

        $insert = $stm->execute();
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


      $stm = $this->bd->prepare("SELECT * FROM T_UNION WHERE MONTH(FECHA) = :mesSeleccionado AND YEAR(FECHA) = :anioSeleccionado");
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
      // $version = $codGen->generarVersion();

      $fechaDHoy = $codGen->c_horaserversql('F');
      // $fechaDHoy = date('Y-m-d');

      $stmFre = $this->bd->prepare("SELECT * FROM T_FRECUENCIA WHERE cast(FECHA as DATE) =cast('$fechaDHoy' as date) AND NOMBRE_FRECUENCIA='$textfrecuencia' AND COD_ZONA='$selectZona'");

      $stmFre->execute();
      $valor = $stmFre->fetchAll();

      $contador = count($valor);

      if ($contador == 0) {
        $version = $codGen->generarVersionGeneral($nombre);
        $stm = $this->bd->prepare("INSERT INTO T_FRECUENCIA(COD_FRECUENCIA, COD_ZONA, NOMBRE_FRECUENCIA, VERSION,OBSERVACION,ACCION_CORRECTIVA,VERIFICACION)
                                  VALUES ('$codFrecuencia','$selectZona', '$textfrecuencia','$version','$textAreaObservacion','$textAreaAccion','$selectVerificacion')");

        $insert = $stm->execute();
        $codGen->generarVersionGeneral($nombre);

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

  public function MostrarControlMaquina()
  {
    try {
      $stm = $this->bd->prepare("SELECT * FROM T_CONTROL_MAQUINA");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarControlMaquinasBusqueda($search)
  {
    try {

      // $stm = $this->bd->prepare("SELECT CM.CODIGO AS CODIGO,CM.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA, TC.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,CM.N_DIAS_POS AS N_DIAS_POS,
      //                                   CM.FECHA_CREACION AS FECHA_CREACION FROM T_ALERTA_CONTROL_MAQUINA CM 
      //                                   INNER JOIN T_CONTROL_MAQUINA TC ON TC.COD_CONTROL_MAQUINA=CM.COD_CONTROL_MAQUINA
      //                                   WHERE CM.CODIGO IS NOT NULL AND TC.NOMBRE_CONTROL_MAQUINA LIKE '$search%' ORDER BY CM.CODIGO DESC");
      $stm = $this->bd->prepare("SELECT CM.CODIGO AS CODIGO, CM.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA,
                                  TC.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA, CM.N_DIAS_POS AS N_DIAS_POS,
                                  CM.FECHA_CREACION AS FECHA_CREACION FROM T_ALERTA_CONTROL_MAQUINA CM
                                  INNER JOIN T_CONTROL_MAQUINA TC ON TC.COD_CONTROL_MAQUINA = CM.COD_CONTROL_MAQUINA
                                  WHERE TC.NOMBRE_CONTROL_MAQUINA LIKE '$search%' AND CM.ESTADO = 'P'
                                  ORDER BY CM.CODIGO DESC");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function contarnombrecontrol($nombrecontrolmaquina)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_CONTROL_MAQUINA WHERE NOMBRE_CONTROL_MAQUINA='$nombrecontrolmaquina'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['COUNT'];

    return $count;
  }
  public function insertarControlMaquina($nombrecontrolmaquina)
  {
    try {
      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $COD_CONTROL_MAQUINA = $cod->generarCodigoControlMaquina();


      $repetir = $cod->contarnombrecontrol($nombrecontrolmaquina);

      if ($repetir == 0) {

        $stm = $this->bd->prepare("INSERT INTO T_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,COD_ZONA, NOMBRE_CONTROL_MAQUINA)
                                  VALUES ('$COD_CONTROL_MAQUINA','16','$nombrecontrolmaquina')");

        $insert = $stm->execute();

        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function generarCodigoalertacontrol()
  {
    $stm = $this->bd->prepare("SELECT MAX(CODIGO) as CODIGO FROM T_ALERTA_CONTROL_MAQUINA");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $maxCodigo = intval($resultado['CODIGO']);
    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 4, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function insertarControl($NOMBRE_CONTROL_MAQUINA, $N_DIAS_CONTROL)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();

      $nombre = 'LBS-PHS-FR-03';

      $repetir = $cod->contarRegistrosControl($NOMBRE_CONTROL_MAQUINA);
      $generarcodigo = $cod->generarCodigoalertacontrol();

      $FECHA = $cod->c_horaserversql('F');

      if ($repetir == 0) {
        $VERSION = $cod->generarVersionGeneral($nombre);
        // $fechaDHoy = '24/07/2023';

        // $cod->generarVersionGeneral($nombre);


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
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_CREACION,FECHA_TOTAL,FECHA_ACORDAR,N_DIAS_POS,CODIGO,COD_ZONA) values('$NOMBRE_CONTROL_MAQUINA','$FECHA','$FECHA_TOTAL','$FECHA_ACORDAR','$N_DIAS_CONTROL','$generarcodigo','16')");
        } else {
          $stm1 = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_CREACION,FECHA_TOTAL,N_DIAS_POS,COD_ZONA) values('$NOMBRE_CONTROL_MAQUINA','$FECHA','$FECHA_TOTAL','$N_DIAS_CONTROL','16')");
        }

        $insert = $stm1->execute();

        $updatecontrolmaquina = $this->bd->prepare("UPDATE T_CONTROL_MAQUINA SET N_DIAS_CONTROL='$N_DIAS_CONTROL',VERSION='$VERSION' WHERE COD_CONTROL_MAQUINA='$NOMBRE_CONTROL_MAQUINA'");
        $updatecontrolmaquina->execute();

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

      $stm = $this->bd->prepare("SELECT CM.CODIGO AS CODIGO, CM.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA, TC.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,
                                  CM.N_DIAS_POS AS N_DIAS_POS FROM T_ALERTA_CONTROL_MAQUINA CM 
                                  INNER JOIN T_CONTROL_MAQUINA TC ON TC.COD_CONTROL_MAQUINA=CM.COD_CONTROL_MAQUINA WHERE CM.CODIGO= '$COD_CONTROL_MAQUINA'");

      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function contaralertacontrol($task_id)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_ALERTA_CONTROL_MAQUINA WHERE CODIGO='$task_id' AND ESTADO='P'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['COUNT'];
    return $count;
  }
  public function duplicadoalertacontrol($NOMBRE_CONTROL, $N_DIAS_CONTROL)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_ALERTA_CONTROL_MAQUINA WHERE COD_CONTROL_MAQUINA='$NOMBRE_CONTROL' AND N_DIAS_POS='$N_DIAS_CONTROL'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = $result['COUNT'];
    return $count;
  }
  public function editarControlMaquina($NOMBRE_CONTROL, $N_DIAS_CONTROL, $task_id)
  {
    try {

      $cod = new m_almacen();
      $nombre = 'LBS-PHS-FR-03';
      $repetir = $cod->contaralertacontrol($task_id);
      $duplicadocontrol = $cod->duplicadoalertacontrol($NOMBRE_CONTROL, $N_DIAS_CONTROL);

      if ($repetir == 0) {
        if ($duplicadocontrol == 0) {

          $FECHA = $cod->c_horaserversql('F');
          $FECHA_FORMATO = DateTime::createFromFormat('d/m/Y', $FECHA);
          $FECHA_TOTAL = $FECHA_FORMATO->modify("+$N_DIAS_CONTROL days")->format('d-m-Y');
          $DIAS_DESCUENTO = 2;
          // Verificar si la fecha total cae en domingo
          if (date('N', strtotime($FECHA_TOTAL)) == 7) {
            $FECHA_TOTAL = date('d-m-Y', strtotime($FECHA_TOTAL . '+1 day'));
          }
          $FECHA_ACORDAR = date('d-m-Y', strtotime($FECHA_TOTAL . '-' . $DIAS_DESCUENTO . 'days'));
          $stmt = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET COD_CONTROL_MAQUINA='$NOMBRE_CONTROL',N_DIAS_POS='$N_DIAS_CONTROL',FECHA_CREACION='$FECHA',FECHA_TOTAL='$FECHA_TOTAL',FECHA_ACORDAR='$FECHA_ACORDAR' WHERE COD_CONTROL_MAQUINA='$task_id'");
          $update = $stmt->execute();

          $cod->generarVersionGeneral($nombre);
          return $update;
        }
      }
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
  public function  guardarControlPdfDiario($valorcapturadocontrol)
  {
    try {

      $this->bd->beginTransaction();

      $codigo = new m_almacen();
      $fechaactualfrecuencia = $codigo->c_horaserversql('F');

      foreach ($valorcapturadocontrol as $row) {

        $codigoalertacontrol = $row['codigoalertacontrol'];
        $codigocontrol = $row['codcontrol'];
        $frecuencia = $row['frecuenciavalor'];


        $repetir = $this->bd->prepare("SELECT MAX(CODIGO) AS CODIGO FROM T_ALERTA_CONTROL_MAQUINA WHERE COD_CONTROL_MAQUINA='$codigocontrol' AND ESTADO='P'");
        $repetir->execute();
        $result = $repetir->fetch(PDO::FETCH_ASSOC);
        $valordecodigo = $result['CODIGO'];

        $fechaConvertida = DateTime::createFromFormat('d/m/Y', $fechaactualfrecuencia);
        $fechaConvertida->modify('+1 day');
        $fechatotal = $fechaConvertida->format('d/m/Y');
        if (isset($row['estado'])) {
          $estado = $row['estado'];

          $vb = $row['vb'];
          $accioncorrectiva = strtoupper($row['accioncorrectiva']);
          $observacion = strtoupper($row['observacion']);

          if ($vb == '1') {
            $vbvalor = 'J.A.C';
          } else {
            $vbvalor = 'A.A.C';
          }


          // $repetircontrolmaquina = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_ALERTA_CONTROL_MAQUINA WHERE N_DIAS_POS='1' AND ESTADO='P'");
          // $repetircontrolmaquina->execute();
          // $repet = $repetircontrolmaquina->fetch(PDO::FETCH_ASSOC);
          // $valordecodigocontrolduplicado = $repet['COUNT'];
          // if ($valordecodigocontrolduplicado > 0) {
          $stminsrtuno = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_TOTAL,ESTADO,N_DIAS_POS,COD_ZONA,CODIGO)VALUES('$codigocontrol','$fechatotal','P','1','16','$valordecodigo')");
          $stminsrtuno->execute();
          // }

          // if ($frecuencia == 'true') {
          if ($estado == 'R') {
            $stm = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET FECHA_TOTAL='$fechaactualfrecuencia',ESTADO='$estado' WHERE COD_ALERTA_CONTROL_MAQUINA='$codigoalertacontrol'");
          } elseif ($estado == 'OB') {

            $stm = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET FECHA_TOTAL='$fechaactualfrecuencia',ESTADO='$estado',ACCION_CORRECTIVA='$accioncorrectiva',
              OBSERVACION='$observacion', VB='$vbvalor'
              WHERE COD_ALERTA_CONTROL_MAQUINA='$codigoalertacontrol'");
          } elseif ($estado == 'PO') {

            $stm = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET FECHA_TOTAL='$fechatotal',ESTADO='PE',ACCION_CORRECTIVA='$accioncorrectiva',
                OBSERVACION='$observacion', VB='$vbvalor'
                WHERE COD_ALERTA_CONTROL_MAQUINA='$codigoalertacontrol'");
          }
        } else {
          $stm = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET FECHA_TOTAL='$fechaactualfrecuencia',ESTADO='DE' WHERE COD_ALERTA_CONTROL_MAQUINA='$codigoalertacontrol'");

          $stminsrtuno = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_TOTAL,ESTADO,N_DIAS_POS,COD_ZONA,CODIGO)VALUES('$codigocontrol','$fechatotal','P','1','16','$valordecodigo')");
          $stminsrtuno->execute();
        }

        $stm->execute();
      }

      $insert = $stm->execute();

      $insert = $this->bd->commit();
      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarAlertaControl()
  {
    try {
      $stm = $this->bd->prepare("SELECT TCM.COD_ALERTA_CONTROL_MAQUINA AS COD_ALERTA_CONTROL_MAQUINA ,TCM.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA,TC.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,
                                  TCM.FECHA_CREACION AS FECHA_CREACION, TCM.FECHA_TOTAL AS FECHA_TOTAL, TCM.FECHA_ACORDAR,
                                  TCM.ESTADO AS ESTADO, TCM.N_DIAS_POS AS N_DIAS_POS FROM T_ALERTA_CONTROL_MAQUINA TCM 
                                  INNER JOIN T_CONTROL_MAQUINA TC ON TC.COD_CONTROL_MAQUINA=TCM.COD_CONTROL_MAQUINA 
                                  WHERE CAST(TCM.FECHA_TOTAL AS DATE)   <= CAST(GETDATE() AS DATE) AND (TCM.ESTADO='P' AND TCM.N_DIAS_POS!='1')
                                  OR (TCM.ESTADO='PE' AND TCM.N_DIAS_POS='1') OR (CAST(TCM.FECHA_TOTAL AS DATE)   <= CAST(GETDATE() AS DATE) AND TCM.ESTADO='OB' AND TCM.POSTERGACION='SI')");

      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function actualizarAlertaCheckControlPos($codigocontrolmaquina, $ndiaspos, $taskId, $observacion, $FECHA_POSTERGACION, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB)
  {
    try {
      $this->bd->beginTransaction();
      $cod = new m_almacen();

      $actualiza = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET ESTADO='PO', OBSERVACION='$observacion',FECHA_POSTERGACION='$FECHA_POSTERGACION',FECHA_TOTAL='$FECHA_ACTUALIZA',ACCION_CORRECTIVA='$accionCorrectiva',VB='$selectVB' WHERE COD_ALERTA_CONTROL_MAQUINA='$taskId'");
      $actualizaralertacontrol = $actualiza->execute();

      $insertar = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_TOTAL,N_DIAS_POS) 
                                      VALUES('$codigocontrolmaquina','$FECHA_POSTERGACION',$ndiaspos) ");
      $insertar->execute();

      $actualizaralertacontrol = $this->bd->commit();
      return $actualizaralertacontrol;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function actualizarAlertaControlCheckBox($codigocontrolmaquina, $estado, $ndiaspos, $taskId,  $observacionTextArea, $FECHA_ACTUALIZA, $accionCorrectiva,  $selectVB)
  {
    try {
      $this->bd->beginTransaction();
      $cod = new m_almacen();

      $actualiza = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET ESTADO='$estado', OBSERVACION='$observacionTextArea',FECHA_TOTAL='$FECHA_ACTUALIZA',ACCION_CORRECTIVA='$accionCorrectiva',VB='$selectVB' WHERE COD_ALERTA_CONTROL_MAQUINA='$taskId'");
      $actualizaralertacontrol = $actualiza->execute();
      if ($ndiaspos != '1') {

        $conversionfecha = strtotime(str_replace('/', '-',  $FECHA_ACTUALIZA));
        $fechasumadias = strtotime("+$ndiaspos days", $conversionfecha);
        $fechadomingo = date('w', $fechasumadias);

        if ($fechadomingo == 0) {
          $fechasumadias = strtotime('+1 day', $fechasumadias);
        }
        $FECHA_TOTAL = date("d/m/Y", $fechasumadias);
        $fechamenosdias = strtotime("-2 days", $fechasumadias);
        $FECHA_ACORDAR = date("d/m/Y", $fechamenosdias);

        $insertar = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,FECHA_TOTAL,FECHA_ACORDAR,N_DIAS_POS) 
                                        VALUES('$codigocontrolmaquina','$FECHA_TOTAL','$FECHA_ACORDAR','$ndiaspos') ");
        $insertar->execute();
      }


      $actualizaralertacontrol = $this->bd->commit();
      return $actualizaralertacontrol;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
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
        "SELECT TCM.COD_ZONA AS COD_ZONA,TCM.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA, TC.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,
         CONVERT(VARCHAR, TCM.FECHA_TOTAL, 103) AS FECHA_TOTAL,TCM.ESTADO AS ESTADO,
          CASE
            WHEN TCM.N_DIAS_POS = 1 THEN 'Diario*'
            WHEN TCM.N_DIAS_POS = 7 THEN 'Semanal'
            WHEN TCM.N_DIAS_POS = 30 THEN 'Mensual'
            ELSE 'Otro'
          END AS FRECUENCIA FROM T_ALERTA_CONTROL_MAQUINA TCM
             INNER JOIN T_CONTROL_MAQUINA TC ON TC.COD_CONTROL_MAQUINA = TCM.COD_CONTROL_MAQUINA
             WHERE TCM.ESTADO !='P' AND TCM.ESTADO !='PE'  AND MONTH(FECHA_TOTAL) = :mesSeleccionado AND YEAR(FECHA_TOTAL) = :anioSeleccionado"
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
  public function MostrarControlMaquinaOBPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {
      $stm = $this->bd->prepare(
        "SELECT  CONVERT(VARCHAR, FECHA_TOTAL, 103) AS FECHA_TOTAL, OBSERVACION , ACCION_CORRECTIVA, VB, ESTADO FROM T_ALERTA_CONTROL_MAQUINA
             WHERE (ESTADO ='OB' OR ESTADO ='PO') AND MONTH(FECHA_TOTAL) = :mesSeleccionado AND YEAR(FECHA_TOTAL) = :anioSeleccionado"
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
  public function controlmaquinapdfmodal()
  {
    try {
      $stm = $this->bd->prepare("SELECT TACM.COD_ALERTA_CONTROL_MAQUINA AS COD_ALERTA_CONTROL_MAQUINA,TACM.COD_CONTROL_MAQUINA AS COD_CONTROL_MAQUINA, TC.NOMBRE_CONTROL_MAQUINA AS NOMBRE_CONTROL_MAQUINA,
      TACM.N_DIAS_POS AS N_DIAS_POS FROM T_ALERTA_CONTROL_MAQUINA TACM
      INNER JOIN T_CONTROL_MAQUINA TC ON TC.COD_CONTROL_MAQUINA=TACM.COD_CONTROL_MAQUINA WHERE TACM.N_DIAS_POS='1' AND TACM.ESTADO='P'");

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
  public function MostrarListaMaestraPDF()
  {
    try {
      $stm = $this->bd->prepare("SELECT COD_PRODUCTO,COD_PRODUCCION,ABR_PRODUCTO,DES_PRODUCTO FROM T_PRODUCTO 
      WHERE COD_PRODUCCION  IS NOT NULL AND COD_CATEGORIA='00002' ORDER BY DES_PRODUCTO ASC");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarListaMaestraEnvasesPDF()
  {
    try {
      $stm = $this->bd->prepare("SELECT COD_PRODUCCION,COD_PRODUCTO,ABR_PRODUCTO,DES_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCCION 
      IS NOT NULL AND COD_CATEGORIA='00008' ORDER BY DES_PRODUCTO ASC");
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






  public function  MostrarProductoFormulacion()
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



  public function  MostrarProductoTerminado()
  {
    try {
      $stm = $this->bd->prepare("SELECT TF.COD_FORMULACION AS COD_FORMULACION,TF.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,TP.ABR_PRODUCTO AS ABR_PRODUCTO,
      TP.COD_PRODUCCION AS COD_PRODUCCION, TP.PESO_NETO AS PESO_NETO,TP.COD_CATEGORIA AS COD_CATEGORIA, TP.CANTIDAD AS CANTIDAD FROM T_TMPFORMULACION TF  INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TF.COD_PRODUCTO 
      WHERE TP.COD_CATEGORIA='00004' AND COD_PRODUCCION IS NOT NULL");
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

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_CATEGORIA='00002'AND COD_PRODUCCION IS NOT NULL");
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

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO, ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_CATEGORIA='00008' AND COD_PRODUCCION IS NOT NULL");
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
  public function ConsultarFormulaDuplicado($selectProductoCombo)
  {
    $stm = $this->bd->prepare("SELECT CAN_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$selectProductoCombo'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $resultadocvantidad = $resultado['CAN_FORMULACION'];

    return $resultadocvantidad;
  }
  public function consultarcodigoformulacion($selectProductoCombo)
  {
    $stm = $this->bd->prepare("SELECT COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$selectProductoCombo'");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);
    $resultadocvantidad = $resultado['COD_FORMULACION'];

    return $resultadocvantidad;
  }

  public function InsertarProductoCombo($codigopersonal, $selectProductoCombo, $cantidadTotal, $dataInsumo, $dataEnvase)
  {
    try {
      $this->bd->beginTransaction();
      $codigoform = new m_almacen();


      $fecha_generado = $codigoform->c_horaserversql('F');
      $maquina = os_info();

      $codigo_formulacion = $codigoform->generarCodigoFormulacion();
      $codigo_categoria = $codigoform->generarCodigoCategoriaProducto($selectProductoCombo);
      $unidad_medida = $codigoform->generarCodigoUnidadMedida($selectProductoCombo);
      $contar_tmpformulacion = $codigoform->contarCodigoFormulacion($selectProductoCombo);
      $consultacodigoformula = $codigoform->consultarcodigoformulacion($selectProductoCombo);

      // if ($contar_tmpformulacion == 0) {
      if ($consultacodigoformula == NULL) {
        $stm = $this->bd->prepare("INSERT INTO T_TMPFORMULACION(COD_FORMULACION, COD_CATEGORIA, COD_PRODUCTO, FEC_GENERADO, CAN_FORMULACION, UNI_MEDIDA,USU_REGISTRO,MAQUINA)
                                      VALUES ('$codigo_formulacion','$codigo_categoria','$selectProductoCombo',CONVERT(VARCHAR, GETDATE(), 112),'$cantidadTotal','UNIDAD','$codigopersonal','$maquina')");
        $stm->execute();
        foreach ($dataInsumo as $item) {
          $insumo = $item['codigoproductoinsumo'];
          $cantidadInsumo = $item['cantidadinsumo'];
          $stmInsumo = $this->bd->prepare("INSERT INTO T_TMPFORMULACION_ITEM(COD_FORMULACION, COD_PRODUCTO, CAN_FORMULACION,USU_REGISTRO,MAQUINA)
                                          VALUES ('$codigo_formulacion','$insumo','$cantidadInsumo','$codigopersonal','$maquina')");

          $insert = $stmInsumo->execute();
        }

        foreach ($dataEnvase as $item) {
          $envase = $item['codigoproductoenvase'];
          $cantidadEnvase = $item['cantidadenvase'];
          $stmEnvase = $this->bd->prepare("INSERT INTO T_TMPFORMULACION_ENVASE(COD_FORMULACION, COD_PRODUCTO, CANTIDA,USU_REGISTRO,MAQUINA)
                                   VALUES ('$codigo_formulacion','$envase','$cantidadEnvase','$codigopersonal','$maquina')");

          $stmEnvase->execute();
        }
      } else {
        $eliminarantiguainsumo = $this->bd->prepare("DELETE FROM T_TMPFORMULACION_ITEM WHERE COD_FORMULACION='$consultacodigoformula'");
        $eliminarantiguainsumo->execute();

        $eliminarantiguaenvase = $this->bd->prepare("DELETE FROM T_TMPFORMULACION_ENVASE WHERE COD_FORMULACION='$consultacodigoformula'");
        $eliminarantiguaenvase->execute();

        foreach ($dataInsumo as $item) {
          $insumo = $item['codigoproductoinsumo'];
          $cantidadInsumo = $item['cantidadinsumo'];
          $stmInsumo = $this->bd->prepare("INSERT INTO T_TMPFORMULACION_ITEM(COD_FORMULACION, COD_PRODUCTO, CAN_FORMULACION,USU_MODIFICO,MAQUINA)
                                          VALUES ('$consultacodigoformula','$insumo','$cantidadInsumo','$codigopersonal','$maquina')");

          $insert = $stmInsumo->execute();
        }

        foreach ($dataEnvase as $item) {
          $envase = $item['codigoproductoenvase'];
          $cantidadEnvase = $item['cantidadenvase'];
          $stmEnvase = $this->bd->prepare("INSERT INTO T_TMPFORMULACION_ENVASE(COD_FORMULACION, COD_PRODUCTO, CANTIDA,USU_MODIFICO,MAQUINA)
                                   VALUES ('$consultacodigoformula','$envase','$cantidadEnvase','$codigopersonal','$maquina')");

          $stmEnvase->execute();
        }
      }



      $insert = $this->bd->commit();
      return $insert;
      // }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarProductoEnvase($buscarregistro)
  {
    try {

      $stm = $this->bd->prepare("SELECT F.COD_FORMULACION AS COD_FORMULACION,F.COD_PRODUCTO AS COD_PRODUCTO,P.ABR_PRODUCTO AS ABR_PRODUCTO,P.DES_PRODUCTO AS DES_PRODUCTO, F.CAN_FORMULACION AS CAN_FORMULACION
                                  FROM T_PRODUCTO AS P INNER JOIN T_TMPFORMULACION AS F ON P.COD_PRODUCTO=F.COD_PRODUCTO 
                                  WHERE P.DES_PRODUCTO LIKE '%$buscarregistro%'");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarPesoNeto($codigoproductoneto)
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCTO,PESO_NETO FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoproductoneto'");
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
      $insert = $stmRequerimiento->execute();

      // $sumaTotalInEn = 0;
      // for ($i = 0; $i < count($unionItem); $i += 2) {

      //   $codProductoTotal = $unionItem[$i];
      //   $canInsuTotal = $unionItem[$i + 1];
      //   $sumaTotalInEn =  $sumaTotalInEn + $canInsuTotal;


      //   $stmRequeItem = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_ITEM(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
      //   VALUES ('$codRequerimiento', '$codProductoTotal', '$canInsuTotal')");
      //   $stmRequeItem->execute();
      // }
      $sumaTotalInEn = 0;
      $totalprod = 0;
      foreach ($unionItem->valoresCapturadosTotalEnvase as $dato) {
        $codProductoTotal = $dato[0];
        $canInsuTotal = $dato[1];
        $sumaTotalInEn += $dato[1];
        $totalprod += $dato[2];
        $stmRequeItem = $this->bd->prepare("INSERT INTO T_TMPREQUERIMIENTO_ITEM(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD,TOTAL_PRODUCTO)
        VALUES ('$codRequerimiento', '$codProductoTotal', '$canInsuTotal','$dato[2]')");
        $stmRequeItem->execute();
      }
      // $stmSumRequerimiento = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET CANTIDAD='$sumaTotalInEn' WHERE COD_REQUERIMIENTO='$codRequerimiento'");
      // $stmSumRequerimiento->execute();
      $stmSumRequerimiento = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET CANTIDAD='$sumaTotalInEn',
      TOTAL_PRODUCTO = '$totalprod' WHERE COD_REQUERIMIENTO='$codRequerimiento'");
      $stmSumRequerimiento->execute();


      for ($i = 0; $i < count($union); $i += 2) {
        $codProducto = ($union[$i]);
        $canInsu = $union[$i + 1];

        $stmRequeInsumo = $this->bd->prepare("INSERT  INTO T_TMPREQUERIMIENTO_INSUMO(COD_REQUERIMIENTO, COD_PRODUCTO, CANTIDAD)
        VALUES ('$codRequerimiento','$codProducto', '$canInsu')");

        $stmRequeInsumo->execute();
      }


      for ($j = 0; $j < count($unionEnvase); $j += 2) {

        $codProductoEnvase = trim($unionEnvase[$j]);
        $canEnvase = $unionEnvase[$j + 1];

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
  public function MostrarValorOrdenCompraTemp($cod_formulacion)
  {
    try {
      $stm = $this->bd->prepare("SELECT OC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,OC.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,CI.FECHA_ENTREGA AS FECHA_REALIZADA,OC.HORA AS HORA,OC.COD_PROVEEDOR AS COD_PROVEEDOR,
                                  TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR ,OC.F_PAGO AS F_PAGO,CI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO, CI.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE,
                                  CI.MONTO AS MONTO, CI.PRECIO_MINIMO AS PRECIO_MINIMO, TA.STOCK_ACTUAL AS STOCK_ACTUAL FROM T_TMPORDEN_COMPRATEMP OC 
                                  INNER JOIN T_TMPORDEN_COMPRA_ITEMTEMP CI ON CI.COD_ORDEN_COMPRA=OC.COD_ORDEN_COMPRA 
                                  INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=OC.COD_PROVEEDOR
                                  INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=CI.COD_PRODUCTO
                                  INNER JOIN T_TMPALMACEN_INSUMOS TA ON TA.COD_PRODUCTO=CI.COD_PRODUCTO
                                  WHERE OC.COD_REQUERIMIENTO='$cod_formulacion' AND CI.ESTADO='P' ORDER BY OC.COD_PROVEEDOR");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage() . "<br>";
      echo "SQL: " . $stm;
      die();
    }
  }
  public function MostrarImagenesOrdenCompraTemp($codigorequerimiento, $codigoproveedor)
  {
    try {
      $stm = $this->bd->prepare("SELECT * FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$codigorequerimiento' AND COD_PROVEEDOR='$codigoproveedor'");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage() . "<br>";
      echo "SQL: " . $stm;
      die();
    }
  }

  public function MostrarOrdenGuardada($buscar)
  {
    try {
      $stm = $this->bd->prepare("SELECT OC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,OC.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,CI.FECHA_ENTREGA AS FECHA_REALIZADA,OC.HORA AS HORA,OC.COD_PROVEEDOR AS COD_PROVEEDOR,
                                  TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR ,OC.F_PAGO AS F_PAGO,CI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO, CI.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE,
                                  CI.MONTO AS MONTO, CI.PRECIO_MINIMO AS PRECIO_MINIMO, TA.STOCK_ACTUAL AS STOCK_ACTUAL,CI.CANTIDAD_LLEGADA AS CANTIDAD_LLEGADA FROM T_TMPORDEN_COMPRATEMP OC 
                                  INNER JOIN T_TMPORDEN_COMPRA_ITEMTEMP CI ON CI.COD_ORDEN_COMPRA=OC.COD_ORDEN_COMPRA 
                                  INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=OC.COD_PROVEEDOR
                                  INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=CI.COD_PRODUCTO
                                  INNER JOIN T_TMPALMACEN_INSUMOS TA ON TA.COD_PRODUCTO=CI.COD_PRODUCTO
                                  WHERE CI.ESTADO='F' AND TP.DES_PRODUCTO LIKE '%$buscar%' ORDER BY OC.COD_PROVEEDOR");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage() . "<br>";
      echo "SQL: " . $stm;
      die();
    }
  }

  public function MostrarSiCompra($cod_formulacion)
  {
    try {
      $stm = $this->bd->prepare("SELECT TI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
      TI.CANTIDAD AS CANTIDAD, TA.STOCK_ACTUAL AS STOCK_ACTUAL, COALESCE(TC.CANTIDAD_MINIMA, 0) AS CANTIDAD_MINIMA, TC.ESTADO AS ESTADO,
      COALESCE(TC.PRECIO_PRODUCTO, 0) AS PRECIO_PRODUCTO, TC.COD_PROVEEDOR AS COD_PROVEEDOR, TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR
      FROM T_TMPREQUERIMIENTO_INSUMO TI INNER JOIN T_PRODUCTO TP ON TI.COD_PRODUCTO = TP.COD_PRODUCTO 
      LEFT JOIN T_TMPCANTIDAD_MINIMA TC ON TI.COD_PRODUCTO = TC.COD_PRODUCTO
      LEFT JOIN T_TMPALMACEN_INSUMOS TA ON TA.COD_PRODUCTO=TP.COD_PRODUCTO
      LEFT JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=TC.COD_PROVEEDOR
      WHERE TI.COD_REQUERIMIENTO = '$cod_formulacion' AND TC.ESTADO='A' AND TI.ESTADO='P'
      UNION ALL
      SELECT TE.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, TE.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
      TE.CANTIDAD AS CANTIDAD, TA.STOCK_ACTUAL AS STOCK_ACTUAL, COALESCE(TC.CANTIDAD_MINIMA, 0) AS CANTIDAD_MINIMA, TC.ESTADO AS ESTADO,
      COALESCE(TC.PRECIO_PRODUCTO, 0) AS PRECIO_PRODUCTO, TC.COD_PROVEEDOR AS COD_PROVEEDOR, TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR
      FROM T_TMPREQUERIMIENTO_ENVASE TE INNER JOIN T_PRODUCTO TP ON TE.COD_PRODUCTO = TP.COD_PRODUCTO 
      LEFT JOIN T_TMPCANTIDAD_MINIMA TC ON TE.COD_PRODUCTO = TC.COD_PRODUCTO
      LEFT JOIN T_TMPALMACEN_INSUMOS TA ON TA.COD_PRODUCTO=TP.COD_PRODUCTO
      LEFT JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=TC.COD_PROVEEDOR
      WHERE TE.COD_REQUERIMIENTO = '$cod_formulacion' AND TC.ESTADO='A' AND TE.ESTADO='P' ORDER BY COD_PROVEEDOR");
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
  public function generarCodigoOrdenCompraTemp()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function InsertarOrdenCompraItem($idRequerimiento, $union, $valoresdeinsumos, $dataimagenesfile, $codigoproveedorimagenes)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $totalimagenesfile = count($_FILES['file']['name']);

      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaactual = $horaActualPeruRequerimiento->format('H:i');

      $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
      $stmCodreq->execute();
      $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
      $maxCodigoRe = $resultadoRe['COD_REQUERIMIENTO'];
      $nuevoCodigoReq = $maxCodigoRe + 1;
      $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);

      $verificarequerimiento = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRA WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $verificarequerimiento->execute();
      $resultadoverifica = $verificarequerimiento->fetch(PDO::FETCH_ASSOC);
      $reCodrequerimiento = $resultadoverifica['COUNT'];

      $contarordentemporal = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $contarordentemporal->execute();
      $resultadoconte = $contarordentemporal->fetch(PDO::FETCH_ASSOC);
      $contar = $resultadoconte['COUNT'];


      if ($contar > 0) {

        if ($reCodrequerimiento == 0) {

          foreach ($union as $valorcapturadostring) {
            $row = json_decode($valorcapturadostring, true);
            if ($row !== null) {
              $id_proveedor = $row['id_proveedor'];
              $id_producto_insumo = trim($row['id_producto_insumo']);
              $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
              $monto = floatval($row['monto']);
              $formapago = $row['formapago'];
              $fechaentrega = $row['fechaentrega'];
              $preciomin = floatval($row['preciomin']);

              $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRA WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
              $repetirproveedortemp->execute();
              $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
              $count = $resultcount['COUNT'];

              $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRA");
              $stm->execute();
              $resultado = $stm->fetch(PDO::FETCH_ASSOC);
              $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
              $nuevoCodigo = $maxCodigo + 1;
              $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

              $fechas = array();
              foreach ($union as $valorcapturastring) {
                $rows = json_decode($valorcapturastring, true);
                if ($row !== null) {
                  $proveedorcod = $rows['id_proveedor'];
                  if ($id_proveedor == $proveedorcod) {
                    $fechas[] = $rows['fechaentrega'];
                  }
                } else {
                  echo "Error al decodificar JSON: " . json_last_error_msg();
                }
              }
              if (!empty($fechas)) {
                // Encuentra la fecha de menor valor
                $fecha_menor = min($fechas);
              } else {
                echo "No se encontraron fechas válidas.";
              }

              if ($count == 0) {

                $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$idRequerimiento','$codigoAumentoReq','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fecha_menor', 23))");

                $stmActualizarOrden->execute();

                $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEM(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$codigoAumento','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");
                $stmActualizar->execute();
              } else {
                $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRA WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
                $codigoordencompra->execute();
                $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
                $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


                $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEM(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");
                $stmActualizar->execute();
              }
            } else {
              echo "Error al decodificar JSON: " . json_last_error_msg();
            }
          }
        } else {
          return;
        }

        if ($totalimagenesfile > 0) {

          foreach ($codigoproveedorimagenes as $codigoproveedorimageness) {

            $rowa = json_decode($codigoproveedorimageness, true);
            if ($rowa !== null) {
              $codigoproveedor = $rowa['codigoproveedor'];
              $eliminarporcodprovyrequerimiento = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$idRequerimiento' AND COD_PROVEEDOR='$codigoproveedor'");
              $eliminarporcodprovyrequerimiento->execute();
            } else {
              echo "Error al decodificar JSON: " . json_last_error_msg();
            }
          }

          for ($total = 0; $total < $totalimagenesfile; $total++) {
            if (isset($dataimagenesfile)) {
              // Validar que se haya seleccionado una imagen
              if (empty($_FILES['file']['name'][$total])) {
                echo json_encode(array('status' => 'error', 'message' => 'Debe seleccionar una imagen.'));
                exit;
              }

              // Obtener la información sobre el archivo
              $imagen_info = getimagesize($_FILES['file']['tmp_name'][$total]);
              $imagen_tipo = $imagen_info['mime'];

              // Verificar que el tipo de archivo sea JPEG o PNG
              if ($imagen_tipo !== 'image/jpeg' && $imagen_tipo !== 'image/png') {
                echo json_encode(array('status' => 'error', 'message' => 'Formato de imagen no válido. Solo se permiten imágenes JPEG, JPG, PNG.'));
                exit;
              }
              // Verificar el tipo de archivo y usar la función adecuada para crear el recurso de imagen
              if ($imagen_tipo === 'image/jpeg') {
                $calidad = 30;
                $imagen_comprimida = imagecreatefromjpeg($_FILES['file']['tmp_name'][$total]);
                ob_start();
                imagejpeg($imagen_comprimida, null, $calidad);
                $imagen_comprimida_binaria = ob_get_contents();
                ob_end_clean();
                $hex = bin2hex($imagen_comprimida_binaria);
                $imagen = '0x' . $hex;
                imagedestroy($imagen_comprimida);
              } elseif ($imagen_tipo === 'image/png') {
                $calidad = 5;
                $imagen_comprimida = imagecreatefrompng($_FILES['file']['tmp_name'][$total]);
                ob_start();
                imagepng($imagen_comprimida, null, $calidad);
                $imagen_comprimida_binaria = ob_get_contents();
                ob_end_clean();
                $hex = bin2hex($imagen_comprimida_binaria);
                $imagen = '0x' . $hex;
                imagedestroy($imagen_comprimida);
              }

              $decodedData = json_decode($codigoproveedorimagenes[$total], true);

              // Verifica si la decodificación fue exitosa
              if ($decodedData !== null) {
                $codigoproveedor = $decodedData['codigoproveedor'];


                $insertdataimagen = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_IMAGENESTEMP(IMAGEN,COD_PROVEEDOR,COD_REQUERIMIENTO)
                                    VALUES($imagen,'$codigoproveedor','$idRequerimiento')");
                $insertdataimagen->execute();
              } else {
                echo "Error al decodificar JSON en el índice $total\n";
                exit;
              }
            } else {
              // La variable imagen no existe
              $imagen = null;
              echo json_encode(array('status' => 'error', 'message' => 'No hay imagen seleccionada.'));
              exit;
            }
          }
        }

        $reCodrequerimiento = $this->bd->commit();
        return $reCodrequerimiento;
      } else {
        return;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function InsertarOrdenCompraItemSinImagen($union, $idRequerimiento, $codpersonal)
  {
    try {
      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $fecha_generado = $cod->c_horaserversql('F');

      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaactual = $horaActualPeruRequerimiento->format('H:i');

      $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
      $stmCodreq->execute();
      $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
      $maxCodigoRe = $resultadoRe['COD_REQUERIMIENTO'];
      $nuevoCodigoReq = $maxCodigoRe + 1;
      $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);

      $verificarequerimiento = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $verificarequerimiento->execute();
      $resultadoverifica = $verificarequerimiento->fetch(PDO::FETCH_ASSOC);
      $reCodrequerimiento = $resultadoverifica['COUNT'];
      if ($reCodrequerimiento > 0) {

        foreach ($union as $valorcapturadostring) {
          $row = json_decode($valorcapturadostring, true);
          if ($row !== null) {
            $id_proveedor = $row['id_proveedor'];
            $id_producto_insumo = trim($row['id_producto_insumo']);
            $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
            $monto = floatval($row['monto']);
            $formapago = $row['formapago'];
            $fechaentrega = $row['fechaentrega'];
            $preciomin = floatval($row['preciomin']);

            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRA WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $countx = $resultcount['COUNT'];

            $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRA");
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);
            $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
            $nuevoCodigo = $maxCodigo + 1;
            $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($union as $valorcapturastring) {
              $rows = json_decode($valorcapturastring, true);
              if ($row !== null) {
                $codigoprovedor = $rows['id_proveedor'];
                if ($id_proveedor == $codigoprovedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }

            if ($countx == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$idRequerimiento','$codigoAumentoReq','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fecha_menor', 23))");

              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEM(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$codigoAumento','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");
              $stmActualizar->execute();
            } else {

              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRA WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEM(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");

              $stmActualizar->execute();
            }
          } else {
            echo "Error al decodificar JSON: " . json_last_error_msg();
          }
        }
      } else {
        return;
      }

      $reCodrequerimiento = $this->bd->commit();
      return $reCodrequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function verificarsihayordencompra($idRequerimiento)
  {
    try {

      $verificarequerimiento = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRA WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $verificarequerimiento->execute();
      $resultadoverifica = $verificarequerimiento->fetch(PDO::FETCH_ASSOC);
      $reCodrequerimiento = $resultadoverifica['COUNT'];

      return $reCodrequerimiento;
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

  public function InsertarOrdenCompraTempCabecera($idRequerimiento, $valorcapturado)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $fecha_generado = $cod->c_horaserversql('F');

      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaactual = $horaActualPeruRequerimiento->format('H:i:s');

      foreach ($valorcapturado as $row) {

        $id_proveedor = $row['id_proveedor'];
        $id_producto_insumo = trim($row['id_producto_insumo']);
        $cantidad_producto_insumo = $row['cantidad_producto_insumo'];
        $monto = $row['monto'];
        $formapago = $row['formapago'];
        $fechaentrega = $row['fechaentrega'];

        $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
        // var_dump($repetirproveedortemp);
        $repetirproveedortemp->execute();
        $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
        $count = $resultcount['COUNT'];

        $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
        $stm->execute();
        $resultado = $stm->fetch(PDO::FETCH_ASSOC);
        $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
        $nuevoCodigo = $maxCodigo + 1;
        $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

        // var_dump($count);
        // if ($count == 0) {

        $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,HORA,COD_PROVEEDOR,F_PAGO)
                                                     VALUES('$codigoAumento','$idRequerimiento','$horaactual','$id_proveedor','$formapago')");
        $insertar = $stmActualizarOrden->execute();

        // }
        // else {
        // //   var_dump("else");
        //   $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
        //   $codigoordencompra->execute();
        //   $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
        //   $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


        //   $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO)
        //                                              VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto')");

        //   $stmActualizar->execute();
        // }
      }


      $insertar = $this->bd->commit();
      return $insertar;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function c_insertar_orden_compra_temp_imagen($idRequerimiento, $valorcapturado, $valoresdeinsumos, $dataimagenesfile, $codigoproveedorimagenes)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $totalimagenesfile = count($_FILES['file']['name']);


      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaactual = $horaActualPeruRequerimiento->format('H:i');

      $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
      $stmCodreq->execute();
      $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
      $maxCodigoRe = $resultadoRe['COD_REQUERIMIENTO'];
      $nuevoCodigoReq = $maxCodigoRe + 1;
      $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);

      $verificarequerimiento = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $verificarequerimiento->execute();
      $resultadoverifica = $verificarequerimiento->fetch(PDO::FETCH_ASSOC);
      $reCodrequerimiento = $resultadoverifica['COUNT'];
      if ($reCodrequerimiento == 0) {

        foreach ($valorcapturado as $valorcapturadostring) {
          $row = json_decode($valorcapturadostring, true);
          if ($row !== null) {
            $id_proveedor = $row['id_proveedor'];
            $id_producto_insumo = trim($row['id_producto_insumo']);
            $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
            $monto = floatval($row['monto']);
            $formapago = $row['formapago'];
            $fechaentrega = $row['fechaentrega'];
            $preciomin = floatval($row['preciomin']);

            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $count = $resultcount['COUNT'];

            $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);
            $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
            $nuevoCodigo = $maxCodigo + 1;
            $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($valorcapturado as $valorcapturastring) {
              $rows = json_decode($valorcapturastring, true);
              if ($row !== null) {
                $proveedor = $rows['id_proveedor'];
                if ($id_proveedor == $proveedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }

            if ($count == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$idRequerimiento','$codigoAumentoReq','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fecha_menor', 23))");
              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$codigoAumento','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");
              $stmActualizar->execute();
            } else {

              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");
              $stmActualizar->execute();
            }
          } else {
            echo "Error al decodificar JSON: " . json_last_error_msg();
          }
        }
      } else {

        // $eliminartempx = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
        // $eliminartempx->execute();
        $eliminartempitem = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_ITEMTEMP WHERE COD_TMPCOMPROBANTE='$idRequerimiento'");
        $eliminartempitem->execute();

        $eliminartemp = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRATEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
        $eliminartemp->execute();

        foreach ($valorcapturado as $stringinsumocaptura) {
          $insumo = json_decode($stringinsumocaptura, true);
          if ($insumo !== null) {
            $proveedor = $insumo['id_proveedor'];
            $idproducto = trim($insumo['id_producto_insumo']);
            $cantidadproducto = floatval($insumo['cantidad_producto_insumo']);
            $montotemp = floatval($insumo['monto']);
            $formapagotemp = $insumo['formapago'];
            $fechaentregatemp = $insumo['fechaentrega'];
            $preciomintemp = floatval($insumo['preciomin']);

            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $count = $resultcount['COUNT'];

            $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);
            $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
            $nuevoCodigo = $maxCodigo + 1;
            $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($valorcapturado as $valorcapturastring) {
              $rows = json_decode($valorcapturastring, true);
              if ($insumo !== null) {
                $codigodeproveedor = $rows['id_proveedor'];
                if ($proveedor == $codigodeproveedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }

            if ($count == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$idRequerimiento','$codigoAumentoReq','$horaactual','$proveedor','$formapagotemp',CONVERT(DATE, '$fecha_menor', 23))");

              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$codigoAumento','$idproducto','$cantidadproducto','$montotemp','$idRequerimiento','$preciomintemp',CONVERT(DATE, '$fechaentregatemp', 23))");
              $stmActualizar->execute();
            } else {

              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$proveedorcodigoorden','$idproducto','$cantidadproducto','$montotemp','$idRequerimiento','$preciomintemp',CONVERT(DATE, '$fechaentregatemp', 23))");

              $stmActualizar->execute();
            }
          } else {
            echo "Error al decodificar JSON: " . json_last_error_msg();
          }
        }
      }
      if ($totalimagenesfile > 0) {

        foreach ($codigoproveedorimagenes as $codigoproveedorimageness) {

          $row = json_decode($codigoproveedorimageness, true);
          if ($row !== null) {
            $codigoproveedor = $row['codigoproveedor'];
            $eliminarporcodprovyrequerimiento = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$idRequerimiento' AND COD_PROVEEDOR='$codigoproveedor'");
            $eliminarporcodprovyrequerimiento->execute();
          } else {
            echo "Error al decodificar JSON: " . json_last_error_msg();
          }
        }
        for ($total = 0; $total < $totalimagenesfile; $total++) {
          if (isset($dataimagenesfile)) {
            // Validar que se haya seleccionado una imagen
            if (empty($_FILES['file']['name'][$total])) {
              echo json_encode(array('status' => 'error', 'message' => 'Debe seleccionar una imagen.'));
              exit;
            }

            // Obtener la información sobre el archivo
            $imagen_info = getimagesize($_FILES['file']['tmp_name'][$total]);
            $imagen_tipo = $imagen_info['mime'];

            // Verificar que el tipo de archivo sea JPEG o PNG
            if ($imagen_tipo !== 'image/jpeg' && $imagen_tipo !== 'image/png') {
              echo json_encode(array('status' => 'error', 'message' => 'Formato de imagen no válido. Solo se permiten imágenes JPEG, JPG, PNG.'));
              exit;
            }
            // Verificar el tipo de archivo y usar la función adecuada para crear el recurso de imagen
            if ($imagen_tipo === 'image/jpeg') {
              $calidad = 30;
              $imagen_comprimida = imagecreatefromjpeg($_FILES['file']['tmp_name'][$total]);
              ob_start();
              imagejpeg($imagen_comprimida, null, $calidad);
              $imagen_comprimida_binaria = ob_get_contents();
              ob_end_clean();
              $hex = bin2hex($imagen_comprimida_binaria);
              $imagen = '0x' . $hex;
              imagedestroy($imagen_comprimida);
            } elseif ($imagen_tipo === 'image/png') {
              $calidad = 5;
              $imagen_comprimida = imagecreatefrompng($_FILES['file']['tmp_name'][$total]);
              ob_start();
              imagepng($imagen_comprimida, null, $calidad);
              $imagen_comprimida_binaria = ob_get_contents();
              ob_end_clean();
              $hex = bin2hex($imagen_comprimida_binaria);
              $imagen = '0x' . $hex;
              imagedestroy($imagen_comprimida);
            }

            $decodedData = json_decode($codigoproveedorimagenes[$total], true);

            // Verifica si la decodificación fue exitosa
            if ($decodedData !== null) {
              $codigoproveedor = $decodedData['codigoproveedor'];

              $insertdataimagen = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_IMAGENESTEMP(IMAGEN,COD_REQUERIMIENTO,COD_PROVEEDOR)
                                                        VALUES($imagen,'$idRequerimiento','$codigoproveedor')");

              $insertdataimagen->execute();
            } else {
              echo "Error al decodificar JSON en el índice $total\n";
              exit;
            }
          } else {
            // La variable imagen no existe
            $imagen = null;
            echo json_encode(array('status' => 'error', 'message' => 'No hay imagen seleccionada.'));
            exit;
          }
        }
      }

      $reCodrequerimiento = $this->bd->commit();
      return $reCodrequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function InsertarOrdenCompraTemp($idRequerimiento, $valorcapturado)
  {
    try {
      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $fecha_generado = $cod->c_horaserversql('F');

      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaactual = $horaActualPeruRequerimiento->format('H:i');

      $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
      $stmCodreq->execute();
      $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
      $maxCodigoRe = $resultadoRe['COD_REQUERIMIENTO'];
      $nuevoCodigoReq = $maxCodigoRe + 1;
      $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);

      $verificarequerimiento = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
      $verificarequerimiento->execute();
      $resultadoverifica = $verificarequerimiento->fetch(PDO::FETCH_ASSOC);
      $reCodrequerimiento = $resultadoverifica['COUNT'];
      if ($reCodrequerimiento == 0) {

        foreach ($valorcapturado as $valorcapturadostring) {
          $row = json_decode($valorcapturadostring, true);
          if ($row !== null) {
            $id_proveedor = $row['id_proveedor'];
            $id_producto_insumo = trim($row['id_producto_insumo']);
            $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
            $monto = floatval($row['monto']);
            $formapago = $row['formapago'];
            $fechaentrega = $row['fechaentrega'];
            $preciomin = floatval($row['preciomin']);


            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $count = $resultcount['COUNT'];

            $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);
            $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
            $nuevoCodigo = $maxCodigo + 1;
            $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($valorcapturado as $valorcapturastring) {
              $rows = json_decode($valorcapturastring, true);
              if ($row !== null) {
                $provedor = $rows['id_proveedor'];
                if ($id_proveedor == $provedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }



            if ($count == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$idRequerimiento','$codigoAumentoReq','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fecha_menor', 23))");

              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$codigoAumento','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");
              $stmActualizar->execute();
            } else {

              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$idRequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23))");

              $stmActualizar->execute();
            }
          } else {
            echo "Error al decodificar JSON: " . json_last_error_msg();
          }
        }
      } else {
        // $eliminartempimagenes = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
        // $eliminartempimagenes->execute();

        $eliminartempitem = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_ITEMTEMP WHERE COD_TMPCOMPROBANTE='$idRequerimiento'");
        $eliminartempitem->execute();

        $eliminartemp = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRATEMP WHERE COD_REQUERIMIENTO='$idRequerimiento'");
        $eliminartemp->execute();


        foreach ($valorcapturado as $stringinsumocaptura) {
          $insumo = json_decode($stringinsumocaptura, true);
          if ($insumo !== null) {
            $proveedor = $insumo['id_proveedor'];
            $idproducto = trim($insumo['id_producto_insumo']);
            $cantidadproducto = floatval($insumo['cantidad_producto_insumo']);
            $montotemp = floatval($insumo['monto']);
            $formapagotemp = $insumo['formapago'];
            $fechaentregatemp = $insumo['fechaentrega'];
            $preciomintemp = floatval($insumo['preciomin']);

            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $count = $resultcount['COUNT'];

            $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);
            $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
            $nuevoCodigo = $maxCodigo + 1;
            $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($valorcapturado as $valorcapturastring) {
              $rows = json_decode($valorcapturastring, true);
              if ($insumo !== null) {
                $cod_provedor = $rows['id_proveedor'];
                if ($proveedor == $cod_provedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }

            if ($count == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$idRequerimiento','$codigoAumentoReq','$horaactual','$proveedor','$formapagotemp',CONVERT(DATE, '$fecha_menor', 23))");

              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$codigoAumento','$idproducto','$cantidadproducto','$montotemp','$idRequerimiento','$preciomintemp',CONVERT(DATE, '$fechaentregatemp', 23))");
              $stmActualizar->execute();
            } else {

              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$proveedor' AND COD_REQUERIMIENTO='$idRequerimiento'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA)
                                                       VALUES('$proveedorcodigoorden','$idproducto','$cantidadproducto','$montotemp','$idRequerimiento','$preciomintemp',CONVERT(DATE, '$fechaentregatemp', 23))");

              $stmActualizar->execute();
            }
          } else {
            echo "Error al decodificar JSON: " . json_last_error_msg();
          }
        }
      }

      $reCodrequerimiento = $this->bd->commit();
      return $reCodrequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function InsertarOrdenCompraItemAdicionada($valorcapturado)
  {
    try {
      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $fecha_generado = $cod->c_horaserversql('F');

      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $horaactual = $horaActualPeruRequerimiento->format('H:i');




      foreach ($valorcapturado as $valorcapturadostring) {
        $row = json_decode($valorcapturadostring, true);
        if ($row !== null) {
          $codigorequerimiento = $row['codigorequerimiento'];
          $id_proveedor = $row['id_proveedor'];
          $id_producto_insumo = trim($row['id_producto_insumo']);
          $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
          $monto = floatval($row['monto']);
          $formapago = $row['formapago'];
          $fechaentrega = $row['fechaentrega'];
          $preciomin = floatval($row['preciomin']);

          $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$codigorequerimiento' AND ESTADO='F'");
          $repetirproveedortemp->execute();
          $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
          $count = $resultcount['COUNT'];

          $stm = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
          $stm->execute();
          $resultado = $stm->fetch(PDO::FETCH_ASSOC);
          $maxCodigo = intval($resultado['COD_ORDEN_COMPRA']);
          $nuevoCodigo = $maxCodigo + 1;
          $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);

          if ($count == 0) {

            $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA)
                                                       VALUES('$codigoAumento','$codigorequerimiento','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fechaentrega', 23))");

            $stmActualizarOrden->execute();

            $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO)
                                                       VALUES('$codigoAumento','$id_producto_insumo','$cantidad_producto_insumo','$monto','$codigorequerimiento','$preciomin')");
            $stmActualizar->execute();
          } else {

            $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$codigorequerimiento'");
            $codigoordencompra->execute();
            $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
            $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


            $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$codigorequerimiento','$preciomin')");

            $stmActualizar->execute();
          }
        } else {
          echo "Error al decodificar JSON: " . json_last_error_msg();
        }
      }


      $reCodrequerimiento = $this->bd->commit();
      return $reCodrequerimiento;
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
      TP.ABR_PRODUCTO AS ABR_PRODUCTO, TCM.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,TCM.ESTADO AS ESTADO FROM T_TMPCANTIDAD_MINIMA TCM 
      INNER JOIN T_PRODUCTO TP ON TCM.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TP.DES_PRODUCTO  LIKE '$buscarcantidadminimasearch%'");

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
                                          INNER JOIN T_PRODUCTO TP ON TRI.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TRI.ESTADO='P'");

      $stmCalculo->execute();
      $datos = $stmCalculo->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function ValorFormula($cantidadinsumo)
  {
    try {
      $this->bd->beginTransaction();
      $resultadofinal = ($cantidadinsumo * 100 / 60);
      $resultadofinal = $this->bd->commit();
      return $resultadofinal;
      return $resultadofinal;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }


  public function ConsultaValorCantidadRequerimiento($codrequerimientoproduccion, $codproductoproduccion)
  {
    try {
      $cantidadenvase = $this->bd->prepare("SELECT MAX(TOTAL_PRODUCTO) AS TOTAL_PRODUCTO FROM T_TMPREQUERIMIENTO_ITEM WHERE COD_PRODUCTO='$codproductoproduccion' AND COD_REQUERIMIENTO='$codrequerimientoproduccion'");
      $cantidadenvase->execute();
      $consultacantidad = $cantidadenvase->fetch(PDO::FETCH_ASSOC);
      $resultadofinal = $consultacantidad['TOTAL_PRODUCTO'];
      return $resultadofinal;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }
  public function InsertarProduccionTotalRequerimiento($codpersonal, $codrequerimientoproduccion, $codproductoproduccion, $numeroproduccion, $cantidadtotalproduccion, $fechainicio, $fechavencimiento,  $textAreaObservacion, $cantidadcaja)
  {
    try {
      $this->bd->beginTransaction();

      $produccion = new m_almacen();

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

      $stmprodbarras = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE FROM T_TMPPRODUCCION_BARRAS WHERE COD_PRODUCTO='$codproductoproduccion'");
      $stmprodbarras->execute();
      $consultaprodbarras = $stmprodbarras->fetch(PDO::FETCH_ASSOC);
      // $resultadoProdBarras = $consultaprodbarras['BARRA_INICIO'];
      $resultadoProdBarras = $consultaprodbarras['NUM_LOTE'];

      $valor_total = $produccion->ConsultaValorCantidadRequerimiento($codrequerimientoproduccion, $codproductoproduccion);
      if ($resultadoProdBarras == null) {
        $stmBarraI = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE FROM T_PRODUCCION_BARRAS_ITEM WHERE COD_PRODUCTO='$codproductoproduccion'");
        $stmBarraI->execute();
        $consultaBarraI = $stmBarraI->fetch(PDO::FETCH_ASSOC);
        $resultadoBarraI = $consultaBarraI['NUM_LOTE'];
        $BarraExtracI = intval(substr($resultadoBarraI, 3));
        $barraSumaI = ($BarraExtracI + 1);
        $barraI = str_pad($barraSumaI, 6, '0', STR_PAD_LEFT);

        // $barraF = $barraSumaI + ($cantidadtotalproduccion - 1);
        $barraF = $barraSumaI + ($valor_total - 1);
        $resultadoF = str_pad($barraF, 6, '0', STR_PAD_LEFT);

        $resultadoFinalI = trim($resultadoabrevia . $barraI);
        $resultadoFinalFin = trim($resultadoabrevia . ($resultadoF));
      } else {
        $stmprodbarrasfn = $this->bd->prepare("SELECT MAX(BARRA_FIN) AS BARRA_FIN FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codproductoproduccion'");
        $stmprodbarrasfn->execute();
        $consultaprodbarrasfn = $stmprodbarrasfn->fetch(PDO::FETCH_ASSOC);
        $resultadoProdBarrasfn = $consultaprodbarrasfn['BARRA_FIN'];
        $BarraExtracfn = intval(substr($resultadoProdBarrasfn, 3));
        $barraSumafn = ($BarraExtracfn + 1);
        $barraI = str_pad($barraSumafn, 6, '0', STR_PAD_LEFT);

        // $barraFin = $barraSumafn + ($cantidadtotalproduccion - 1);
        $barraFin = $barraSumafn + ($valor_total - 1);
        $resultadoFin = str_pad($barraFin, 6, '0', STR_PAD_LEFT);

        $resultadoFinalI = trim($resultadoabrevia . $barraI);
        $resultadoFinalFin = trim($resultadoabrevia . ($resultadoFin));
      }

      $ordencompraexiste = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_TMPREQUERIMIENTO_ITEM WHERE ESTADO='C'");
      $ordencompraexiste->execute();
      $valororden = $ordencompraexiste->fetch(PDO::FETCH_ASSOC);
      $contarordencompra = $valororden['COUNT'];

      $maquina = os_info();

      if ($contarordencompra == 0) {
        $stmProducciontototal = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION(COD_PRODUCCION, COD_REQUERIMIENTO, COD_CATEGORIA, COD_PRODUCTO, NUM_PRODUCION_LOTE, CAN_PRODUCCION,CANTIDAD_PRODUCIDA, FEC_GENERADO,HOR_GENERADO,FEC_VENCIMIENTO, OBSERVACION,UNI_MEDIDA,BARRA_INICIO,BARRA_FIN, USU_REGISTRO,MAQUINA, COD_ALMACEN,CAN_CAJA)
        VALUES ('$codigo_de_produccion_generado','$codrequerimientoproduccion', '$codigo_categoria','$codproductoproduccion','$numeroproduccion','$cantidadtotalproduccion','$cantidadtotalproduccion',CONVERT(DATETIME, '$fechainicio', 120),'$horaMinutosSegundos',CONVERT(DATETIME, '$fechavencimiento', 120),'$textAreaObservacion','UNIDAD','$resultadoFinalI','$resultadoFinalFin','$codpersonal','$maquina','00017','$cantidadcaja')");

        $insert = $stmProducciontototal->execute();


        foreach ($consulta as $row) {

          $codProductoitem = $row->COD_PRODUCTO;
          $cantidadInsumos = $row->CAN_FORMULACION;
          $cantidadformulacion = $row->CANTIDAD_FORMULACION;
          $totalInsumos =  round((($cantidadInsumos * $cantidadtotalproduccion) / $cantidadformulacion), 3);

          $stmProduccionitem = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_ITEM(COD_PRODUCCION, COD_PRODUCTO,  CAN_PRODUCCION)
                                                    VALUES ('$codigo_de_produccion_generado','$codProductoitem','$totalInsumos')");
          $stmProduccionitem->execute();

          $consultadestock = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOSTEMP WHERE COD_PRODUCTO='$codProductoitem'");
          $consultadestock->execute();
          $valorstock = $consultadestock->fetch(PDO::FETCH_ASSOC);
          $valstock = floatval($valorstock['STOCK_ACTUAL']);

          $valorstock = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOSTEMP WHERE COD_PRODUCTO='$codProductoitem'");
          $valorstock->execute();
          $cantidadstock = $valorstock->fetch(PDO::FETCH_ASSOC);
          $valstockcan = floatval($cantidadstock['STOCK_ACTUAL']);

          $valorresta = $valstock - $totalInsumos;
          $valororiginal = $valstockcan - $totalInsumos;

          $actualizaalmacentemp = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOSTEMP SET STOCK_ACTUAL='$valorresta',STOCK_ANTERIOR='$valstock' WHERE COD_PRODUCTO='$codProductoitem'");
          $actualizaalmacentemp->execute();
          // $actualizaalmacentemp = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET STOCK_ACTUAL='$valororiginal',STOCK_ANTERIOR='$valstockcan' WHERE COD_PRODUCTO='$codProductoitem'");
          // $actualizaalmacentemp->execute();
        }

        foreach ($consultaEnvase as $rowEnvase) {

          $codProductoenvase = $rowEnvase->COD_PRODUCTO;
          $cantidadEnvases = $rowEnvase->CANTIDA;
          $cantidadformulacion = $row->CANTIDAD_FORMULACION;
          $totalEnvases =  ceil(($cantidadEnvases * $cantidadtotalproduccion) / $cantidadformulacion);

          $stmProduccionenvases = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_ENVASE(COD_PRODUCCION, COD_PRODUCTO,  CAN_PRODUCCION_ENVASE)
                                                    VALUES ('$codigo_de_produccion_generado','$codProductoenvase','$totalEnvases')");
          $stmProduccionenvases->execute();

          // $consultadestockenvase = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOSTEMP WHERE COD_PRODUCTO='$codProductoitem'");
          // $consultadestockenvase->execute();
          // $valorstockenvase = $consultadestockenvase->fetch(PDO::FETCH_ASSOC);
          // $valstockenvase = floatval($valorstockenvase['STOCK_ACTUAL']);

          // $valorrestaenvase = $valstockenvase - $totalEnvases;

          // $actualizaalmacentemp = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOSTEMP SET STOCK_ACTUAL='$valorrestaenvase',STOCK_ANTERIOR='$valstockenvase' WHERE COD_PRODUCTO='$codProductoitem'");
          // $actualizaalmacentemp->execute();
        }

        $stmActualiza = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='T' WHERE COD_REQUERIMIENTO='$codrequerimientoproduccion' AND COD_PRODUCTO='$codproductoproduccion'");
        $stmActualiza->execute();



        $insert = $this->bd->commit();
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function RechazarPendienteRequerimiento($cod_requerimiento_pedido, $codpersonal)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $fecha_actual = $cod->c_horaserversql('F');

      $zonaHorariaPeru = new DateTimeZone('America/Lima');
      $horaActualPeru = new DateTime('now', $zonaHorariaPeru);
      $horaMinutosSegundos = $horaActualPeru->format('H:i:s');


      $stm = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO SET ESTADO='R',COD_CONFIRMACION='$codpersonal',FECHA=CONVERT(DATE, GETDATE()),HORA='$horaMinutosSegundos' WHERE COD_REQUERIMIENTO = '$cod_requerimiento_pedido'");
      $actualizarRequerimiento = $stm->execute();

      $stmActualizar = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='R' WHERE COD_REQUERIMIENTO = '$cod_requerimiento_pedido'");
      $stmActualizar->execute();


      $stmActualizarinsumo = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_INSUMO SET ESTADO='R' WHERE COD_REQUERIMIENTO = '$cod_requerimiento_pedido'");
      $stmActualizarinsumo->execute();

      $stmActualizarenvase = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ENVASE SET ESTADO='R' WHERE COD_REQUERIMIENTO = '$cod_requerimiento_pedido'");
      $stmActualizarenvase->execute();


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
                                  TP.PESO_NETO AS PESO_NETO, TRI.ESTADO AS ESTADO FROM T_TMPREQUERIMIENTO_ITEM TRI INNER JOIN T_PRODUCTO TP ON TRI.COD_PRODUCTO=TP.COD_PRODUCTO WHERE TRI.ESTADO='T'");
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
  public function  MostrarPersonal()
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PERSONAL,NOM_PERSONAL FROM T_PERSONAL");
      $stm->execute();
      $datos = $stm->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function MostrarAlmaceninsumos($codigoproducto)
  {
    try {

      $stm = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$codigoproducto'");
      $stm->execute();
      $consulta = $stm->fetch(PDO::FETCH_ASSOC);
      // $resultadoformula = $consulta['STOCK_ACTUAL'];
      return $consulta;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function CodigoFormulacionVerificacion($codigoproducto)
  {
    try {
      $stmCodigoFormula = $this->bd->prepare("SELECT MAX(COD_FORMULACION) AS COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoproducto'");
      $stmCodigoFormula->execute();
      $consultacodigoformula = $stmCodigoFormula->fetch(PDO::FETCH_ASSOC);
      $resultadoformula = $consultacodigoformula['COD_FORMULACION'];


      return $resultadoformula;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function ValorProduccionCantidad($codigoproducto, $codigoproduccion)
  {
    try {
      $stmverificardatos = $this->bd->prepare("SELECT MAX(CANTIDAD_PRODUCIDA) AS CANTIDAD_PRODUCIDA FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
      $stmverificardatos->execute();
      $consultacodigoformulacion = $stmverificardatos->fetch(PDO::FETCH_ASSOC);

      return $consultacodigoformulacion;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function ValoresEnvases($codigoproducto)
  {
    try {
      $mostrar = new m_almacen();
      $codigoformulacion = $mostrar->CodigoFormulacionVerificacion($codigoproducto);

      $stmformulacionenvase = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION, TFE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, 
      TFE.CANTIDA AS CANTIDA, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ENVASE TFE 
      INNER JOIN T_PRODUCTO TP ON TFE.COD_PRODUCTO=TP.COD_PRODUCTO
      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFE.COD_FORMULACION
      WHERE TFE.COD_FORMULACION='$codigoformulacion'");

      $stmformulacionenvase->execute();
      $resultadoCantidad = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);

      return $resultadoCantidad;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }

  public function ValoresInsumos($codigoproducto)
  {
    try {
      $mostrar = new m_almacen();
      $resultadoformula = $mostrar->CodigoFormulacionVerificacion($codigoproducto);
      $stmformulacionenvase = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION, TFE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, 
                                                      TFE.CAN_FORMULACION AS CAN_FORMULACION, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ITEM TFE 
                                                      INNER JOIN T_PRODUCTO TP ON TFE.COD_PRODUCTO=TP.COD_PRODUCTO
                                                      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFE.COD_FORMULACION
                                                      WHERE TFE.COD_FORMULACION='$resultadoformula'");
      $stmformulacionenvase->execute();

      $resultadoCantidad = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);

      return $resultadoCantidad;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }
  public function  MostrarEnvasesPorProduccion($codigoproducto, $codigoproduccion, $cantidadenvase, $cantidadinsumo)
  {
    try {
      $this->bd->beginTransaction();
      $mostrar = new m_almacen();
      $codigoformulacion = $mostrar->CodigoFormulacionVerificacion($codigoproducto);


      $cantidadproduccion = $mostrar->ValorProduccionCantidad($codigoproducto, $codigoproduccion);

      if ($cantidadinsumo <= $cantidadproduccion) {

        $stmformulacionenvase = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION, TFE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, 
                                                      TFE.CANTIDA AS CANTIDA, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ENVASE TFE 
                                                      INNER JOIN T_PRODUCTO TP ON TFE.COD_PRODUCTO=TP.COD_PRODUCTO
                                                      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFE.COD_FORMULACION
                                                      WHERE TFE.COD_FORMULACION='$codigoformulacion'");

        $stmformulacionenvase->execute();
        $respuesta['respuestae'] = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);

        $respuesta['tipoe'] = 0;
      } else {

        $valorderequerimiento = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) AS COD_REQUERIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
        $valorderequerimiento->execute();
        $resultadoreuqerimiento = $valorderequerimiento->fetch(PDO::FETCH_ASSOC);
        $valorrequerimientoprod = $resultadoreuqerimiento['COD_REQUERIMIENTO'];

        $consultarcantidadkg = $this->bd->prepare("SELECT MAX(TOTAL_PRODUCTO) AS TOTAL_PRODUCTO FROM T_TMPREQUERIMIENTO_ITEM WHERE COD_PRODUCTO='$codigoproducto' AND COD_REQUERIMIENTO='$valorrequerimientoprod '");
        $consultarcantidadkg->execute();
        $resultadokg = $consultarcantidadkg->fetch(PDO::FETCH_ASSOC);
        $valorkg = $resultadokg['TOTAL_PRODUCTO'];


        $stmformulacionenvase = $this->bd->prepare("SELECT TPRO.COD_PRODUCCION AS COD_PRODUCCION, TPRO.CANTIDAD_PRODUCIDA AS CANTIDAD_PRODUCIDA,'$valorkg' AS VALOR_KG ,TP.DES_PRODUCTO AS DES_PRODUCTO FROM T_TMPPRODUCCION TPRO 
        INNER JOIN T_PRODUCTO TP ON TPRO.COD_PRODUCTO=TP.COD_PRODUCTO
        WHERE TPRO.COD_PRODUCCION='$codigoproduccion' AND TPRO.COD_PRODUCTO='$codigoproducto'");
        $stmformulacionenvase->execute();
        $respuesta['respuestae'] = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);
        $respuesta['tipoe'] = 1;
      }

      $this->bd->commit();

      return $respuesta;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarInsumosTotalesAvance($codigoproducto, $codigoproduccion, $cantidadinsumo)
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


      if ($cantidadinsumo <= $resultadoCantidadFormulacion) {

        $stmformulacionenvase = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION, TFE.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, 
                                                      TFE.CAN_FORMULACION AS CAN_FORMULACION, TF.CAN_FORMULACION AS CANTIDAD_FORMULACION FROM T_TMPFORMULACION_ITEM TFE 
                                                      INNER JOIN T_PRODUCTO TP ON TFE.COD_PRODUCTO=TP.COD_PRODUCTO
                                                      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFE.COD_FORMULACION
                                                      WHERE TFE.COD_FORMULACION='$resultadoformula'");
        $stmformulacionenvase->execute();

        $respuesta['respuesta'] = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);
        $respuesta['tipo'] = 0;
      } else {
        $valorderequerimiento = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) AS COD_REQUERIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
        $valorderequerimiento->execute();
        $resultadoreuqerimiento = $valorderequerimiento->fetch(PDO::FETCH_ASSOC);
        $valorrequerimientoprod = $resultadoreuqerimiento['COD_REQUERIMIENTO'];

        $consultarcantidadkg = $this->bd->prepare("SELECT MAX(TOTAL_PRODUCTO) AS TOTAL_PRODUCTO FROM T_TMPREQUERIMIENTO_ITEM WHERE COD_PRODUCTO='$codigoproducto' AND COD_REQUERIMIENTO='$valorrequerimientoprod '");
        $consultarcantidadkg->execute();
        $resultadokg = $consultarcantidadkg->fetch(PDO::FETCH_ASSOC);
        $valorkg = $resultadokg['TOTAL_PRODUCTO'];


        $stmformulacionenvase = $this->bd->prepare("SELECT TPRO.COD_PRODUCCION AS COD_PRODUCCION, TPRO.CANTIDAD_PRODUCIDA AS CANTIDAD_PRODUCIDA,'$valorkg' AS VALOR_KG ,TP.DES_PRODUCTO AS DES_PRODUCTO FROM T_TMPPRODUCCION TPRO 
        INNER JOIN T_PRODUCTO TP ON TPRO.COD_PRODUCTO=TP.COD_PRODUCTO
        WHERE TPRO.COD_PRODUCCION='$codigoproduccion' AND TPRO.COD_PRODUCTO='$codigoproducto'");
        $stmformulacionenvase->execute();
        $respuesta['respuesta'] = $stmformulacionenvase->fetchAll(PDO::FETCH_OBJ);
        $respuesta['tipo'] = 1;
      }

      $this->bd->commit();

      return $respuesta;
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
  public function NumeroBachadaGenerado($codigoproducto, $codigoproduccion)
  {
    try {
      $malamacen = new m_almacen();
      $fechadehoy = $malamacen->c_horaserversql('F');

      $stmfecha = $this->bd->prepare("SELECT MAX(CONVERT(VARCHAR, FECHA, 103)) AS FECHA FROM T_TMPAVANCE_INSUMOS_PRODUCTOS 
                                       WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
      $stmfecha->execute();
      $resultadofecha = $stmfecha->fetch(PDO::FETCH_ASSOC);
      $fechaobtenida = $resultadofecha['FECHA'];


      if ($fechadehoy == $fechaobtenida) {
        $stm = $this->bd->prepare("SELECT MAX(N_BACHADA) as N_BACHADA FROM T_TMPAVANCE_INSUMOS_PRODUCTOS 
        WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
        $stm->execute();
        $resultado = $stm->fetch(PDO::FETCH_ASSOC);
        $maxCodigo = intval($resultado['N_BACHADA']);
        $nuevoCodigo = $maxCodigo + 1;
      } else {

        $maxCodigo = 0;
        $nuevoCodigo = $maxCodigo + 1;
      }

      return $nuevoCodigo;
    } catch (Exception $e) {
      die($e->getMessage());
    }
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
  public function  InsertarValorInsumoRegistro($valoresCapturadosProduccion, $valoresCapturadosProduccioninsumo, $codigoproducto, $codigoproduccion, $cantidad, $cantidadtotalenvases,  $codpersonal, $codoperario)
  {
    try {

      $this->bd->beginTransaction();

      $codigoInsumosAvances = new m_almacen();
      $codigo_de_avance_insumo = $codigoInsumosAvances->CodigoAvanceInsumo();
      $numero_generado_bachada = $codigoInsumosAvances->NumeroBachadaGenerado($codigoproducto, $codigoproduccion);


      $nombre = 'LBS-OP-FR-01';

      $codigoInsumosAvances->generarVersionGeneral($nombre);


      $stmCantidad = $this->bd->prepare("SELECT CANTIDAD_PRODUCIDA FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
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

      $stmabrproducto = $this->bd->prepare("SELECT DES_PRODUCTO,ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoproducto'");
      $stmabrproducto->execute();
      $valorProd = $stmabrproducto->fetch(PDO::FETCH_ASSOC);
      $abrprod = trim($valorProd['ABR_PRODUCTO']);

      $updatetotal = $insert  - $cantidad;

      $maquina = os_info();

      if ($insert  > 0) {

        $cantidadrestar = $cantidadtotalenvases;
        $calculofecha = $this->bd->prepare("SELECT FEC_GENERADO,FEC_VENCIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
        $calculofecha->execute();
        $fechaconsulta = $calculofecha->fetch(PDO::FETCH_ASSOC);
        $fechainicio = $fechaconsulta['FEC_GENERADO'];
        $fechafinal = $fechaconsulta['FEC_VENCIMIENTO'];

        // $fechaInicioObj = new DateTime($fechainicio);
        // $fechaFinalObj = new DateTime($fechafinal);

        // $diferencia = $fechaInicioObj->diff($fechaFinalObj);
        // $dias = $diferencia->days;

        $fecha_actual = $codigoInsumosAvances->c_horaserversql('F');

        // $fecha_formateada = DateTime::createFromFormat('d/m/Y', $fecha_actual)->format('Y-m-d');
        // $nueva_fecha_vencimiento = date('d/m/Y', strtotime($fecha_formateada . ' + ' . $dias . ' days'));


        $stmActualizaproduccion = $this->bd->prepare("UPDATE T_TMPPRODUCCION SET CANTIDAD_PRODUCIDA='$updatetotal',ESTADO='A' WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
        $stmActualizaproduccion->execute();

        $stmInsertarInsumoAvance = $this->bd->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS(COD_AVANCE_INSUMOS,N_BACHADA,COD_PRODUCTO,COD_PRODUCCION,CANTIDAD,FEC_VENCIMIENTO,COD_OPERARIO)
          VALUES ('$codigo_de_avance_insumo','$numero_generado_bachada','$codigoproducto','$codigoproduccion','$cantidadtotalenvases',CONVERT(DATE, '$fecha_actual', 103),'$codoperario')");

        $stmInsertarInsumoAvance->execute();

        for ($i = 0; $i < count($valoresCapturadosProduccion); $i += 3) {
          $codProductoAvance = trim($valoresCapturadosProduccion[$i]);
          $cantidadcaptura = trim($valoresCapturadosProduccion[$i + 1]);
          $cantidadlote = ($valoresCapturadosProduccion[$i + 2]);


          if ($valoresCapturadosProduccion[$i + 2] == '0') {
            $this->bd->rollBack();
            return false;
          }
          $rptalt = $this->stocklote($valoresCapturadosProduccion[$i + 2], $cantidadcaptura);
          $loterpa = '';
          $hora_actual = $codigoInsumosAvances->c_horaserversql('H');


          for ($j = 0; $j < count($rptalt); $j++) {
            // $saldo = $this->m_saldolote(trim($rptalt[$j][0]));
            $saldo = $this->m_saldolote(trim($rptalt[$j][0]), $codProductoAvance);

            $ltproducto = $saldo[0][1];
            $ltabr = $saldo[0][4];
            $ltlote = $saldo[0][2];
            $canlote = ($rptalt[$j][1] < 0) ? ($rptalt[$j][1] * -1) : $rptalt[$j][1];
            $ltresta = number_format($saldo[0][3] - $canlote);

            $calcularkardexenvase = $this->bd->prepare("SELECT MAX(CODIGO) AS CODIGO FROM T_TMPKARDEX_PRODUCCION WHERE COD_PRODUCTO='$ltproducto'");
            $calcularkardexenvase->execute();
            $valorkardexenvase = $calcularkardexenvase->fetch(PDO::FETCH_ASSOC);
            $resultadocodigokardexenvase = $valorkardexenvase['CODIGO'];



            $calcularkardex = $this->bd->prepare("SELECT KARDEX FROM T_TMPKARDEX_PRODUCCION WHERE CODIGO='$resultadocodigokardexenvase'");
            $calcularkardex->execute();
            $valorrest = $calcularkardex->fetch(PDO::FETCH_ASSOC);
            $resultadokardex = $valorrest['KARDEX'];

            // $sumakardexenvase =  $resultadokardex - $canlote;
            if ($resultadokardex != null) {
              $sumakardexresta = $resultadokardex - $canlote;
            } else {
              $sumakardexresta = $ltresta;
            }
            $descripcion = 'SALIDA PARA LA PRODUCCION - ' . $codigo_de_avance_insumo;
            $querylote = $this->bd->prepare("INSERT INTO T_TMPKARDEX_PRODUCCION(COD_PRODUCTO,ABR_PRODUCTO,LOTE,
            DESCRIPCION,COD_EGRESO,CANT_EGRESO,SALDO,USU_REGISTRO,HORA_REGISTRO,KARDEX,ESTADO) VALUES('$ltproducto','$ltabr','$ltlote',
            '$descripcion','$codigo_de_avance_insumo','$canlote',CONVERT(numeric(9,2), REPLACE('$ltresta', ',', ''), 1),
            '$codpersonal','$hora_actual',CONVERT(numeric(9,2), REPLACE('$sumakardexresta', ',', ''), 1),'F')");
            $querylote->execute();
            if ($querylote->errorCode() > 0) {
              $this->bd->rollBack();
              return 0;
              break;
            }
            // $loterpa .= $ltlote . "-" . $canlote . "/";
            $loterpa .= $ltlote;
            $stmInsumoAvance = $this->bd->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASES(COD_AVANCE_INSUMOS,COD_PRODUCTO,CANTIDAD,LOTE)
            VALUES ('$codigo_de_avance_insumo','$ltproducto','$canlote','$loterpa')"); //$cantidadlote
            $stmInsumoAvance->execute();
          }

          $verificastockactualenvase = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$codProductoAvance'");
          $verificastockactualenvase->execute();
          $valorsenvase = $verificastockactualenvase->fetch(PDO::FETCH_ASSOC);
          $valorestockenvase = floatval($valorsenvase['STOCK_ACTUAL']);
          $valordisminuidoenvase = $valorestockenvase - floatval($cantidadcaptura);


          $disminuyealmaceninsumos = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET STOCK_ACTUAL='$valordisminuidoenvase',STOCK_ANTERIOR='$valorestockenvase' WHERE COD_PRODUCTO='$codProductoAvance'");
          $disminuyealmaceninsumos->execute();
        }

        $suminsumos = 0;


        for ($i = 0; $i < count($valoresCapturadosProduccioninsumo); $i += 3) {
          $codProductoAvanceinsumo = trim($valoresCapturadosProduccioninsumo[$i]);
          $cantidadcapturainsumo = trim($valoresCapturadosProduccioninsumo[$i + 1]);
          $cantidadloteinsumo = ($valoresCapturadosProduccioninsumo[$i + 2]);



          if ($valoresCapturadosProduccioninsumo[$i + 2] == '0') {
            $this->bd->rollBack();
            return false;
          }
          $rptalt = $this->stocklote($valoresCapturadosProduccioninsumo[$i + 2], $cantidadcapturainsumo);
          $loterpa = '';
          $hora_actual = $codigoInsumosAvances->c_horaserversql('H');


          for ($j = 0; $j < count($rptalt); $j++) {
            $saldo = $this->m_saldolote(trim($rptalt[$j][0]), $codProductoAvanceinsumo);
            $ltproducto = $saldo[0][1];
            $ltabr = $saldo[0][4];
            $ltlote = $saldo[0][2];
            $canlote = ($rptalt[$j][1] < 0) ? ($rptalt[$j][1] * -1) : $rptalt[$j][1];
            $ltresta = number_format($saldo[0][3] - $canlote, 3);





            $calcularkardex = $this->bd->prepare("SELECT MAX(CODIGO) AS CODIGO FROM T_TMPKARDEX_PRODUCCION WHERE COD_PRODUCTO='$ltproducto'");
            $calcularkardex->execute();
            $valorkardex = $calcularkardex->fetch(PDO::FETCH_ASSOC);
            $resultadocodigokardex = $valorkardex['CODIGO'];

            $calcularkardexvalor = $this->bd->prepare("SELECT KARDEX FROM T_TMPKARDEX_PRODUCCION WHERE CODIGO='$resultadocodigokardex'");
            $calcularkardexvalor->execute();
            $valorrest = $calcularkardexvalor->fetch(PDO::FETCH_ASSOC);
            $resultadokardexrest = $valorrest['KARDEX'];

            if ($resultadokardexrest != null) {
              $sumakardexresta =    $resultadokardexrest - $canlote;
            } else {
              $sumakardexresta = $ltresta;
            }


            $descripcion = 'SALIDA PARA LA PRODUCCION - ' . $codigo_de_avance_insumo;
            $querylote = $this->bd->prepare("INSERT INTO T_TMPKARDEX_PRODUCCION(COD_PRODUCTO,ABR_PRODUCTO,LOTE,
            DESCRIPCION,COD_EGRESO,CANT_EGRESO,SALDO,USU_REGISTRO,HORA_REGISTRO,KARDEX,ESTADO) VALUES('$ltproducto','$ltabr','$ltlote',
            '$descripcion','$codigo_de_avance_insumo','$canlote',CONVERT(numeric(9,2), REPLACE('$ltresta', ',', ''), 1),'$codpersonal',
            '$hora_actual',CONVERT(numeric(9,2), REPLACE('$sumakardexresta', ',', ''), 1),'F')");
            $querylote->execute();
            if ($querylote->errorCode() > 0) {
              $this->bd->rollBack();
              return 0;
              break;
            }

            // $loterpa .= $ltlote . "-" . $canlote . "/";
            $loterpa .= $ltlote;
            $stmInsertarInsumo = $this->bd->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ITEM(COD_AVANCE_INSUMOS,COD_PRODUCTO,CANTIDAD,LOTE)
            VALUES ('$codigo_de_avance_insumo','$ltproducto','$canlote','$loterpa')");
            $stmInsertarInsumo->execute();
            $suminsumos = $suminsumos + $canlote;
          }
          $verificastockactual = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$codProductoAvanceinsumo'");
          $verificastockactual->execute();
          $valors = $verificastockactual->fetch(PDO::FETCH_ASSOC);
          $valorestock = floatval($valors['STOCK_ACTUAL']);
          $valordisminuido = $valorestock - floatval($cantidadcapturainsumo);


          $disminuyealmaceninsumos = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET STOCK_ACTUAL='$valordisminuido',STOCK_ANTERIOR='$valorestock' WHERE COD_PRODUCTO='$codProductoAvanceinsumo'");
          $disminuyealmaceninsumos->execute();
        }

        $stmContienevalor = $this->bd->prepare("SELECT NUM_LOTE FROM T_TMPPRODUCCION_BARRAS WHERE COD_PRODUCCION='$codigoproduccion'");
        $stmContienevalor->execute();
        $existeNum = $stmContienevalor->fetch(PDO::FETCH_ASSOC);
        $valorexistente = $existeNum['NUM_LOTE'];



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

          for ($e = 0; $e < $cantidadtotalenvases; $e++) {


            $nuevoCodigo = $maxCodigo + $c;
            $codigo_gen_barrasIf = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
            $c++;


            $codigonuminci = intval(substr($valoriniciobarra, 3));
            $codigogenerado = ($codigonuminci + $e);
            $valorFINAL = str_pad($codigogenerado, 6, '0', STR_PAD_LEFT);

            $valorINICIAL = substr($codigobarrainicio['BARRA_INICIO'], 0, 3);
            $respuestaTotalNumlote = $valorINICIAL . $valorFINAL;

            $insertarproducba = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS(COD_PRODUCCION_BARRAS,COD_PRODUCCION,COD_PRODUCTO,NUM_LOTE,USU_REGISTRO,MAQUINA)
            VALUES('$codigo_gen_barrasIf','$codigoproduccion','$codigoproducto','$respuestaTotalNumlote','$codpersonal','$maquina')");
            $insertarproducba->execute();
          }


          $stmDesProd = $this->bd->prepare("SELECT DES_PRODUCTO,ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoproducto'");
          $stmDesProd->execute();
          $valorProd = $stmDesProd->fetch(PDO::FETCH_ASSOC);
          $desprod = $valorProd['DES_PRODUCTO'];
          $abrprod = $valorProd['ABR_PRODUCTO'];

          $stmcancajaprod = $this->bd->prepare("SELECT CAN_CAJA FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
          $stmcancajaprod->execute();
          $cancaja = $stmcancajaprod->fetch(PDO::FETCH_ASSOC);
          $valorcancaja = $cancaja['CAN_CAJA'];



          $totalcajas = round(($cantidadtotalenvases / $valorcancaja), 3);
          $num_cajas = 1;
          for ($val = 0; $val < $totalcajas; $val++) {

            $stmaxBarraincioIf = $this->bd->prepare("SELECT MAX(BARRA_INI) AS BARRA_INI  FROM T_TMPPRODUCCION_BARRAS_GRUPO WHERE COD_PRODUCTO='$codigoproducto'");
            $stmaxBarraincioIf->execute();
            $valormaxBarraInIF = $stmaxBarraincioIf->fetch(PDO::FETCH_ASSOC);
            $codbarrainicioif = intval($valormaxBarraInIF['BARRA_INI']);


            $stmmaxnumloteEls = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE  FROM T_TMPPRODUCCION_BARRAS_GRUPO WHERE COD_PRODUCTO='$codigoproducto'");
            $stmmaxnumloteEls->execute();
            $valormaxnumloteEls = $stmmaxnumloteEls->fetch(PDO::FETCH_ASSOC);
            $codmaxnumloteEls = $valormaxnumloteEls['NUM_LOTE'];
            $codmaxnumloteextraiEls = intval(substr($codmaxnumloteEls, 4));
            $valorresultanteestraiEls = $codmaxnumloteextraiEls + 1;

            $stmproducionlote = $this->bd->prepare("SELECT NUM_PRODUCION_LOTE FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
            $stmproducionlote->execute();
            $valormaxproducion = $stmproducionlote->fetch(PDO::FETCH_ASSOC);
            $codproduccionlote = $valormaxproducion['NUM_PRODUCION_LOTE'];


            $stmfechavencimi = $this->bd->prepare("SELECT FEC_VENCIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
            $stmfechavencimi->execute();
            $valorfechavencimi = $stmfechavencimi->fetch(PDO::FETCH_ASSOC);
            $codfechavencimi = $valorfechavencimi['FEC_VENCIMIENTO'];

            $formato = 'Y-m-d H:i:s.u';
            $fecha_datetime_venci = DateTime::createFromFormat($formato, $codfechavencimi);
            $dateFechavencimi = $fecha_datetime_venci->format('d/m/Y');


            $codigo_barra_inicio = intval(substr($valoriniciobarra, 3));

            if ($cantidadtotalenvases >= $valorcancaja) {
              $num_lote_cajas = trim(str_pad($valorresultanteestraiEls, 5, '0', STR_PAD_LEFT));
              $num_lote = '-' . trim($abrprod) . $num_lote_cajas;

              if ($codbarrainicioif == null) {
                $valoriniciobaraif = $codigonuminci;
                $valorfinbarraif = $codigonuminci + $valorcancaja - 1;
              } else {
                $valoriniciobaraif = $codbarrainicioif + $valorcancaja;
                $valorfinbarraif = $valoriniciobaraif + $valorcancaja - 1;
              }
              $insertarproducbarra = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS_GRUPO(COD_PRODUCTO,DES_PRODUCTO,N_CAJA,CANTIDAD,ABR_PRODUCTO,BARRA_INI,BARRA_FIN,COD_PRODUCCION,NUM_LOTE,PRODUCCION,FECHA,FEC_VENCIMIENTO,N_PRODUCCION_G)
              VALUES('$codigoproducto','$desprod','$num_cajas','$valorcancaja','$abrprod','$valoriniciobaraif','$valorfinbarraif','$codigoproduccion','$num_lote','$codproduccionlote',GETDATE(),'$dateFechavencimi','$codproduccionlote')");
              $cantidadtotalenvases = $cantidadtotalenvases - $valorcancaja;
            } else {
              $num_lote_cajas = trim(str_pad($valorresultanteestraiEls, 5, '0', STR_PAD_LEFT));
              $num_lote = '-' . trim($abrprod) . $num_lote_cajas;

              if ($codbarrainicioif == null) {
                $valoriniciobara = $codigo_barra_inicio;
                // $valorfinbarra = $codigo_barra_inicio + $valorcancaja - 1;
                $valorfinbarra = $valoriniciobara + $cantidadtotalenvases - 1;
              } else {
                $valoriniciobara = $codbarrainicioif + $valorcancaja;
                $valorfinbarra = $valoriniciobara + $valorcancaja - 1;
                $valorfinbarra = $valoriniciobara + $cantidadtotalenvases - 1;
              }

              $insertarproducbarra = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS_GRUPO(COD_PRODUCTO,DES_PRODUCTO,N_CAJA,CANTIDAD,ABR_PRODUCTO,BARRA_INI,BARRA_FIN,COD_PRODUCCION,NUM_LOTE,PRODUCCION,FECHA,FEC_VENCIMIENTO,N_PRODUCCION_G)
              VALUES('$codigoproducto','$desprod','$num_cajas','$cantidadtotalenvases','$abrprod','$valoriniciobara','$valorfinbarra','$codigoproduccion','$num_lote','$codproduccionlote',GETDATE(),'$dateFechavencimi','$codproduccionlote')");
              $cantidad = 0;
            }

            $insertarproducbarra->execute();
            $num_cajas++;
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





          $stmDesProd = $this->bd->prepare("SELECT DES_PRODUCTO,ABR_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoproducto'");
          $stmDesProd->execute();
          $valorProd = $stmDesProd->fetch(PDO::FETCH_ASSOC);
          $desprod = $valorProd['DES_PRODUCTO'];
          $abrprod = $valorProd['ABR_PRODUCTO'];


          $con = 1;
          $num_cajas_else = 1;
          for ($ex = 1; $ex <= $cantidadtotalenvases; $ex++) {

            $nuevoCodigoEl = $maxCodigoEl + $con;
            $codigo_gen_barrasEl = str_pad($nuevoCodigoEl, 9, '0', STR_PAD_LEFT);
            $con++;

            $codigonumero = intval(substr($valorpuesto, 3));
            $codigo_generar = ($codigonumero + $ex);
            $valorFINALE = str_pad($codigo_generar, 6, '0', STR_PAD_LEFT);

            $valorINICIALE = substr($codigogen['NUM_LOTE'], 0, 3);
            $respuestaTotalNumloteE = $valorINICIALE . $valorFINALE;

            $insertarproduc = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS(COD_PRODUCCION_BARRAS,COD_PRODUCCION,COD_PRODUCTO,NUM_LOTE,USU_REGISTRO,MAQUINA)
            VALUES('$codigo_gen_barrasEl','$codigoproduccion','$codigoproducto','$respuestaTotalNumloteE','$codpersonal','$maquina')");
            $insertarproduc->execute();
          }


          $stmcancajaprodels = $this->bd->prepare("SELECT CAN_CAJA FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
          $stmcancajaprodels->execute();
          $cancajaEls = $stmcancajaprodels->fetch(PDO::FETCH_ASSOC);
          $valorcancajaEls = $cancajaEls['CAN_CAJA'];


          $totalcajasEls = round(($cantidadtotalenvases / $valorcancajaEls), 3);



          $num_cajas_else = 1;
          for ($valel = 0; $valel < $totalcajasEls; $valel++) {

            $stmaxBarraincioEls = $this->bd->prepare("SELECT MAX(BARRA_INI) AS BARRA_INI  FROM T_TMPPRODUCCION_BARRAS_GRUPO WHERE COD_PRODUCTO='$codigoproducto'");
            $stmaxBarraincioEls->execute();
            $valormaxBarraInelse = $stmaxBarraincioEls->fetch(PDO::FETCH_ASSOC);
            $codbarrainicioels = intval($valormaxBarraInelse['BARRA_INI']);


            $stmproducionlote = $this->bd->prepare("SELECT NUM_PRODUCION_LOTE FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
            $stmproducionlote->execute();
            $valormaxproducion = $stmproducionlote->fetch(PDO::FETCH_ASSOC);
            $codproduccionlote = $valormaxproducion['NUM_PRODUCION_LOTE'];


            $stmfechavencimi = $this->bd->prepare("SELECT FEC_VENCIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCCION='$codigoproduccion'");
            $stmfechavencimi->execute();
            $valorfechavencimi = $stmfechavencimi->fetch(PDO::FETCH_ASSOC);
            $codfechavencimi = $valorfechavencimi['FEC_VENCIMIENTO'];


            $stmcodigoAumEls = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE  FROM T_TMPPRODUCCION_BARRAS_GRUPO WHERE COD_PRODUCTO='$codigoproducto'");
            $stmcodigoAumEls->execute();
            $codigogenEls = $stmcodigoAumEls->fetch(PDO::FETCH_ASSOC);
            $valorpuestoEls = $codigogenEls['NUM_LOTE'];

            $extraccionvalor = intval(substr($valorpuestoEls, 4));

            $sum = $extraccionvalor + 1;


            $codigo_barra_inicio_els = intval(substr($valoriniciobarra, 3));

            if ($cantidadtotalenvases >= $valorcancajaEls) {

              $num_lote_cajas = trim(str_pad($sum, 5, '0', STR_PAD_LEFT));
              $num_lote = '-' . trim($abrprod) . $num_lote_cajas;

              if ($codbarrainicioels == null) {

                $valoriniciobaraif = $codigo_barra_inicio_els;
                $valorfinbarraif = $codigo_barra_inicio_els + $valorcancajaEls - 1;
              } else {
                $codigoinicioelsestm = $this->bd->prepare("SELECT MAX(BARRA_FIN) AS BARRA_FIN  FROM T_TMPPRODUCCION_BARRAS_GRUPO WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
                $codigoinicioelsestm->execute();
                $codigoinciioelse = $codigoinicioelsestm->fetch(PDO::FETCH_ASSOC);
                $valorinicioelse = $codigoinciioelse['BARRA_FIN'];

                // $valoriniciobaraif = $codbarrainicioels + $valorcancajaEls;
                $valoriniciobaraif = $valorinicioelse + 1;
                $valorfinbarraif = $valoriniciobaraif + $valorcancajaEls - 1;
              }
              $insertarproducbarra = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS_GRUPO(COD_PRODUCTO,DES_PRODUCTO,N_CAJA,CANTIDAD,ABR_PRODUCTO,BARRA_INI,BARRA_FIN,COD_PRODUCCION,NUM_LOTE,PRODUCCION,FECHA,FEC_VENCIMIENTO,N_PRODUCCION_G)
              VALUES('$codigoproducto','$desprod','$num_cajas_else','$valorcancajaEls','$abrprod','$valoriniciobaraif','$valorfinbarraif','$codigoproduccion','$num_lote','$codproduccionlote',GETDATE(),CONVERT(DATETIME,'$codfechavencimi',120),'$codproduccionlote')");
              $cantidadtotalenvases = $cantidadtotalenvases - $valorcancajaEls;
            } else {

              $num_lote_cajas = trim(str_pad($sum, 5, '0', STR_PAD_LEFT));
              $num_lote = '-' . trim($abrprod) . $num_lote_cajas;

              if ($codbarrainicioels == null) {
                $valoriniciobara = $codigonumero;
                // $valorfinbarraEls = $codigonumero + $valorcancajaEls - 1;
                $valorfinbarraEls = $codigonumero + $cantidadtotalenvases - 1;
              } else {
                // $valoriniciobara = $codigonumero;
                $valoriniciobara = $codbarrainicioels + $valorcancajaEls;
                // $valorfinbarraEls = $valoriniciobara + $valorcancajaEls - 1;
                $valorfinbarraEls = $valoriniciobara + $cantidadtotalenvases - 1;
              }

              $insertarproducbarra = $this->bd->prepare("INSERT INTO T_TMPPRODUCCION_BARRAS_GRUPO(COD_PRODUCTO,DES_PRODUCTO,N_CAJA,CANTIDAD,ABR_PRODUCTO,BARRA_INI,BARRA_FIN,COD_PRODUCCION,NUM_LOTE,PRODUCCION,FECHA,FEC_VENCIMIENTO,N_PRODUCCION_G)
              VALUES('$codigoproducto','$desprod','$num_cajas_else','$cantidadtotalenvases','$abrprod','$valoriniciobara','$valorfinbarraEls','$codigoproduccion','$num_lote','$codproduccionlote',GETDATE(),CONVERT(DATETIME, '$codfechavencimi', 120),'$codproduccionlote')");
              // $cantidad = 0;
            }

            $insertarproducbarra->execute();
            $num_cajas_else++;
          }
        }

        $stmbusquedabfin = $this->bd->prepare("SELECT MAX(NUM_LOTE) AS NUM_LOTE FROM T_TMPPRODUCCION_BARRAS WHERE COD_PRODUCCION='$codigoproduccion' AND COD_PRODUCTO='$codigoproducto'");
        $stmbusquedabfin->execute();
        $valorbusquedafin = $stmbusquedabfin->fetch(PDO::FETCH_ASSOC);
        $valorfinbuqueda = $valorbusquedafin['NUM_LOTE'];
        $numeroextraidofin = substr($valorfinbuqueda, 3);

        $valorconvint = intval($numeroextraidofin);


        $valorabrfin = trim($abrprod) . trim($valorconvint);
        $valoriniciodebarra =  $valorconvint - $cantidadrestar + 1;
        $valorinicioabr = trim($abrprod) . trim($valoriniciodebarra);



        $stmbusquedabfin = $this->bd->prepare("UPDATE T_TMPAVANCE_INSUMOS_PRODUCTOS SET BARRA_INICIO='$valorinicioabr', BARRA_FIN='$valorabrfin',CANT_INSUMOS='$suminsumos' WHERE COD_AVANCE_INSUMOS ='$codigo_de_avance_insumo'");
        $stmbusquedabfin->execute();
        if ($updatetotal == 0) {
          $stmVerificaCodReque = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) AS COD_REQUERIMIENTO FROM T_TMPPRODUCCION WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
          $stmVerificaCodReque->execute();
          $consultarequerimientocod = $stmVerificaCodReque->fetch(PDO::FETCH_ASSOC);
          $valorcodrequerimiento = ($consultarequerimientocod['COD_REQUERIMIENTO']);


          $actualizaComboProducto = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ITEM SET ESTADO='F' WHERE COD_PRODUCTO='$codigoproducto' AND COD_REQUERIMIENTO='$valorcodrequerimiento'");
          $actualizaComboProducto->execute();

          $actualizarRequerimientoItem = $this->bd->prepare("UPDATE T_TMPPRODUCCION SET ESTADO='F' WHERE COD_PRODUCTO='$codigoproducto' AND COD_PRODUCCION='$codigoproduccion'");
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
      $stmMostrar = $this->bd->prepare("SELECT TAI.COD_AVANCE_INSUMOS AS COD_AVANCE_INSUMOS,TAI.N_BACHADA AS N_BACHADA,TP.ABR_PRODUCTO AS ABR_PRODUCTO,
                                          TP.PESO_NETO AS PESO_NETO, TAI.CANTIDAD AS CANTIDAD,TAI.CANT_INSUMOS AS CANT_INSUMOS,  CONVERT(varchar, TAI.FECHA, 103) AS FECHA
                                          FROM T_TMPAVANCE_INSUMOS_PRODUCTOS TAI 
                                          INNER JOIN T_PRODUCTO TP ON TAI.COD_PRODUCTO=TP.COD_PRODUCTO WHERE MONTH(FECHA) = '$mesSeleccionado' AND YEAR(FECHA) = '$anioSeleccionado'");
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
      $stmMostrar = $this->bd->prepare("SELECT TAIP.COD_AVANCE_INSUMOS AS COD_AVANCE_INSUMOS,TP.ABR_PRODUCTO AS ABR_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO,
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
      if ($insert == $idrequerimiento) {
        return $insert;
      }
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }


  public function MostrarOrdenDeCompra()
  {
    try {
      $stmMostrar = $this->bd->prepare("SELECT COD_ORDEN_COMPRA,COD_REQUERIMIENTO,FECHA FROM T_TMPORDEN_COMPRA WHERE ESTADO='P'");
      $stmMostrar->execute();
      $datos = $stmMostrar->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }
  public function MirarOrdenCompra($idcodordencompra)
  {
    try {
      $stmMostrar = $this->bd->prepare("SELECT OC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA, P.DES_PRODUCTO AS DES_PRODUCTO,
                                         OC.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE, OC.CANTIDAD_MINIMA AS CANTIDAD_MINIMA  
                                         FROM T_TMPORDEN_COMPRA_ITEM OC INNER JOIN T_PRODUCTO P ON OC.COD_PRODUCTO=P.COD_PRODUCTO WHERE OC.COD_ORDEN_COMPRA='$idcodordencompra'");

      $stmMostrar->execute();
      $datos = $stmMostrar->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {

      die($e->getMessage());
    }
  }
  public function AprobarOrdenCompra($idcodordencompra, $codigopersonal)
  {
    try {
      $this->bd->beginTransaction();

      $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
      $stmCodreq->execute();
      $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
      $maxCodigoRe = intval($resultadoRe['COD_REQUERIMIENTO']);
      $nuevoCodigoReq = $maxCodigoRe + 1;
      $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);

      $zonaHorariaPeru = new DateTimeZone('America/Lima');
      $horaActualPeru = new DateTime('now', $zonaHorariaPeru);
      $horaMinutosSegundos = $horaActualPeru->format('H:i:s');

      $maquina = os_info();


      $stmtrequerimiento = $this->bd->prepare("INSERT INTO T_REQUERIMIENTOTEMP (COD_REQUERIMIENTO, COD_CATEGORIA, FEC_REQUERIMIENTO, HOR_REQUERIMIENTO, EST_REQUERIMIENTO, USU_REGISTRO, FEC_REGISTRO,MAQUINA)
                                                VALUES('$codigoAumentoReq','00004',GETDATE(),'$horaMinutosSegundos','P','$codigopersonal',GETDATE(),'$maquina')");
      $stmtrequerimiento->execute();

      $stmactualiza = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET ESTADO='T', COD_REQUERIMIENTO='$codigoAumentoReq' WHERE COD_ORDEN_COMPRA='$idcodordencompra'");
      $stmactualiza->execute();


      $stmtrequerimiento = $this->bd->commit();
      return $stmtrequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarOrdenDeCompraAlerta()
  {
    try {

      $stmOrdenCompra = $this->bd->prepare("SELECT TC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,TC.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,TC.COD_REQUERIMIENTOTEMP AS COD_REQUERIMIENTOTEMP,TC.FECHA_REALIZADA AS FECHA_REALIZADA,
                                              TC.COD_PROVEEDOR AS COD_PROVEEDOR,TCI.COD_PRODUCTO AS COD_PRODUCTO,TP.COD_PRODUCCION AS COD_PRODUCCION,TP.ABR_PRODUCTO AS ABR_PRODUCTO, TP.COD_PRODUCCION AS COD_PRODUCCION,
                                              TP.DES_PRODUCTO AS DES_PRODUCTO,TCI.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE, TCI.CANTIDAD_LLEGADA AS CANTIDAD_LLEGADA,TCI.ESTADO AS ESTADO,TCI.FECHA_ENTREGA AS FECHA_ENTREGA FROM T_TMPORDEN_COMPRA TC
                                              INNER JOIN T_TMPORDEN_COMPRA_ITEM TCI ON TC.COD_ORDEN_COMPRA=TCI.COD_ORDEN_COMPRA
                                              INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TCI.COD_PRODUCTO WHERE (TCI.ESTADO='P' OR TCI.ESTADO='N') AND CAST(TCI.FECHA_ENTREGA AS DATE) <= CAST(GETDATE() AS DATE)");
      $stmOrdenCompra->execute();
      $datos = $stmOrdenCompra->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function  MostrarProduccionProductoEnvase($ID_PRODUCTO_COMBO, $idp)
  {
    try {

      $stm = $this->bd->prepare("SELECT COD_PRODUCCION, CONVERT(VARCHAR, FEC_VENCIMIENTO, 103) AS FEC_GENERADO,
                                  COD_PRODUCTO,NUM_PRODUCION_LOTE,ESTADO FROM T_TMPPRODUCCION 
                                  WHERE COD_REQUERIMIENTO='$ID_PRODUCTO_COMBO' AND COD_PRODUCTO='$idp'");
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }



  public function MostrarOrdenDeCompraAprobada()
  {
    try {
      $stmOrdenCompraAprobada = $this->bd->prepare("SELECT COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA, COD_REQUERIMIENTO AS COD_REQUERIMIENTO,
                                                      FECHA AS FECHA FROM T_TMPORDEN_COMPRA  WHERE ESTADO='T'");
      $stmOrdenCompraAprobada->execute();
      $datos = $stmOrdenCompraAprobada->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarInsumosCompras($idcompraaprobada)
  {
    try {
      $stmInsumosCompras = $this->bd->prepare("SELECT CI.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA, CI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
                                                CI.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,TAL.STOCK_ACTUAL AS STOCK_ACTUAL, CI.COD_PROVEEDOR AS COD_PROVEEDOR, TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR FROM T_TMPORDEN_COMPRA_ITEM CI
                                                INNER JOIN T_PRODUCTO TP ON CI.COD_PRODUCTO=TP.COD_PRODUCTO
                                                INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=CI.COD_PROVEEDOR
                                                INNER JOIN T_TMPALMACEN_INSUMOS TAL ON TAL.COD_PRODUCTO=CI.COD_PRODUCTO
                                                WHERE CI.COD_ORDEN_COMPRA='$idcompraaprobada' AND CI.ESTADO='P'");
      $stmInsumosCompras->execute();
      $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_OBJ);
      // $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_NUM);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarProveedoresPorProducto($codigoProducto)
  {
    try {
      $stmInsumosCompras = $this->bd->prepare("SELECT TCAN.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA, TCAN.COD_PROVEEDOR AS COD_PROVEEDOR, TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR, TPRO.RUC_PROVEEDOR AS RUC_PROVEEDOR,
                                                TCAN.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TCAN.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,TCAN.PRECIO_PRODUCTO AS PRECIO_PRODUCTO 
                                                FROM T_TMPCANTIDAD_MINIMA TCAN INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=TCAN.COD_PROVEEDOR INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TCAN.COD_PRODUCTO
                                                WHERE TCAN.COD_PRODUCTO='$codigoProducto'");
      $stmInsumosCompras->execute();
      $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_OBJ);
      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarPrecioPorCantidad($codproducto, $codProveedor)
  {
    try {
      $stmInsumosCompras = $this->bd->prepare("SELECT TC.COD_PROVEEDOR AS COD_PROVEEDOR, TC.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO, TC.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,
                                                TC.PRECIO_PRODUCTO AS PRECIO_PRODUCTO, TC.TIPO_MONEDA AS TIPO_MONEDA FROM T_TMPCANTIDAD_MINIMA TC
                                                INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TC.COD_PRODUCTO
                                                WHERE TC.COD_PRODUCTO='$codproducto' AND TC.COD_PROVEEDOR='$codProveedor'");
      $stmInsumosCompras->execute();
      $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarCodRequerimientoTEMP()
  {
    try {
      $stmInsumosCompras = $this->bd->prepare("SELECT TOP 5 *FROM T_REQUERIMIENTOTEMP ORDER BY COD_REQUERIMIENTO DESC;");
      $stmInsumosCompras->execute();
      $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarTPMRequerimiento()
  {
    try {

      $stmInsumosCompras = $this->bd->prepare("SELECT TOP 5 *FROM T_TMPREQUERIMIENTO ORDER BY COD_REQUERIMIENTO DESC;");
      $stmInsumosCompras->execute();
      $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_OBJ);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  public function MostrarListaRequerimiento($requerimiento)
  {
    try {

      $stmInsumosCompras = $this->bd->prepare("SELECT RI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,TP.COD_PRODUCCION AS COD_PRODUCCION,RI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO, 
      RI.CANTIDAD AS CANTIDAD, RI.TOTAL_PRODUCTO AS TOTAL_PRODUCTO FROM T_TMPREQUERIMIENTO_ITEM RI
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=RI.COD_PRODUCTO
      WHERE RI.COD_REQUERIMIENTO='$requerimiento'");
      $stmInsumosCompras->execute();
      $datos = $stmInsumosCompras->fetchAll(PDO::FETCH_ASSOC);

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarProveedores()
  {
    try {

      $stmproveedores = $this->bd->prepare("SELECT COD_PROVEEDOR,NOM_PROVEEDOR,DIR_PROVEEDOR,RUC_PROVEEDOR,DNI_PROVEEDOR FROM T_PROVEEDOR");
      $stmproveedores->execute();
      $datosproveedor = $stmproveedores->fetchAll(PDO::FETCH_OBJ);

      return $datosproveedor;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function   MostrarProveedoresId($id)
  {
    try {
      $stmproveedores = $this->bd->prepare("SELECT COD_PROVEEDOR,NOM_PROVEEDOR,DIR_PROVEEDOR,RUC_PROVEEDOR,DNI_PROVEEDOR FROM T_PROVEEDOR WHERE COD_PROVEEDOR='$id'");
      $stmproveedores->execute();
      $datosproveedor = $stmproveedores->fetchAll(PDO::FETCH_OBJ);

      return $datosproveedor;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function generarcodigocomprobante()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_TMPCOMPROBANTE) as COD_TMPCOMPROBANTE FROM T_TMPCOMPROBANTE");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['COD_TMPCOMPROBANTE']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }
  public function GuardarInsumosComprasImagen($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada, $dataimagenesfile)
  {
    try {
      $this->bd->beginTransaction();
      $codigo = new m_almacen();
      $totalimagenesfile = count($_FILES['file']['name']);


      // var_dump($datosSeleccionadosInsumos);
      // exit;
      // $fechaFormateada = DateTime::createFromFormat('Y-m-d', $fecha);

      // $stmexisteproveedor = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_PROVEEDOR WHERE RUC_PROVEEDOR='$proveedorruc'");
      // $stmexisteproveedor->execute();
      // $resultadoExisteProveedor = $stmexisteproveedor->fetch(PDO::FETCH_ASSOC);
      // $count = $resultadoExisteProveedor['COUNT']

      // $codigoproveedor = $maxCodigo + 1;
      // $codigoproveedorgenerado = str_pad($codigoproveedor, 5, '0', STR_PAD_LEFT);

      $zonaHorariaPeru = new DateTimeZone('America/Lima');
      $horaActualPeru = new DateTime('now', $zonaHorariaPeru);
      $horaMinutosSegundos = $horaActualPeru->format('H:i');

      $actualizarordecomprainsumos = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET FECHA_REALIZADA=CONVERT(DATE, '$fecha', 23), HORA='$horaMinutosSegundos' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
      $insertOCI = $actualizarordecomprainsumos->execute();

      // if ($count == 0) {
      //   $insertardatosproveedor = $this->bd->prepare("INSERT INTO T_PROVEEDOR(COD_PROVEEDOR,NOM_PROVEEDOR,DIR_PROVEEDOR,RUC_PROVEEDOR,DNI_PROVEEDOR)
      //                                                 VALUES('$codigoproveedorgenerado','$proveedor','$proveedordireccion','$proveedorruc','$proveedordni')");
      //   $insertardatosproveedor->execute();
      // }

      $codigocomprobante = $codigo->generarcodigocomprobante();


      // if ($count == 0) {
      //   $verificacodprove = $codigoproveedorgenerado;
      // } else {

      //   $stmproveedorcondicion = $this->bd->prepare("SELECT MAX(COD_PROVEEDOR) AS COD_PROVEEDOR FROM T_PROVEEDOR WHERE RUC_PROVEEDOR='$proveedorruc'");
      //   $stmproveedorcondicion->execute();
      //   $resultadoProveedorCondicion = $stmproveedorcondicion->fetch(PDO::FETCH_ASSOC);
      //   $codproveedoractual = $resultadoProveedorCondicion['COD_PROVEEDOR'];

      //   $verificacodprove = $codproveedoractual;
      // }




      // $stminsertarcomprobante = $this->bd->prepare("INSERT INTO T_TMPCOMPROBANTE(COD_TMPCOMPROBANTE,COD_PROVEEDOR,COD_EMPRESA,OFICINA,FECHA_REALIZADA,COD_USUARIO,COD_ORDEN_COMPRA,OBSERVACION,HORA)
      //                                               VALUES('$codigocomprobante','$verificacodprove','$empresa','$oficina',CONVERT(DATE, '$fecha', 23),'$personalcod','$idcompraaprobada','$observacion','$horaMinutosSegundos')");
      // $stminsertarcomprobante->execute();
      $sumordenitem = 0;
      foreach ($datosSeleccionadosInsumos as $insumoString) {
        $insumoArray = json_decode($insumoString, true);

        // Verifica si la decodificación fue exitosa
        if ($insumoArray !== null) {
          $codigoproducto = $insumoArray["codproducto"];
          $cantidad = $insumoArray["cantidad"];
          $precio = $insumoArray["precio"];
          $idmoneda = $insumoArray["id_moneda"];
          $f_pago = $insumoArray["f_pago"];
          $codigoproveedorselect = $insumoArray["codigoproveedorselect"];

          $stmactualizaitemcompra = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET ESTADO='O', MONTO='$precio', TIPO_MONEDA='$idmoneda', F_PAGO='$f_pago', COD_PROVEEDOR='$codigoproveedorselect' WHERE COD_ORDEN_COMPRA='$idcompraaprobada' AND COD_PRODUCTO='$codigoproducto'");
          $stmactualizaitemcompra->execute();
          $sumordenitem = $sumordenitem + $precio;
        } else {
          // Manejar el error de decodificación, si es necesario
          echo "Error al decodificar JSON: " . json_last_error_msg();
        }
      }

      $stmconsultadeestado = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_TMPORDEN_COMPRA_ITEM  WHERE COD_ORDEN_COMPRA='$idcompraaprobada' AND ESTADO='P'");
      $stmconsultadeestado->execute();
      $resul = $stmconsultadeestado->fetch(PDO::FETCH_ASSOC);
      $contador = $resul['COUNT'];

      $stmsumatoriadecordenitem = $this->bd->prepare("SELECT SUM(MONTO) AS SUMA FROM T_TMPORDEN_COMPRA_ITEM  WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
      $stmsumatoriadecordenitem->execute();
      $resulsumitem = $stmsumatoriadecordenitem->fetch(PDO::FETCH_ASSOC);
      $sumatoria = $resulsumitem['SUMA'];

      if ($contador == 0) {
        $stmSumatoriadeinsumospedidos = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET TOTAL='$sumatoria' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
        $stmSumatoriadeinsumospedidos->execute();

        $stmcambioestado = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET ESTADO='O' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
        $stmcambioestado->execute();
      }
      $actualizacodigoperson = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET COD_USU='$personalcod' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
      $actualizacodigoperson->execute();

      $stmactualizaitemcompra = $this->bd->prepare("UPDATE T_TMPCOMPROBANTE SET MONTO_TOTAL='$sumordenitem' WHERE COD_ORDEN_COMPRA='$idcompraaprobada' AND COD_TMPCOMPROBANTE='$codigocomprobante'");
      $stmactualizaitemcompra->execute();
      if ($totalimagenesfile > 0) {
        for ($total = 0; $total < $totalimagenesfile; $total++) {
          if (isset($dataimagenesfile)) {
            // Validar que se haya seleccionado una imagen
            if (empty($_FILES['file']['name'][$total])) {
              echo json_encode(array('status' => 'error', 'message' => 'Debe seleccionar una imagen.'));
              exit;
            }

            // Obtener la información sobre el archivo
            $imagen_info = getimagesize($_FILES['file']['tmp_name'][$total]);
            $imagen_tipo = $imagen_info['mime'];

            // Verificar que el tipo de archivo sea JPEG o PNG
            if ($imagen_tipo !== 'image/jpeg' && $imagen_tipo !== 'image/png') {
              echo json_encode(array('status' => 'error', 'message' => 'Formato de imagen no válido. Solo se permiten imágenes JPEG, JPG, PNG.'));
              exit;
            }
            // Verificar el tipo de archivo y usar la función adecuada para crear el recurso de imagen
            if ($imagen_tipo === 'image/jpeg') {
              $calidad = 30;
              $imagen_comprimida = imagecreatefromjpeg($_FILES['file']['tmp_name'][$total]);
              ob_start();
              imagejpeg($imagen_comprimida, null, $calidad);
              $imagen_comprimida_binaria = ob_get_contents();
              ob_end_clean();
              $hex = bin2hex($imagen_comprimida_binaria);
              $imagen = '0x' . $hex;
              imagedestroy($imagen_comprimida);
            } elseif ($imagen_tipo === 'image/png') {
              $calidad = 5;
              $imagen_comprimida = imagecreatefrompng($_FILES['file']['tmp_name'][$total]);
              ob_start();
              imagepng($imagen_comprimida, null, $calidad);
              $imagen_comprimida_binaria = ob_get_contents();
              ob_end_clean();
              $hex = bin2hex($imagen_comprimida_binaria);
              $imagen = '0x' . $hex;
              imagedestroy($imagen_comprimida);
            }

            $insertdataimagen = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_IMAGENES(COD_TMPCOMPROBANTE,IMAGEN)
                                                    VALUES('$idcompraaprobada',$imagen)");
            $insertdataimagen->execute();
          } else {
            // La variable imagen no existe
            $imagen = null;
            echo json_encode(array('status' => 'error', 'message' => 'No hay imagen seleccionada.'));
            exit;
          }
        }
      }
      $insertOCI = $this->bd->commit();
      return $insertOCI;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function GuardarInsumosCompras($fecha, $empresa,  $personalcod,  $oficina, $observacion, $datosSeleccionadosInsumos, $idcompraaprobada)
  {
    try {
      $this->bd->beginTransaction();
      $codigo = new m_almacen();

      // var_dump($datosSeleccionadosInsumos);
      // exit;
      // $fechaFormateada = DateTime::createFromFormat('Y-m-d', $fecha);

      // $stmexisteproveedor = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_PROVEEDOR WHERE RUC_PROVEEDOR='$proveedorruc'");
      // $stmexisteproveedor->execute();
      // $resultadoExisteProveedor = $stmexisteproveedor->fetch(PDO::FETCH_ASSOC);
      // $count = $resultadoExisteProveedor['COUNT'];


      // $stmMaxProveedor = $this->bd->prepare("SELECT MAX(COD_PROVEEDOR) AS COD_PROVEEDOR FROM T_PROVEEDOR");
      // $stmMaxProveedor->execute();
      // $resultadoProveedor = $stmMaxProveedor->fetch(PDO::FETCH_ASSOC);
      // $maxCodigo = $resultadoProveedor['COD_PROVEEDOR'];

      // $codigoproveedor = $maxCodigo + 1;
      // $codigoproveedorgenerado = str_pad($codigoproveedor, 5, '0', STR_PAD_LEFT);

      $zonaHorariaPeru = new DateTimeZone('America/Lima');
      $horaActualPeru = new DateTime('now', $zonaHorariaPeru);
      $horaMinutosSegundos = $horaActualPeru->format('H:i');

      $actualizarordecomprainsumos = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET FECHA_REALIZADA=CONVERT(DATE, '$fecha', 23), HORA='$horaMinutosSegundos' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
      $insertOCI = $actualizarordecomprainsumos->execute();


      $codigocomprobante = $codigo->generarcodigocomprobante();


      // if ($count == 0) {
      //   $verificacodprove = $codigoproveedorgenerado;
      // } else {

      //   $stmproveedorcondicion = $this->bd->prepare("SELECT MAX(COD_PROVEEDOR) AS COD_PROVEEDOR FROM T_PROVEEDOR WHERE RUC_PROVEEDOR='$proveedorruc'");
      //   $stmproveedorcondicion->execute();
      //   $resultadoProveedorCondicion = $stmproveedorcondicion->fetch(PDO::FETCH_ASSOC);
      //   $codproveedoractual = $resultadoProveedorCondicion['COD_PROVEEDOR'];

      //   $verificacodprove = $codproveedoractual;
      // }




      // $stminsertarcomprobante = $this->bd->prepare("INSERT INTO T_TMPCOMPROBANTE(COD_TMPCOMPROBANTE,COD_PROVEEDOR,COD_EMPRESA,OFICINA,FECHA_REALIZADA,COD_USUARIO,COD_ORDEN_COMPRA,OBSERVACION,HORA)
      //                                               VALUES('$codigocomprobante','$verificacodprove','$empresa','$oficina',CONVERT(DATE, '$fecha', 23),'$personalcod','$idcompraaprobada','$observacion','$horaMinutosSegundos')");
      // $stminsertarcomprobante->execute();
      $sumordenitem = 0;
      foreach ($datosSeleccionadosInsumos as $insumoString) {
        $insumoArray = json_decode($insumoString, true);

        // Verifica si la decodificación fue exitosa
        if ($insumoArray !== null) {
          $codigoproducto = $insumoArray["codproducto"];
          $cantidad = $insumoArray["cantidad"];
          $precio = $insumoArray["precio"];
          $idmoneda = $insumoArray["id_moneda"];
          $f_pago = $insumoArray["f_pago"];
          $codigoproveedorselect = $insumoArray["codigoproveedorselect"];

          $stmactualizaitemcompra = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET ESTADO='O', MONTO='$precio', TIPO_MONEDA='$idmoneda', F_PAGO='$f_pago', COD_PROVEEDOR='$codigoproveedorselect' WHERE COD_ORDEN_COMPRA='$idcompraaprobada' AND COD_PRODUCTO='$codigoproducto'");
          $stmactualizaitemcompra->execute();
          $sumordenitem = $sumordenitem + $precio;
        } else {
          // Manejar el error de decodificación, si es necesario
          echo "Error al decodificar JSON: " . json_last_error_msg();
        }
      }

      $stmconsultadeestado = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_TMPORDEN_COMPRA_ITEM  WHERE COD_ORDEN_COMPRA='$idcompraaprobada' AND ESTADO='P'");
      $stmconsultadeestado->execute();
      $resul = $stmconsultadeestado->fetch(PDO::FETCH_ASSOC);
      $contador = $resul['COUNT'];

      $stmsumatoriadecordenitem = $this->bd->prepare("SELECT SUM(MONTO) AS SUMA FROM T_TMPORDEN_COMPRA_ITEM  WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
      $stmsumatoriadecordenitem->execute();
      $resulsumitem = $stmsumatoriadecordenitem->fetch(PDO::FETCH_ASSOC);
      $sumatoria = $resulsumitem['SUMA'];

      if ($contador == 0) {
        $stmSumatoriadeinsumospedidos = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET TOTAL='$sumatoria' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
        $stmSumatoriadeinsumospedidos->execute();

        $stmcambioestado = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET ESTADO='O' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
        $stmcambioestado->execute();
      }
      $actualizacodigoperson = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET COD_USU='$personalcod' WHERE COD_ORDEN_COMPRA='$idcompraaprobada'");
      $actualizacodigoperson->execute();


      $insertOCI = $this->bd->commit();
      return $insertOCI;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarReporteOrdenCompra($idrequerimientotemp)
  {
    try {
      $stmmostrarcompracomprobante = $this->bd->prepare("SELECT COD_ORDEN_COMPRA,FECHA_REALIZADA,HORA FROM T_TMPORDEN_COMPRA 
                                                          WHERE COD_REQUERIMIENTO='$idrequerimientotemp'");
      $stmmostrarcompracomprobante->execute();
      // $datoscompra = $stmmostrarcompracomprobante->fetchAll(PDO::FETCH_OBJ);
      return $stmmostrarcompracomprobante->fetchAll(PDO::FETCH_NUM);
      // return $datoscompra;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarReporteOrdenCompraPDF($idrequerimientotemp)
  {
    try {
      $stmmostrarcompracomprobante = $this->bd->prepare("SELECT OC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,OC.COD_REQUERIMIENTO AS COD_REQUERIMIENTO, OC.FECHA_REALIZADA AS FECHA_REALIZADA,OC.HORA AS HORA,
                                                          OC.F_PAGO AS F_PAGO, TP.COD_PROVEEDOR AS COD_PROVEEDOR, TP.NOM_PROVEEDOR AS NOM_PROVEEDOR FROM T_TMPORDEN_COMPRATEMP OC 
                                                          INNER JOIN T_PROVEEDOR TP ON OC.COD_PROVEEDOR=TP.COD_PROVEEDOR 
                                                          WHERE OC.COD_REQUERIMIENTO='$idrequerimientotemp'");
      $stmmostrarcompracomprobante->execute();
      return $stmmostrarcompracomprobante->fetchAll(PDO::FETCH_NUM);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarFacturaItemTempPDF($codigoordencompratemp)
  {
    try {
      $mostrardatospdf = $this->bd->prepare("SELECT CI.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,CI.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO,
      CI.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE, CI.MONTO AS MONTO, CI.PRECIO_MINIMO AS PRECIO_MINIMO FROM T_TMPORDEN_COMPRA_ITEMTEMP CI 
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=CI.COD_PRODUCTO WHERE CI.COD_ORDEN_COMPRA='$codigoordencompratemp'");
      $mostrardatospdf->execute();
      return $mostrardatospdf->fetchAll(PDO::FETCH_NUM);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }





  public function MostrarCompraComprobante()
  {
    try {

      $stmmostrarcompracomprobante = $this->bd->prepare("SELECT TOC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,TC.COD_TMPCOMPROBANTE AS COD_TMPCOMPROBANTE,TC.FECHA_REALIZADA AS FECHA_REALIZADA,
                                                          TP.NOM_PROVEEDOR AS NOM_PROVEEDOR, TE.NOMBRE AS NOMBRE FROM T_TMPORDEN_COMPRA TOC 
                                                          INNER JOIN T_TMPCOMPROBANTE TC ON TOC.COD_ORDEN_COMPRA=TC.COD_ORDEN_COMPRA
                                                          INNER JOIN T_PROVEEDOR TP ON TP.COD_PROVEEDOR=TC.COD_PROVEEDOR
                                                          INNER JOIN T_EMPRESA TE ON TE.COD_EMPRESA=TC.COD_EMPRESA WHERE TC.ESTADO='P'");
      $stmmostrarcompracomprobante->execute();
      $datoscompra = $stmmostrarcompracomprobante->fetchAll(PDO::FETCH_OBJ);

      return $datoscompra;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarValoresOrdenfactura($codigoComprobante)
  {
    try {

      $stmponervaloresfact = $this->bd->prepare("SELECT TC.COD_EMPRESA AS COD_EMPRESA,TP.NOM_PROVEEDOR,TC.F_PAGO AS F_PAGO,
                                                  TC.TIPO_MONEDA AS TIPO_MONEDA, TC.OBSERVACION AS OBSERVACION FROM T_TMPCOMPROBANTE TC
                                                  INNER JOIN T_PROVEEDOR TP ON TP.COD_PROVEEDOR=TC.COD_PROVEEDOR
                                                  WHERE TC.COD_TMPCOMPROBANTE='$codigoComprobante'");
      $stmponervaloresfact->execute();
      $datosfactura = $stmponervaloresfact->fetchAll(PDO::FETCH_OBJ);

      return $datosfactura;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function PonerPersonalUsu($codpersonalusu)
  {
    try {

      $stmponerpersonal = $this->bd->prepare("SELECT TU.COD_USUARIO AS COD_USUARIO,TP.COD_PERSONAL AS COD_PERSONAL, TP.NOM_PERSONAL AS NOM_PERSONAL FROM T_USUARIO TU 
                                                INNER JOIN T_PERSONAL TP ON TP.COD_PERSONAL=TU.COD_PERSONAL WHERE TU.COD_USUARIO='$codpersonalusu'");
      $stmponerpersonal->execute();
      $datospersonal = $stmponerpersonal->fetchAll(PDO::FETCH_OBJ);

      return $datospersonal;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarPonerValoresComprarFactura($codigoComprobantemostrar)
  {
    try {

      $stmponer = $this->bd->prepare("SELECT TP.DES_PRODUCTO AS DES_PRODUCTO, TOI.CANTIDAD_MINIMA AS CANTIDAD_MINIMA, TOI.MONTO AS MONTO FROM T_TMPORDEN_COMPRA_ITEM TOI
                                                  INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TOI.COD_PRODUCTO WHERE TOI.COD_TMPCOMPROBANTE='$codigoComprobantemostrar'");
      $stmponer->execute();
      $datosf = $stmponer->fetchAll(PDO::FETCH_OBJ);

      return $datosf;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarTipoCambioSunat()
  {
    try {

      $stmmostrartipocambio = $this->bd->prepare("SELECT TOP 1 FECHA, VENTA FROM T_TIPOCAMBIO ORDER BY FECHA DESC");
      $stmmostrartipocambio->execute();
      $datostipocambio = $stmmostrartipocambio->fetchAll(PDO::FETCH_OBJ);

      return $datostipocambio;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function GuardarDatosFactura($idcomprobantecaptura, $empresa, $fecha_emision, $hora, $fecha_entrega, $codusu, $selecttipocompro, $selectformapago, $selectmoneda, $tipocambio, $serie, $correlativo, $observacion, $imagen)
  {
    try {
      $this->bd->beginTransaction();
      $codigo = new m_almacen();

      //   $nombre = 'ordencompra';
      //  $codigo->generarVersionGeneral($nombre);

      $fechaFormateadaIncio = DateTime::createFromFormat('Y-m-d', $fecha_emision);
      $fecha_emision_formato = $fechaFormateadaIncio->format('d/m/Y');

      $fechaFormateadaposterga = DateTime::createFromFormat('Y-m-d', $fecha_entrega);
      $fecha_entrega_formato = $fechaFormateadaposterga->format('d/m/Y');


      if ($tipocambio) {
        $insertarfacturacompra = $this->bd->prepare("INSERT INTO T_TMPCOMPROBANTE_ITEM(COD_TMPCOMPROBANTE,SERIE,CORRELATIVO,COD_EMPRESA,TIPO_MONEDA,F_PAGO,FECHA_EMISION,HORA,FECHA_ENTREGA,TIPO_COMPROBANTE,OBSERVACION,COD_USUARIO,TIPO_VENTA,PDF)
                                                       VALUES('$idcomprobantecaptura','$serie','$correlativo','$empresa','$selectmoneda','$selectformapago',' $fecha_emision_formato','$hora','$fecha_entrega_formato','$selecttipocompro','$observacion','$codusu','$tipocambio',$imagen)");
      } else {
        $insertarfacturacompra = $this->bd->prepare("INSERT INTO T_TMPCOMPROBANTE_ITEM(COD_TMPCOMPROBANTE,SERIE,CORRELATIVO,COD_EMPRESA,TIPO_MONEDA,F_PAGO,FECHA_EMISION,HORA,FECHA_ENTREGA,TIPO_COMPROBANTE,OBSERVACION,COD_USUARIO,PDF)
                                                        VALUES('$idcomprobantecaptura','$serie','$correlativo','$empresa','$selectmoneda','$selectformapago','$fecha_emision_formato','$hora','$fecha_entrega_formato','$selecttipocompro','$observacion','$codusu',$imagen)");
      }

      $insertfactura = $insertarfacturacompra->execute();

      $actualizarcomprobante = $this->bd->prepare("UPDATE T_TMPCOMPROBANTE SET ESTADO='C' WHERE COD_TMPCOMPROBANTE='$idcomprobantecaptura'");
      $actualizarcomprobante->execute();

      $insertfactura = $this->bd->commit();
      return $insertfactura;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function MostrarFacturaProveedorPDF($requerimiento)
  {
    try {
      $mostrardatospdf = $this->bd->prepare("SELECT TC.COD_TMPCOMPROBANTE AS COD_TMPCOMPROBANTE , CONVERT(VARCHAR, TC.FECHA_REALIZADA, 105) AS FECHA_REALIZADA, 
      TC.HORA AS HORA, TP.NOM_PROVEEDOR AS NOM_PROVEEDOR,TC.MONTO_TOTAL AS MONTO_TOTAL, TOR.COD_REQUERIMIENTO AS COD_REQUERIMIENTO FROM T_TMPCOMPROBANTE TC
      INNER JOIN T_PROVEEDOR TP ON TP.COD_PROVEEDOR = TC.COD_PROVEEDOR
      INNER JOIN T_TMPORDEN_COMPRA TOR ON TOR.COD_ORDEN_COMPRA=TC.COD_ORDEN_COMPRA WHERE TOR.COD_REQUERIMIENTO='$requerimiento'");
      $mostrardatospdf->execute();
      $datosfactura = $mostrardatospdf->fetchAll(PDO::FETCH_OBJ);

      return $datosfactura;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarFacturaItemPDF($codtmpcomprobante)
  {
    try {

      $mostrardatospdf = $this->bd->prepare("SELECT TOI.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA, TOI.COD_PRODUCTO AS COD_PRODUCTO, TP.DES_PRODUCTO AS DES_PRODUCTO,
                                              TOI.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,TOI.MONTO AS MONTO, TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR FROM T_TMPORDEN_COMPRA_ITEM TOI
                                              INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TOI.COD_PRODUCTO
                                              INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=TOI.COD_PRODUCTO WHERE TOI.COD_ORDEN_COMPRA='$codtmpcomprobante'");
      $mostrardatospdf->execute();
      return $mostrardatospdf->fetchAll(PDO::FETCH_NUM);
      // $datosfactura = $mostrardatospdf->fetchAll(PDO::FETCH_OBJ);

      // return $datosfactura;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarImagenFactura($codigorequerimiento, $codigoproveedor)
  {
    try {

      $mostrardatospdf = $this->bd->prepare("SELECT * FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$codigorequerimiento' AND COD_PROVEEDOR='$codigoproveedor'");
      $mostrardatospdf->execute();
      $resultado = $mostrardatospdf->fetchAll(PDO::FETCH_NUM);

      return $resultado;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage() . " linea " . $e->getLine() . " arch " . $e->getFile();
      error_log($e->getMessage());
    }
  }

  public function actualizar_requerimiento_item($codrequerimiento, $valoresorden)
  {
    try {
      $this->bd->beginTransaction();
      $mostrar = new m_almacen();
      var_dump("codreque" . $codrequerimiento);
      var_dump($valoresorden);
      exit;
      foreach ($valoresorden as $row) {
        $codigocompraorde = $row['codigocompraorde'];
        $codtempreque = $row['codtempreque'];
        $codigoproductocompra = $row['codigoproductocompra'];
        $codigoproveedororden = $row['codigoproveedororden'];
        $cantidadpedida = floatval($row['cantidadpedida']);
        $cantidadllegada = $row['cantidadllegada'];

        // $resultado = $cantidadpedida - $cantidadllegada;
        if ($cantidadllegada == "true") {
          $codigoproducto = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigocompraorde' AND COD_PROVEEDOR='$codigoproveedororden' AND COD_REQUERIMIENTO='$codrequerimiento'");
          $codigoproducto->execute();
          $codigoproducto = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET CANTIDAD_LLEGADA='1', ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigocompraorde' AND COD_PRODUCTO='$codigoproductocompra'");
          $codigoproducto->execute();

          $buscarcodigoeninsumo = $this->bd->prepare("SELECT MAX(COD_PRODUCTO) AS COD_PRODUCTO FROM T_TMPREQUERIMIENTO_INSUMO WHERE COD_REQUERIMIENTO='$codrequerimiento' AND COD_PRODUCTO='$codigoproductocompra'");
          $buscarcodigoeninsumo->execute();
          $resultadoproductocodigo = $buscarcodigoeninsumo->fetch(PDO::FETCH_ASSOC);
          $codigoinsumorequerimiento = $resultadoproductocodigo['COD_PRODUCTO'];

          if ($codigoinsumorequerimiento != NULL) {
            $codigoproductoinsumo = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_INSUMO SET ESTADO='C' WHERE COD_REQUERIMIENTO='$codrequerimiento' AND COD_PRODUCTO='$codigoproductocompra'");
            $codigoproductoinsumo->execute();
          } else {
            $codigoproductoenvase = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ENVASE SET ESTADO='C' WHERE COD_REQUERIMIENTO='$codrequerimiento' AND COD_PRODUCTO='$codigoproductocompra'");
            $codigoproductoenvase->execute();
          }
        } else {
          $codigoproducto = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET CANTIDAD_LLEGADA='0' WHERE COD_ORDEN_COMPRA='$codigocompraorde' AND COD_PRODUCTO='$codigoproductocompra'");
          $codigoproducto->execute();
        }
      }

      $codigoproducto = $this->bd->commit();
      return $codigoproducto;
    } catch (Exception $e) {
      $this->bd->rollBack();
      // die($e->getMessage());
      echo "Error: " . $e->getMessage();
      return false;
    }
  }


  public function MostrarRequerimientoEstadoT()
  {
    try {

      $mostrarrequerimiento = $this->bd->prepare("SELECT DISTINCT COD_REQUERIMIENTO FROM T_TMPORDEN_COMPRA WHERE ESTADO='P'");
      $mostrarrequerimiento->execute();
      $datosrequerimiento = $mostrarrequerimiento->fetchAll(PDO::FETCH_OBJ);

      return $datosrequerimiento;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarValoresPorCodigoRequerimiento($selectrequerimiento)
  {
    try {
      $mostrarrequerimiento = $this->bd->prepare("SELECT RI.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,RI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
      RI.CANTIDAD AS CANTIDAD,RI.TOTAL_PRODUCTO AS TOTAL_PRODUCTO FROM T_TMPREQUERIMIENTO_ITEM RI 
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=RI.COD_PRODUCTO WHERE RI.COD_REQUERIMIENTO='$selectrequerimiento'");

      $mostrarrequerimiento->execute();
      $datosrequerimiento = $mostrarrequerimiento->fetchAll(PDO::FETCH_OBJ);

      return $datosrequerimiento;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarValoresComprobante($selectrequerimiento)
  {
    try {
      $mostrarvalorcomprobante = $this->bd->prepare("SELECT OC.COD_ORDEN_COMPRA AS COD_ORDEN_COMPRA,OC.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,OC.FECHA_REALIZADA AS FECHA_REALIZADA,TI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,TP.COD_PRODUCCION AS COD_PRODUCCION,
            TI.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE,TI.MONTO AS MONTO, OC.COD_PROVEEDOR AS COD_PROVEEDOR,TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR,CONVERT(VARCHAR, GETDATE(), 23) AS FECHA_EMISION  FROM T_TMPORDEN_COMPRATEMP OC 
            INNER JOIN T_TMPORDEN_COMPRA_ITEMTEMP TI ON OC.COD_ORDEN_COMPRA=TI.COD_ORDEN_COMPRA
            INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TI.COD_PRODUCTO
            INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=OC.COD_PROVEEDOR WHERE OC.COD_REQUERIMIENTO='$selectrequerimiento' AND CAST(TI.FECHA_ENTREGA AS DATE) <= CAST(GETDATE() AS DATE) AND TI.ESTADO='P'");

      $mostrarvalorcomprobante->execute();
      $datosvalorcomprobante = $mostrarvalorcomprobante->fetchAll(PDO::FETCH_OBJ);

      return $datosvalorcomprobante;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function generarcodigocontrolrecepcion()
  {
    $stm = $this->bd->prepare("SELECT MAX(COD_TMPCONTROL_RECEPCION_COMPRAS) AS COD_TMPCONTROL_RECEPCION_COMPRAS FROM T_TMPCONTROL_RECEPCION_COMPRAS");
    $stm->execute();
    $resultado = $stm->fetch(PDO::FETCH_ASSOC);


    $maxCodigo = intval($resultado['COD_TMPCONTROL_RECEPCION_COMPRAS']);

    $nuevoCodigo = $maxCodigo + 1;
    $codigoAumento = str_pad($nuevoCodigo, 9, '0', STR_PAD_LEFT);
    return $codigoAumento;
  }

  public function InsertarControlRecepcion($datos, $datosTabla, $idrequerimiento, $codpersonal)
  {
    try {
      $this->bd->beginTransaction();

      $codigo = new m_almacen();
      $codigorecepcion = $codigo->generarcodigocontrolrecepcion();
      $nombre = 'LBS-BPM-FR-09';

      if ($datosTabla) {

        $insertarecepcioncompras = $this->bd->prepare("INSERT INTO T_TMPCONTROL_RECEPCION_COMPRAS(COD_TMPCONTROL_RECEPCION_COMPRAS, CODIGO_PERSONAL, COD_REQUERIMIENTO)
                                                      VALUES('$codigorecepcion','$codpersonal','$idrequerimiento')");
        $insert = $insertarecepcioncompras->execute();

        foreach ($datos as $dato) {
          $codigoordencompra = $dato["codigoordencompra"];
          $fechaingresoC = $dato["fechaingreso"];

          $hora = $dato["hora"];
          $producto = trim($dato["producto"]);
          $codigolote = $dato["codigolote"];
          $fechav = $dato["fechavencimiento"];
          $proveedor = $dato["proveedor"];
          $remision = $dato["remision"];
          $boleta = $dato["boleta"];
          $factura = $dato["factura"];
          if ($remision == "1") {
            $remision = 'C';
          } else {
            $remision = 'V';
          }
          if ($boleta == "1") {
            $boleta = 'C';
          } else {
            $boleta = 'V';
          }
          if ($factura == "1") {
            $factura = 'C';
          } else {
            $factura = 'V';
          }
          $gbf = $dato["numerofactura"];
          $primario = $dato["primario"];
          $secundario = $dato["secundario"];
          $saco = $dato["saco"];
          $caja = $dato["caja"];
          $cilindro = $dato["cilindro"];
          $bolsa = $dato["bolsa"];

          if ($primario == "1") {
            $primario = 'C';
          } else {
            $primario = 'V';
          }
          if ($secundario == "1") {
            $secundario = 'C';
          } else {
            $secundario = 'V';
          }
          if ($saco == "1") {
            $saco = 'C';
          } else {
            $saco = 'V';
          }
          if ($caja == "1") {
            $caja = 'C';
          } else {
            $caja = 'V';
          }
          if ($cilindro == "1") {
            $cilindro = 'C';
          } else {
            $cilindro = 'V';
          }
          if ($bolsa == "1") {
            $bolsa = 'C';
          } else {
            $bolsa = 'V';
          }
          $cantidadminima =  floatval($dato["cantidadminima"]);
          $eih =  $dato["eih"];
          $cdc =  $dato["cdc"];
          $rotulacion =  $dato["rotulacion"];
          $aplicacion =  $dato["aplicacion"];
          $higienesalud =  $dato["higienesalud"];
          $indumentaria =  $dato["indumentaria"];
          $limpio =  $dato["limpio"];
          $exclusivo =  $dato["exclusivo"];
          $hermetico =  $dato["hermetico"];
          $ausencia =  $dato["ausencia"];
          if ($eih == "1") {
            $eih =  'C';
          } else {
            $eih =  'A';
          }
          if ($cdc == "1") {
            $cdc =  'C';
          } else {
            $cdc =  'A';
          }
          if ($rotulacion == "1") {
            $rotulacion =  'C';
          } else {
            $rotulacion =  'A';
          }
          if ($aplicacion == "1") {
            $aplicacion =  'C';
          } else {
            $aplicacion =  'A';
          }
          if ($higienesalud == "1") {
            $higienesalud =  'C';
          } else {
            $higienesalud =  'A';
          }
          if ($indumentaria == "1") {
            $indumentaria =  'C';
          } else {
            $indumentaria =  'A';
          }
          if ($limpio == "1") {
            $limpio =  'C';
          } else {
            $limpio =  'A';
          }
          if ($exclusivo == "1") {
            $exclusivo =  'C';
          } else {
            $exclusivo =  'A';
          }
          if ($hermetico == "1") {
            $hermetico =  'C';
          } else {
            $hermetico =  'A';
          }
          if ($ausencia == "1") {
            $ausencia = 'C';
          } else {
            $ausencia = 'A';
          }


          $insertarrecepcion = $this->bd->prepare("INSERT INTO T_TMPCONTROL_RECEPCION_COMPRAS_ITEM(COD_TMPCONTROL_RECEPCION_COMPRAS, COD_ORDEN_COMPRA,FECHA_INGRESO, HORA, CODIGO_LOTE,COD_PRODUCTO, FECHA_VENCIMIENTO,COD_PROVEEDOR, GUIA, BOLETA, FACTURA, GBF, PRIMARIO, SECUNDARIO, SACO, CAJA, CILINDRO, BOLSA, CANTIDAD_MINIMA, ENVASE, CERTIFICADO, ROTULACION, APLICACION, HIGIENE, INDUMENTARIA, LIMPIO, EXCLUSIVO, HERMETICO, AUSENCIA)
          VALUES('$codigorecepcion','$codigoordencompra',CONVERT(DATE, '$fechaingresoC', 103),'$hora','$codigolote','$producto',CAST('$fechav' AS DATE),'$proveedor','$remision','$boleta','$factura','$gbf','$primario','$secundario','$saco','$caja','$cilindro','$bolsa','$cantidadminima','$eih','$cdc','$rotulacion','$aplicacion','$higienesalud','$indumentaria','$limpio','$exclusivo','$hermetico','$ausencia')");

          $insertarrecepcion->execute();

          $abrproducto = $this->bd->prepare("SELECT ABR_PRODUCTO  FROM T_PRODUCTO WHERE COD_PRODUCTO='$producto'");
          $abrproducto->execute();
          $abrprod = $abrproducto->fetch(PDO::FETCH_ASSOC);
          $valorabrprod = $abrprod['ABR_PRODUCTO'];

          /*FUNCION PARA AGREGAR A LA TABLA T_TMPKARDEX_PRODUCCION*/

          $respuestacodigokardex = $this->bd->prepare("SELECT MAX(CODIGO) AS CODIGO  FROM T_TMPKARDEX_PRODUCCION WHERE COD_PRODUCTO='$producto' ORDER BY CODIGO ASC");
          $respuestacodigokardex->execute();
          $codigokardex = $respuestacodigokardex->fetch(PDO::FETCH_ASSOC);
          $valorcodigokar = $codigokardex['CODIGO'];

          $cantidadkardex = $this->bd->prepare("SELECT KARDEX FROM T_TMPKARDEX_PRODUCCION WHERE CODIGO='$valorcodigokar'");
          $cantidadkardex->execute();
          $kardexcantidad = $cantidadkardex->fetch(PDO::FETCH_ASSOC);
          $valorkardexnuevo = $kardexcantidad['KARDEX'];


          $valoralmacenx = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$producto'");
          $valoralmacenx->execute();
          $cantidadalmacenx = $valoralmacenx->fetch(PDO::FETCH_ASSOC);
          $valoralmacencantidadx = $cantidadalmacenx['STOCK_ACTUAL'];

          $hora_actual = $codigo->c_horaserversql('H');
          $saldo = $this->m_saldolote($codigolote, $producto);
          $valores = 0;
          $kardex = 0;
          if (count($saldo) != 0) {
            $valores = $saldo[0][3];
          } else {
            // $valores = 0;
            $valores = $valoralmacencantidadx;
          }

          if ($valorkardexnuevo > 0) {
            $kardex = $valorkardexnuevo;
          } else {
            // $kardex = 0;
            $kardex = $valoralmacencantidadx;
          }

          $ltresta = number_format($valores + $cantidadminima, 3);
          $lkardex = number_format($kardex + $cantidadminima, 3);

          $kardexegresos = $this->bd->prepare("SELECT CANT_EGRESO  FROM T_TMPKARDEX_PRODUCCION WHERE CODIGO='$valorcodigokar'");
          $kardexegresos->execute();
          $valoregresos = $kardexegresos->fetch(PDO::FETCH_ASSOC);
          $egresos = $valoregresos['CANT_EGRESO'];
          if ($egresos != NULL) {
            $actualizarkardex = $this->bd->prepare("UPDATE T_TMPKARDEX_PRODUCCION SET KARDEX=CONVERT(numeric(9,2), REPLACE('$lkardex', ',', ''), 1) WHERE CODIGO='$valorcodigokar'");
            $actualizarkardex->execute();
          }

          $descripcion = 'INGRESO DE LA FACTURA - ' . $gbf; //descripcion de la compra cambiar la descripcion

          $querylote = $this->bd->prepare("INSERT INTO T_TMPKARDEX_PRODUCCION(COD_PRODUCTO,ABR_PRODUCTO,
            LOTE,
            DESCRIPCION,
            COD_INGRESO,
            CANT_INGRESO,
            SALDO,
            USU_REGISTRO,
            HORA_REGISTRO,
            KARDEX) 
            VALUES(
            '$producto',
            '$valorabrprod',
            '$codigolote',
            '$descripcion'
            ,'$codigorecepcion', 
            '$cantidadminima'
            ,CONVERT(numeric(9,2), REPLACE('$ltresta', ',', ''), 1)
            ,'$codpersonal'
            ,'$hora_actual'
            ,CONVERT(numeric(9,2), REPLACE('$lkardex', ',', ''), 1)
            )");
          $querylote->execute();


          $stockanteriorx = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$producto'");
          $stockanteriorx->execute();
          $cantidadstockx = $stockanteriorx->fetch(PDO::FETCH_ASSOC);
          $canstockx = $cantidadstockx['STOCK_ACTUAL'];
          $sumatotalstockx = floatval($canstockx + $cantidadminima);


          $actualizoalmaceninsumoi = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET STOCK_ACTUAL='$sumatotalstockx',STOCK_ANTERIOR='$canstockx' WHERE COD_PRODUCTO='$producto'");
          $actualizoalmaceninsumoi->execute();

          $actualizoalmaceninsumoi = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOSTEMP SET STOCK_ACTUAL='$sumatotalstockx',STOCK_ANTERIOR='$canstockx' WHERE COD_PRODUCTO='$producto'");
          $actualizoalmaceninsumoi->execute();

          $actualizo = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET CANTIDAD_LLEGADA='$cantidadminima' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
          $actualizo->execute();

          $actualizote = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET CANTIDAD_LLEGADA='$cantidadminima' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
          $actualizote->execute();

          $ver = $this->bd->prepare("SELECT CANTIDAD_LLEGADA FROM T_TMPORDEN_COMPRA_ITEM WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento'");
          $ver->execute();
          $valorcantidadllegada = $ver->fetch(PDO::FETCH_ASSOC);
          $canllegadax = $valorcantidadllegada['CANTIDAD_LLEGADA'];

          $can = $this->bd->prepare("SELECT CANTIDAD_INSUMO_ENVASE FROM T_TMPORDEN_COMPRA_ITEMTEMP WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento'AND COD_PRODUCTO='$producto'");
          $can->execute();
          $valorcantida = $can->fetch(PDO::FETCH_ASSOC);
          $cantidax = floatval($valorcantida['CANTIDAD_INSUMO_ENVASE']);

          // $cantid = floatval($cantidadminima);

          if ($cantidadminima == $cantidax) {
            $modifica = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            $modifica->execute();

            // $modificaordencompraestado = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_REQUERIMIENTO='$idrequerimiento' AND COD_PROVEEDOR='$proveedor'");
            // $modificaordencompraestado->execute();

            $modificaitem = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento'");
            $modificaitem->execute();
            $modificaordencompraestado = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRATEMP SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_REQUERIMIENTO='$idrequerimiento' AND COD_PROVEEDOR='$proveedor'");
            $modificaordencompraestado->execute();
          } else {
            $modificaordencompraestadoz = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRATEMP SET ESTADO='F' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_REQUERIMIENTO='$idrequerimiento' AND COD_PROVEEDOR='$proveedor'");
            $modificaordencompraestadoz->execute();

            $modificaz = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET ESTADO='F' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            $modificaz->execute();
          }
        }

        foreach ($datosTabla as $datot) {
          $codproductos = $datot["productoc"];
          $idcheck = $datot["idc"];
          $fechaC = $datot["Fechax"];
          $fechaConvertida = date_create($fechaC);
          $fecha = date_format($fechaConvertida, 'Y-m-d');

          $observacion = $datot["Observacionx"];
          $accioncorrectivaobs = $datot["AccionCorrectivax"];

          $insertarobs = $this->bd->prepare("INSERT INTO T_TMPCONTROL_RECEPCION_COMPRAS_OBSERVACION(COD_TMPCONTROL_RECEPCION_COMPRAS, FECHA, COD_PRODUCTO, ACCION_CORRECTIVA, OBSERVACION, IDCHECK)
                            VALUES('$codigorecepcion','$fecha','$codproductos','$accioncorrectivaobs','$observacion','$idcheck')");
          $insertarobs->execute();
        }

        $verificarr = $this->bd->prepare("SELECT COD_PRODUCTO, SUM(CAST(CANTIDAD_MINIMA AS DECIMAL(15, 2))) AS SUMA_TOTAL
                                         FROM T_TMPCONTROL_RECEPCION_COMPRAS_ITEM WHERE COD_TMPCONTROL_RECEPCION_COMPRAS='$codigorecepcion'
                                         GROUP BY COD_PRODUCTO");
        $verificarr->execute();
        $totalsumar = $verificarr->fetchAll(PDO::FETCH_ASSOC);

        foreach ($totalsumar as $rowr) {
          $codigoproductor = $rowr["COD_PRODUCTO"];
          $sumatotalproductor = $rowr["SUMA_TOTAL"];

          $actualizatotalprod = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET INGRESO='$sumatotalproductor' WHERE COD_PRODUCTO='$codigoproductor'");
          $actualizatotalprod->execute();
        }
      } else {

        $insertarecepcioncompras = $this->bd->prepare("INSERT INTO T_TMPCONTROL_RECEPCION_COMPRAS(COD_TMPCONTROL_RECEPCION_COMPRAS, CODIGO_PERSONAL, COD_REQUERIMIENTO)
                                                          VALUES('$codigorecepcion','$codpersonal','$idrequerimiento')");
        $insert = $insertarecepcioncompras->execute();


        foreach ($datos as $dato) {
          $codigoordencompra = $dato["codigoordencompra"];
          $fechaingresoC = $dato["fechaingreso"];

          $hora = $dato["hora"];

          $producto = trim($dato["producto"]);
          $codigolote = trim($dato["codigolote"]);
          $fechaven = $dato["fechavencimiento"];

          $proveedor = $dato["proveedor"];
          $remisionx = $dato["remision"];
          $boletax = $dato["boleta"];
          $facturax = $dato["factura"];

          if ($remisionx == "1") {
            $remisionx = 'C';
          } else {
            $remisionx = 'V';
          }
          if ($boletax == "1") {
            $boletax = 'C';
          } else {
            $boletax = 'V';
          }
          if ($facturax == "1") {
            $facturax = 'C';
          } else {
            $facturax = 'V';
          }
          $gbfx = $dato["numerofactura"];
          $primariox = $dato["primario"];

          $secundariox = $dato["secundario"];
          $sacox = $dato['saco'];
          $cajax = $dato["caja"];
          $cilindrox = $dato["cilindro"];
          $bolsax = $dato["bolsa"];

          if ($primariox == "1") {
            $primariox = 'C';
          } else {
            $primariox = 'V';
          }
          if ($secundariox == "1") {
            $secundariox = 'C';
          } else {
            $secundariox = 'V';
          }
          if ($sacox == "1") {
            $sacox = 'C';
          } else {
            $sacox = 'V';
          }
          if ($cajax == "1") {
            $cajax = 'C';
          } else {
            $cajax = 'V';
          }
          if ($cilindrox == "1") {
            $cilindrox = 'C';
          } else {
            $cilindrox = 'V';
          }
          if ($bolsax == "1") {
            $bolsax = 'C';
          } else {
            $bolsax = 'V';
          }
          $cantidadminimas =  floatval($dato["cantidadminima"]);

          $eihx = $dato["eih"];
          $cdcx =  $dato["cdc"];
          $rotulacionx = $dato["rotulacion"];
          $aplicacionx =  $dato["aplicacion"];
          $higienesaludx =  $dato["higienesalud"];
          $indumentariax =  $dato["indumentaria"];
          $limpiox =  $dato["limpio"];
          $exclusivox =  $dato["exclusivo"];
          $hermeticox =  $dato["hermetico"];
          $ausenciax =  $dato["ausencia"];
          if ($eihx == "1") {
            $eihx =  'C';
          } else {
            $eihx =  'A';
          }
          if ($cdcx == "1") {
            $cdcx =  'C';
          } else {
            $cdcx =  'A';
          }
          if ($rotulacionx == "1") {
            $rotulacionx =  'C';
          } else {
            $rotulacionx =  'A';
          }
          if ($aplicacionx == "1") {
            $aplicacionx =  'C';
          } else {
            $aplicacionx =  'A';
          }
          if ($higienesaludx == "1") {
            $higienesaludx =  'C';
          } else {
            $higienesaludx =  'A';
          }
          if ($indumentariax == "1") {
            $indumentariax =  'C';
          } else {
            $indumentariax =  'A';
          }
          if ($limpiox == "1") {
            $limpiox =  'C';
          } else {
            $limpiox =  'A';
          }
          if ($exclusivox == "1") {
            $exclusivox =  'C';
          } else {
            $exclusivox =  'A';
          }
          if ($hermeticox == "1") {
            $hermeticox =  'C';
          } else {
            $hermeticox =  'A';
          }
          if ($ausenciax == "1") {
            $ausenciax = 'C';
          } else {
            $ausenciax = 'A';
          }
          $insertarrecepcion = $this->bd->prepare("INSERT INTO T_TMPCONTROL_RECEPCION_COMPRAS_ITEM(COD_TMPCONTROL_RECEPCION_COMPRAS, COD_ORDEN_COMPRA,FECHA_INGRESO, HORA, CODIGO_LOTE,COD_PRODUCTO, FECHA_VENCIMIENTO,COD_PROVEEDOR, GUIA, BOLETA, FACTURA, GBF, PRIMARIO, SECUNDARIO, SACO, CAJA, CILINDRO, BOLSA, CANTIDAD_MINIMA, ENVASE, CERTIFICADO, ROTULACION, APLICACION, HIGIENE, INDUMENTARIA, LIMPIO, EXCLUSIVO, HERMETICO, AUSENCIA)
          VALUES('$codigorecepcion','$codigoordencompra',CONVERT(DATE, '$fechaingresoC', 103),'$hora','$codigolote','$producto',CAST('$fechaven' AS DATE),'$proveedor','$remisionx','$boletax','$facturax','$gbfx','$primariox','$secundariox','$sacox','$cajax','$cilindrox','$bolsax','$cantidadminimas','$eihx','$cdcx','$rotulacionx','$aplicacionx','$higienesaludx','$indumentariax','$limpiox','$exclusivox','$hermeticox','$ausenciax')");

          $insertarrecepcion->execute();

          $abrproducto = $this->bd->prepare("SELECT ABR_PRODUCTO  FROM T_PRODUCTO WHERE COD_PRODUCTO='$producto'");
          $abrproducto->execute();
          $abrprod = $abrproducto->fetch(PDO::FETCH_ASSOC);
          $valorabrprod = $abrprod['ABR_PRODUCTO'];

          /*FUNCION PARA AGREGAR A LA TABLA T_TMPKARDEX_PRODUCCION*/

          $respuestacodigokardex = $this->bd->prepare("SELECT MAX(CODIGO) AS CODIGO  FROM T_TMPKARDEX_PRODUCCION WHERE COD_PRODUCTO='$producto' ORDER BY CODIGO ASC");
          $respuestacodigokardex->execute();
          $codigokardex = $respuestacodigokardex->fetch(PDO::FETCH_ASSOC);
          $valorcodigokar = $codigokardex['CODIGO'];

          $cantidadkardex = $this->bd->prepare("SELECT KARDEX FROM T_TMPKARDEX_PRODUCCION WHERE CODIGO='$valorcodigokar'");
          $cantidadkardex->execute();
          $kardexcantidad = $cantidadkardex->fetch(PDO::FETCH_ASSOC);
          $valorkardexnuevo = $kardexcantidad['KARDEX'];
          // $valorkardexsaldo = $kardexcantidad['SALDO'];

          $valoralmacen = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$producto'");
          $valoralmacen->execute();
          $cantidadalmacen = $valoralmacen->fetch(PDO::FETCH_ASSOC);
          $valoralmacencantidad = $cantidadalmacen['STOCK_ACTUAL'];


          $hora_actual = $codigo->c_horaserversql('H');
          $saldo = $this->m_saldolote($codigolote, $producto);
          $valores = 0;
          $kardex = 0;
          if (count($saldo) != 0) {

            $valores = $saldo[0][3];
          } else {

            $valores = $valoralmacencantidad;
          }
          if ($valorkardexnuevo > 0) {
            $kardex = $valorkardexnuevo;
          } else {
            $kardex = $valoralmacencantidad;
          }


          $ltresta = number_format($valores + $cantidadminimas, 2);
          $lkardex = number_format($kardex + $cantidadminimas, 2);


          $kardexegresos = $this->bd->prepare("SELECT CANT_EGRESO  FROM T_TMPKARDEX_PRODUCCION WHERE CODIGO='$valorcodigokar'");
          $kardexegresos->execute();
          $valoregresos = $kardexegresos->fetch(PDO::FETCH_ASSOC);
          $egresos = $valoregresos['CANT_EGRESO'];
          if ($egresos != NULL) {
            $actualizarkardex = $this->bd->prepare("UPDATE T_TMPKARDEX_PRODUCCION SET KARDEX=CONVERT(numeric(9,2), REPLACE('$lkardex', ',', ''), 1) WHERE CODIGO='$valorcodigokar'");
            $actualizarkardex->execute();
          }
          $descripcion = 'INGRESO DE LA FACTURA - ' . $gbfx; //descripcion de la compra cambiar la descripcion

          $querylote = $this->bd->prepare("INSERT INTO T_TMPKARDEX_PRODUCCION(
            COD_PRODUCTO,
            ABR_PRODUCTO,
            LOTE,
            DESCRIPCION,
            COD_INGRESO,
            CANT_INGRESO,
            SALDO,
            USU_REGISTRO,
            HORA_REGISTRO,
            KARDEX,
            ESTADO) 
            VALUES(
            '$producto',
            '$valorabrprod',
            '$codigolote',
            '$descripcion'
            ,'$codigorecepcion', 
           '$cantidadminimas'
            ,CONVERT(numeric(9,2), REPLACE('$ltresta', ',', ''), 1)
            ,'$codpersonal'
            ,'$hora_actual'
            ,CONVERT(numeric(9,2), REPLACE('$lkardex', ',', ''), 1),
            'I'
            )");
          $querylote->execute();

          $stockanteriorx = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOS WHERE COD_PRODUCTO='$producto'");
          $stockanteriorx->execute();
          $cantidadstockx = $stockanteriorx->fetch(PDO::FETCH_ASSOC);
          $canstockx = $cantidadstockx['STOCK_ACTUAL'];
          $sumatotalstockxs = floatval($canstockx + $cantidadminimas);


          $actualizoalmaceninsumoi = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET STOCK_ACTUAL='$sumatotalstockxs',STOCK_ANTERIOR='$canstockx' WHERE COD_PRODUCTO='$producto'");
          $actualizoalmaceninsumoi->execute();
          $actualizoalmacenin = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOSTEMP SET STOCK_ACTUAL='$sumatotalstockxs',STOCK_ANTERIOR='$canstockx' WHERE COD_PRODUCTO='$producto'");
          $actualizoalmacenin->execute();

          $actualizo = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET CANTIDAD_LLEGADA='$cantidadminimas' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
          $actualizo->execute();

          $actualizote = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET CANTIDAD_LLEGADA='$cantidadminimas' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
          $actualizote->execute();

          $ver = $this->bd->prepare("SELECT CANTIDAD_LLEGADA FROM T_TMPORDEN_COMPRA_ITEM WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento'");
          $ver->execute();
          $valorcantidadllegada = $ver->fetch(PDO::FETCH_ASSOC);
          $canllegadax = $valorcantidadllegada['CANTIDAD_LLEGADA'];

          $can = $this->bd->prepare("SELECT CANTIDAD_INSUMO_ENVASE FROM T_TMPORDEN_COMPRA_ITEMTEMP WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento'AND COD_PRODUCTO='$producto'");
          $can->execute();
          $valorcantida = $can->fetch(PDO::FETCH_ASSOC);
          $cantidax = floatval($valorcantida['CANTIDAD_INSUMO_ENVASE']);

          //   // $cantid = floatval($cantidadminimas);


          //   // $calculoinsumoenvase = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_TMPREQUERIMIENTO_INSUMO WHERE COD_REQUERIMIENTO='$idrequerimiento' AND COD_PRODUCTO='$producto'");
          //   // $calculoinsumoenvase->execute();
          //   // $totalinsumoenvase = $calculoinsumoenvase->fetch(PDO::FETCH_ASSOC);
          //   // $siexiste = intval($totalinsumoenvase['COUNT']);


          if ($cantidadminimas == $cantidax) {
            $modifica = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            $modifica->execute();

            $modificaalerta = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            $modificaalerta->execute();

            $modificaordencompraestado = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRATEMP SET ESTADO='C' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_REQUERIMIENTO='$idrequerimiento' AND COD_PROVEEDOR='$proveedor'");
            $modificaordencompraestado->execute();

            // if ($siexiste > 0) {
            //   $modificainsumoreq = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_INSUMO SET ESTADO='C' WHERE  COD_REQUERIMIENTO='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            //   $modificainsumoreq->execute();
            // } else {
            //   $modificaenvasereq = $this->bd->prepare("UPDATE T_TMPREQUERIMIENTO_ENVASE SET ESTADO='C' WHERE  COD_REQUERIMIENTO='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            //   $modificaenvasereq->execute();
            // }
          } else {
            $modificaordencompraestadoz = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRATEMP SET ESTADO='F' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_REQUERIMIENTO='$idrequerimiento' AND COD_PROVEEDOR='$proveedor'");
            $modificaordencompraestadoz->execute();

            $modificaz = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET ESTADO='F' WHERE COD_ORDEN_COMPRA='$codigoordencompra' AND COD_TMPCOMPROBANTE='$idrequerimiento' AND COD_PRODUCTO='$producto'");
            $modificaz->execute();
          }
        }

        $verificar = $this->bd->prepare("SELECT COD_PRODUCTO, SUM(CAST(CANTIDAD_MINIMA AS DECIMAL(15, 2))) AS SUMA_TOTAL
                                         FROM T_TMPCONTROL_RECEPCION_COMPRAS_ITEM WHERE COD_TMPCONTROL_RECEPCION_COMPRAS='$codigorecepcion'
                                         GROUP BY COD_PRODUCTO");
        $verificar->execute();
        $totalsuma = $verificar->fetchAll(PDO::FETCH_ASSOC);

        foreach ($totalsuma as $row) {
          $codigoproducto = $row["COD_PRODUCTO"];
          $sumatotalproducto = $row["SUMA_TOTAL"];

          $actualizatotalprod = $this->bd->prepare("UPDATE T_TMPALMACEN_INSUMOS SET INGRESO='$sumatotalproducto' WHERE COD_PRODUCTO='$codigoproducto'");
          $actualizatotalprod->execute();
        }
      }

      $codigo->generarVersionGeneral($nombre);


      $insert = $this->bd->commit();
      return $insert;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
      echo $e->getLine();
    }
  }
  public function MostrarControlRecepcionPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {
      $stm = $this->bd->prepare(
        "SELECT TCO.COD_REQUERIMIENTO AS COD_REQUERIMIENTO,TRECEP.FECHA_INGRESO AS FECHA_INGRESO, TRECEP.HORA AS HORA, TP.COD_PRODUCCION AS COD_PRODUCCION,TP.DES_PRODUCTO AS DES_PRODUCTO, TRECEP.CODIGO_LOTE AS CODIGO_LOTE,
        TRECEP.FECHA_VENCIMIENTO AS FECHA_VENCIMIENTO, TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR, TRECEP.GUIA AS GUIA, TRECEP.BOLETA AS BOLETA, TRECEP.FACTURA AS FACTURA,
        TRECEP.GBF AS GBF, TRECEP.PRIMARIO AS PRIMARIO, TRECEP.SECUNDARIO AS SECUNDARIO, TRECEP.SACO AS SACO, TRECEP.CAJA AS CAJA, TRECEP.CILINDRO AS CILINDRO, TRECEP.BOLSA AS BOLSA,
        TRECEP.CANTIDAD_MINIMA AS CANTIDAD_MINIMA, TRECEP.ENVASE AS ENVASE, TRECEP.CERTIFICADO AS CERTIFICADO, TRECEP.ROTULACION AS ROTULACION,
        TRECEP.APLICACION AS APLICACION, TRECEP.HIGIENE AS HIGIENE, TRECEP.INDUMENTARIA AS INDUMENTARIA, TRECEP.EXCLUSIVO AS EXCLUSIVO, TRECEP.LIMPIO AS LIMPIO,
        TRECEP.HERMETICO AS HERMETICO,TRECEP.AUSENCIA AS AUSENCIA FROM T_TMPCONTROL_RECEPCION_COMPRAS_ITEM TRECEP
        INNER JOIN T_TMPCONTROL_RECEPCION_COMPRAS TCO ON TCO.COD_TMPCONTROL_RECEPCION_COMPRAS=TRECEP.COD_TMPCONTROL_RECEPCION_COMPRAS
        INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=TRECEP.COD_PROVEEDOR
        INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TRECEP.COD_PRODUCTO
        INNER JOIN T_TMPCONTROL_RECEPCION_COMPRAS TCR ON TCR.COD_TMPCONTROL_RECEPCION_COMPRAS=TRECEP.COD_TMPCONTROL_RECEPCION_COMPRAS
        WHERE TCR.ESTADO='P'AND MONTH(FECHA_INGRESO) = '$mesSeleccionado' AND YEAR(FECHA_INGRESO) = '$anioSeleccionado'"
      );
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarControlRecepcionObservacionPDF($anioSeleccionado, $mesSeleccionado)
  {
    try {


      $stm = $this->bd->prepare(
        "SELECT TOBS.COD_TMPCONTROL_RECEPCION_COMPRAS AS COD_TMPCONTROL_RECEPCION_COMPRAS,TOBS.FECHA AS FECHA,
        TOBS.OBSERVACION AS OBSERVACION, TOBS.ACCION_CORRECTIVA AS ACCION_CORRECTIVA, TCOM.FECHA AS FECHA FROM T_TMPCONTROL_RECEPCION_COMPRAS_OBSERVACION TOBS 
        INNER JOIN T_TMPCONTROL_RECEPCION_COMPRAS TCOM ON TCOM.COD_TMPCONTROL_RECEPCION_COMPRAS=TOBS.COD_TMPCONTROL_RECEPCION_COMPRAS
        WHERE MONTH(TCOM.FECHA) = '$mesSeleccionado' AND YEAR(TCOM.FECHA) = '$anioSeleccionado'"
      );
      $stm->execute();
      $datos = $stm->fetchAll();

      return $datos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function InsertarActualizarAlerta($capturavalor)
  {
    try {
      $this->bd->beginTransaction();

      $codigo = new m_almacen();

      foreach ($capturavalor as $valor) {
        $codigozona = trim($valor['idzona']);
        $codigoinfra = trim($valor['idinfra']);
        $codigoalerta = trim($valor['idalerta']);
        $ndias = trim($valor['frecuenciadias']);
        // $estado = $valor['check'];
        $estado = $valor['estadoseleccion'];
        $observacion = strtoupper($valor['obs']);
        $accioncorrectiva = strtoupper($valor['accioncorrecto']);
        $selectvb = $valor['selectvb'];
        $estadoverifica = $valor['estadoverifica'];
        $fechatotal = $valor['fecha'];

        $fecha = strtotime($fechatotal);


        // if ($estado === 'false') {
        //   $fechacreacion = $codigo->c_horaserversql('F');

        //   $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO='PO', OBSERVACION='$observacion',ACCION_CORRECTIVA='$accioncorrectiva', VB='$selectvb' WHERE COD_ALERTA='$codigoalerta'");
        //   $insertaractualizar = $actualizarestado->execute();

        //   $fechaformato = DateTime::createFromFormat('d/m/Y', $fechaactualalerta);
        //   $fechaformato->modify('+1 day');

        //   // if ($fechaformato->format('N') == 6) {
        //   //   $fechaformato->modify('+2 days');
        //   // }
        //   $fechatotal = $fechaformato->format('d/m/Y');

        //   $insertarfalse = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL,ESTADO,POSTERGACION)
        //                                                    VALUES('$codigozona','$codigoinfra','$ndias','$fechacreacion','$fechatotal','OB','SI')");
        //   $insertarfalse->execute();
        // } else if ($estado === 'true') {

        //   $fecha_creacion = $codigo->c_horaserversql('F');

        //   if ($estadoverifica == 'OB') {
        //     $fechaForma = DateTime::createFromFormat('Y-m-d', $fecha);
        //     $fechaForma->format('d/m/Y');

        //     // $timestamp = strtotime($fechatotalcontrol);
        //     // $fechaFormatos = date('d/m/Y', $timestamp);
        //     // $dia_semana = date('w', $timestamp);

        //     if ($fechaForma->format('N') == 6) {
        //       $fechatotalsabado = $fechaForma->format('d/m/Y');
        //       $conversionfechasabado = strtotime(str_replace('/', '-',  $fechatotalsabado));

        //       $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET FECHA_TOTAL='$fechatotalsabado',ESTADO='OB' WHERE COD_ALERTA='$codigoalerta'");
        //       $insertaractualizar = $actualizarestado->execute();

        //       if ($ndias == '2') {
        //         $fechatotalinsertar = strtotime("+3 days", $conversionfechasabado);
        //       } else {
        //         $fechatotalinsertar = strtotime("+$ndias days", $conversionfechasabado);
        //       }

        //       $fechadomingo = date('w', $fechatotalinsertar);

        //       if ($fechadomingo == 0) {
        //         $fechatotalinsertar = strtotime('+1 day', $fechatotalinsertar);
        //       }

        //       $fechamodificadainsertar = date("d/m/Y", $fechatotalinsertar);

        //       $insertartrue = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fechatotalsabado','$fechamodificadainsertar')");
        //       $insertartrue->execute();
        //     } else {
        //       $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET FECHA_TOTAL='$fechaactualalerta',ESTADO='OB' WHERE COD_ALERTA='$codigoalerta'");
        //       $insertaractualizar = $actualizarestado->execute();

        //       $conversionfecha = strtotime(str_replace('/', '-',  $fechaactualalerta));
        //       $fechasumadias = strtotime("+$ndias days", $conversionfecha);

        //       $fechadomingo = date('w', $fechasumadias);

        //       if ($fechadomingo == 0) {
        //         $fechasumadias = strtotime('+1 day', $fechasumadias);
        //       }
        //       $fechasumarelse = date("d/m/Y", $fechasumadias);

        //       $insertartrue = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechasumarelse')");
        //       $insertartrue->execute();
        //     }
        //   } else {
        //     $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO='R' WHERE COD_ALERTA='$codigoalerta'");
        //     $insertaractualizar = $actualizarestado->execute();

        //     $conversionfecha = strtotime(str_replace('/', '-',  $fecha_creacion));
        //     $fechasumadias = strtotime("+$ndias days", $conversionfecha);
        //     $fechadomingo = date('w', $fechasumadias);

        //     if ($fechadomingo == 0) {
        //       $fechasumadias = strtotime('+1 day', $fechasumadias);
        //     }
        //     $fechatotalrealizado = date("d/m/Y", $fechasumadias);

        //     $insertartrue = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechatotalrealizado')");
        //     $insertartrue->execute();
        //   }
        // }
        $fecha_creacion = $codigo->c_horaserversql('F');
        $conversionfecha = strtotime(str_replace('/', '-',  $fecha_creacion));

        if ($estado == 'R') {

          $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO='R' WHERE COD_ALERTA='$codigoalerta'");
          $insertaractualizar = $actualizarestado->execute();

          $fechasabado = date('w', $fecha);

          if ($ndias == '2') {
            if ($fechasabado == 6) {
              $fechasumadiassabado = strtotime("+3 days", $fecha);
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiassabado);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            } else {
              $fechasumadiassabado = strtotime("+$ndias days", $conversionfecha);
              $fechacaedomingo = date('w', $fechasumadiassabado);
              if ($fechacaedomingo == 0) {
                $fechasumadiassabado = strtotime('+1 day', $fechasumadiassabado);
              }

              $fechamodificadainsertar = date("d/m/Y", $fechasumadiassabado);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            }
          } else {

            if ($fechasabado == 6) {
              $fechasumadiassabado = strtotime("+$ndias days", $fecha);

              if (date('w', $fechasumadiassabado) == 0) {
                $fechasumadiassabado = strtotime('+1 day',  $fechasumadiassabado);
              }
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiassabado);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            } else {
              $fechasumadiaselse = strtotime("+$ndias days", $conversionfecha);
              $fechacaedomingoelse = date('w', $fechasumadiaselse);
              if ($fechacaedomingoelse == 0) {
                $fechasumadiaselse = strtotime('+1 day', $fechasumadiaselse);
              }
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiaselse);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            }
          }
        } else if ($estado == 'OB') {

          $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO='OB',OBSERVACION='$observacion',ACCION_CORRECTIVA='$accioncorrectiva',VB='$selectvb' WHERE COD_ALERTA='$codigoalerta'");
          $insertaractualizar = $actualizarestado->execute();

          $fechasabado = date('w', $fecha);

          if ($ndias == '2') {
            if ($fechasabado == 6) {
              $fechasumadiassabado = strtotime("+3 days", $fecha);
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiassabado);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            } else {
              $fechasumadiassabado = strtotime("+$ndias days", $conversionfecha);
              $fechacaedomingo = date('w', $fechasumadiassabado);
              if ($fechacaedomingo == 0) {
                $fechasumadiassabado = strtotime('+1 day', $fechasumadiassabado);
              }
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiassabado);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            }
          } else {
            if ($fechasabado == 6) {
              $fechasumadiaspendientes = strtotime("+$ndias days", $fecha);
              $fechacaedomingoelse = date('w',  $fechasumadiaspendientes);
              if ($fechacaedomingoelse == 0) {
                $fechasumadiaspendientes = strtotime('+1 day', $fechasumadiaspendientes);
              }
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiaspendientes);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            } else {
              $fechasumadiaselse = strtotime("+$ndias days", $conversionfecha);
              $fechacaedomingoelse = date('w', $fechasumadiaselse);
              if ($fechacaedomingoelse == 0) {
                $fechasumadiaselse = strtotime('+1 day', $fechasumadiaselse);
              }
              $fechamodificadainsertar = date("d/m/Y", $fechasumadiaselse);
              $insertarRinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
              $insertarRinter->execute();
            }
          }
        } else if ($estado == "PE") {
          $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA SET ESTADO='PE',OBSERVACION='$observacion',ACCION_CORRECTIVA='$accioncorrectiva',VB='$selectvb' WHERE COD_ALERTA='$codigoalerta'");
          $insertaractualizar = $actualizarestado->execute();

          $fechasabadototal = date('w', $fecha);

          if ($fechasabadototal == 6) {
            $fechadiaspen = strtotime("+2 days", $fecha);
            $fechamodificadainsertar = date("d/m/Y", $fechadiaspen);
            $insertarPEinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
            $insertarPEinter->execute();
          } else {
            $fechadiaspen = strtotime("+1 days", $conversionfecha);
            $fechamodificadainsertar = date("d/m/Y", $fechadiaspen);
            $insertarPEinter = $this->bd->prepare("INSERT INTO T_ALERTA(COD_ZONA,COD_INFRAESTRUCTURA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigozona','$codigoinfra','$ndias','$fecha_creacion','$fechamodificadainsertar')");
            $insertarPEinter->execute();
          }
        }
      }

      $insertaractualizar = $this->bd->commit();
      return $insertaractualizar;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function  InsertarActualizarAlertaControl($capturavalorcontrol)
  {
    try {
      $this->bd->beginTransaction();

      $alerta = new m_almacen();
      $fechaactualalertacontrol = $alerta->c_horaserversql('F');

      foreach ($capturavalorcontrol as $valorcontrol) {
        $idcontrolmaquina = trim($valorcontrol['idcontrolalerta']);
        $codigocontrolmaquina = trim($valorcontrol['codigomaquinacontrol']);
        $estadocontrol = $valorcontrol['checkcontro'];
        $ndiascontrol = $valorcontrol['frecuenciacontrol'];
        $observacioncontrol = strtoupper($valorcontrol['obscontrol']);
        $accioncorrectivacontrol = strtoupper($valorcontrol['accioncorrectocontrol']);
        $selectvbcontrol = $valorcontrol['selectvbcontrol'];
        $estadoverificacontrol = trim($valorcontrol['estadoverificacontrol']);
        $fechatotalcontrol = $valorcontrol['fechacontrol'];

        if ($estadocontrol === 'false') {
          $fechacreacioncontrol = $alerta->c_horaserversql('F');

          $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET ESTADO='PO', OBSERVACION='$observacioncontrol',ACCION_CORRECTIVA='$accioncorrectivacontrol', VB='$selectvbcontrol' WHERE COD_ALERTA_CONTROL_MAQUINA='$idcontrolmaquina'");
          $insertaractualizarcontrol = $actualizarestado->execute();

          $fechaformatocontrol = DateTime::createFromFormat('d/m/Y', $fechaactualalertacontrol);
          $fechaformatocontrol->modify('+1 day');


          $fechatotalcontro = $fechaformatocontrol->format('d/m/Y');

          $insertarfalse = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL,ESTADO,POSTERGACION)
                                                               VALUES('$codigocontrolmaquina','$ndiascontrol','$fechacreacioncontrol','$fechatotalcontro','OB','SI')");
          $insertarfalse->execute();
        } else if ($estadocontrol === 'true') {

          $fecha_creacion_control = $alerta->c_horaserversql('F');

          if ($estadoverificacontrol == 'OB') {

            // $fechaFormatos = DateTime::createFromFormat('Y-m-d', $fechatotalcontrol);
            // $fechs = $fechaFormatos->format('d/m/Y');
            $timestamp = strtotime($fechatotalcontrol);
            $fechaFormatos = date('d/m/Y', $timestamp);
            $dia_semana = date('w', $timestamp);

            if ($dia_semana  == 6) {
              $fechatotalsabado = $fechaFormatos;
              $conversionfechasabado = strtotime(str_replace('/', '-',  $fechatotalsabado));

              $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET FECHA_TOTAL='$fechatotalsabado',ESTADO='OB',POSTERGACION='NO' WHERE COD_ALERTA_CONTROL_MAQUINA='$idcontrolmaquina'");
              $insertaractualizarcontrol = $actualizarestado->execute();

              $fechatotalinsertar = strtotime("+$ndiascontrol days", $conversionfechasabado);


              $fechadomingo = date('w', $fechatotalinsertar);

              if ($fechadomingo == 0) {
                $fechatotalinsertar = strtotime('+1 day', $fechatotalinsertar);
              }

              $fechamodificadainsertar = date("d/m/Y", $fechatotalinsertar);

              $insertartrue = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigocontrolmaquina','$ndiascontrol','$fechatotalsabado','$fechamodificadainsertar')");
              $insertartrue->execute();
            } else {
              $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET FECHA_TOTAL='$fechaactualalertacontrol',ESTADO='OB',POSTERGACION='NO' WHERE COD_ALERTA_CONTROL_MAQUINA='$idcontrolmaquina'");
              $insertaractualizarcontrol = $actualizarestado->execute();

              $conversionfecha = strtotime(str_replace('/', '-',  $fechaactualalertacontrol));
              $fechasumadias = strtotime("+$ndiascontrol days", $conversionfecha);

              $fechadomingo = date('w', $fechasumadias);

              if ($fechadomingo == 0) {
                $fechasumadias = strtotime('+1 day', $fechasumadias);
              }
              $fechasumarelse = date("d/m/Y", $fechasumadias);

              $insertartrue = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigocontrolmaquina','$ndiascontrol','$fecha_creacion_control','$fechasumarelse')");
              $insertartrue->execute();
            }
          } else {
            $actualizarestado = $this->bd->prepare("UPDATE T_ALERTA_CONTROL_MAQUINA SET ESTADO='R' WHERE COD_ALERTA_CONTROL_MAQUINA='$idcontrolmaquina'");
            $insertaractualizarcontrol = $actualizarestado->execute();

            $conversionfecha = strtotime(str_replace('/', '-',  $fecha_creacion_control));
            $fechasumadias = strtotime("+$ndiascontrol days", $conversionfecha);
            $fechadomingo = date('w', $fechasumadias);

            if ($fechadomingo == 0) {
              $fechasumadias = strtotime('+1 day', $fechasumadias);
            }
            $fechatotalrealizado = date("d/m/Y", $fechasumadias);

            $insertartrue = $this->bd->prepare("INSERT INTO T_ALERTA_CONTROL_MAQUINA(COD_CONTROL_MAQUINA,N_DIAS_POS,FECHA_CREACION,FECHA_TOTAL) VALUES('$codigocontrolmaquina','$ndiascontrol','$fecha_creacion_control','$fechatotalrealizado')");
            $insertartrue->execute();
          }
        }
      }

      $insertaractualizarcontrol = $this->bd->commit();
      return $insertaractualizarcontrol;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }
  public function MostrarCantidadCajas($codigoproducto, $codigorequerimiento)
  {
    try {

      $mostarcajas = $this->bd->prepare("SELECT CAN_CAJA FROM T_TMPPRODUCCION WHERE COD_REQUERIMIENTO='$codigorequerimiento' AND COD_PRODUCTO='$codigoproducto'");
      $mostarcajas->execute();
      $datoscaja = $mostarcajas->fetchAll(PDO::FETCH_OBJ);

      return $datoscaja;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function contarduplicadoproveedorproducto($codigoprovedor, $codigoproducto)
  {
    $repetir = $this->bd->prepare("SELECT COUNT(*) AS COUNT FROM T_TMPCANTIDAD_MINIMA WHERE COD_PRODUCTO='$codigoproducto' AND COD_PROVEEDOR='$codigoprovedor'");
    $repetir->execute();
    $result = $repetir->fetch(PDO::FETCH_ASSOC);
    $count = intval($result['COUNT']);

    return $count;
  }

  public function InsertarProveedorProducto($selectmoneda, $precioproducto, $cantidadMinima, $selectprovedores, $selectproductosproveedores)
  {
    try {

      $cod = new m_almacen();
      $codigo_cantidad_minima = $cod->generarCodigoCantidadMinima();
      $valorduplicado = $cod->contarduplicadoproveedorproducto($selectprovedores, $selectproductosproveedores);

      if ($valorduplicado == 0) {
        $mostarcajas = $this->bd->prepare("INSERT INTO T_TMPCANTIDAD_MINIMA(COD_CANTIDAD_MINIMA,COD_PRODUCTO,COD_PROVEEDOR,CANTIDAD_MINIMA,PRECIO_PRODUCTO,TIPO_MONEDA)
                                           VALUES('$codigo_cantidad_minima','$selectproductosproveedores','$selectprovedores','$cantidadMinima','$precioproducto','$selectmoneda')");
        $datoscajas = $mostarcajas->execute();
        return $datoscajas;
      }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarProductoProveedores()
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT * FROM T_PRODUCTO WHERE COD_PRODUCCION IS NOT NULL");
      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function BuscarListarProveedorProducto($buscarProveedorPrecios)
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT TC.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA,TC.COD_PRODUCTO AS COD_PRODUCTO,
                                              TP.DES_PRODUCTO AS DES_PRODUCTO, TC.CANTIDAD_MINIMA AS CANTIDAD_MINIMA, TC.ESTADO AS ESTADO,
                                              TC.PRECIO_PRODUCTO AS PRECIO_PRODUCTO, TC.TIPO_MONEDA AS TIPO_MONEDA, T.NOM_PROVEEDOR AS NOM_PROVEEDOR,
                                              T.COD_PROVEEDOR AS COD_PROVEEDOR FROM T_TMPCANTIDAD_MINIMA TC
                                              INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TC.COD_PRODUCTO
                                              INNER JOIN T_PROVEEDOR T ON T.COD_PROVEEDOR=TC.COD_PROVEEDOR 
                                              WHERE T.NOM_PROVEEDOR LIKE '$buscarProveedorPrecios%'
                                              OR TP.DES_PRODUCTO LIKE '$buscarProveedorPrecios%'");
      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function CambiarEstadoCantidadMinima($taskId)
  {
    try {
      $mostarproductos = $this->bd->prepare("UPDATE T_TMPCANTIDAD_MINIMA SET ESTADO='A' WHERE COD_CANTIDAD_MINIMA='$taskId'");
      $mostarproductos->execute();


      return $mostarproductos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function CambiarEstado($id)
  {
    try {
      $mostarproductos = $this->bd->prepare("UPDATE T_TMPCANTIDAD_MINIMA SET ESTADO='P' WHERE COD_CANTIDAD_MINIMA='$id'");
      $mostarproductos->execute();


      return $mostarproductos;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function  SelectProveedorPrecios($cod_mini)
  {
    try {

      $stm = $this->bd->prepare("SELECT TC.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA,TC.COD_PRODUCTO AS COD_PRODUCTO,
      TP.DES_PRODUCTO AS DES_PRODUCTO, TC.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,
      TC.PRECIO_PRODUCTO AS PRECIO_PRODUCTO, TC.TIPO_MONEDA AS TIPO_MONEDA, T.NOM_PROVEEDOR AS NOM_PROVEEDOR,
      T.COD_PROVEEDOR AS COD_PROVEEDOR FROM T_TMPCANTIDAD_MINIMA TC
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TC.COD_PRODUCTO
      INNER JOIN T_PROVEEDOR T ON T.COD_PROVEEDOR=TC.COD_PROVEEDOR WHERE TC.COD_CANTIDAD_MINIMA='$cod_mini'");
      $stm->execute();

      return $stm;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function ActualizaTablaProveedorPrecios($codminimo, $cantidadMinima, $precioproducto, $selectmoneda)
  {
    try {
      $this->bd->beginTransaction();

      $cod = new m_almacen();
      // $repetir = $cod->contarRegistrosZona($NOMBRE_T_ZONA_AREAS);
      // $nombre = 'LBS-PHS-FR-01';

      // if ($repetir == 0) {

      $stmt = $this->bd->prepare("UPDATE T_TMPCANTIDAD_MINIMA SET CANTIDAD_MINIMA ='$cantidadMinima',
                                   PRECIO_PRODUCTO='$precioproducto', TIPO_MONEDA='$selectmoneda' WHERE COD_CANTIDAD_MINIMA = '$codminimo'");
      $update = $stmt->execute();

      $update = $this->bd->commit();

      return $update;
      // }
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarProveedoresCantidadesMinimas($cod_producto_fila)
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT CM.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA, CM.COD_PRODUCTO AS COD_PRODUCTO ,CM.COD_PROVEEDOR AS COD_PROVEEDOR, TP.NOM_PROVEEDOR AS NOM_PROVEEDOR,
      CM.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,CM.PRECIO_PRODUCTO AS PRECIO_PRODUCTO, CM.TIPO_MONEDA AS TIPO_MONEDA,CM.ESTADO AS ESTADO 
      FROM T_TMPCANTIDAD_MINIMA CM INNER JOIN T_PROVEEDOR TP ON TP.COD_PROVEEDOR=CM.COD_PROVEEDOR WHERE CM.COD_PRODUCTO='$cod_producto_fila'");
      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarCantidadPrecioCalculo($valorproveedor, $valorproducto)
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT CM.COD_CANTIDAD_MINIMA AS COD_CANTIDAD_MINIMA,CM.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
                                              CM.PRECIO_PRODUCTO AS PRECIO_PRODUCTO,CM.CANTIDAD_MINIMA AS CANTIDAD_MINIMA,CM.TIPO_MONEDA AS TIPO_MONEDA, 
                                              CM.ESTADO AS ESTADO, CM.COD_PROVEEDOR AS COD_PROVEEDOR,TPRO.NOM_PROVEEDOR AS NOM_PROVEEDOR FROM T_TMPCANTIDAD_MINIMA CM
                                              INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=CM.COD_PRODUCTO
                                              INNER JOIN T_PROVEEDOR TPRO ON TPRO.COD_PROVEEDOR=CM.COD_PROVEEDOR
                                              WHERE CM.COD_PRODUCTO='$valorproducto' AND CM.COD_PROVEEDOR='$valorproveedor'");
      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarProductoFormula($codigoformulacion, $codigoproducto)
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT TFOR.COD_FORMULACION AS COD_FORMULACION, TFOR.COD_PRODUCTO AS COD_PRODUCTO,TPR.DES_PRODUCTO AS DES_PRODUCTO,
      TFOR.CAN_FORMULACION AS CAN_FORMULACION FROM T_TMPFORMULACION TFOR INNER JOIN T_PRODUCTO TPR ON TFOR.COD_PRODUCTO=TPR.COD_PRODUCTO
      WHERE TFOR.COD_FORMULACION='$codigoformulacion' AND TFOR.COD_PRODUCTO='$codigoproducto'");

      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarInsumosFormula($codigoformulacion, $codigoproducto)
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT TFI.COD_FORMULACION AS COD_FORMULACION, TFI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
      TFI.CAN_FORMULACION AS CAN_FORMULACION  FROM T_TMPFORMULACION_ITEM TFI 
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TFI.COD_PRODUCTO WHERE TFI.COD_FORMULACION='$codigoformulacion'");

      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function MostrarEnvasesFormula($codigoformulacionenvase, $codigoproductoenvase)
  {
    try {
      $mostarproductos = $this->bd->prepare("SELECT TFE.COD_FORMULACION AS COD_FORMULACION_ENVASE, TFE.COD_PRODUCTO AS COD_PRODUCTO_ENVASE,TP.DES_PRODUCTO AS DES_PRODUCTO_ENVASE,
                                              TFE.CANTIDA AS CAN_FORMULACION_ENVASE  FROM T_TMPFORMULACION_ENVASE TFE 
                                              INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TFE.COD_PRODUCTO 
                                              WHERE TFE.COD_FORMULACION='$codigoformulacionenvase'");

      $mostarproductos->execute();
      $datosproducprov = $mostarproductos->fetchAll(PDO::FETCH_OBJ);

      return $datosproducprov;
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function InsertarOrdenAdicional($valorcapturadoadicional)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();

      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $reCodrequerimiento = $horaactual = $horaActualPeruRequerimiento->format('H:i');


      foreach ($valorcapturadoadicional as $rowstring) {
        $row = json_decode($rowstring, true);
        if ($row !== null) {
          $codigorequerimiento = $row['codigorequerimiento'];
          $codigoordencomprax = $row['codigoordencompra'];
          $id_proveedor = $row['id_proveedor'];
          $id_producto_insumo = trim($row['id_producto_insumo']);
          $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
          $monto = floatval($row['monto']);
          $formapago = $row['formapago'];
          $fechaentrega = $row['fechaentrega'];
          $preciomin = floatval($row['preciomin']);
          $canrecibir = floatval($row['canrecibir']);

          if ($codigoordencomprax == null) {
            $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
            $stmCodreq->execute();
            $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
            $maxCodigoRe = $resultadoRe['COD_REQUERIMIENTO'];
            $nuevoCodigoReq = $maxCodigoRe + 1;
            $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);


            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$codigorequerimiento' AND ESTADO='N'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $count = $resultcount['COUNT'];

            $codigoorden = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
            $codigoorden->execute();
            $traercodorden = $codigoorden->fetch(PDO::FETCH_ASSOC);
            $maxcodorden = $traercodorden['COD_ORDEN_COMPRA'];
            $codidoaumentado = $maxcodorden + 1;
            $codigonuevoorden = str_pad($codidoaumentado, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($valorcapturadoadicional as $valorstring) {
              $rows = json_decode($valorstring, true);
              if ($row !== null) {
                $cod_provedor = $rows['id_proveedor'];
                if ($id_proveedor == $cod_provedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }

            if ($count == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA,ESTADO)
                                                       VALUES('$codigonuevoorden','$codigorequerimiento','$codigoAumentoReq','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fecha_menor', 23),'N')");

              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA,ESTADO)
                                                       VALUES('$codigonuevoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$codigorequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23),'N')");
              $stmActualizar->execute();
            } else {
              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$codigorequerimiento' AND ESTADO='N'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA,ESTADO)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$codigorequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23),'N')");
              $stmActualizar->execute();
            }
          } else {

            $actualizafechaorden = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET FECHA_ENTREGA=CONVERT(DATE, '$fechaentrega', 23),ESTADO='P' WHERE COD_TMPCOMPROBANTE='$codigorequerimiento' AND COD_PRODUCTO='$id_producto_insumo' AND COD_ORDEN_COMPRA='$codigoordencomprax'");
            $actualizafechaorden->execute();
            $actualizafechaordentemp = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET FECHA_ENTREGA=CONVERT(DATE, '$fechaentrega', 23),ESTADO='P',CANTIDAD_INSUMO_ENVASE='$canrecibir' WHERE COD_TMPCOMPROBANTE='$codigorequerimiento' AND COD_PRODUCTO='$id_producto_insumo' AND COD_ORDEN_COMPRA='$codigoordencomprax' AND ESTADO='F'");
            $actualizafechaordentemp->execute();
          }
        } else {
          echo "Error al decodificar JSON: " . json_last_error_msg();
        }
      }


      $reCodrequerimiento = $this->bd->commit();
      return $reCodrequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }

  public function InsertarOrdenAdicionalImagenes($valorcapturadoadicional, $dataimagenesfile, $codigoproveedorimagenes)
  {
    try {

      $this->bd->beginTransaction();
      $cod = new m_almacen();
      $totalimagenesfile = count($_FILES['file']['name']);


      $zonaHorariaPeruRequerimiento = new DateTimeZone('America/Lima');
      $horaActualPeruRequerimiento = new DateTime('now', $zonaHorariaPeruRequerimiento);
      $reCodrequerimiento = $horaactual = $horaActualPeruRequerimiento->format('H:i');


      foreach ($valorcapturadoadicional as $rowstring) {
        $row = json_decode($rowstring, true);
        if ($row !== null) {
          $codigorequerimiento = $row['codigorequerimiento'];
          $codigoordencomprax = $row['codigoordencompra'];
          $id_proveedor = $row['id_proveedor'];
          $id_producto_insumo = trim($row['id_producto_insumo']);
          $cantidad_producto_insumo = floatval($row['cantidad_producto_insumo']);
          $monto = floatval($row['monto']);
          $formapago = $row['formapago'];
          $fechaentrega = $row['fechaentrega'];
          $preciomin = floatval($row['preciomin']);
          $canrecibir = floatval($row['canrecibir']);

          if ($codigoordencomprax == null) {
            $stmCodreq = $this->bd->prepare("SELECT MAX(COD_REQUERIMIENTO) as COD_REQUERIMIENTO FROM T_REQUERIMIENTOTEMP");
            $stmCodreq->execute();
            $resultadoRe = $stmCodreq->fetch(PDO::FETCH_ASSOC);
            $maxCodigoRe = $resultadoRe['COD_REQUERIMIENTO'];
            $nuevoCodigoReq = $maxCodigoRe + 1;
            $codigoAumentoReq = str_pad($nuevoCodigoReq, 8, '0', STR_PAD_LEFT);


            $repetirproveedortemp = $this->bd->prepare("SELECT COUNT(*) as COUNT FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$codigorequerimiento' AND ESTADO='N'");
            $repetirproveedortemp->execute();
            $resultcount = $repetirproveedortemp->fetch(PDO::FETCH_ASSOC);
            $count = $resultcount['COUNT'];

            $codigoorden = $this->bd->prepare("SELECT MAX(COD_ORDEN_COMPRA) as COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP");
            $codigoorden->execute();
            $traercodorden = $codigoorden->fetch(PDO::FETCH_ASSOC);
            $maxcodorden = $traercodorden['COD_ORDEN_COMPRA'];
            $codidoaumentado = $maxcodorden + 1;
            $codigonuevoorden = str_pad($codidoaumentado, 9, '0', STR_PAD_LEFT);

            $fechas = array();
            foreach ($valorcapturadoadicional as $valorstring) {
              $rows = json_decode($valorstring, true);
              if ($row !== null) {
                $cod_provedor = $rows['id_proveedor'];
                if ($id_proveedor == $cod_provedor) {
                  $fechas[] = $rows['fechaentrega'];
                }
              } else {
                echo "Error al decodificar JSON: " . json_last_error_msg();
              }
            }
            if (!empty($fechas)) {
              // Encuentra la fecha de menor valor
              $fecha_menor = min($fechas);
            } else {
              echo "No se encontraron fechas válidas.";
            }

            if ($count == 0) {

              $stmActualizarOrden = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRATEMP(COD_ORDEN_COMPRA,COD_REQUERIMIENTO,COD_REQUERIMIENTOTEMP,HORA,COD_PROVEEDOR,F_PAGO,FECHA_REALIZADA,ESTADO)
                                                       VALUES('$codigonuevoorden','$codigorequerimiento','$codigoAumentoReq','$horaactual','$id_proveedor','$formapago',CONVERT(DATE, '$fecha_menor', 23),'N')");
              $stmActualizarOrden->execute();

              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA,ESTADO)
                                                       VALUES('$codigonuevoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$codigorequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23),'N')");
              $stmActualizar->execute();
            } else {
              $codigoordencompra = $this->bd->prepare("SELECT COD_ORDEN_COMPRA FROM T_TMPORDEN_COMPRATEMP WHERE COD_PROVEEDOR='$id_proveedor' AND COD_REQUERIMIENTO='$codigorequerimiento' AND ESTADO='N'");
              $codigoordencompra->execute();
              $codigoresultado = $codigoordencompra->fetch(PDO::FETCH_ASSOC);
              $proveedorcodigoorden = $codigoresultado['COD_ORDEN_COMPRA'];


              $stmActualizar = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_ITEMTEMP(COD_ORDEN_COMPRA,COD_PRODUCTO,CANTIDAD_INSUMO_ENVASE,MONTO,COD_TMPCOMPROBANTE,PRECIO_MINIMO,FECHA_ENTREGA,ESTADO)
                                                       VALUES('$proveedorcodigoorden','$id_producto_insumo','$cantidad_producto_insumo','$monto','$codigorequerimiento','$preciomin',CONVERT(DATE, '$fechaentrega', 23),'N')");
              $stmActualizar->execute();
            }
          } else {

            $actualizafechaorden = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEM SET FECHA_ENTREGA=CONVERT(DATE, '$fechaentrega', 23),ESTADO='P' WHERE COD_TMPCOMPROBANTE='$codigorequerimiento' AND COD_PRODUCTO='$id_producto_insumo' AND COD_ORDEN_COMPRA='$codigoordencomprax'");
            $actualizafechaorden->execute();
            $actualizafechaordentemp = $this->bd->prepare("UPDATE T_TMPORDEN_COMPRA_ITEMTEMP SET FECHA_ENTREGA=CONVERT(DATE, '$fechaentrega', 23),ESTADO='P',CANTIDAD_INSUMO_ENVASE='$canrecibir' WHERE COD_TMPCOMPROBANTE='$codigorequerimiento' AND COD_PRODUCTO='$id_producto_insumo' AND COD_ORDEN_COMPRA='$codigoordencomprax' AND ESTADO='F'");
            $actualizafechaordentemp->execute();
          }
        } else {
          echo "Error al decodificar JSON: " . json_last_error_msg();
        }
      }
      if ($totalimagenesfile > 0) {

        // foreach ($codigoproveedorimagenes as $codigoproveedorimageness) {

        //   $row = json_decode($codigoproveedorimageness, true);
        //   if ($row !== null) {
        //     $codigoproveedor = $row['codigoproveedor'];
        //     $eliminarporcodprovyrequerimiento = $this->bd->prepare("DELETE FROM T_TMPORDEN_COMPRA_IMAGENESTEMP WHERE COD_REQUERIMIENTO='$idRequerimiento' AND COD_PROVEEDOR='$codigoproveedor'");
        //     $eliminarporcodprovyrequerimiento->execute();
        //   } else {
        //     echo "Error al decodificar JSON: " . json_last_error_msg();
        //   }
        // }
        for ($total = 0; $total < $totalimagenesfile; $total++) {
          if (isset($dataimagenesfile)) {
            // Validar que se haya seleccionado una imagen
            if (empty($_FILES['file']['name'][$total])) {
              echo json_encode(array('status' => 'error', 'message' => 'Debe seleccionar una imagen.'));
              exit;
            }

            // Obtener la información sobre el archivo
            $imagen_info = getimagesize($_FILES['file']['tmp_name'][$total]);
            $imagen_tipo = $imagen_info['mime'];

            // Verificar que el tipo de archivo sea JPEG o PNG
            if ($imagen_tipo !== 'image/jpeg' && $imagen_tipo !== 'image/png') {
              echo json_encode(array('status' => 'error', 'message' => 'Formato de imagen no válido. Solo se permiten imágenes JPEG, JPG, PNG.'));
              exit;
            }
            // Verificar el tipo de archivo y usar la función adecuada para crear el recurso de imagen
            if ($imagen_tipo === 'image/jpeg') {
              $calidad = 30;
              $imagen_comprimida = imagecreatefromjpeg($_FILES['file']['tmp_name'][$total]);
              ob_start();
              imagejpeg($imagen_comprimida, null, $calidad);
              $imagen_comprimida_binaria = ob_get_contents();
              ob_end_clean();
              $hex = bin2hex($imagen_comprimida_binaria);
              $imagen = '0x' . $hex;
              imagedestroy($imagen_comprimida);
            } elseif ($imagen_tipo === 'image/png') {
              $calidad = 5;
              $imagen_comprimida = imagecreatefrompng($_FILES['file']['tmp_name'][$total]);
              ob_start();
              imagepng($imagen_comprimida, null, $calidad);
              $imagen_comprimida_binaria = ob_get_contents();
              ob_end_clean();
              $hex = bin2hex($imagen_comprimida_binaria);
              $imagen = '0x' . $hex;
              imagedestroy($imagen_comprimida);
            }

            $decodedData = json_decode($codigoproveedorimagenes[$total], true);

            // Verifica si la decodificación fue exitosa
            if ($decodedData !== null) {
              $codigoproveedor = $decodedData['codigoproveedor'];
              $idRequerimiento = $decodedData['codigorequerimiento'];
              $insertdataimagen = $this->bd->prepare("INSERT INTO T_TMPORDEN_COMPRA_IMAGENESTEMP(IMAGEN,COD_REQUERIMIENTO,COD_PROVEEDOR)
                                                        VALUES($imagen,'$idRequerimiento','$codigoproveedor')");

              $insertdataimagen->execute();
            } else {
              echo "Error al decodificar JSON en el índice $total\n";
              exit;
            }
          } else {
            // La variable imagen no existe
            $imagen = null;
            echo json_encode(array('status' => 'error', 'message' => 'No hay imagen seleccionada.'));
            exit;
          }
        }
      }

      $reCodrequerimiento = $this->bd->commit();
      return $reCodrequerimiento;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
    }
  }


  public function VerificaCodFormulacion($codigoproducto)
  {
    try {

      $codigo = new m_almacen();
      $codigorecepcion = $codigo->generarcodigocontrolrecepcion();

      $valordecodformulacion = $this->bd->prepare("SELECT COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoproducto'");
      $valordecodformulacion->execute();
      $codigoresultado = $valordecodformulacion->fetch(PDO::FETCH_ASSOC);
      $formulacod = $codigoresultado['COD_FORMULACION'];

      return  $formulacod;
    } catch (Exception $e) {
      die($e->getMessage());
      echo $e->getLine();
    }
  }
  public function InsumosFormulacion($codigoformula)
  {
    try {
      $totalinsumo = $this->bd->prepare("SELECT TFI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,TFI.CAN_FORMULACION AS CAN_FORMULACION,TF.CAN_FORMULACION AS CANTIDAD FROM T_TMPFORMULACION_ITEM TFI 
      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFI.COD_FORMULACION
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TFI.COD_PRODUCTO WHERE TFI.COD_FORMULACION='$codigoformula'");
      $totalinsumo->execute();
      $totalinsumoorden = $totalinsumo->fetchAll(PDO::FETCH_ASSOC);


      return $totalinsumoorden;
    } catch (Exception $e) {
      die($e->getMessage());
      echo $e->getLine();
    }
  }

  public function AlmacenVerificarProductoCantidad($codinsumo)
  {
    try {

      $totalinsumo = $this->bd->prepare("SELECT STOCK_ACTUAL FROM T_TMPALMACEN_INSUMOSTEMP WHERE COD_PRODUCTO='$codinsumo'");
      $totalinsumo->execute();
      $totalinsumoorden = $totalinsumo->fetch(PDO::FETCH_ASSOC);



      return $totalinsumoorden;
    } catch (Exception $e) {
      die($e->getMessage());
      echo $e->getLine();
    }
  }

  public function  VerificarFormulaOrdenCompra($codigorequerimiento, $codigoproducto, $valorcantidad)
  {
    try {
      $this->bd->beginTransaction();

      $codigo = new m_almacen();
      $codigorecepcion = $codigo->generarcodigocontrolrecepcion();

      $valordecodformulacion = $this->bd->prepare("SELECT COD_FORMULACION FROM T_TMPFORMULACION WHERE COD_PRODUCTO='$codigoproducto'");
      $valordecodformulacion->execute();
      $codigoresultado = $valordecodformulacion->fetch(PDO::FETCH_ASSOC);
      $formulacod = $codigoresultado['COD_FORMULACION'];

      $totalinsumo = $this->bd->prepare("SELECT TFI.COD_PRODUCTO AS COD_PRODUCTO,TFI.CAN_FORMULACION AS CAN_FORMULACION,TF.CAN_FORMULACION AS CANTIDAD FROM T_TMPFORMULACION_ITEM TFI 
      INNER JOIN T_TMPFORMULACION TF ON TF.COD_FORMULACION=TFI.COD_FORMULACION WHERE TFI.COD_FORMULACION='$formulacod'");
      $totalinsumo->execute();
      $totalinsumoorden = $totalinsumo->fetchAll(PDO::FETCH_ASSOC);

      foreach ($totalinsumoorden as $roworden) {
        $codproducto = trim($roworden['COD_PRODUCTO']);
        $cantidadinsumo = floatval($roworden['CAN_FORMULACION']);
        $cantidadformula = floatval($roworden['CANTIDAD']);

        $comprar = ($valorcantidad * $cantidadinsumo) / $cantidadformula;
        var_dump($comprar);
      }




      $insertarecepcioncompras = $this->bd->commit();
      return $insertarecepcioncompras;
    } catch (Exception $e) {
      $this->bd->rollBack();
      die($e->getMessage());
      echo $e->getLine();
    }
  }

  public function MostrarOrdenComprada($requerimiento)
  {
    try {

      $totalinsumo = $this->bd->prepare("SELECT O.COD_PROVEEDOR AS COD_PROVEEDOR,TPR.NOM_PROVEEDOR AS NOM_PROVEEDOR,OI.COD_PRODUCTO AS COD_PRODUCTO,
      TP.DES_PRODUCTO AS DES_PRODUCTO, OI.CANTIDAD_INSUMO_ENVASE AS CANTIDAD_INSUMO_ENVASE, TP.COD_PRODUCCION AS COD_PRODUCCION FROM T_TMPORDEN_COMPRA_ITEMTEMP OI 
      INNER JOIN T_TMPORDEN_COMPRATEMP O ON O.COD_ORDEN_COMPRA=OI.COD_ORDEN_COMPRA
      INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=OI.COD_PRODUCTO
      INNER JOIN T_PROVEEDOR TPR ON TPR.COD_PROVEEDOR=O.COD_PROVEEDOR WHERE COD_TMPCOMPROBANTE='$requerimiento' ORDER BY TP.DES_PRODUCTO ASC");
      $totalinsumo->execute();
      $totalinsumoorden = $totalinsumo->fetchAll(PDO::FETCH_ASSOC);

      return $totalinsumoorden;
    } catch (Exception $e) {
      die($e->getMessage());
      echo $e->getLine();
    }
  }

  public function MostrarStockActual()
  {
    try {

      $totalinsumo = $this->bd->prepare("SELECT TI.COD_ALMACEN AS COD_ALMACEN,TP.COD_PRODUCCION AS COD_PRODUCCION,TI.COD_PRODUCTO AS COD_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,
                                          TI.STOCK_ACTUAL AS STOCK_ACTUAL, TI.STOCK_ANTERIOR AS STOCK_ANTERIOR FROM T_TMPALMACEN_INSUMOS TI 
                                          INNER JOIN T_PRODUCTO TP ON TI.COD_PRODUCTO=TP.COD_PRODUCTO ORDER BY TP.DES_PRODUCTO ASC");
      $totalinsumo->execute();
      $totalinsumoorden = $totalinsumo->fetchAll(PDO::FETCH_ASSOC);

      return $totalinsumoorden;
    } catch (Exception $e) {
      die($e->getMessage());
      echo $e->getLine();
    }
  }







  /*funcion agregadas */
  public function m_lotes_producto($codproducto)
  {
    try {
      $saldo = 0;
      $query = $this->bd->prepare("SELECT * FROM V_LOTES_PRODUCTO
      where COD_PRODUCTO = ? AND SALDO != ?
      order by SALDO ASC");
      $query->bindParam(1, $codproducto, PDO::PARAM_STR);
      $query->bindParam(2, $saldo, PDO::PARAM_STR);
      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function Mostrarkardex()
  {
    try {
      $saldo = 0;
      $query = $this->bd->prepare("SELECT * FROM T_PRODUCTO WHERE COD_CATEGORIA='00008' OR COD_CATEGORIA='00002'");
      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarListaKardexProducto($codigoproducto, $fechainicio, $fechafin)
  {
    try {
      $fecini = retunrFechaSqlphp($fechainicio);
      $fecfin = retunrFechaSqlphp($fechafin);

      $query = $this->bd->prepare("SELECT TK.CODIGO AS CODIGO,TP.COD_PRODUCCION AS COD_PRODUCCION,TK.COD_PRODUCTO AS COD_PRODUCTO,
      TP.ABR_PRODUCTO AS ABR_PRODUCTO,TP.DES_PRODUCTO AS DES_PRODUCTO,TK.LOTE AS LOTE,TK.DESCRIPCION,TK.COD_INGRESO AS COD_INGRESO,TK.CANT_INGRESO AS CANT_INGRESO,
      TK.CANT_EGRESO AS CANT_EGRESO, TK.SALDO AS SALDO,TK.FEC_REGISTRO AS FEC_REGISTRO,TK.KARDEX AS KARDEX,TK.ESTADO AS ESTADO
       FROM T_TMPKARDEX_PRODUCCION TK INNER JOIN T_PRODUCTO TP ON TP.COD_PRODUCTO=TK.COD_PRODUCTO
      WHERE CAST(TK.FEC_REGISTRO as date) >= '$fecini' AND CAST(TK.FEC_REGISTRO as date) <= '$fecfin'
      AND TK.COD_PRODUCTO = '$codigoproducto' ORDER BY CODIGO ASC
      ");
      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  public function MostrarProducto($codigoproducto)
  {
    try {
      $query = $this->bd->prepare("SELECT COD_PRODUCCION,DES_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCTO='$codigoproducto'");
      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function stocklote($dato, $cantidad)
  {
    $array = [];
    $lote = explode('/', $dato);
    for ($i = 0; $i < count($lote); $i++) {
      if (trim($lote[$i]) != '') {
        if ($cantidad > 0) {
          $lote1 = explode('-', $lote[$i]);
          $can = floatval(trim($lote1[1]));
          $usado = ($cantidad > $can) ? $can : (($cantidad - $can) * -1) - $can;

          $cantidad = $cantidad - $can;
          array_push($array, [$lote1[0], round(trim($usado), 3)]);
        }
      }
      if ($i + 1 == count($lote)) {
        return $array;
      }
    }
  }

  public function m_saldolote($lote, $producto)
  {
    try {
      $query = $this->bd->prepare("SELECT * FROM V_LOTES_PRODUCTO
      where LOTE = ? AND COD_PRODUCTO=? order by LOTE ASC");
      $query->bindParam(1, $lote, PDO::PARAM_STR);
      $query->bindParam(2, $producto, PDO::PARAM_STR);

      $query->execute();
      return $query->fetchAll();
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function m_reportekardex($codproducto, $fecini, $fecfin, $lote)
  {
    try {
      $fecini = retunrFechaSqlphp($fecini);
      $fecfin = retunrFechaSqlphp($fecfin);
      $consulta = '';
      if (strlen(trim($lote)) != 0) {
        $consulta = " AND LOTE = ? ";
      }
      $query = $this->bd->prepare("SELECT * FROM V_KARDES_PRODUCCION
      where CAST(FEC_REGISTRO as date) >= ? AND CAST(FEC_REGISTRO as date) <= ?
      AND COD_PRODUCTO = ? $consulta  order by CODIGO asc");
      $query->bindParam(1, $fecini, PDO::PARAM_STR);
      $query->bindParam(2, $fecfin, PDO::PARAM_STR);
      $query->bindParam(3, $codproducto, PDO::PARAM_STR);
      if (strlen(trim($lote)) != 0) {
        $query->bindParam(4, $lote, PDO::PARAM_STR);
      }
      $query->execute();
      return $query->fetchAll(PDO::FETCH_NUM);
    } catch (Exception $e) {
      print_r("Error al obtener el kardex" . $e->getMessage());
    }
  }

  public function m_productos()
  {
    try {
      $query = $this->bd->prepare("SELECT * FROM V_PRODUCTO_KARDEX");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_NUM);
    } catch (Exception $e) {
      print_r("Error al buscar productos" . $e->getMessage());
    }
  }

  public function m_loteproducto($producto)
  {
    try {
      $query = $this->bd->prepare("SELECT LOTE FROM V_KARDES_PRODUCCION
    WHERE COD_PRODUCTO = ?
    group by LOTE");
      $query->bindParam(1, $producto, PDO::PARAM_STR);
      $query->execute();
      return $query->fetchAll(PDO::FETCH_NUM);
    } catch (Exception $e) {
      print_r("Error al buscar lotes del producto" . $e->getMessage());
    }
  }

  public function m_total_x_lote($producto, $lote)
  {
    try {
      $saldo = 0;
      $consulta = '';
      if (strlen($lote) != '') {
        $consulta = ' AND LOTE = ? ';
      }
      //   $query = $this->bd->prepare("SELECT ISNULL(SUM(SALDO),0) as TOTAL FROM V_LOTES_PRODUCTO
      // where COD_PRODUCTO = ? AND SALDO != ? $consulta");
      //   $query->bindParam(1, $producto, PDO::PARAM_STR);
      //   $query->bindParam(2, $saldo, PDO::PARAM_STR);
      $query = $this->bd->prepare("SELECT (ISNULL(SUM(CANT_INGRESO), 0) - ISNULL(SUM(CANT_EGRESO), 0)) AS TOTAL FROM T_TMPKARDEX_PRODUCCION
                              WHERE COD_PRODUCTO = ?");
      $query->bindParam(1, $producto, PDO::PARAM_STR);
      // if (strlen($lote) != '') {
      //   $query->bindParam(2, $lote, PDO::PARAM_STR);
      // }
      $query->execute();
      return $query->fetchAll(PDO::FETCH_NUM);
    } catch (Exception $e) {
      print_r("Error al buscar lotes del producto" . $e->getMessage());
    }
  }
}
