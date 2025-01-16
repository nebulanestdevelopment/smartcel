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


if(isset($_GET['method']) && $_GET['method'] == "get-all-compras"){
    $data = (new ComprasData)->getAllBuys($_GET['fechainicio'],$_GET['fechafinal']);
    echo json_encode(['data' => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "delete-operation"){
    Roles::validHasAdmin();
    $save = (new RepuestosData)->eliminarOperacion($_POST['oid'],$_POST['pid']);
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "delete"){
  Roles::validHasAdmin();
  $save = (new ComprasData)->delete($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-compra"){
  
  Roles::validHasAdmin();
  if(!isset($_SESSION['reabastecer']) || count($_SESSION['reabastecer'])  == 0 ){
    http_response_code(400);
    echo json_encode(['msg' => "No hay ningun producto agregado para procesar la compra..."]);
    exit;
  }
  $cart = $_SESSION['reabastecer'];
  $total = 0;
  $totald = 0;
  foreach ($cart as $key => $v) {
    $total  += floatval($v['pcc']) * intval($v['q']);
    $totald += floatval($v['pcd']) * intval($v['q']);
  }

  $compra = new ComprasData();
  $compra->person_id = filter_var($_POST["proveedor"], FILTER_VALIDATE_INT);
  $compra->user_id = intval($_SESSION['user_id']);
  $compra->operation_type_id = 1;
  $compra->box_id = 0;
  $compra->total = $total;
  $compra->total_d = $totald;
  $compra->cash = 0;
  $compra->cash_d= 0;
  $compra->discount = 0;
  $compra->discount_d = 0;
  $compra->sell_type = 0;
  $compra->saldo= 0;
  $compra->status = 1;
  $compra->compra_type = filter_var($_POST["tipo"], FILTER_VALIDATE_INT);
  $compra->compra_saldo = 0;
  $compra->compra_status = 1;  
  $compra->facturano = strip_tags($_POST['factura']);
  $compra->created_at = date('Y-m-d',strtotime($_POST['fecha']));
  $save = $compra->save();
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg'],'id'=>$save['id']]);
  exit;
}


?>
