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



if(isset($_POST['method']) && $_POST['method'] == "save-accesorios"){  

    //Roles::validHasAdmin();
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
    $save = $repuesto->saveOnly();
    if ($save['code']){
      $cart = [
               'product_id'=>$save['id'],
               'q'=>1,
               'pcc' => filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT),
               'pcd' => filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT),
               'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
               'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT),
               'pec' => filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT),
               'ped' => filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT)
      ];
      ComprasData::addToCart($cart);
    }
    $code = (!$save['code'])?400:201;
    http_response_code($code);
    echo json_encode(['msg' => $save['msg']]);
    exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-accesorios-autos"){  

  $validarCodigo = ProductoData::validarCodigo(strip_tags($_POST['codigo']),'4');
    
    if ($validarCodigo) {
        http_response_code(400);
        echo json_encode('El codigo '.$_POST['codigo'].' para accesorio de autos ya esta en uso');
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

    $repuesto = new AccesoriosAutosData();
    $repuesto->image = $newFileName;
    $repuesto->barcode = ' ';
    $repuesto->codigo = strip_tags($_POST['codigo']);
    $repuesto->imei2 = ' ';
    $repuesto->imeivarios = ' ';
    $repuesto->type = 4;
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
   
  $save = $repuesto->saveOnly();
  if ($save['code']){
    $cart = [
             'product_id'=>$save['id'],
             'q'=>1,
             'pcc' => filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT),
             'pcd' => filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT),
             'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
             'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT),
             'pec' => filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT),
             'ped' => filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT)
    ];
    ComprasData::addToCart($cart);
  }
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-celulares"){  

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
   
  $save = $repuesto->saveOnly();
  if ($save['code']){
    $cart = [
             'product_id'=>$save['id'],
             'q'=>1,
             'pcc' => filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT),
             'pcd' => filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT),
             'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
             'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT),
             'pec' => filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT),
             'ped' => filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT)
    ];
    ComprasData::addToCart($cart);
  }
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "save-repuestos"){  

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
 
$save = $repuesto->saveOnly();
if ($save['code']){
  $cart = [
           'product_id'=>$save['id'],
           'q'=>1,
           'pcc' => filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT),
           'pcd' => filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT),
           'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
           'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT),
           'pec' => filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT),
           'ped' => filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT)
  ];
  ComprasData::addToCart($cart);
}
$code = (!$save['code'])?400:201;
http_response_code($code);
echo json_encode(['msg' => $save['msg']]);
exit;
}















?>