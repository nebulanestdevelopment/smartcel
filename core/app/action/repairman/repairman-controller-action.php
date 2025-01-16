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


 if(isset($_POST['method']) && $_POST['method'] == "en-proceso"){
  $save = (new RepairmanData)->reparacionEnProceso($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "terminar"){
  $save = (new RepairmanData)->reparacionTerminada($_POST['id']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit; 
}else if(isset($_POST['method']) && $_POST['method'] == "no-se-pudo"){
  $save = (new RepairmanData)->reparacionNoSePudo($_POST['id'],$_POST['nota']);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg']]);
  exit; 
}else if(isset($_POST['method']) && $_POST['method'] == "update-reparacion"){
 
  $repuesto = "";
  $repuesto_id = "";
  $costo_c = 0;
  $costo_d = 0;
  $total_c = 0;
  $total_d = 0;
  $desc_c = 0;
  $desc_d = 0;

if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0){
  $cart = $_SESSION['cart-repair'];
  foreach ($cart as $key => $v) {  
      $repuesto .= " ". trim(ProductoData::getProductName($v['product_id'])) .' +';  
      $repuesto_id .= " ".$v['product_id'].','; 
      $costo_c  += ((floatval($v['pvc']) * intval($v['q'])) - floatval($v['desc_c']));
      $costo_d  += ((floatval($v['pvd']) * intval($v['q']))  - floatval($v['desc_d']));   
      $total_c  += (floatval($v['pvc']) * intval($v['q'])) ;
      $total_d  += (floatval($v['pvd']) * intval($v['q']));
      $desc_c   += floatval($v['desc_c']);
      $desc_d   += floatval($v['desc_d']);
  }
  $repuesto = rtrim($repuesto, '+');
  $repuesto_id = rtrim($repuesto_id, ',');
}

$_POST['cash_c'] = $total_c;
$_POST['cash_d'] = $total_d;
$_POST['discount'] = $desc_c;
$_POST['discount_d'] = $desc_d;


  $r = new RepairmanData();
  $r->id = $_POST['idr'];
  $r->status = 0;
  $r->client_id = 0;
  $r->cliente = "";
  $r->facturano = 0;  
  $r->sell_id = 0;
  $r->tecnico = "";
  $r->tecnico_id = 0;
  $r->descripcion = strip_tags($_POST['descripcion']);  
  $r->repuesto = $repuesto;
  $r->repuesto_id = $repuesto_id;
  $r->costo_repuesto = $costo_c;
  $r->costo_repuesto_d = $costo_d;
  $r->costo_reparacion = floatval($_POST['total_c']);
  $r->costo_reparacion_d = floatval($_POST['total_d']);
  $r->total = (floatval($_POST['total_c']) + $costo_c);
  $r->total_d = (floatval($_POST['total_d']) + $costo_d);
  $r->nota = " ";
  $r->estado_taller = '';
  $r->fecha_reparacion ='';
  $r->hora_reparacion = '';
  $r->created_at = '';
  $save = $r->save($_POST);
  $code = (!$save['code'])?400:201;
  http_response_code($code);
  echo json_encode(['msg' => $save['msg'],'id'=>$save['id']]);
  exit;
}else if(isset($_POST['method']) && $_POST['method'] == "subir-imagenes"){
  
    if (isset($_FILES['imagenes'])) {
      $rootPath = realpath(__DIR__ . '/../../../../');
      $assetsPath = $rootPath . '/storage/reparaciones/'.$_POST['id'].'/'.$_POST['tipo'];
      if (!is_dir($assetsPath)) {
        mkdir($assetsPath, 0777, true); 
        subirImagesSalidaTaller($assetsPath,$_FILES,0);
      }else{ 
        $imgArray =[];
          $files = glob($assetsPath . '/*');
           foreach ($files as $index => $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $imgArray[$index] = $filename;
              }
              rsort($imgArray);
              $ind = intval($imgArray[0]) + 1;
              subirImagesSalidaTaller($assetsPath,$_FILES,$ind);
      }
      http_response_code(200);
      echo json_encode(['msg' => "Imagenes subida..",'id'=>0 ]);     
    }else{
      http_response_code(400);
      echo json_encode(['msg' => "No selecciono ninguna imagen..",'id'=>0]);
    }
} else if(isset($_POST['method']) && $_POST['method'] == "eliminar-imagenes"){ 
 
    $rootPath = realpath(__DIR__ . '/../../../../');
    $assetsPath = $rootPath . '/storage/reparaciones/'.$_POST['id'].'/'.$_POST['tipo'];
    $imagePath = $assetsPath. '/' . $_POST['img'];

    if (file_exists($imagePath)) {
      if (unlink($imagePath)) {
          echo json_encode(['msg' => "Imagen eliminada..",'id'=>0]);
      } else {
          echo json_encode(['msg' => "La imagen no se pudo eliminar..",'id'=>0]);
      }
  } else {
      http_response_code(400);
      echo json_encode(['msg' => "No encontro ninguna imagen..",'id'=>0]);
  }     

} 


function  subirImagesSalidaTaller($path,$FILES,$ind){
  $i = $ind;
  $extension=array("jpeg","jpg","png");
  foreach($FILES['imagenes']["tmp_name"] as $index => $file){        
    $file_name = $FILES["imagenes"]["name"][$index];
    $file_tmp  = $FILES["imagenes"]["tmp_name"][$index];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
      if(in_array($ext,$extension)) {
        $newname =  $i.".".$ext;
        $target  =  $path."/".$newname;
        move_uploaded_file($FILES['imagenes']['tmp_name'][$index], $target); 
        $i++;         
      }       
  }  
}


?>