<?php
class AccesoriosAutosData extends ProductoData {

    public static function getAll() {
            $sql = "SELECT p.id,p.image,p.codigo,p.name,p.description,p.price_in,p.price_in_d,p.price_out,p.price_out_d,p.price_out_es_d,p.price_out_es,p.presentation,p.marca,p.modelo,p.color,
            p.created_at,CONCAT('[ ',pe.razon_social,' ] ',pe.name,' ',pe.lastname) AS proveedor, c.name AS categoria
            FROM product p 
            LEFT OUTER JOIN person pe ON p.person_id = pe.id 
            LEFT OUTER JOIN category c ON p.category_id = c.id
            WHERE p.type=4 Order BY p.id ASC;";
            ExecutorPDO::initCon();
            ExecutorPDO::initPreparate($sql);
            $array = array();
            ExecutorPDO::executeParams(array());
                foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                    $units = OperationData::getUnitsTotalByProductoId($row['id']);
                    $array[$index]['description'] = $row['description'];
                    $array[$index]['id'] = $row['id'];
                    $array[$index]['name'] = $row['name'];
                    $array[$index]['image'] = $row['image'];
                    $array[$index]['codigo'] = $row['codigo'];
                    $array[$index]['costo_c'] = floatval($row['price_in']);
                    $array[$index]['costo_d'] = floatval($row['price_in_d']);
                    $array[$index]['precio_c'] = floatval($row['price_out']);
                    $array[$index]['precio_d'] = floatval($row['price_out_d']);
                    $array[$index]['precio_es_c'] = floatval($row['price_out_es']);
                    $array[$index]['precio_es_d'] = floatval($row['price_out_es_d']);
                    $array[$index]['unidades'] = $units;
                    $array[$index]['presentation'] = $row['presentation'];
                    $array[$index]['proveedor'] =  $row['proveedor'];
                    $array[$index]['marca'] = $row['marca'];
                    $array[$index]['modelo'] = $row['modelo'];
                    $array[$index]['color'] = $row['color'];
                    $array[$index]['categoria'] = $row['categoria'];
                    $array[$index]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
                    $array[$index]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
                    $array[$index]['is_admin'] = Roles::hasAdmin() ? 1 : 0 ;
                }
            ExecutorPDO::closeCon();	
            return $array;        
    }

    public static function getAllByCategory($id) {
        $sql = "SELECT p.id,p.image,p.codigo,p.name,p.description,p.price_in,p.price_in_d,p.price_out,p.price_out_d,p.price_out_es_d,p.price_out_es,p.presentation,p.marca,p.modelo,p.color,
        p.created_at,CONCAT('[ ',pe.razon_social,' ] ',pe.name,' ',pe.lastname) AS proveedor, c.name AS categoria
        FROM product p 
        LEFT OUTER JOIN person pe ON p.person_id = pe.id 
        LEFT OUTER JOIN category c ON p.category_id = c.id
        WHERE p.type=4 AND p.category_id='".$id."' Order BY p.id ASC;";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                $units = OperationData::getUnitsTotalByProductoId($row['id']);
                $array[$index]['description'] = $row['description'];
                $array[$index]['id'] = $row['id'];
                $array[$index]['name'] = $row['name'];
                $array[$index]['image'] = $row['image'];
                $array[$index]['codigo'] = $row['codigo'];
                $array[$index]['costo_c'] = floatval($row['price_in']);
                $array[$index]['costo_d'] = floatval($row['price_in_d']);
                $array[$index]['precio_c'] = floatval($row['price_out']);
                $array[$index]['precio_d'] = floatval($row['price_out_d']);
                $array[$index]['precio_es_c'] = floatval($row['price_out_es']);
                $array[$index]['precio_es_d'] = floatval($row['price_out_es_d']);
                $array[$index]['unidades'] = $units;
                $array[$index]['presentation'] = $row['presentation'];
                $array[$index]['proveedor'] =  $row['proveedor'];
                $array[$index]['marca'] = $row['marca'];
                $array[$index]['modelo'] = $row['modelo'];
                $array[$index]['color'] = $row['color'];
                $array[$index]['categoria'] = $row['categoria'];
                $array[$index]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
                $array[$index]['is_admin'] = Roles::hasAdmin() ? 1 : 0 ;
            }
        ExecutorPDO::closeCon();	
        return $array;        
}
    
    public static function getById($id) {
        $sql = "SELECT p.id,p.image,p.codigo,p.name,p.description,p.price_in,p.price_in_d,p.price_out,p.price_out_d,p.price_out_es_d,p.price_out_es,p.presentation,p.marca,p.modelo,p.color,
        p.created_at,CONCAT('[ ',pe.razon_social,' ] ',pe.name,' ',pe.lastname) AS proveedor, c.name AS categoria,category_id,person_id,inventary_min,p.facturano,p.is_active
        FROM product p 
        LEFT OUTER JOIN person pe ON p.person_id = pe.id 
        LEFT OUTER JOIN category c ON p.category_id = c.id
        WHERE p.type=4 AND p.id='".$id."';";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $row) {
                $units = OperationData::getUnitsTotalByProductoId($row['id']);                
                $array['description'] = $row['description'];
                $array['id'] = $row['id'];
                $array['name'] = $row['name'];
                $array['image'] = $row['image'];
                $array['codigo'] = $row['codigo'];
                $array['costo_c'] = floatval($row['price_in']);
                $array['costo_d'] = floatval($row['price_in_d']);
                $array['precio_c'] = floatval($row['price_out']);
                $array['precio_d'] = floatval($row['price_out_d']);
                $array['precio_es_c'] = floatval($row['price_out_es']);
                $array['precio_es_d'] = floatval($row['price_out_es_d']);
                $array['unidades'] = intval($units);
                $array['presentation'] = $row['presentation'];
                $array['proveedor'] =  $row['proveedor'];
                $array['proveedorid'] =  $row['person_id'];
                $array['marca'] = $row['marca'];
                $array['modelo'] = $row['modelo'];
                $array['color'] = $row['color'];
                $array['categoria'] = $row['categoria'];
                $array['categoriaid'] = $row['category_id'];
                $array['min_inv'] = intval($row['inventary_min']);
                $array['factura'] = $row['facturano'];
                $array['fecha'] = date('d/m/Y', strtotime($row['created_at']));
                $array['fecha_input'] = date('Y-m-d', strtotime($row['created_at']));
                $array['active'] = intval($row['is_active']);
                $array['is_admin'] = Roles::hasAdmin() ? 1 : 0 ;
            }
        ExecutorPDO::closeCon();	
        return $array;        
}


