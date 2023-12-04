<?php
date_default_timezone_set('America/Lima');
require_once('../funciones/DataDinamicaA.php');


    class M_BaseDinamica
    { 
    private $db;

    public function __construct($bd)
    {
        $this->db = DatabaseDinamica::Conectarbd($bd);
    }

    public function buscar_personal()
    {
        $query = $this->db->prepare("SELECT COD_PERSONAL, NOM_PERSONAL1 FROM T_PERSONAL");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $formattedResults = [];
        foreach ($results as $result) {
            $formattedResults[] = ['label' => $result['NOM_PERSONAL1'], 'codigo' => $result['COD_PERSONAL']];
        }
        return $formattedResults;
    }


    public function obtener_nombre_personal($cod_personal)
    {
        $query = $this->db->prepare("SELECT NOM_PERSONAL1 FROM T_PERSONAL WHERE COD_PERSONAL = :cod_personal");
        $query->bindParam(':cod_personal', $cod_personal);
        $query->execute();
        $resultados = $query->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

    
    

}
?>