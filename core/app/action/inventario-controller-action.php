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


if(isset($_GET['method']) && $_GET['method'] == "accesorios"){
    $data = ReportesData::getInventario(1); 
    http_response_code(200);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "celulares"){
    $data = ReportesData::getInventario(2); 
    http_response_code(200);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "repuestos"){
    $data = ReportesData::getInventario(3); 
    http_response_code(200);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-autos"){
    $data = ReportesData::getInventario(4); 
    http_response_code(200);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-item-cero"){
  $data = ReportesData::getInventarioItemCero(1); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "celulares-item-cero"){
  $data = ReportesData::getInventarioItemCero(2); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "repuestos-item-cero"){
  $data = ReportesData::getInventarioItemCero(3); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-autos-item-cero"){
  $data = ReportesData::getInventarioItemCero(4); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-inventario-minimo"){
  $data = ReportesData::getInventarioCantidadMinima(1); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "celulares-inventario-minimo"){
  $data = ReportesData::getInventarioCantidadMinima(2); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "repuestos-inventario-minimo"){
  $data = ReportesData::getInventarioCantidadMinima(3); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-autos-inventario-minimo"){
  $data = ReportesData::getInventarioCantidadMinima(4); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-inventario-neutro"){
  $data = ReportesData::getInventarioItemNeutros(1); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "celulares-inventario-neutro"){
  $data = ReportesData::getInventarioItemNeutros(2); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "repuestos-inventario-neutro"){
  $data = ReportesData::getInventarioItemNeutros(3); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_GET['method']) && $_GET['method'] == "accesorios-autos-inventario-neutro"){
  $data = ReportesData::getInventarioItemNeutros(4); 
  http_response_code(200);
  echo json_encode(["data" => $data]);
  exit;
}





?>