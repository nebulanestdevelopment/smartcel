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
}else if(isset($_POST['method']) && $_POST['method'] == "save"){
    
    $categoria = new CategoriaData();
    $categoria->name = strtoupper($_POST['nombre']);
    $categoria->subcategoria = $_POST['subcategoria'];
    $save = $categoria->save();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-return"){
    
    $categoria = new CategoriaData();
    $categoria->name = strtoupper($_POST['nombre']);
    $categoria->subcategoria = $_POST['subcategoria'];
    $save = $categoria->saveReturn();
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg'],'id' => $save['id']]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "edit" && isset($_GET['id'])){
    $data = (new CategoriaData)->getById($_GET['id']);
    $code = count($data) > 0?200:500;
    http_response_code($code);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    $categoria = new CategoriaData();
    $categoria->id = $_POST['idCategoria'];
    $categoria->name = strtoupper($_POST['nombre']);
    $categoria->subcategoria = $_POST['subcategoria'];
    $categoria->created_at = (new DateTime())->format('Y-m-d H:i:s');
    $update = $categoria->update();
    $code = (!$update['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $update['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method']=='delete'){
    $id=intval($_POST["id"]);
    $categoria = new CategoriaData();
    $categoria->id = $id;
    $resultado = $categoria->delete();
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg']]);
    exit;
}






?>