public static function getMovimientosById($id) {
    $sql = "SELECT o.id, o.product_id, o.q, o.price_in,o.price_in_d,o.price_out,o.price_out_d,o.price_out_es,o.price_out_es_d, o.discount, 
            s.facturano,s.status, if(o.operation_type_id=1,'Entrada','Salida') as tipo_operacion,  
                if(s.person_id=0,' - ',(if(s.person_id=1,'No registrado',CONCAT(pe.name,' ',pe.lastname)))) AS cliente,s.created_at as fecha,
            CONCAT(c.name,' ',p.name) AS item,o.descripcion                     
            FROM operation o 
            LEFT OUTER JOIN product p ON o.product_id = p.id
            LEFT OUTER JOIN category c ON p.category_id = c.id
            LEFT OUTER JOIN sell s ON o.sell_id = s.id
            LEFT OUTER JOIN person pe ON s.person_id = pe.id
            WHERE o.product_id='".$id."'
            AND s.operation_type_id !=0
            ORDER BY s.created_at DESC;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
            $total_c = ($row['tipo_operacion'] == "Salida")?(($row['q'] * (floatval($row['price_out']) + floatval($row['price_out_es'] ))) - floatval($row['discount'])):($row['q'] * floatval($row['price_in']));
            $total_d = ($row['tipo_operacion'] == "Salida")?(($row['q'] * (floatval($row['price_out_d']) + floatval($row['price_out_es_d'] ))) - floatval($row['discount_d'])):($row['q'] * floatval($row['price_in_d']));
            $array[$index]['id'] = $row['id'];
            $array[$index]['product_id'] = $row['product_id'];
            $array[$index]['cliente'] = $row['cliente'];
            $array[$index]['factura'] = $row['facturano'];
            $array[$index]['unidades'] = $row['q'];
            $array[$index]['costo_c'] = floatval($row['price_in']);
            $array[$index]['costo_d'] = floatval($row['price_in_d']);
            $array[$index]['precio_c'] = floatval($row['price_out']);
            $array[$index]['precio_d'] = floatval($row['price_out_d']);
            $array[$index]['precio_es_c'] = floatval($row['price_out_es']);
            $array[$index]['precio_es_d'] = floatval($row['price_out_es_d']);
            $array[$index]['descuento_c'] = floatval($row['discount']);
            $array[$index]['descuento_d'] = floatval($row['discount_d']);
            $array[$index]['total_c'] = floatval($total_c);
            $array[$index]['total_d'] = floatval($total_d);
            $array[$index]['tipo_operacion'] =  $row['tipo_operacion'];
            $array[$index]['status'] =  $row['status'];
            $array[$index]['fecha'] = $row['fecha'];
            $array[$index]['descripcion'] = $row['descripcion'];
            $array[$index]['item'] = $row['item'];
        }
    ExecutorPDO::closeCon();	
    return $array;        
}

