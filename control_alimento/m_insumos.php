<?php
require_once('../funciones/DataBaseA.php');

date_default_timezone_set('America/Lima');
class m_seguimiento
{

    private $db;
    public function __construct(){
        $this->db=DataBase::Conectar();

    }

    public function pre_carga_datos_pendientes()
    {
        $query = $this->db->prepare("SELECT T_PRODUCTO.DES_PRODUCTO, T_INS.N_BACHADA, T_INS.CANT_INSUMOS, T_INS.ESTADO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.COD_AVANCE_INSUMOS, T_INS.FECHA
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS 
        JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
        JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        WHERE T_INS.ESTADO = '0'
        ");
        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
/*
    public function traer_dato_maqueta_1($codigo_avance_insumo)
    {
        $query = $this->db->prepare("SELECT T_PRODUCTO.DES_PRODUCTO, T_INS.N_BACHADA, T_INS.CANT_INSUMOS, T_INS.ESTADO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.COD_AVANCE_INSUMOS, T_INS.FECHA
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS 
        JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
        JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        WHERE T_INS.COD_AVANCE_INSUMOS = :cod_avance_insumos
        ");
        $query->bindParam(':cod_avance_insumos', $codigo_avance_insumo);
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }
    */

    public function traer_dato_maqueta_1($codigo_avance_insumo)
    {
        $query = $this->db->prepare("SELECT T_PRODUCTO.DES_PRODUCTO, T_INS.N_BACHADA, T_INS.CANT_INSUMOS, T_INS.ESTADO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.COD_AVANCE_INSUMOS
        , T_INS.FECHA AS FECHA_PRODUCCION, T_INS.COD_PRODUCTO, T_INS.COD_PRODUCCION, T_INS.FEC_VENCIMIENTO
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS 
        JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
        JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        WHERE T_INS.COD_AVANCE_INSUMOS = :cod_avance_insumos
        ");
        $query->bindParam(':cod_avance_insumos', $codigo_avance_insumo);
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

//////////////////////
    public function GuardarDatosMaqueta($codigo_avance_insumo, $cod_encargado, $totalMerma, $codigo_interno, $hora_inicial, $hora_final, $peso,
     $observaciones, $acciones_correctivas, $contadorFilas, $totalMezcla, $hora_analisis_sensorial, $eva_pol_col, $eva_pol_olo, $eva_pol_apa, $eva_rec_col, $eva_rec_olo,
     $eva_rec_sab, $eva_rec_apa, $eva_rec_tex, $txt_acetado_rechazado, $txt_analista, $observaciones_sensorial, $acc_correctiva_sensorial
     , $cod_produccion, $fecha_produccion, $cod_producto, $fecha_vencimiento, $total_item_bolsas, $lote , $numero_bachada, $ingreso, $egreso, $stock, $saldo)
    {
        try {
            $this->db->beginTransaction();
    
            $query1 = $this->db->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS (COD_AVANCE_INSUMO, COD_PERSONAL, MERMA, FECHA, HORA, TOTAL_MEZCLA)
            VALUES (:cod_avance_insumo, :cod_personal, :merma, GETDATE(), CAST(GETDATE() AS TIME), :total_mezcla)
                
            ");
    
            $query1->bindParam(':cod_avance_insumo', $codigo_avance_insumo);
            $query1->bindParam(':cod_personal', $cod_encargado);
            $query1->bindParam(':merma', $totalMerma);
            $query1->bindParam(':total_mezcla', $totalMezcla);
            $query1->execute();

            $id_codigo_envasados = $this->db->lastInsertId();

            $query2 = $this->db->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS_ITEM (CODIGO, COD_AVANCE_INSUMO, ID, CODIGO_INTERNO, HORA_INICIAL,
             HORA_FINAL, PESO, OBSERVACIONES, ACCION_CORRECTIVA)
            VALUES (:codigo, :cod_avance_insumo, :id, :codigo_interno, :hora_inicial, :hora_final, :peso, :observaciones, :accion_correctiva)
                
            ");

            for ($i = 0; $i < count($contadorFilas); $i++) {

                $query1IDAumento = $this->db->prepare("
                SELECT ISNULL(MAX(ID), 0) + 1 as new_code_id
                FROM T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS_ITEM;
                ");

                $query1IDAumento->execute();
                $row1 = $query1IDAumento->fetch(PDO::FETCH_ASSOC);
                $id = str_pad($row1['new_code_id'], 9, '0', STR_PAD_LEFT);

                $query2->bindParam(':codigo', $id_codigo_envasados);
                $query2->bindParam(':cod_avance_insumo', $codigo_avance_insumo);
                $query2->bindParam(':id', $id);
                $query2->bindParam(':codigo_interno', $codigo_interno[$i]);
                $query2->bindParam(':hora_inicial', $hora_inicial[$i]);
                $query2->bindParam(':hora_final', $hora_final[$i]);
                $query2->bindParam(':peso', $peso[$i]);
                $query2->bindParam(':observaciones', $observaciones[$i]);
                $query2->bindParam(':accion_correctiva', $acciones_correctivas[$i]);
                $query2->execute();
                }

            $query3 = $this->db->prepare("UPDATE T_TMPAVANCE_INSUMOS_PRODUCTOS SET ESTADO = '1' WHERE COD_AVANCE_INSUMOS = :cod_avance_insumo");
            $query3->bindParam(':cod_avance_insumo', $codigo_avance_insumo);
            $query3->execute();

            $query4 = $this->db->prepare("INSERT INTO T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS_SENSORIAL (CODIGO, COD_AVANCE_INSUMO, FECHA, HORA, EVA_POL_COL, EVA_POL_OLO, EVA_POL_APA, 
            EVA_REC_COL, EVA_REC_OLO, EVA_REC_SAB, EVA_REC_APA, EVA_REC_TEX, EST_SENSORIAL, ANALISTA, OBSERVACION_SE, ACCION_CORRECTIVA_SE)
            VALUES (:codigo, :cod_avance_insumo, GETDATE(), :hora_sensorial, :eva_pol_col, :eva_pol_olo, :eva_pol_apa, :eva_rec_col, :eva_rec_olo,
             :eva_rec_sab, :eva_rec_apa, :eva_rec_tex, :est_sensorial, :analista, :observacion_se, :accion_correctiva_se)
            ");
    
            $query4->bindParam(':codigo', $id_codigo_envasados);
            $query4->bindParam(':cod_avance_insumo', $codigo_avance_insumo);
            $query4->bindParam(':hora_sensorial', $hora_analisis_sensorial);
            $query4->bindParam(':eva_pol_col', $eva_pol_col);
            $query4->bindParam(':eva_pol_olo', $eva_pol_olo);
            $query4->bindParam(':eva_pol_apa', $eva_pol_apa);
            $query4->bindParam(':eva_rec_col', $eva_rec_col);
            $query4->bindParam(':eva_rec_olo', $eva_rec_olo);
            $query4->bindParam(':eva_rec_sab', $eva_rec_sab);
            $query4->bindParam(':eva_rec_apa', $eva_rec_apa);
            $query4->bindParam(':eva_rec_tex', $eva_rec_tex);
            $query4->bindParam(':est_sensorial', $txt_acetado_rechazado);
            $query4->bindParam(':analista', $txt_analista);
            $query4->bindParam(':observacion_se', $observaciones_sensorial);
            $query4->bindParam(':accion_correctiva_se', $acc_correctiva_sensorial);

            $query4->execute();


            $query5 = $this->db->prepare("INSERT INTO T_ENVASE_KARDEX (COD_AVANCE_INSUMO, COD_PRODUCCION, TOTAL_MEZCLA_PESO, TOTAL_ITEM_BOLSAS, COD_PRODUCTO, FECHA_MEZCLADO, LOTE, 
            BACHADA, FECHA_PRODUCCION, FECHA_VENCIMIENTO, INGRESO, EGRESO, STOCK, SALDO, ESTADO)
            VALUES (:cod_avance_insumo, :cod_produccion, :total_mezcla_peso, :total_item_bolsas, :cod_producto, GETDATE(), :lote, :bachada, :fecha_produccion, :fecha_vencimiento, 
            :ingreso, :egreso, :stock, :saldo, 'P')
            ");
            $query5->bindParam(':cod_avance_insumo', $codigo_avance_insumo);
            $query5->bindParam(':cod_produccion', $cod_produccion);
            $query5->bindParam(':total_mezcla_peso', $totalMezcla);
            $query5->bindParam(':total_item_bolsas', $total_item_bolsas);
            $query5->bindParam(':cod_producto', $cod_producto);
            //$query5->bindParam(':fecha_mezclado', $fecha_mezclado);
            $query5->bindParam(':lote', $lote);
            $query5->bindParam(':bachada', $numero_bachada);
            $query5->bindParam(':fecha_produccion', $fecha_produccion);
            $query5->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $query5->bindParam(':ingreso', $ingreso);
            $query5->bindParam(':egreso', $egreso);
            $query5->bindParam(':stock', $stock);
            $query5->bindParam(':saldo', $saldo);
            
            $query5->execute();

            $this->db->commit();
            return true;
        }   catch (Exception $e) {
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }

    public function traer_datos_envase_kardex($cod_producto)
    {
        $query = $this->db->prepare("SELECT TOP(1)* FROM T_ENVASE_KARDEX WHERE COD_PRODUCTO = :cod_producto ORDER BY ID DESC");
        $query->bindParam(':cod_producto', $cod_producto);
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_datos_cod_producto_produccion()
    {
        $query = $this->db->prepare("SELECT MAX(T_INS.COD_PRODUCTO) AS COD_PRODUCTO, MAX(T_INS.COD_PRODUCCION) AS COD_PRODUCCION FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS
        WHERE T_INS.ESTADO = '1'
        GROUP BY T_INS.COD_PRODUCTO, T_INS.COD_PRODUCCION
        ");
        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function buscar_producto($cod_producto)
    {
        $query = $this->db->prepare("SELECT COD_PRODUCTO, DES_PRODUCTO FROM T_PRODUCTO WHERE COD_PRODUCTO = :cod_producto");
        $query->bindParam(':cod_producto', $cod_producto);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = ['label' => $result['DES_PRODUCTO'], 'codigo' => $result['COD_PRODUCTO']];
        }
        return $formattedResults;
    }

    public function buscar_produccion($cod_produccion)
    {
        $query = $this->db->prepare("SELECT COD_PRODUCCION, NUM_PRODUCION_LOTE FROM T_TMPPRODUCCION WHERE COD_PRODUCCION = :cod_produccion");
        $query->bindParam(':cod_produccion', $cod_produccion);
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = ['label' => $result['NUM_PRODUCION_LOTE'], 'codigo' => $result['COD_PRODUCCION']];
        }
        return $formattedResults;
    }

    public function traer_datos_generales_insumo($cod_producto, $cod_produccion, $numero_bachada)
    {
        $query = $this->db->prepare("SELECT T_PRODUCTO.DES_PRODUCTO, T_INS.COD_PRODUCTO, T_INS.N_BACHADA, T_INS.CANT_INSUMOS, T_INS.ESTADO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.COD_PRODUCCION, 
        T_INS.COD_AVANCE_INSUMOS, T_ENV.FECHA, T_ENV.COD_PERSONAL, T_ENV.MERMA, T_ENV.TOTAL_MEZCLA
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS 
        JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
        JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        JOIN T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS T_ENV ON T_INS.COD_AVANCE_INSUMOS = T_ENV.COD_AVANCE_INSUMO
        WHERE T_INS.ESTADO = '1' AND T_INS.COD_PRODUCTO = :cod_producto AND T_INS.COD_PRODUCCION = :cod_produccion AND T_INS.N_BACHADA = :numero_bachada
        ");

        $query->bindParam(':cod_producto', $cod_producto);
        $query->bindParam(':cod_produccion', $cod_produccion);

        $query->bindParam(':numero_bachada', $numero_bachada);

        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_datos_item_insumo($cod_avance_insumo)
    {
        $query = $this->db->prepare("SELECT T_ENV_ITEM.CODIGO_INTERNO, T_ENV_ITEM.HORA_INICIAL, 
        T_ENV_ITEM.HORA_FINAL, T_ENV_ITEM.PESO, T_ENV_ITEM.OBSERVACIONES, T_ENV_ITEM.ACCION_CORRECTIVA
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS
        JOIN T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS_ITEM T_ENV_ITEM ON T_INS.COD_AVANCE_INSUMOS = T_ENV_ITEM.COD_AVANCE_INSUMO
        WHERE T_ENV_ITEM.COD_AVANCE_INSUMO = :cod_avance_insumo
        ");

        $query->bindParam(':cod_avance_insumo', $cod_avance_insumo);

        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_datos_insumo_version()
    {
        $query = $this->db->prepare("SELECT * FROM T_VERSION_GENERAL WHERE NOMBRE = 'LBS-OP-FR-03'");
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }



    public function traer_datos_generales_sensorial($cod_producto, $cod_produccion, $numero_bachada)
    {
        $query = $this->db->prepare("SELECT T_PRODUCTO.DES_PRODUCTO, T_INS.COD_PRODUCTO, T_INS.N_BACHADA, T_INS.CANT_INSUMOS, T_INS.ESTADO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.COD_PRODUCCION, 
        T_INS.COD_AVANCE_INSUMOS, T_INS.FECHA, T_ENV.COD_PERSONAL, T_ENV.MERMA, T_ENV.TOTAL_MEZCLA
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS 
        JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
        JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        JOIN T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS T_ENV ON T_INS.COD_AVANCE_INSUMOS = T_ENV.COD_AVANCE_INSUMO
        WHERE T_INS.ESTADO = '1' AND T_INS.COD_PRODUCTO = :cod_producto AND T_INS.COD_PRODUCCION = :cod_produccion AND T_INS.N_BACHADA = :numero_bachada
        ");

        $query->bindParam(':cod_producto', $cod_producto);
        $query->bindParam(':cod_produccion', $cod_produccion);

        $query->bindParam(':numero_bachada', $numero_bachada);

        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_datos_item_sensorial($cod_avance_insumo)
    {
        $query = $this->db->prepare("SELECT T_ENV_SENSO.FECHA, T_ENV_SENSO.HORA, T_PRODUCTO.DES_PRODUCTO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.N_BACHADA, T_ENV_SENSO.EVA_POL_COL, 
        T_ENV_SENSO.EVA_POL_OLO, T_ENV_SENSO.EVA_POL_APA, T_ENV_SENSO.EVA_REC_COL, T_ENV_SENSO.EVA_REC_OLO, T_ENV_SENSO.EVA_REC_SAB, T_ENV_SENSO.EVA_REC_APA, T_ENV_SENSO.EVA_REC_TEX, 
        T_ENV_SENSO.EST_SENSORIAL, T_ENV_SENSO.ANALISTA, T_ENV_SENSO.OBSERVACION_SE, T_ENV_SENSO.ACCION_CORRECTIVA_SE
                FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS
                JOIN T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS_SENSORIAL T_ENV_SENSO ON T_INS.COD_AVANCE_INSUMOS = T_ENV_SENSO.COD_AVANCE_INSUMO
                JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
                JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
                WHERE T_ENV_SENSO.COD_AVANCE_INSUMO = :cod_avance_insumo
        ");

        $query->bindParam(':cod_avance_insumo', $cod_avance_insumo);

        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_datos_sensorial_version()
    {
        $query = $this->db->prepare("SELECT * FROM T_VERSION_GENERAL WHERE NOMBRE = 'LBS-FR-OP-06'");
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }




}


?>
