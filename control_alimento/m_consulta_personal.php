<?php

require_once("../funciones/DataDinamicaA.php");


class m_almacen_consulta
{

    private $bd_dinamica;
    public function __construct($bd_dinamica)
    {
        $this->bd_dinamica = $bd_dinamica;
        $this->bd_dinamica = DatabaseDinamica::Conectarbd($this->bd_dinamica);
    }


    public function MostrarNomPersonal($codigopersonalsmp2)
    {
        try {

            $stm = $this->bd_dinamica->prepare("SELECT NOM_PERSONAL1 AS NOM_PERSONAL1, COD_PERSONAL AS COD_PERSONAL FROM T_PERSONAL WHERE COD_PERSONAL='$codigopersonalsmp2'");
            $stm->execute();
            $datos = $stm->fetchAll(PDO::FETCH_OBJ);

            return $datos;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function MostrarDatosPersonal()
    {
        try {

            $stm = $this->bd_dinamica->prepare("SELECT * FROM T_PERSONAL");
            $stm->execute();
            $datos = $stm->fetchAll(PDO::FETCH_OBJ);

            return $datos;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
