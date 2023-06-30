<?php

class DataBase
{
    /*Database::Conectar()*/
    public static  function Conectar()
    {
        try {
            // $base_de_datos = new PDO("sqlsrv:server=DESKTOP-C8GLM7A;database=monitoring", "sa", "123");
            $base_de_datos = new PDO("sqlsrv:server=YORDY;database=monitoring", "sa", "70836940");

            $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $base_de_datos;
        } catch (Exception $e) {
            echo "Ocurrió un error con la base de datos: " . $e;
        }
    }
}
