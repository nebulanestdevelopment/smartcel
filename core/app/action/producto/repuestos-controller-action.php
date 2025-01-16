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


if(isset($_GET['method']) && $_GET['method'] == "get-all"){
    $data = (new RepuestosData)->getAll();
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){
    Roles::validHasAdmin();
    $repuesto = new RepuestosData();
    $repuesto->name = ' ';
    $repuesto->description = $_POST['description'];
    $repuesto->compatibilidad = $_POST['compatibilidad'];
    $repuesto->inventary_min = intval($_POST['mininv']);
    $repuesto->unit = intval($_POST['invini']);
    $repuesto->price_in = floatval($_POST['compra_c']);  
    $repuesto->price_in_d =floatval($_POST['compra_d']);  
    $repuesto->price_out = floatval($_POST['venta_c']);  
    $repuesto->price_out_d = floatval($_POST['venta_d']);  
    $repuesto->price_out_es = floatval($_POST['esp_c']);  
    $repuesto->price_out_es_d = floatval($_POST['esp_d']);  
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->person_id = $_POST['proveedor'];
    $repuesto->marca = $_POST['marca'];
    $repuesto->modelo = $_POST['modelo'];
    $repuesto->color = $_POST['color'];
    $repuesto->category_id = $_POST['categoria'];
    $repuesto->created_at = date("Y-m-d H:i:s",strtotime($_POST['fecha']));;
    $repuesto->facturano = $_POST['factura'];
    $save = $repuesto->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
    $data = (new RepuestosData)->getById($_GET['id']);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    Roles::validHasAdmin();
    $repuesto = new RepuestosData();
    $repuesto->id = $_POST['id'];
    $repuesto->name = ' ';
    $repuesto->description = $_POST['description'];
    $repuesto->compatibilidad = $_POST['compatibilidad'];
    $repuesto->inventary_min = intval($_POST['mininv']);
    $repuesto->price_in = floatval($_POST['compra_c']);  
    $repuesto->price_in_d =floatval($_POST['compra_d']);  
    $repuesto->price_out = floatval($_POST['venta_c']);  
    $repuesto->price_out_d = floatval($_POST['venta_d']);  
    $repuesto->price_out_es = floatval($_POST['esp_c']);  
    $repuesto->price_out_es_d = floatval($_POST['esp_d']);  
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->person_id = $_POST['proveedor'];
    $repuesto->marca = $_POST['marca'];
    $repuesto->modelo = $_POST['modelo'];
    $repuesto->color = $_POST['color'];
    $repuesto->category_id = $_POST['categoria'];
    $repuesto->created_at = date("Y-m-d H:i:s",strtotime($_POST['fecha']));;
    $repuesto->facturano = $_POST['factura'];
    $repuesto->is_active = intval($_POST['active']);
    $save = $repuesto->update();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update-inventario"){
    Roles::validHasAdmin();
    $repuesto = new RepuestosData();
    $repuesto->id = $_POST['id'];
    $repuesto->justificacion = $_POST['justificacion'];
    $repuesto->price_in = intval($_POST['aumentar']);
    $repuesto->price_out = intval($_POST['decrementar']);
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->created_at = date("Y-m-d H:i:s");;
    $save = $repuesto->updateInventario();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
    Roles::validHasAdmin();
    $id=intval($_POST["id"]);
    $resultado = (new ProductoData)->eliminarProducto($id);
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='duplicar-producto'){
    Roles::validHasAdmin();
    
    $id=filter_var($_POST["id"], FILTER_VALIDATE_INT);
    $resultado = (new RepuestosData)->duplicar($id);
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg'],'id' => $resultado['id']]);
    exit;
}






?>