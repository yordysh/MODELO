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

//////////////////////

    public function GuardarDatosMaqueta($codigo_avance_insumo, $cod_encargado, $totalMerma, $codigo_interno, $hora_inicial, $hora_final, $peso, $observaciones, $acciones_correctivas, $contadorFilas, $totalMezcla)
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

            $this->db->commit();
            return true;
        }   catch (Exception $e) {
            $this->db->rollBack();
            echo "Error: " . $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
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

    public function traer_datos_generales_insumo($cod_producto, $cod_produccion)
    {
        $query = $this->db->prepare("SELECT T_PRODUCTO.DES_PRODUCTO, T_INS.COD_PRODUCTO, T_INS.N_BACHADA, T_INS.CANT_INSUMOS, T_INS.ESTADO, T_TMPPRODUCCION.NUM_PRODUCION_LOTE, T_INS.COD_PRODUCCION, 
        T_INS.COD_AVANCE_INSUMOS, T_INS.FECHA, T_ENV.COD_PERSONAL, T_ENV.MERMA, T_ENV.TOTAL_MEZCLA
        FROM T_TMPAVANCE_INSUMOS_PRODUCTOS T_INS 
        JOIN T_TMPPRODUCCION ON T_INS.COD_PRODUCCION = T_TMPPRODUCCION.COD_PRODUCCION
        JOIN T_PRODUCTO ON T_INS.COD_PRODUCTO = T_PRODUCTO.COD_PRODUCTO
        JOIN T_TMPAVANCE_INSUMOS_PRODUCTOS_ENVASADOS T_ENV ON T_INS.COD_AVANCE_INSUMOS = T_ENV.COD_AVANCE_INSUMO
        WHERE T_INS.ESTADO = '1' AND T_INS.COD_PRODUCTO = :cod_producto AND T_INS.COD_PRODUCCION = :cod_produccion
        ");

        $query->bindParam(':cod_producto', $cod_producto);
        $query->bindParam(':cod_produccion', $cod_produccion);

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

}


?>
