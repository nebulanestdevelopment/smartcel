<?php

    class ProductoHistorialData extends Precios{
        public static $tableName = "product_history";
        public $id;
        public $id_product;
        public $image;
        public $barcade;
        public $codigo;
        public $imei2;
        public $imeivarios;
        public $type;
        public $name;
        public $description;
        public $compatibilidad;
        public $inventary_min;
        public $price_in;
        public $price_in_d;
        public $price_out;
        public $price_out_d;
        public $price_out_es;
        public $price_out_es_d;
        public $unit;
        public $presentation;
        public $user_id;
        public $person_id;
        public $marca;
        public $modelo;
        public $color;
        public $calidad;
        public $category_id;
        public $ingresado_type;
        public $created_at;
        public $facturano;
        public $is_active;
        public $justificacion;
    
        public static function getAll() {
            $sql = "SELECT id,id_product,image, barcode,codigo,imei2,imeivarios,type,name, 
                           description,compatibilidad,inventary_min,price_in,price_in_d,price_out,
                           price_out_d,price_out_es,price_out_es_d,unit,presentation,user_id,person_id,
                           marca,modelo,color,calidad,category_id,ingresado_type,created_at,facturano,
                           is_active,justificacion
                    FROM ".self::$tableName."  Order BY created_at ASC";
            ExecutorPDO::initCon();
            ExecutorPDO::initPreparate($sql);
            $array = array();
            ExecutorPDO::executeParams(array());
                foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                    $proveedor = ProveedorData::getById($row['person_id']);
                    $categoria = CategoriaData::getById($row['category_id']);
                    $user      = UsuarioData::getById($row['user_id']);
                    $usuario   = $user['nombre'] . ' ' . $user['apellido'];
                    $array[$index]['id'] = $row['id'];
                    $array[$index]['idproduct'] = $row['id_product'];
                    $array[$index]['image'] = $row['image'];
                    $array[$index]['barcode'] = $row['barcode'];
                    $array[$index]['codigo'] = $row['codigo'];
                    $array[$index]['imei2'] = $row['imei2'];
                    $array[$index]['imeivarios'] = $row['imeivarios'];
                    $array[$index]['type'] = $row['type'];
                    $array[$index]['name'] = $row['name'];
                    $array[$index]['description'] = $row['description'];
                    $array[$index]['compatibilidad'] = $row['compatibilidad'];
                    $array[$index]['inventarymin'] = $row['inventary_min'];
                    $array[$index]['costo_c'] = $row['price_in'];
                    $array[$index]['costo_d'] = $row['price_in_d'];
                    $array[$index]['precio_c'] = $row['price_out'];
                    $array[$index]['precio_d'] = $row['price_out_d'];
                    $array[$index]['precioe_c'] = $row['price_out_es'];
                    $array[$index]['precioe_d'] = $row['price_out_es_d'];
                    $array[$index]['unidades'] = $row['unit'];
                    $array[$index]['presentation'] = $row['presentation'];
                    $array[$index]['userid'] = $row['user_id'];
                    $array[$index]['usuario'] = $usuario;
                    $array[$index]['proveedorid'] = $row['person_id'];
                    $array[$index]['proveedor'] =  $proveedor['completo'];
                    $array[$index]['marca'] = $row['marca'];
                    $array[$index]['modelo'] = $row['modelo'];
                    $array[$index]['color'] = $row['color'];
                    $array[$index]['calidad'] = $row['calidad'];
                    $array[$index]['category_id'] = $row['category_id'];
                    $array[$index]['categoria'] = $categoria['name'];
                    $array[$index]['ingresadotype'] = $row['ingresado_type'];
                    $array[$index]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
                    $array[$index]['facturano'] = $row['facturano'];
                    $array[$index]['status'] = $row['is_active'];
                    $array[$index]['justificacion'] = $row['justificacion'];
                }
            ExecutorPDO::closeCon();	
            return $array;        
    }             
      
    
    
    public static  function getAllByProductoId($id) {
      $sql = "SELECT * FROM ".self::$tableName." WHERE id='".$id."' Order BY created_at DESC";
      ExecutorPDO::initCon();
      ExecutorPDO::initPreparate($sql);
      $array = array();
      ExecutorPDO::executeParams(array());
          foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
              $proveedor = ProveedorData::getById($row['person_id']);
              $categoria = CategoriaData::getById($row['category_id']);
              $array['image'] = $row['image'];
              $array['barcode'] = $row['barcode'];
              $array['codigo'] = $row['codigo'];
              $array['imei2'] = $row['imei2'];
              $array['imeivarios'] = $row['imeivarios'];
              $array['type'] = $row['type'];
              $array['name'] = $row['name'];
              $array['description'] = $row['description'];
              $array['compatibilidad'] = $row['compatibilidad'];
              $array['inventary_min'] = $row['inventary_min'];
              $array['costo_c'] = $row['price_in'];
              $array['costo_d'] = $row['price_in_d'];
              $array['precio_c'] = $row['price_out'];
              $array['precio_d'] = $row['price_out_d'];
              $array['price_out_es'] = $row['price_out_es'];
              $array['price_out_es_d'] = $row['price_out_es_d'];
              $array['unidades'] = $row['unit'];
              $array['presentation'] = $row['presentation'];
              $array['user_id'] = $row['user_id'];
              $array['proveedor_id'] = $row['person_id'];
              $array['proveedor'] =  $proveedor['completo'];
              $array['marca'] = $row['marca'];
              $array['modelo'] = $row['modelo'];
              $array['color'] = $row['color'];
              $array['calidad'] = $row['calidad'];
              $array['category_id'] = $row['category_id'];
              $array['categoria'] = $categoria['name'];
              $array['ingresado_type'] = $row['ingresado_type'];
              $array['fecha'] = date('d/m/Y', strtotime($row['created_at']));
              $array['facturano'] = $row['facturano'];
              $array['is_active'] = $row['is_active'];
              $array['justificacion'] = $row['justificacion'];
          }
      ExecutorPDO::closeCon();	
      return $array;     
    }
    public static  function getAllDetailByProductoId($id) {
        $sql = "SELECT id_product,price_in,price_in_d,price_out,price_out_d,
                        price_out_es,price_out_es_d,created_at
                FROM product_history WHERE id_product='".$id."' Order BY created_at DESC";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                $array[$index ]['id_product'] = $row['id_product'];
                $array[$index ]['costo_c'] = $row['price_in'];
                $array[$index ]['costo_d'] = $row['price_in_d'];
                $array[$index ]['precio_c'] = $row['price_out'];
                $array[$index ]['precio_d'] = $row['price_out_d'];
                $array[$index ]['price_out_es'] = $row['price_out_es'];
                $array[$index ]['price_out_es_d'] = $row['price_out_es_d'];
                $array[$index ]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
            }
        ExecutorPDO::closeCon();	
        return $array;     
      }
    
    
    public static function save($idProducto,$con){
             try {
                     $conex = $con;
                     $sql_get = "SELECT * FROM product WHERE id='".$idProducto."' ;";  
                     $stmt = $conex->prepare($sql_get);
                     $stmt->execute();
                     $collect = $stmt->fetchAll(PDO::FETCH_CLASS, "ProductoData");
                     $p =$collect[0];                    
                     $sql_producto = "INSERT INTO ".self::$tableName." ( `id_product`,`image`, `barcode`, `codigo`, `imei2`, `imeivarios`,
                            `type`, `name`, `description`, `compatibilidad`, `inventary_min`, `price_in`, `price_in_d`, `price_out`,
                            `price_out_d`, `price_out_es`, `price_out_es_d`, `unit`, `presentation`, `user_id`, `person_id`, `marca`,
                            `modelo`, `color`, `calidad`, `category_id`, `ingresado_type`, `created_at`, `facturano`, `is_active`, `justificacion`) 
                            VALUES ('".$p->id."','".$p->image."','".$p->barcode."','".$p->codigo."','".$p->imei2."','".$p->imeivarios."',
                            '".$p->type."','".$p->name."','".$p->description."','".$p->compatibilidad."','".$p->inventary_min."','".floatval($p->price_in)."','".floatval($p->price_in_d)."','".floatval($p->price_out)."',
                            '".floatval($p->price_out_d)."','".floatval($p->price_out_es)."','".floatval($p->price_out_es_d)."','".$p->unit."','".$p->presentation."','".$p->user_id."','".$p->person_id."','".$p->marca."',
                            '".$p->modelo."','".$p->color."','".$p->calidad."','".$p->category_id."','".$p->ingresado_type."','".$p->created_at."','".$p->facturano."','".$p->is_active."','".$p->justificacion."');";
                           
                         $stmt = $conex->prepare($sql_producto);
                         $stmt->execute();     
                         $conex = null;
                         $stmt = null;
                         return ["msg"=>"Producto agregado a historial","code"=>true];      
                   
             }catch(\PDOException $e){
                 $con = null;
                 return ["msg"=>$e->getMessage(),"code"=>false];        
             }
    }
    /* guardar historial de producto */
    /*****************************************/
    
    
    }
    ?>
