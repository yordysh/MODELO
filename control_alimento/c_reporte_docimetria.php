<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("m_reporte_docimetria.php");
require_once "m_consulta_personal.php";


$accion = $_POST['accion'];
if ($accion == 'reporte') {
    c_reporte_docimetria::c_reporte();
}



class c_reporte_docimetria
{

    static function c_reporte()
    {
        $m_docimetria = new m_reporte_docimetria();
        $cab = $m_docimetria->m_reporte_cabecera();
        $version = $m_docimetria->m_reporte_version();
        $fecha = explode(" ", $version[0][4]);
        $mes =  explode("-", $fecha[0]);
        $nommes = c_reporte_docimetria::obtenerNombreMes($mes[2]);

        $oficina = 'SMP2';
        $personal = new m_almacen_consulta($oficina);

        for ($i = 0; $i < count($cab); $i++) {
            $cab[$i][5] = convFecSistema($cab[$i][5]);
            $valor = $personal->MostrarNomPersonalCodigo($cab[$i][7]);

            if (count($valor) > 0) {
                $cab[$i][7] = $valor[0][0];
            } else {
                $cab[$i][7] = '';
            }
            $item = $m_docimetria->m_reporte_item($cab[$i][0]);
            array_push($cab[$i], $item);
        }
        $m = $nommes . " " . $mes[0];
        $dato = array(
            'd' => $cab,
            'c' => count($cab),
            'm' => $m,
            'v' => $version[0][1],
            'n' => $version[0][2],
        );

        echo json_encode($dato, JSON_FORCE_OBJECT);
    }

    static function obtenerNombreMes($numeroMes)
    {
        $meses = [
            1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo",
            6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre",
            11 => "Noviembre", 12 => "Diciembre"
        ];
        return $meses[$numeroMes];
    }
}
