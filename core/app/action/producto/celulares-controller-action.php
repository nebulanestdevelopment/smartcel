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
    $data = (new CelularesData)->getAll();
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){    
    Roles::validHasAdmin();
    
    $repuesto = new CelularesData();
    $repuesto->image = ' ';
    $repuesto->barcode = strip_tags($_POST['imei1']);
    $repuesto->codigo = ' ';
    $repuesto->imei2 = strip_tags($_POST['imei2']);
    $repuesto->imeivarios = ' ';
    $repuesto->type = 2;
    $repuesto->name = ' ';
    $repuesto->description = ' ';
    $repuesto->compatibilidad = ' ';
    $repuesto->inventary_min = filter_var($_POST['mininv'], FILTER_VALIDATE_INT);
    
    $repuesto->price_in = filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_in_d = filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out = filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_d = filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es = filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es_d = filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT);

    $repuesto->unit = filter_var($_POST['invini'], FILTER_VALIDATE_INT);
    $repuesto->presentation = '';    
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->person_id = (filter_var($_POST['proveedor'], FILTER_VALIDATE_INT))?intval($_POST['proveedor']):0;
    $repuesto->marca = strip_tags($_POST['marca']);
    $repuesto->modelo = strip_tags($_POST['modelo']);
    $repuesto->color = strip_tags($_POST['color']);
    $repuesto->calidad = ' ';
    $repuesto->category_id = filter_var($_POST['categoria'], FILTER_VALIDATE_INT);
    $repuesto->ingresado_type = 1;
    $repuesto->created_at = date("Y-m-d H:i:s",strtotime($_POST['fecha']));;
    $repuesto->facturano = strip_tags($_POST['factura']);
    $repuesto->is_active = 1;
    $repuesto->justificacion = ' ';
    $save = $repuesto->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
    $data = (new CelularesData)->getById($_GET['id']);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    
   Roles::validHasAdmin();

    $repuesto = new CelularesData();
    $repuesto->id =filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $repuesto->image = ' ';
    $repuesto->barcode = strip_tags($_POST['imei1']);
    $repuesto->codigo = ' ';
    $repuesto->imei2 = strip_tags($_POST['imei2']);
    $repuesto->imeivarios = ' ';
    $repuesto->type = 2;
    $repuesto->name = ' ';
    $repuesto->description = ' ';
    $repuesto->compatibilidad = ' ';
    $repuesto->inventary_min = filter_var($_POST['mininv'], FILTER_VALIDATE_INT);
    
    $repuesto->price_in = filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_in_d = filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out = filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_d = filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es = filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es_d = filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT);

    $repuesto->unit = 0;
    $repuesto->presentation = ' ';    
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->person_id = (filter_var($_POST['proveedor'], FILTER_VALIDATE_INT))?intval($_POST['proveedor']):0;
    $repuesto->marca = strip_tags($_POST['marca']);;
    $repuesto->modelo = strip_tags($_POST['modelo']);;
    $repuesto->color = strip_tags($_POST['color']);;
    $repuesto->calidad = ' ';
    $repuesto->category_id = filter_var($_POST['categoria'], FILTER_VALIDATE_INT);
    $repuesto->ingresado_type = 1;
    $repuesto->created_at = date("Y-m-d H:i:s",strtotime($_POST['fecha']));
    $repuesto->facturano = strip_tags($_POST['factura']);
    $repuesto->is_active = filter_var($_POST['active'], FILTER_VALIDATE_INT);
    $repuesto->justificacion = ' ';
    $save = $repuesto->update();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update-inventario"){    
    Roles::validHasAdmin();
    $repuesto = new CelularesData();
    $repuesto->id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $repuesto->justificacion = strip_tags($_POST['justificacion']);
    $repuesto->price_in = filter_var($_POST['aumentar'], FILTER_VALIDATE_INT);
    $repuesto->price_out = filter_var($_POST['decrementar'], FILTER_VALIDATE_INT);
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->created_at = date("Y-m-d H:i:s");;
    $save = $repuesto->updateInventario();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
    Roles::validHasAdmin();
    $id=filter_var($_POST["id"], FILTER_VALIDATE_INT);
    $resultado = (new ProductoData)->eliminarProducto($id);
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='duplicar-producto'){
    Roles::validHasAdmin();
    
    $id=filter_var($_POST["id"], FILTER_VALIDATE_INT);
    $resultado = (new CelularesData)->duplicar($id);
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg'],'id' => $resultado['id']]);
    exit;
}






?>