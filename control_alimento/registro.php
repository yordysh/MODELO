<?php 
$datosFinal =[];
    for($i = 1; $i < 8; $i++){
        $datos =[
            "codProducto"=> $_POST['comboProducto'],
            "comboProduccion"=> $_POST['comboProduccion'],
            "lote" => $_POST['lote'.$i],
            "cantidad" => $_POST['cant'.$i],
        ];
        array_push($datosFinal, $datos);
    }
    $modeloGUardar = new Modelo();
    $modeloGUardar->insertar($datos);
