<?php

class DataBase
{
    /*Database::Conectar()*/
    public static  function Conectar()
    {
        try {
            //$base_de_datos = new PDO("sqlsrv:server=vpnsmp.ddns.net;database=ALMACENES", "raul", "raul@01/");
            $base_de_datos = new PDO("sqlsrv:server=DESKTOP-C8GLM7A;database=ALMACEN2", "sa", "123");
            //$base_de_datos = new PDO("sqlsrv:server=DESKTOP-C8GLM7A;database=empleadosLista", "sa", "123");
            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $base_de_datos;
        } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e;
        }
    }
}
