<?php 
Session::isLogin();
header("Content-Type: application/json; charset=UTF-8");
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
 if (error_reporting() == 0) {
   return;
 }
 if (error_reporting() & $severity) {
   throw new ErrorException($message, 0, $severity, $filename, $lineno);
 }
}

if(isset($_SESSION["cart"])){
    $items = $_SESSION["cart"];
    $dc = 0;
    $dd = 0;
    foreach ($items as $v) {
        $dc += floatval($v['desc_c']);
        $dd += floatval($v['desc_d']);
    }   
    http_response_code(200);
    echo json_encode(['desc_c' => number_format($dc,2,'.',',') ,'desc_d' => number_format($dd,2,'.',',')]);
    exit;
}else{
    http_response_code(200);
    echo json_encode(['desc_c' => 0 ,'desc_d' => 0]);
    exit;
}

?>

