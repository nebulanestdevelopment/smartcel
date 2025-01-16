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
    $tc = 0;
    $td = 0;
    foreach ($items as $v) {
      $precio_c = ($v['is_esp'] == "true")?$v['pec']:$v['pvc'];
      $precio_d = ($v['is_esp'] == "true")?$v['ped']:$v['pvd'];
      $tc = floatval($tc) + ((floatval($precio_c) * intval($v['q'])) - floatval($v['desc_c']));
      $td = floatval($td) + ((floatval($precio_d) * intval($v['q'])) - floatval($v['desc_d']));
    }   
    http_response_code(200);
    echo json_encode(['total_c' => $tc,'total_d' => $td]);
    exit;
}

?>

