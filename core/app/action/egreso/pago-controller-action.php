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
    $data = (new PagoData)->getAll();
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-mes-actual"){
    $data = (new PagoData)->getPagosMesActual();
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){
 try {
    $egreso = new PagoData();
    $egreso->name = strtoupper($_POST['tipo']);
    $egreso->descripcion = strtoupper($_POST['descripcion']);
    $egreso->total_c = floatval($_POST['c']);
    $egreso->total_d = floatval($_POST['d']);
    $phpDate = new DateTime($_POST['fecha']);
    $mysqlDateTime = $phpDate->format('Y-m-d H:i:s');
    $egreso->created_at = $mysqlDateTime;
    $save = $egreso->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
 } catch (\Throwable $th) {
    http_response_code(500);
    echo json_encode($th);
    exit;
 }   
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
    $data = (new PagoData)->getById($_GET['id']);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    
    $egreso = new PagoData();
    $egreso->id = intval($_POST['idpago']);
    $egreso->name = strtoupper($_POST['tipo']);
    $egreso->descripcion = strtoupper($_POST['descripcion']);
    $egreso->total_c = floatval($_POST['c']);
    $egreso->total_d = floatval($_POST['d']);
    $phpDate = new DateTime($_POST['fecha']);
    $mysqlDateTime = $phpDate->format('Y-m-d H:i:s');
    $egreso->created_at = $mysqlDateTime;  
    $update = $egreso->update();
    $code = (!$update['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $update['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
    $id=intval($_POST["id"]);
    $egreso = new PagoData();
    $egreso->id = $id;
    $resultado = $egreso->delete();
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method']=='get-total-gastos-mes-actual'){
    $data = (new PagoData)->getTotalGastosMesActual();
    echo json_encode($data);
    exit;
}else if(isset($_GET['method']) && $_GET['method']=='get-historial-egresos'){
    $data = (new PagoData)->getHistorialEgresos($_GET);
    echo json_encode($data);
    exit;
}else if(isset($_GET['method']) && $_GET['method']=='get-historial-egresos-total'){
    $data = (new PagoData)->getTotalHistorialEgresos($_GET);
    echo json_encode($data);
    exit;
}







?>