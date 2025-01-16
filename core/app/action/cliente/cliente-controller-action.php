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
    $data = (new ClienteData)->getAll();
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-all-repair"){
  $data = (new ClienteData)->getAllRepair();
  $code = count($data) > 0?200:500;
  http_response_code($code);
  echo json_encode(["data" => $data]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){
  
    $proveedor = new ClienteData();
    $proveedor->image = " ";
		$proveedor->razon_social = " ";
		$proveedor->cedula = $_POST['cedula'];
		$proveedor->codigo = $_POST['codigo'];
		$proveedor->name = $_POST['nombre'];
		$proveedor->lastname = $_POST['apellido'];
		$proveedor->company = " ";
		$proveedor->address1 = $_POST['direccion'];
		$proveedor->address2 = " ";
		$proveedor->phone1 = $_POST['telefono'];
		$proveedor->phone2 = " ";
		$proveedor->email1 = $_POST['email'];
		$proveedor->email2 = " ";
		$proveedor->kind =$_POST['tipo'] ;
    $save = $proveedor->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg'],'id' => $save['id']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
  Roles::validHasAdmin();
  $data = (new ClienteData)->getById($_GET['id']);
  $code = count($data) > 0?200:500;
  http_response_code($code);
  echo json_encode($data);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
  Roles::validHasAdmin();
    $proveedor = new ClienteData();
    $proveedor->id = $_POST['idCliente'];
    $proveedor->image = " ";
		$proveedor->razon_social = " ";
		$proveedor->cedula = $_POST['cedula'];
		$proveedor->codigo = $_POST['codigo'];
		$proveedor->name = $_POST['nombre'];
		$proveedor->lastname = $_POST['apellido'];
		$proveedor->company = " ";
		$proveedor->address1 = $_POST['direccion'];
		$proveedor->address2 = " ";
		$proveedor->phone1 = $_POST['telefono'];
		$proveedor->phone2 = " ";
		$proveedor->email1 = $_POST['email'];
		$proveedor->email2 = " ";
		$proveedor->kind = intval($_POST['tipo']);
    $update = $proveedor->update();
    $code = (!$update['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $update['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
  Roles::validHasAdmin();
    $id=intval($_POST["id"]);
    $proveedor = new ClienteData();
    $proveedor->id = $id;
    $resultado = $proveedor->delete();
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}






?>