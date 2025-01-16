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
    $data = (new CategoriaData)->getAll();
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-all-by-subcategory"){
    $data = (new CategoriaData)->getAllBySubcategory($_GET['subcategory']);
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update-data"){
  
    $system = new SystemData();
    $system->id = $_POST['id'];
    $system->tecnicos = $_POST['tecnicos'];
    $system->tasa_cambio = floatval($_POST['tasa-cambio']);
    $save = $system->update();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update-tasa-inventario"){
  
    $system = new SystemData();
    $save = $system->updateTasaInventario();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}





?>