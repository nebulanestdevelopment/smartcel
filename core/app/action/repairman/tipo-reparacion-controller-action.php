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
    $data = (new ReparacionTipoData)->getAll();
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){
    $reparacion = new ReparacionTipoData();
    $reparacion->name = strtoupper($_POST['nombre']);
    $reparacion->precio_d = $_POST['d'];
    $reparacion->precio_c = $_POST['c'];
    $save = $reparacion->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
    $data = (new PagoTipoData)->getById($_GET['id']);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    $egreso = new PagoTipoData();
    $egreso->id = $_POST['idGastosTipo'];
    $egreso->name = strtoupper($_POST['name']);
    $update = $egreso->update();
    $code = (!$update['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $update['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
    $id=intval($_POST["id"]);
    $egreso = new PagoTipoData();
    $egreso->id = $id;
    $resultado = $egreso->delete();
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}

?>