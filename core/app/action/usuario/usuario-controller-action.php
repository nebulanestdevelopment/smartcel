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
    $data = (new UsuarioData)->getAll();
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-all-vendedores"){
    $data = (new UsuarioData)->getAllVendedores();
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-all-tecnicos"){
    $data = (new UsuarioData)->getAllTecnicos();
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){
    $user = new UsuarioData();
    $user->name = $_POST['nombre'];
    $user->lastname = $_POST['apellido'];
    $user->username = $_POST['username'];
    $user->email = $_POST['username'];
    $user->password = sha1(md5($_POST['password']));
    $user->image = "";
    $user->is_active = ($_POST['estado'] == "activo")?1:0;
    $user->is_admin = ($_POST['tipo'] == "admin")?1:0;
    $user->is_repairman = ($_POST['tipo'] == "tecnico")?1:0;
    $user->is_seller = ($_POST['tipo'] == "vendedor")?1:0;
    $save = $user->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
    $data = (new UsuarioData)->getById($_GET['id']);
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    $user = new UsuarioData();
    $user->id = $_POST['idUsuario'];
    $user->name = $_POST['nombre'];
    $user->lastname = $_POST['apellido'];
    $user->is_active = ($_POST['estado'] == "activo")?1:0;
    $user->is_admin = ($_POST['tipo'] == "admin")?1:0;
    $user->is_repairman = ($_POST['tipo'] == "tecnico")?1:0;
    $user->is_seller = ($_POST['tipo'] == "vendedor")?1:0;
    $update = $user->update();
    $code = (!$update['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $update['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
    $id=intval($_POST["id"]);
    $user = new UsuarioData();
    $user->id = $id;
    $resultado = $user->delete();
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='update-password'){    
    
    $resultado = UsuarioData::updatePassword($_POST);
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}



 function getUserTipe(){
    return 0;
}


?>