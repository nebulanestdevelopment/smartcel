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


if(isset($_GET['method']) && $_GET['method'] == "get-all-ventas"){
    $data = (new ComprasData)->getAllSells($_GET['fechainicial'],$_GET['fechaifinal']);
    echo json_encode(['data' => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "delete"){
  Roles::validHasAdmin();
  $save = (new SellData)->delete($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "delete-item"){
  Roles::validHasAdmin();
  $save = (new SellData)->deleteItem($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg'],'total' => $save['total']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-venta"){
  
  if(!isset($_SESSION['cart']) || count($_SESSION['cart'])  == 0 ){
    http_response_code(400);
    echo json_encode(['msg' => "No hay ningun producto agregado para procesar la venta..."]);
    exit;
  }

  $cart = $_SESSION['cart'];
  $total_c = 0;
  $total_d = 0;
  $desc_c = 0;
  $desc_d = 0;
  foreach ($cart as $key => $v) {
    
    if($v['is_esp']== 'false'){
      $total_c += (floatval($v['pvc']) * intval($v['q'])) - floatval($v['desc_c']) ;
      $total_d += (floatval($v['pvd']) * intval($v['q'])) - floatval($v['desc_d']) ;
      
    }else{
      $total_c += (floatval($v['pec']) * intval($v['q'])) - floatval($v['desc_c']) ;
      $total_d += (floatval($v['ped']) * intval($v['q'])) - floatval($v['desc_d']) ;
    }
      $desc_c += floatval($v['desc_c']) ;
      $desc_d += floatval($v['desc_d']) ;
    
  }

 
  $sell = new SellData();
  $sell->person_id = filter_var($_POST["cliente_id"], FILTER_VALIDATE_INT);
  $sell->user_id = filter_var($_POST["vendedor"], FILTER_VALIDATE_INT);
  $sell->operation_type_id = 2;
  $sell->is_boxed = 0;
  $sell->box_id = NULL;  
  $sell->related_box = 0;
  $sell->id_caja_a_revertir = 0;
  $sell->total = $total_c;
  $sell->total_d = $total_d;
  $sell->cash = filter_var($_POST["cashc"], FILTER_VALIDATE_FLOAT);
  $sell->cash_d= filter_var($_POST["cashd"], FILTER_VALIDATE_FLOAT);
  $sell->discount = $desc_c;
  $sell->discount_d = $desc_d;
  $sell->sell_type = filter_var($_POST["tipo_venta"], FILTER_VALIDATE_INT);
  $sell->saldo= 0;
  $sell->status = 1;
  $sell->compra_type = 0;
  $sell->compra_saldo = 0;
  $sell->compra_status = 0;  
  $sell->facturano = strip_tags($_POST['factura']);  
  $sell->clienteanonimo = strip_tags($_POST['cliente_anonimo']);
  $sell->justificacion = " ";
  $sell->created_at = date('Y-m-d h:m',strtotime($_POST['fecha']));
  $save = $sell->save();
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg'],'id'=>$save['id']]);
  exit;
}


?>