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


    //BACHADA
    //
    public function EnviarDatosProductosYLotesBusqueda()
    {
        $query = $this->db->prepare("SELECT T_ENV_KA.COD_PRODUCTO, T_PRODUCTO.DES_PRODUCTO, T_ENV_KA.LOTE
        FROM T_ENVASE_KARDEX T_ENV_KA
        JOIN T_PRODUCTO ON T_ENV_KA.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        WHERE ESTADO IN ('P', 'S')
        GROUP BY T_ENV_KA.COD_PRODUCTO, T_PRODUCTO.DES_PRODUCTO, T_ENV_KA.LOTE
        ORDER BY T_ENV_KA.COD_PRODUCTO ASC");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = ['label' => $result['DES_PRODUCTO'], 'cod_producto' => $result['COD_PRODUCTO'], 'lote_b' => $result['LOTE']];
        }
        return $formattedResults;
    }

    public function pre_carga_datos_pendientes_bachada($cod_producto_busca, $cod_lote_busca)
    {
        $query = $this->db->prepare("SELECT T_ENV_KA.ID, T_ENV_KA.COD_AVANCE_INSUMO, T_ENV_KA.COD_PRODUCCION, T_ENV_KA.TOTAL_MEZCLA_PESO, T_ENV_KA.TOTAL_ITEM_BOLSAS,
        T_ENV_KA.COD_PRODUCTO, T_ENV_KA.FECHA_MEZCLADO, T_ENV_KA.LOTE, T_ENV_KA.BACHADA, T_ENV_KA.FECHA_PRODUCCION, T_ENV_KA.FECHA_VENCIMIENTO,
         T_ENV_KA.INGRESO, T_ENV_KA.EGRESO, T_ENV_KA.STOCK, T_ENV_KA.SALDO, T_ENV_KA.ESTADO, T_PRODUCTO.DES_PRODUCTO,
          T_PRODUCTO.ABR_PRODUCTO, T_PRODUCTO.PESO_NETO
         FROM T_ENVASE_KARDEX T_ENV_KA
        JOIN T_PRODUCTO ON T_ENV_KA.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO WHERE ESTADO IN ('P', 'S') AND T_ENV_KA.COD_PRODUCTO = :cod_producto AND T_ENV_KA.LOTE = :lote ORDER BY ID ASC");
        $query->bindParam(':cod_producto', $cod_producto_busca);
        $query->bindParam(':lote', $cod_lote_busca);
        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_dato_maqueta_bachada($id_bachada)
    {
        $query = $this->db->prepare("SELECT T_ENV_KA.ID, T_ENV_KA.COD_AVANCE_INSUMO, T_ENV_KA.COD_PRODUCCION, T_ENV_KA.TOTAL_MEZCLA_PESO, T_ENV_KA.TOTAL_ITEM_BOLSAS,
        T_ENV_KA.COD_PRODUCTO, T_ENV_KA.FECHA_MEZCLADO, T_ENV_KA.LOTE, T_ENV_KA.BACHADA, T_ENV_KA.FECHA_PRODUCCION, T_ENV_KA.FECHA_VENCIMIENTO,
         T_ENV_KA.INGRESO, T_ENV_KA.EGRESO, T_ENV_KA.STOCK, T_ENV_KA.SALDO, T_ENV_KA.ESTADO, T_PRODUCTO.DES_PRODUCTO,
          T_PRODUCTO.ABR_PRODUCTO, T_PRODUCTO.PESO_NETO
        FROM T_ENVASE_KARDEX T_ENV_KA
       JOIN T_PRODUCTO ON T_ENV_KA.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        WHERE T_ENV_KA.ID = :id_bachada ORDER BY ID ASC
        ");
        $query->bindParam(':id_bachada', $id_bachada);
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_dato_restantes_id($id_bachada)
    {
        $query = $this->db->prepare("SELECT * FROM T_ENVASE_KARDEX WHERE ID = :id
        ");
        $query->bindParam(':id', $id_bachada);
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function GuardarDatosBachada($codigo_id_kardex, $cod_avance_insumo, $cod_produccion, $total_mezcla_peso, $total_item_bolsas, $cod_producto, $fecha_mezclado, $lote,
    $numero_bachada, $fecha_produccion, $fecha_vencimiento, $ingreso, $egreso, $stock, $saldo, $estado, $cant_programada_unidades, 
    $peso_estimado_kg, $can_bol_select, $peso_total_select, $mezcla_select_bol_inco, $mezcla_sobrante, $mezcla_env_total, $cant_estimada_unidad, $cant_bol_sobrante, $peso_total_bol_sobrante, 
    $cod_personal, $observaciones_envasado, $acc_correctiva_envasado, $codigo_id_kardex_sobrante, $bachada_anterior)
    {
        try {
            $this->db->beginTransaction();
    
            $query3 = $this->db->prepare("UPDATE T_ENVASE_KARDEX SET ESTADO = 'F' WHERE ID = :id");
            $query3->bindParam(':id', $codigo_id_kardex);
            $query3->execute();

            $query1 = $this->db->prepare("UPDATE T_ENVASE_KARDEX SET ESTADO = 'X' WHERE ID = :id_sobrante");
            $query1->bindParam(':id_sobrante', $codigo_id_kardex_sobrante);
            $query1->execute();

            if ($mezcla_sobrante == '0'){
            $query5 = $this->db->prepare("INSERT INTO T_ENVASE_KARDEX (COD_AVANCE_INSUMO, COD_PRODUCCION, TOTAL_MEZCLA_PESO, TOTAL_ITEM_BOLSAS, COD_PRODUCTO, FECHA_MEZCLADO, LOTE, 
            BACHADA, FECHA_PRODUCCION, FECHA_VENCIMIENTO, INGRESO, EGRESO, STOCK, SALDO, ESTADO)
            VALUES (:cod_avance_insumo, :cod_produccion, :total_mezcla_peso, :total_item_bolsas, :cod_producto, CONVERT(DATE, :fecha_mezclado), :lote, :bachada,
             CONVERT(DATE, :fecha_produccion), CONVERT(DATE, :fecha_vencimiento), :ingreso, :egreso, :stock, :saldo, 'N')
            ");
            $query5->bindParam(':cod_avance_insumo', $cod_avance_insumo);
            $query5->bindParam(':cod_produccion', $cod_produccion);
            $query5->bindParam(':total_mezcla_peso', $total_mezcla_peso);
            $query5->bindParam(':total_item_bolsas', $total_item_bolsas);
            $query5->bindParam(':cod_producto', $cod_producto);
            $query5->bindParam(':fecha_mezclado', $fecha_mezclado);
            $query5->bindParam(':lote', $lote);
            $query5->bindParam(':bachada', $numero_bachada);
            $query5->bindParam(':fecha_produccion', $fecha_produccion);
            $query5->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $query5->bindParam(':ingreso', $ingreso);
            $query5->bindParam(':egreso', $egreso);
            $query5->bindParam(':stock', $stock);
            $query5->bindParam(':saldo', $saldo);
            $query5->execute();

            } else {
                $query5 = $this->db->prepare("INSERT INTO T_ENVASE_KARDEX (COD_AVANCE_INSUMO, COD_PRODUCCION, TOTAL_MEZCLA_PESO, TOTAL_ITEM_BOLSAS, COD_PRODUCTO, FECHA_MEZCLADO, LOTE, 
                BACHADA, FECHA_PRODUCCION, FECHA_VENCIMIENTO, INGRESO, EGRESO, STOCK, SALDO, ESTADO)
                VALUES (:cod_avance_insumo, :cod_produccion, :total_mezcla_peso, :total_item_bolsas, :cod_producto, CONVERT(DATE, :fecha_mezclado), :lote, :bachada,
                 CONVERT(DATE, :fecha_produccion), CONVERT(DATE, :fecha_vencimiento), :ingreso, :egreso, :stock, :saldo, 'S')
                ");
                $query5->bindParam(':cod_avance_insumo', $cod_avance_insumo);
                $query5->bindParam(':cod_produccion', $cod_produccion);
                $query5->bindParam(':total_mezcla_peso', $total_mezcla_peso);
                $query5->bindParam(':total_item_bolsas', $total_item_bolsas);
                $query5->bindParam(':cod_producto', $cod_producto);
                $query5->bindParam(':fecha_mezclado', $fecha_mezclado);
                $query5->bindParam(':lote', $lote);
                $query5->bindParam(':bachada', $numero_bachada);
                $query5->bindParam(':fecha_produccion', $fecha_produccion);
                $query5->bindParam(':fecha_vencimiento', $fecha_vencimiento);
                $query5->bindParam(':ingreso', $ingreso);
                $query5->bindParam(':egreso', $egreso);
                $query5->bindParam(':stock', $stock);
                $query5->bindParam(':saldo', $saldo);
                $query5->execute();
            }
            
                $query6 = $this->db->prepare("INSERT INTO T_CONTROL_BACHADAS_REPORTE (FECHA_MEZCLADO, NUMERO_BACHADA, PESO_TOTAL_OBTENIDO, CANT_BOLSAS, CANT_PROGRAMADA_UNIDADES, 
                PESO_ESTIMADO, CANT_BOL_SELECT, PESO_TOTAL_SELECT, MEZCLA_SELECT_BOL_INCO, MEZCLA_SOBRANTE, MEZCLA_ENV_TOTAL, CANT_ESTIMADA, CANT_BOL_SOBRANTE, PESO_TOTAL_BOL_SOBRANTE, 
                LOTE, FECHA_PRODUCCION, FECHA_VENCIMIENTO, COD_PRODUCTO, COD_PERSONAL, OBSERVACIONES_ENV, ACCION_CORRECTIVA_ENV, BACHADA_ANTERIOR)
                VALUES (:fecha_mezclado, :numero_bachada, :peso_total_obtenido, :cant_bolsas, :cant_programada_unidades, :peso_estimado, :cant_bol_select, :peso_total_select,
                 :mezcla_select_bol_inco, :mezcla_sobrante, :mezcla_env_total, :cant_estimada, :cant_bol_sobrante, :peso_total_bol_sobrante, :lote, CONVERT(DATE, :fecha_produccion), 
                 CONVERT(DATE, :fecha_vencimiento), :cod_producto, :cod_personal, :observaciones_envasado, :acc_correctiva_envasado, :bachada_anterior)
                ");
                $query6->bindParam(':fecha_mezclado', $fecha_mezclado);
                $query6->bindParam(':numero_bachada', $numero_bachada);
                $query6->bindParam(':peso_total_obtenido', $total_mezcla_peso);
                $query6->bindParam(':cant_bolsas', $total_item_bolsas);
                $query6->bindParam(':cant_programada_unidades', $cant_programada_unidades);
                $query6->bindParam(':peso_estimado', $peso_estimado_kg);
                $query6->bindParam(':cant_bol_select', $can_bol_select);
                $query6->bindParam(':peso_total_select', $peso_total_select);
                $query6->bindParam(':mezcla_select_bol_inco', $mezcla_select_bol_inco);
                $query6->bindParam(':mezcla_sobrante', $mezcla_sobrante);
                $query6->bindParam(':mezcla_env_total', $mezcla_env_total);
                $query6->bindParam(':cant_estimada', $cant_estimada_unidad);
                $query6->bindParam(':cant_bol_sobrante', $cant_bol_sobrante);
                $query6->bindParam(':peso_total_bol_sobrante', $peso_total_bol_sobrante);
                $query6->bindParam(':lote', $lote);
                $query6->bindParam(':fecha_produccion', $fecha_produccion);
                $query6->bindParam(':fecha_vencimiento', $fecha_vencimiento);
                $query6->bindParam(':cod_producto', $cod_producto);
                $query6->bindParam(':cod_personal', $cod_personal);
                $query6->bindParam(':observaciones_envasado', $observaciones_envasado);
                $query6->bindParam(':acc_correctiva_envasado', $acc_correctiva_envasado);

                $query6->bindParam(':bachada_anterior', $bachada_anterior);
                
                $query6->execute();
            
            

            $this->db->commit();
            return true;
        }   catch (Exception $e) {
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }



    public function TraerDatosProducto_lote_envasado()
    {
        $query = $this->db->prepare("SELECT MAX(T_PRODUCTO.COD_PRODUCTO) AS COD_PRODUCTO, MAX(T_PRODUCTO.DES_PRODUCTO) AS DES_PRODUCTO, MAX(T_CO_BAC.LOTE) AS LOTE,
         MAX(T_CO_BAC.NUMERO_BACHADA) AS NUMERO_BACHADA
        FROM T_CONTROL_BACHADAS_REPORTE
        T_CO_BAC JOIN T_PRODUCTO ON T_CO_BAC.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        GROUP BY T_CO_BAC.COD_PRODUCTO");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = ['label' => $result['DES_PRODUCTO'], 'cod_producto' => $result['COD_PRODUCTO'], 'lote_b' => $result['LOTE']];
        }
        return $formattedResults;
    }




    public function traer_datos_reporte_bachada_pdf($cod_producto, $cod_lote)
    {
        $query = $this->db->prepare("SELECT T_CO_BACH.ID, T_CO_BACH.FECHA_MEZCLADO, T_CO_BACH.NUMERO_BACHADA, T_CO_BACH.PESO_TOTAL_OBTENIDO, T_CO_BACH.CANT_BOLSAS, T_CO_BACH.CANT_PROGRAMADA_UNIDADES, 
        T_CO_BACH.PESO_ESTIMADO, T_CO_BACH.CANT_BOL_SELECT, T_CO_BACH.PESO_TOTAL_SELECT, T_CO_BACH.MEZCLA_SELECT_BOL_INCO, T_CO_BACH.MEZCLA_SOBRANTE, T_CO_BACH.MEZCLA_ENV_TOTAL, 
        T_CO_BACH.CANT_ESTIMADA, T_CO_BACH.CANT_BOL_SOBRANTE, T_CO_BACH.PESO_TOTAL_BOL_SOBRANTE, T_CO_BACH.LOTE, T_CO_BACH.FECHA_PRODUCCION, T_CO_BACH.FECHA_VENCIMIENTO, T_CO_BACH.BACHADA_ANTERIOR, 
        T_CO_BACH.COD_PERSONAL, T_PRODUCTO.ABR_PRODUCTO, T_PRODUCTO.PESO_NETO, T_CO_BACH.OBSERVACIONES_ENV
        
         FROM T_CONTROL_BACHADAS_REPORTE T_CO_BACH
        JOIN T_PRODUCTO ON T_CO_BACH.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        
         WHERE T_CO_BACH.COD_PRODUCTO = :cod_producto AND T_CO_BACH.LOTE = :cod_lote

         ORDER BY T_CO_BACH.ID ASC
        ");

        $query->bindParam(':cod_producto', $cod_producto);
        $query->bindParam(':cod_lote', $cod_lote);

        $query->execute();
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function traer_datos_envasado_version()
    {
        $query = $this->db->prepare("SELECT * FROM T_VERSION_GENERAL WHERE NOMBRE = 'LBS-OP-FR-04'");
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

















    public function ValorFormula($cantidadinsumo)
    {
        try {
        $this->db->beginTransaction();
        $resultadofinal = ($cantidadinsumo * 100 / 60);
        $resultadofinal = $this->db->commit();
        return $resultadofinal;
        } catch (Exception $e) {

        die($e->getMessage());
        }
    }


}


?>