public function save(){
    $idp = 0;
    $idc = 0;      
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
            $sql_producto = "INSERT INTO product (`image`,`barcode`, `codigo`, `imei2`, `imeivarios`, `type`,
                            `name`, `description`, `compatibilidad`,`inventary_min`,`price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                            `unit`,`presentation`, `user_id`, `person_id`,`marca`,`modelo`,`color`,`calidad`, `category_id`, `ingresado_type`, `created_at`, `facturano`,`is_active`,`justificacion`)
                            VALUES (:image,:barcode, :codigo, :imei2, :imeivarios,:type, 
                            :name, :description, :compatibilidad, :invmin, :costoc, :costod, :ventac,:ventad, :espc, :espd,
                            :unit, :presentation, :user, :proveedor, :marca, :modelo,:color,:calidad, :categoria, :ingresado_type,:fecha,:factura,:is_active,:justificacion);";           
                
                $stmt = $con->prepare($sql_producto);
                $stmt->bindParam(':image', $this->image,PDO::PARAM_STR);
                $stmt->bindParam(':barcode', $this->barcode,PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $this->codigo,PDO::PARAM_STR);
                $stmt->bindParam(':imei2', $this->imei2,PDO::PARAM_STR);
                $stmt->bindParam(':imeivarios', $this->imeivarios,PDO::PARAM_STR);
                $stmt->bindParam(':type', $this->type,PDO::PARAM_STR);

                $stmt->bindParam(':name', $this->name,PDO::PARAM_STR);
                $stmt->bindParam(':description', $this->description,PDO::PARAM_STR);
                $stmt->bindParam(':compatibilidad', $this->compatibilidad,PDO::PARAM_STR);
                $stmt->bindParam(':invmin', $this->inventary_min,PDO::PARAM_STR);
                $stmt->bindParam(':costoc', $this->price_in,PDO::PARAM_STR);
                $stmt->bindParam(':costod', $this->price_in_d,PDO::PARAM_STR);
                $stmt->bindParam(':ventac', $this->price_out,PDO::PARAM_STR);
                $stmt->bindParam(':ventad', $this->price_out_d,PDO::PARAM_STR);
                $stmt->bindParam(':espc', $this->price_out_es,PDO::PARAM_STR);
                $stmt->bindParam(':espd', $this->price_out_es_d,PDO::PARAM_STR);

                $stmt->bindParam(':unit', $this->unit,PDO::PARAM_STR);
                $stmt->bindParam(':presentation', $this->presentation,PDO::PARAM_STR);
                
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $this->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $this->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $this->color,PDO::PARAM_STR);
                $stmt->bindParam(':calidad', $this->calidad,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $this->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':ingresado_type', $this->ingresado_type,PDO::PARAM_STR);

                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':is_active', $this->is_active,PDO::PARAM_STR);
                $stmt->bindParam(':justificacion', $this->justificacion,PDO::PARAM_STR);
                $producto = $stmt->execute();
                if(!$producto){
                   throw new PDOException("No se pudo guardar registrar el repuesto");
                }
                $idp = $con->lastInsertId(); 
                ProductoHistorialData::save($idp,$con);
                $compra_c = floatval(floatval($this->price_in) * $this->unit);
                $compra_d = floatval(floatval($this->price_in_d) * $this->unit);
                
                    $sql_sell = "INSERT INTO `sell` (`person_id`, `user_id`, `operation_type_id`,`id_caja_a_revertir`, 
                                `total`, `total_d`, `cash`, `cash_d`, `discount`, `discount_d`, `sell_type`, `saldo`,
                                `status`, `compra_type`, `compra_saldo`, `compra_status`, `facturano`, `clienteanonimo`,  `justificacion`, `created_at`) 
                                VALUES (:proveedor, :user, 1, 0,
                                :totalc, :totald, 0, 0, 0, 0, 0, 0,
                                1, 1,0,0, :factura, '0', ' ',:fecha);";
                        $stmt = $con->prepare($sql_sell);                        
                        $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                        $stmt->bindParam(':user',$this->user_id,PDO::PARAM_INT);
                        $stmt->bindParam(':totalc', $compra_c,PDO::PARAM_STR);
                        $stmt->bindParam(':totald', $compra_d,PDO::PARAM_STR);
                        $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);                
                        $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                        $compra = $stmt->execute();
                        
                        if(!$compra){
                            throw new PDOException("No se pudo guardar registrar la compra");
                        }
                        $idc = $con->lastInsertId();                         

                            $sql_operation = "INSERT INTO `operation` (`product_id`, `imei`, `color`, `q`,
                             `price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                             `operation_type_id`, `sell_id`, `discount`, `discount_d`, `descripcion`, `created_at`) 
                             VALUES (:product, ' ', ' ', :units,
                                     :comprac, :comprad, 0, 0, 0, 0,
                                     1, :compra, 0, 0, ' ', :fecha);";

                            $stmt = $con->prepare($sql_operation);                        
                            $stmt->bindParam(':product', $idp,PDO::PARAM_STR);
                            $stmt->bindParam(':units',$this->unit,PDO::PARAM_INT);
                            $stmt->bindParam(':comprac', $this->price_in,PDO::PARAM_STR);
                            $stmt->bindParam(':comprad', $this->price_in_d,PDO::PARAM_STR);
                            $stmt->bindParam(':compra', $idc,PDO::PARAM_STR);                
                            $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                            $operacion = $stmt->execute();         
                            if(!$operacion){
                                throw new PDOException("No se pudo guardar registrar la compra");
                            }
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                    
                        return ["msg"=>"Producto registrado correctamente...","code"=>true];      
          
    }catch(\PDOException $e){
        if($idp > 0 ){$con->exec("DELETE FROM product WHERE id = '".$idp."';");}
        if($idc > 0 ){$con->exec("DELETE FROM sell WHERE id = '".$idc."';");}
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}

