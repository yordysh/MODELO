<?php
date_default_timezone_set('America/Lima');
require_once("../funciones/DataBaseA.php");
require_once("../funciones/f_funcion.php");

class m_reporte_docimetria{

    private $bd;

    public function __construct()
    {
        $this->bd = DataBase::Conectar();
    } 

    public function m_reporte_cabecera(){
        try {
            $query = $this->bd->prepare("SELECT * FROM V_REPORTE_DOSIMETRIA");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_NUM);
        } catch (Exception $e) {
            print_r("error al buscar datos " .$e->getMessage());
        }
    }

    public function m_reporte_item($codavance){
        try {
            $query = $this->bd->prepare("SELECT * FROM V_INSUMO_DOSIMETRIA WHERE COD_AVANCE_INSUMOS = ?");
            $query->bindParam('1',$codavance,PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_NUM);
        } catch (Exception $e) {
            print_r("error al buscar datos " .$e->getMessage());
        }
    }

    public function m_reporte_version(){
        try {
            $nombre = 'LBS-OP-FR-02';
            $query = $this->bd->prepare("SELECT * FROM T_VERSION_GENERAL WHERE NOMBRE= ? ");
            $query->bindParam('1',$nombre,PDO::PARAM_STR);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_NUM);
        } catch (Exception $e) {
            print_r("error al buscar datos version " .$e->getMessage());
        }
    }

};