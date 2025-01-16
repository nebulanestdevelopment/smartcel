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
    $data = (new AccesoriosData)->getAll();
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_GET['method']) && $_GET['method'] == "get-all-by-category"){
    if(intval($_GET['category']) == 0){
        $data = (new AccesoriosData)->getAll();
    }else{
        $data = (new AccesoriosData)->getAllByCategory($_GET['category']);
    }
    echo json_encode(["data" => $data]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save"){    
    Roles::validHasAdmin();
    $validarCodigo = ProductoData::validarCodigo(strip_tags($_POST['codigo']),'1');
    
    if ($validarCodigo) {
        http_response_code(400);
        echo json_encode('El codigo '.$_POST['codigo'].' para accesorio ya esta en uso');
        exit;
    }

    $rootPath = realpath(__DIR__ . '/../../../../');
    $assetsPath = $rootPath . '/storage/products/';
    $newFileName = ""; 
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    
        if (!in_array($fileExtension, $allowedExtensions)) {
            http_response_code(400);
            echo json_encode('Solo se permiten imagenes con las extensiones JPG, JPEG, PNG, and GIF.');
            exit;
        }
        $name = preg_replace('/\s+/', ' ', $_POST['name']);
        $name = strtolower(str_replace(' ', '_', $name));
        $name = preg_replace('/[^A-Za-z0-9\_]/', '', $name); // Removes special chars.
        $codigo = preg_replace('/\s+/', ' ', $_POST['codigo']);;      
        $codigo = preg_replace('/[^A-Za-z0-9\_]/', '', $codigo);   
        $newFileName = $name . '_' . $codigo . '.' . $fileExtension;      
        move_uploaded_file($image['tmp_name'],"$assetsPath$newFileName");
        chmod("$assetsPath$newFileName", 0644);
    }  

    $repuesto = new AccesoriosData();
    $repuesto->image = $newFileName;
    $repuesto->barcode = ' ';
    $repuesto->codigo = strip_tags($_POST['codigo']);
    $repuesto->imei2 = ' ';
    $repuesto->imeivarios = ' ';
    $repuesto->type = 1;
    $repuesto->name = strip_tags($_POST['name']);
    $repuesto->description = strip_tags($_POST['description']);
    $repuesto->compatibilidad = ' ';
    $repuesto->inventary_min = filter_var($_POST['mininv'], FILTER_VALIDATE_INT);
    
    $repuesto->price_in = filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_in_d = filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out = filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_d = filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es = filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es_d = filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT);

    $repuesto->unit = filter_var($_POST['invini'], FILTER_VALIDATE_INT);
    $repuesto->presentation = strip_tags($_POST['presentation']);    
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->person_id = filter_var($_POST['proveedor'], FILTER_VALIDATE_INT);
    $repuesto->marca = ' ';
    $repuesto->modelo = ' ';
    $repuesto->color = ' ';
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
    $data = (new AccesoriosData)->getById($_GET['id']);
    echo json_encode($data);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "update"){
    
   Roles::validHasAdmin();
    $rootPath = realpath(__DIR__ . '/../../../../');
    $assetsPath = $rootPath . '/storage/products/';
    $newFileName = $_POST['img']; 
    $oldFileName = $_POST['img']; 
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    
        if (!in_array($fileExtension, $allowedExtensions)) {
            http_response_code(400);
            echo json_encode('Solo se permiten imagenes con las extensiones JPG, JPEG, PNG, and GIF.');
            exit;
        }

        $name = preg_replace('/\s+/', ' ', $_POST['name']);
        $name = strtolower(str_replace(' ', '_', $name));
        $name = preg_replace('/[^A-Za-z0-9\_]/', '', $name); // Removes special chars.
        $codigo = preg_replace('/\s+/', ' ', $_POST['codigo']);;      
        $codigo = preg_replace('/[^A-Za-z0-9\_]/', '', $codigo);   
        $newFileName = $name . '_' . $codigo . '.' . $fileExtension;     
        if(file_exists("$assetsPath$oldFileName") && $oldFileName  != ""){
            unlink("$assetsPath$oldFileName");
        } 
        
        move_uploaded_file($image['tmp_name'],"$assetsPath$newFileName");
        chmod("$assetsPath$newFileName", 0644);
        
    }  
   

    $repuesto = new AccesoriosData();
    $repuesto->id =filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $repuesto->image = $newFileName;
    $repuesto->barcode = ' ';
    $repuesto->codigo = strip_tags($_POST['codigo']);
    $repuesto->imei2 = ' ';
    $repuesto->imeivarios = ' ';
    $repuesto->type = 1;
    $repuesto->name = strip_tags($_POST['name']);
    $repuesto->description = strip_tags($_POST['description']);
    $repuesto->compatibilidad = ' ';
    $repuesto->inventary_min = filter_var($_POST['mininv'], FILTER_VALIDATE_INT);
    
    $repuesto->price_in = filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_in_d = filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out = filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_d = filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es = filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT);
    $repuesto->price_out_es_d = filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT);

    $repuesto->unit = 0;
    $repuesto->presentation = strip_tags($_POST['presentation']);    
    $repuesto->user_id = $_SESSION['user_id'];
    $repuesto->person_id = filter_var($_POST['proveedor'], FILTER_VALIDATE_INT);
    $repuesto->marca = ' ';
    $repuesto->modelo = ' ';
    $repuesto->color = ' ';
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
    $repuesto = new AccesoriosData();
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
    $resultado = (new AccesoriosData)->duplicar($id);
    $code = (!$resultado['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $resultado['msg'],'id' => $resultado['id']]);
    exit;
}






?>
