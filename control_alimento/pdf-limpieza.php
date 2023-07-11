<?php
ob_start();

include "htmlLimpiezaPDF.php";

$html = ob_get_clean();


require_once 'DomPDF/autoload.inc.php';

$dompdf = new Dompdf\Dompdf();

$options = $dompdf->getOptions();
// $options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A2', 'landscape');
$dompdf->render();
$dompdf->stream('LimpiezayDesinfeccion.pdf', array('Attachment' => 0));
