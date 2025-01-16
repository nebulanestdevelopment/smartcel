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


if(isset($_GET['method']) && $_GET['method'] == "cerrar-reparaciones"){
 // Roles::validHasAdmin();
  ReparacionData::cerrarReparaciones();
  header('location: index.php?view=reparacion/abiertas');
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-reparacion-data"){
   $data = ReparacionData::getReparacionesData($_GET['id']);
   http_response_code(200);
   echo json_encode($data);
   exit;
 }else if(isset($_POST['method']) && $_POST['method'] == "delete"){
  Roles::validHasAdmin();
  $save = (new ReparacionData)->delete($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "revertir-reparacion"){
 // Roles::validHasAdmin();
  $save = (new ReparacionData)->revertirReparaciones($_POST['fecha']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "reparado"){
   $save = (new ReparacionData)->marcarReparado($_POST['id']);
   $code = (!$save['code'])?400:201;
   http_response_code($code);
   echo json_encode(['msg' => $save['msg']]);
   exit;
 }else if(isset($_POST['method']) && $_POST['method'] == "no-reparado"){
  $save = (new ReparacionData)->marcarNoReparado($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-reparacion"){
 

  $repuesto = "";
  $repuesto_id = "";
  $costo_c = 0;
  $costo_d = 0;
  $total_c = 0;
  $total_d = 0;
  $desc_c = 0;
  $desc_d = 0;

if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0){
  $cart = $_SESSION['cart-repair'];
  foreach ($cart as $key => $v) {  
      $repuesto .= " ". trim(ProductoData::getProductName($v['product_id'])) .' +';  
      $repuesto_id .= " ".$v['product_id'].','; 
      $costo_c  += ((floatval($v['pvc']) * intval($v['q'])) - floatval($v['desc_c']));
      $costo_d  += ((floatval($v['pvd']) * intval($v['q']))  - floatval($v['desc_d']));   
      $total_c  += (floatval($v['pvc']) * intval($v['q'])) ;
      $total_d  += (floatval($v['pvd']) * intval($v['q']));
      $desc_c   += floatval($v['desc_c']);
      $desc_d   += floatval($v['desc_d']);
  }
  $repuesto = rtrim($repuesto, '+');
  $repuesto_id = rtrim($repuesto_id, ',');
}

$_POST['cash_c'] = $total_c;
$_POST['cash_d'] = $total_d;
$_POST['discount'] = $desc_c;
$_POST['discount_d'] = $desc_d;

 $cliente = (intval($_POST["cliente_id"]) == 2)?$_POST['cliente_anonimo']:' ';  
 if(intval($_POST["cliente_id"]) != 2 ){
    $data = ClienteData::getById(intval($_POST["cliente_id"]));
    $cliente = $data['name'].' '.$data['lastname'];
 }



 $tecnico_data = UsuarioData::getById(intval($_POST['tecnico'])); 
 $tecnico = $tecnico_data['nombre'].' '.$tecnico_data['apellido'];

  $r = new ReparacionData();
  $r->id = 0;
  $r->status = 0;
  $r->client_id = filter_var($_POST["cliente_id"], FILTER_VALIDATE_INT);
  $r->cliente = $cliente;
  $r->facturano = (trim($_POST['factura']) != "")?strip_tags($_POST['factura']):0;  
  $r->sell_id = 0;
  $r->tecnico = $tecnico;
  $r->tecnico_id = filter_var($_POST["tecnico"], FILTER_VALIDATE_INT);;
  $r->descripcion = strip_tags($_POST['descripcion']);  ;
  $r->repuesto = $repuesto;
  $r->repuesto_id = $repuesto_id;
  $r->costo_repuesto = $costo_c;
  $r->costo_repuesto_d = $costo_d;
  $r->costo_reparacion = floatval($_POST['total_c']);
  $r->costo_reparacion_d = floatval($_POST['total_d']);
  $r->total = (floatval($_POST['total_c']) + $costo_c);
  $r->total_d = (floatval($_POST['total_d']) + $costo_d);
  $r->nota = " ";
  $r->estado_taller = 'Pendiente';
  $r->fecha_reparacion = date('Y-m-d', strtotime($_POST['fecha']));
  $r->hora_reparacion = date('h:m:s');
  $r->created_at = date('Y-m-d h:m:s');
  $_POST['fecha'] = date('Y-m-d h:i:s', strtotime($_POST['fecha']));
  $save = $r->save($_POST); 
  $code = (!$save['code'])?400:201;
  if($save['code']){
    if (isset($_FILES['imagenes'])) {
      $rootPath = realpath(__DIR__ . '/../../../../');
      $assetsPath = $rootPath . '/storage/reparaciones/'.$save['id'].'/entrada';
      if (!is_dir($assetsPath)) {
        mkdir($assetsPath, 0777, true); 
      }      
      $extension=array("jpeg","jpg","png");
      foreach($_FILES['imagenes']["tmp_name"] as $index => $file){        
        $file_name=$_FILES["imagenes"]["name"][$index];
        $file_tmp=$_FILES["imagenes"]["tmp_name"][$index];
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);
          if(in_array($ext,$extension)) {
            $newname=$index.".".$ext;
            $target =  $assetsPath."/".$newname;
            move_uploaded_file($_FILES['imagenes']['tmp_name'][$index], $target);          
          }       
      }
    }  
  }  
  http_response_code($code);
  echo json_encode(['msg' => $save['msg'],'id'=>$save['id']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update-reparacion"){
 
  $repuesto = "";
  $repuesto_id = "";
  $costo_c = 0;
  $costo_d = 0;
  $total_c = 0;
  $total_d = 0;
  $desc_c = 0;
  $desc_d = 0;

if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0){
  $cart = $_SESSION['cart-repair'];
  foreach ($cart as $key => $v) {  
      $repuesto .= " ". trim(ProductoData::getProductName($v['product_id'])) .' +';  
      $repuesto_id .= " ".$v['product_id'].','; 
      $costo_c  += ((floatval($v['pvc']) * intval($v['q'])) - floatval($v['desc_c']));
      $costo_d  += ((floatval($v['pvd']) * intval($v['q']))  - floatval($v['desc_d']));   
      $total_c  += (floatval($v['pvc']) * intval($v['q'])) ;
      $total_d  += (floatval($v['pvd']) * intval($v['q']));
      $desc_c   += floatval($v['desc_c']);
      $desc_d   += floatval($v['desc_d']);
  }
  $repuesto = rtrim($repuesto, '+');
  $repuesto_id = rtrim($repuesto_id, ',');
}

$_POST['cash_c'] = $total_c;
$_POST['cash_d'] = $total_d;
$_POST['discount'] = $desc_c;
$_POST['discount_d'] = $desc_d;

 $cliente = (intval($_POST["cliente_id"]) == 2)?$_POST['cliente_anonimo']:' ';  
 if(intval($_POST["cliente_id"]) != 2 ){
    $data = ClienteData::getById(intval($_POST["cliente_id"]));
    $cliente = $data['name'].' '.$data['lastname'];
 }



 $tecnico_data = UsuarioData::getById(intval($_POST['tecnico'])); 
 $tecnico = $tecnico_data['nombre'].' '.$tecnico_data['apellido'];

  $r = new ReparacionData();
  $r->id = filter_var($_POST["idr"], FILTER_VALIDATE_INT);;
  $r->status = 0;
  $r->client_id = filter_var($_POST["cliente_id"], FILTER_VALIDATE_INT);
  $r->cliente = $cliente;
  $r->facturano = strip_tags($_POST['factura']);  
  $r->sell_id = 0;
  $r->tecnico = $tecnico;
  $r->tecnico_id = filter_var($_POST["tecnico"], FILTER_VALIDATE_INT);;
  $r->descripcion = strip_tags($_POST['descripcion']);  ;
  $r->repuesto = $repuesto;
  $r->repuesto_id = $repuesto_id;
  $r->costo_repuesto = $costo_c;
  $r->costo_repuesto_d = $costo_d;
  $r->costo_reparacion = floatval($_POST['total_c']);
  $r->costo_reparacion_d = floatval($_POST['total_d']);
  $r->total = (floatval($_POST['total_c']) + $costo_c);
  $r->total_d = (floatval($_POST['total_d']) + $costo_d);
  $r->nota = " ";
  $r->estado_taller = 'Pendiente';
  $r->fecha_reparacion = date('Y-m-d', strtotime($_POST['fecha']));
  $r->hora_reparacion = date('h:m:s');
  $r->created_at = date('Y-m-d h:m:s');
  $_POST['fecha'] = date('Y-m-d h:i:s', strtotime($_POST['fecha']));
  $save = $r->updateRepair($_POST);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg'],'id'=>$save['id']]);
  exit;
}


?>