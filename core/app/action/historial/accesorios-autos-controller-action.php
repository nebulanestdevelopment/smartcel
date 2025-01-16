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


if(isset($_GET['method']) && $_GET['method'] == "movimientos" && $_GET['id'] != ""){
    $data = (new AccesoriosAutosData)->getMovimientosById($_GET['id']);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "delete-operation"){
    Roles::validHasAdmin();
    $save = (new RepuestosData)->eliminarOperacion($_POST['oid'],$_POST['pid']);
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}


?>