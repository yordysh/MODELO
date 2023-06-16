<?php
require_once '../assets/DomPDF/autoload.inc.php';

use Dompdf\Dompdf;

// Create an instance of Dompdf
$pdf = new Dompdf();
$html = file_get_contents("http://localhost/modelo/php/tablaInfraestructura.php");
$pdf->loadHtml($html);
$pdf->setPaper("A4", "landingpage");
$pdf->render();
$pdf->stream("archivo.pdf");

// $html = ob_get_clean();
