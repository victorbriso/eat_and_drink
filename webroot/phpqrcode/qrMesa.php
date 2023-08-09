<?php    
    header('Content-Type: application/json');
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $PNG_WEB_DIR = 'temp/';
    include "qrlib.php";  
    $size=5;
    $data=$_GET['data'];
    $id=$_GET['id'];
    $numero=$_GET['numero'];
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);     
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'H';
    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);
    if (isset($_REQUEST['data'])) {                 
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
        copy($PNG_WEB_DIR.basename($filename),$_SERVER['DOCUMENT_ROOT']."/webroot/files/qrs/".$id."/".$numero.".png");
        unlink($PNG_WEB_DIR.basename($filename));
    }
    echo json_encode($id);
    