public function saveOnly(){
    $idp = 0;  
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
            $sql_producto = "INSERT INTO product (`image`,`barcode`, `codigo`, `imei2`, `imeivarios`, `type`,
                            `name`, `description`, `compatibilidad`,`inventary_min`,`price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                            `unit`,`presentation`, `user_id`, `person_id`,`marca`,`modelo`,`color`,`calidad`, `category_id`, `ingresado_type`, `created_at`, `facturano`,`is_active`,`justificacion`)
                            VALUES (:image,:barcode, :codigo, :imei2, :imeivarios,:type, 
                            :name, :description, :compatibilidad, :invmin, :costoc, :costod, :ventac,:ventad, :espc, :espd,
                            :unit, :presentation, :user, :proveedor, :marca, :modelo,:color,:calidad, :categoria, :ingresado_type,:fecha,:factura,:is_active,:justificacion);";           
                
                $stmt = $con->prepare($sql_producto);
                $stmt->bindParam(':image', $this->image,PDO::PARAM_STR);
                $stmt->bindParam(':barcode', $this->barcode,PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $this->codigo,PDO::PARAM_STR);
                $stmt->bindParam(':imei2', $this->imei2,PDO::PARAM_STR);
                $stmt->bindParam(':imeivarios', $this->imeivarios,PDO::PARAM_STR);
                $stmt->bindParam(':type', $this->type,PDO::PARAM_STR);

                $stmt->bindParam(':name', $this->name,PDO::PARAM_STR);
                $stmt->bindParam(':description', $this->description,PDO::PARAM_STR);
                $stmt->bindParam(':compatibilidad', $this->compatibilidad,PDO::PARAM_STR);
                $stmt->bindParam(':invmin', $this->inventary_min,PDO::PARAM_STR);
                $stmt->bindParam(':costoc', $this->price_in,PDO::PARAM_STR);
                $stmt->bindParam(':costod', $this->price_in_d,PDO::PARAM_STR);
                $stmt->bindParam(':ventac', $this->price_out,PDO::PARAM_STR);
                $stmt->bindParam(':ventad', $this->price_out_d,PDO::PARAM_STR);
                $stmt->bindParam(':espc', $this->price_out_es,PDO::PARAM_STR);
                $stmt->bindParam(':espd', $this->price_out_es_d,PDO::PARAM_STR);

                $stmt->bindParam(':unit', $this->unit,PDO::PARAM_STR);
                $stmt->bindParam(':presentation', $this->presentation,PDO::PARAM_STR);
                
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $this->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $this->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $this->color,PDO::PARAM_STR);
                $stmt->bindParam(':calidad', $this->calidad,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $this->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':ingresado_type', $this->ingresado_type,PDO::PARAM_STR);

                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':is_active', $this->is_active,PDO::PARAM_STR);
                $stmt->bindParam(':justificacion', $this->justificacion,PDO::PARAM_STR);
                $producto = $stmt->execute();
                if(!$producto){
                   throw new PDOException("No se pudo guardar registrar el repuesto");
                }
                $idp = $con->lastInsertId(); 
             
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                    
                        return ["msg"=>"Producto registrado correctamente...","code"=>true,"id"=>$idp];      
          
    }catch(\PDOException $e){
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}

public function update(){   
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {            
            $sql_get = "SELECT id,price_in as pcc,price_in_d as pcd,price_out as pvc,price_out_d as pvd,price_out_es as pec,price_out_es_d as ped FROM product where id='".$this->id."';";  
            $stmt = $con->prepare($sql_get);
            $stmt->execute();
            $collect = $stmt->fetchAll(PDO::FETCH_CLASS, "Precios");
            $precios =$collect[0]; 

            $sql_producto = "UPDATE product SET
                            image= :image,barcode= :barcode, codigo= :codigo, imei2= :imei2, imeivarios= :imeivarios, type= :type,
                            name= :name, description= :description, compatibilidad= :compatibilidad,inventary_min= :invmin,
                            price_in= :costoc, price_in_d= :costod, price_out= :ventac, price_out_d= :ventad, price_out_es= :espc, price_out_es_d= :espd,
                            unit= :unit,presentation= :presentation, user_id= :user, person_id= :proveedor,marca= :marca,modelo= :modelo,color= :color,
                            calidad= :calidad, category_id= :categoria, ingresado_type= :ingresado_type, created_at= :fecha, facturano= :factura,is_active= :is_active
                            ,justificacion= :justificacion WHERE  id = :id ;";
                            
                $stmt = $con->prepare($sql_producto);
                $stmt->bindParam(':image', $this->image,PDO::PARAM_STR);
                $stmt->bindParam(':barcode', $this->barcode,PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $this->codigo,PDO::PARAM_STR);
                $stmt->bindParam(':imei2', $this->imei2,PDO::PARAM_STR);
                $stmt->bindParam(':imeivarios', $this->imeivarios,PDO::PARAM_STR);
                $stmt->bindParam(':type', $this->type,PDO::PARAM_STR);

                $stmt->bindParam(':name', $this->name,PDO::PARAM_STR);
                $stmt->bindParam(':description', $this->description,PDO::PARAM_STR);
                $stmt->bindParam(':compatibilidad', $this->compatibilidad,PDO::PARAM_STR);
                $stmt->bindParam(':invmin', $this->inventary_min,PDO::PARAM_STR);
                $stmt->bindParam(':costoc', $this->price_in,PDO::PARAM_STR);
                $stmt->bindParam(':costod', $this->price_in_d,PDO::PARAM_STR);
                $stmt->bindParam(':ventac', $this->price_out,PDO::PARAM_STR);
                $stmt->bindParam(':ventad', $this->price_out_d,PDO::PARAM_STR);
                $stmt->bindParam(':espc', $this->price_out_es,PDO::PARAM_STR);
                $stmt->bindParam(':espd', $this->price_out_es_d,PDO::PARAM_STR);

                $stmt->bindParam(':unit', $this->unit,PDO::PARAM_STR);
                $stmt->bindParam(':presentation', $this->presentation,PDO::PARAM_STR);
                
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $this->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $this->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $this->color,PDO::PARAM_STR);
                $stmt->bindParam(':calidad', $this->calidad,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $this->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':ingresado_type', $this->ingresado_type,PDO::PARAM_STR);

                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':is_active', $this->is_active,PDO::PARAM_STR);
                $stmt->bindParam(':justificacion', $this->justificacion,PDO::PARAM_STR);
                $stmt->bindParam(':id', $this->id,PDO::PARAM_STR);
                $producto = $stmt->execute();
                if(!$producto){
                   throw new PDOException("No se pudo actualizar los datos del repuesto");
                } 
                $cambioPrecio = false;
                if(floatval($this->price_in) != floatval($precios->pcc)){$cambioPrecio = true;}
                if(floatval($this->price_in_d) != floatval($precios->pcd)){$cambioPrecio = true;}
                if(floatval($this->price_out) != floatval($precios->pvc)){$cambioPrecio = true;}
                if(floatval($this->price_out) != floatval($precios->pvc)){$cambioPrecio = true;}
                if(floatval($this->price_out_es) != floatval($precios->pec)){$cambioPrecio = true;}
                if(floatval($this->price_out_es_d) != floatval($precios->ped)){$cambioPrecio = true;}
                if($cambioPrecio){
                    ProductoHistorialData::save($this->id,$con);
                }
                
                $con->commit(); 
                $con = null;
                ExecutorPDO::closeConnection();                    
                return ["msg"=>"Datos del repuesto actualizados correctamente...","code"=>true];      
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}

public function updateInventario(){   
    $idc = 0; 
    $con = ExecutorPDO::getConnection();
    $con->beginTransaction();
    try {            
            $sql_get = "SELECT id,price_in as pcc,price_in_d as pcd,price_out as pvc,price_out_d as pvd,price_out_es as pec,price_out_es_d as ped FROM product where id='".$this->id."';";  
            $stmt = $con->prepare($sql_get);
            $stmt->execute();
 //           $collect = $stmt->fetchAll(PDO::FETCH_CLASS, "Precios");
//            $precios =$collect[0]; 
                    $tipo_movimiento = ($this->price_in > 0)?1:2;
                    $tipo_movimiento = ($this->price_out > 0)?2:1;
                    $tipo_status = ($this->price_in > 0)?3:4;
                    $tipo_status = ($this->price_out > 0)?4:3;
                    $tcompra = ($this->price_in > 0)?3:4;
                    $tventa  = ($this->price_out > 0)?4:3;
                    $sql_sell = "INSERT INTO `sell` (`person_id`, `user_id`, `operation_type_id`,`id_caja_a_revertir`, 
                        `total`, `total_d`, `cash`, `cash_d`, `discount`, `discount_d`, `sell_type`, `saldo`,
                        `status`, `compra_type`, `compra_saldo`, `compra_status`, `facturano`, `clienteanonimo`,  `justificacion`, `created_at`) 
                        VALUES (0, :user, :movimiento, 0,
                        0, 0, 0, 0, 0, 0, :tventa, 0,
                        :status, :tcompra,0,0,0,0,' ',:fecha);";
                    $stmt = $con->prepare($sql_sell);
                    $stmt->bindParam(':user',$this->user_id,PDO::PARAM_INT); 
                    $stmt->bindParam(':movimiento',$tipo_movimiento,PDO::PARAM_INT);
                    $stmt->bindParam(':tventa',$tventa,PDO::PARAM_INT);  
                    $stmt->bindParam(':status',$tipo_status,PDO::PARAM_INT);  
                    $stmt->bindParam(':tcompra',$tcompra,PDO::PARAM_INT);               
                    $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                    $compra = $stmt->execute();                        
                        if(!$compra){
                            throw new PDOException("No se pudo guardar registrar la compra");
                        }
                        $idc = $con->lastInsertId(); 
                        $q = ($this->price_in > 0)?$this->price_in:$this->price_out;
                        $sql_operation = "INSERT INTO `operation` (`product_id`, `imei`, `color`, `q`,
                             `price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                             `operation_type_id`, `sell_id`, `discount`, `discount_d`, `descripcion`, `created_at`) 
                             VALUES (:product, ' ', ' ', :q,
                                     0, 0, 0, 0, 0, 0,
                                     :opt, :compra, 0, 0,:descripcion,:fecha);";
                            $stmt = $con->prepare($sql_operation);                        
                            $stmt->bindParam(':product', $this->id,PDO::PARAM_STR);
                            $stmt->bindParam(':q', $q,PDO::PARAM_STR);
                            $stmt->bindParam(':opt', $tipo_movimiento,PDO::PARAM_STR);
                            $stmt->bindParam(':compra', $idc,PDO::PARAM_STR);  
                            $stmt->bindParam(':descripcion', $this->justificacion,PDO::PARAM_STR);            
                            $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                            $operacion = $stmt->execute();         
                            if(!$operacion){
                                throw new PDOException("No se pudo guardar registrar la compra");
                            }
                $con->commit(); 
                $con = null;
                ExecutorPDO::closeConnection();                    
                return ["msg"=>"Se actualizo el inventario del producto...","code"=>true];      
          
    }catch(\PDOException $e){
        if($idc > 0 ){$con->exec("DELETE FROM sell WHERE id = '".$idc."';");}
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}

