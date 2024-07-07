<?php

//Cargar la Librerías 
require_once '../../vendor/autoload.php'; 
require_once '../../models/kardex.php';

/* Espacios de nombres */
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    ob_start();

    //Instancia
    $kardex = new Kardex();

    //Estilos
    require_once '../estilos.html';

    //Datos backend
    $fechaActual = date('m-d-Y');
    
    //Realiza una consulta para obtener el idtipoproducto 
    $datosPRO = $kardex->getkardex(['idproducto' => $_GET['idproducto']]);
    
    // Verificar tiene datos, si no tiene registros mostrará un mensaje y volverá a filtro.php
    if (empty($datosPRO)) {
        echo '<script>alert("No se encontraron registros para el producto seleccionado.");</script>';
        echo '<script>window.location.href = "./index.php";</script>';
        exit;
    }
    
    //Plantilla
    require_once './contenido.php';

    $content = ob_get_clean();

    $html2pdf = new Html2Pdf('L', 'A4', 'es', true, 'UTF-8', array(15,15,15,15));
    $html2pdf->writeHTML($content);
    $html2pdf->output('PDF-Generado-PHP.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}