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


$total_c = 0;
$total_d = 0;
if(isset($_SESSION["cart-repair"]) && count($_SESSION["cart-repair"]) > 0){
    $cart = $_SESSION["cart-repair"];
    foreach ($cart as $v) {
        $total_c += (floatval($v['pvc']) * intval($v['q'])) - floatval($v['desc_c']);
        $total_d += (floatval($v['pvd']) * intval($v['q'])) - floatval($v['desc_d']);
    }
}
echo  json_encode(array("total_c"=>$total_c,"total_d"=>$total_d));
exit();


?>