/**************************/
public function duplicar($id){
    $idp = 0;
    $idc = 0;      
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();  
    
    try {
        $stmt = $con->prepare("SELECT * from product where id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT );
        $stmt->execute();
        $p = $stmt->fetchAll(PDO::FETCH_CLASS,"AccesoriosAutosData");
        $p = $p[0];

    $lastCode = intval(ProductoData::getLastCode(4)['code']) + 1;
    $rootPath = realpath(__DIR__ . '/../../../../');
    $assetsPath = $rootPath . '/storage/products';
    $newFileName = "";
    $oldFileName = $p->image;
    $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . SELF::$dirImg . $oldFileName;
    $ext = pathinfo($assetsPath.'/'.$oldFileName, PATHINFO_EXTENSION);
        $name = preg_replace('/\s+/', ' ', $p->name);
        $name = strtolower(str_replace(' ', '_', $name));
        $name = preg_replace('/[^A-Za-z0-9\_]/', '', $name); // Removes special chars.
        $codigo = preg_replace('/\s+/', ' ', $lastCode);;      
        $codigo = preg_replace('/[^A-Za-z0-9\_]/', '', $codigo);   
        $newFileName = $name . '_' . $codigo . '.' . $ext;    
        $newFilePath =$_SERVER['DOCUMENT_ROOT'] . SELF::$dirImg . $newFileName;

      
    if (copy($oldFilePath, $newFilePath)) { }

            $sql_producto = "INSERT INTO product (`image`,`barcode`, `codigo`, `imei2`, `imeivarios`, `type`,
                            `name`, `description`, `compatibilidad`,`inventary_min`,`price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                            `unit`,`presentation`, `user_id`, `person_id`,`marca`,`modelo`,`color`,`calidad`, `category_id`, `ingresado_type`, `created_at`, `facturano`,`is_active`,`justificacion`)
                            VALUES (:image,:barcode, :codigo, :imei2, :imeivarios,:type, 
                            :name, :description, :compatibilidad, :invmin, :costoc, :costod, :ventac,:ventad, :espc, :espd,
                            :unit, :presentation, :user, :proveedor, :marca, :modelo,:color,:calidad, :categoria, :ingresado_type,:fecha,:factura,:is_active,:justificacion);";           
                
                $stmt = $con->prepare($sql_producto);
                $stmt->bindParam(':image', $newFileName,PDO::PARAM_STR);
                $stmt->bindParam(':barcode', $p->barcode,PDO::PARAM_STR);
                $stmt->bindParam(':codigo', $codigo,PDO::PARAM_STR);
                $stmt->bindParam(':imei2', $p->imei2,PDO::PARAM_STR);
                $stmt->bindParam(':imeivarios', $p->imeivarios,PDO::PARAM_STR);
                $stmt->bindParam(':type', $p->type,PDO::PARAM_STR);

                $stmt->bindParam(':name', $p->name,PDO::PARAM_STR);
                $stmt->bindParam(':description', $p->description,PDO::PARAM_STR);
                $stmt->bindParam(':compatibilidad', $p->compatibilidad,PDO::PARAM_STR);
                $stmt->bindParam(':invmin', $p->inventary_min,PDO::PARAM_STR);
                $stmt->bindParam(':costoc', $p->price_in,PDO::PARAM_STR);
                $stmt->bindParam(':costod', $p->price_in_d,PDO::PARAM_STR);
                $stmt->bindParam(':ventac', $p->price_out,PDO::PARAM_STR);
                $stmt->bindParam(':ventad', $p->price_out_d,PDO::PARAM_STR);
                $stmt->bindParam(':espc', $p->price_out_es,PDO::PARAM_STR);
                $stmt->bindParam(':espd', $p->price_out_es_d,PDO::PARAM_STR);

                $stmt->bindParam(':unit', $p->unit,PDO::PARAM_STR);
                $stmt->bindParam(':presentation', $p->presentation,PDO::PARAM_STR);
                
                $stmt->bindParam(':user', $p->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $p->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $p->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $p->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $p->color,PDO::PARAM_STR);
                $stmt->bindParam(':calidad', $p->calidad,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $p->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':ingresado_type', $p->ingresado_type,PDO::PARAM_STR);

                $stmt->bindParam(':fecha', $p->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $p->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':is_active', $p->is_active,PDO::PARAM_STR);
                $stmt->bindParam(':justificacion', $p->justificacion,PDO::PARAM_STR);
                $producto = $stmt->execute();
                if(!$producto){
                   throw new PDOException("No se pudo guardar registrar el accesorio");
                }
                $idp = $con->lastInsertId(); 
                ProductoHistorialData::save($idp,$con);
                /*$compra_c = floatval(floatval($p->price_in) * 0);
                $compra_d = floatval(floatval($p->price_in_d) * 0);
                
                    $sql_sell = "INSERT INTO `sell` (`person_id`, `user_id`, `operation_type_id`,`id_caja_a_revertir`, 
                                `total`, `total_d`, `cash`, `cash_d`, `discount`, `discount_d`, `sell_type`, `saldo`,
                                `status`, `compra_type`, `compra_saldo`, `compra_status`, `facturano`, `clienteanonimo`,  `justificacion`, `created_at`) 
                                VALUES (:proveedor, :user, 1, 0,
                                :totalc, :totald, 0, 0, 0, 0, 0, 0,
                                1, 1,0,0, :factura, '0', ' ',:fecha);";
                        $stmt = $con->prepare($sql_sell);                        
                        $stmt->bindParam(':proveedor', $p->person_id,PDO::PARAM_STR);
                        $stmt->bindParam(':user',$p->user_id,PDO::PARAM_INT);
                        $stmt->bindParam(':totalc', $compra_c,PDO::PARAM_STR);
                        $stmt->bindParam(':totald', $compra_d,PDO::PARAM_STR);
                        $stmt->bindParam(':factura', $p->facturano,PDO::PARAM_STR);                
                        $stmt->bindParam(':fecha', $p->created_at,PDO::PARAM_STR);
                        $compra = $stmt->execute();
                        
                        if(!$compra){
                            throw new PDOException("No se pudo guardar registrar la compra");
                        }
                        $idc = $con->lastInsertId();                         

                            $sql_operation = "INSERT INTO `operation` (`product_id`, `imei`, `color`, `q`,
                             `price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                             `operation_type_id`, `sell_id`, `discount`, `discount_d`, `descripcion`, `created_at`) 
                             VALUES (:product, ' ', ' ', 0,
                                     :comprac, :comprad, 0, 0, 0, 0,
                                     1, :compra, 0, 0, 'Producto Duplicado', :fecha);";

                            $stmt = $con->prepare($sql_operation);                        
                            $stmt->bindParam(':product', $idp,PDO::PARAM_STR);
                            $stmt->bindParam(':comprac', $p->price_in,PDO::PARAM_STR);
                            $stmt->bindParam(':comprad', $p->price_in_d,PDO::PARAM_STR);
                            $stmt->bindParam(':compra', $idc,PDO::PARAM_STR);                
                            $stmt->bindParam(':fecha', $p->created_at,PDO::PARAM_STR);
                            $operacion = $stmt->execute();         
                            if(!$operacion){
                                throw new PDOException("No se pudo guardar registrar la compra");
                            }*/
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                    
                        return ["msg"=>"Producto Duplicado correctamente","id"=>$idp,"code"=>true];      
          
    }catch(\PDOException $e){
        //if($idp > 0 ){$con->exec("DELETE FROM product WHERE id = '".$idp."';");}
       // if($idc > 0 ){$con->exec("DELETE FROM sell WHERE id = '".$idc."';");}
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}















}
?>
