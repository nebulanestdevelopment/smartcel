<?php
class RepuestosData extends ProductoData {



    public static function getAll() {
            $sql = "SELECT p.id,p.description,p.compatibilidad,p.price_in,p.price_in_d,p.price_out,p.price_out_d,p.price_out_es_d,p.price_out_es,p.presentation,p.marca,p.modelo,p.color,
            p.created_at,CONCAT('[ ',pe.razon_social,' ] ',pe.name,' ',pe.lastname) AS proveedor, c.name AS categoria
            FROM product p 
            LEFT OUTER JOIN person pe ON p.person_id = pe.id 
            LEFT OUTER JOIN category c ON p.category_id = c.id
            WHERE p.type=3 Order BY p.marca  ASC;";
            ExecutorPDO::initCon();
            ExecutorPDO::initPreparate($sql);
            $array = array();
            ExecutorPDO::executeParams(array());
                foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                    $units = OperationData::getUnitsTotalByProductoId($row['id']);
                    $array[$index]['id'] = $row['id'];
                    $array[$index]['description'] = $row['description'];
                    $array[$index]['compatibilidad'] = $row['compatibilidad'];
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
        $sql = "SELECT p.id,p.description,p.compatibilidad,p.name,inventary_min,is_active,facturano,p.codigo,p.price_in,p.price_in_d,p.price_out,p.price_out_d,p.price_out_es,p.price_out_es_d,p.presentation,p.marca,p.modelo,p.color,
        p.created_at,CONCAT('[ ',pe.razon_social,' ] ',pe.name,' ',pe.lastname) AS proveedor, c.name AS categoria,category_id,person_id
        FROM product p 
        LEFT OUTER JOIN person pe ON p.person_id = pe.id 
        LEFT OUTER JOIN category c ON p.category_id = c.id
        WHERE p.type=3 AND p.id='".$id."';";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $row) {
                $units = OperationData::getUnitsTotalByProductoId($row['id']);
                $array['id'] = $row['id'];
                $array['description'] = $row['description'];
                $array['compatibilidad'] = $row['compatibilidad'];
                $array['name'] = $row['name'];
                $array['codigo'] = $row['codigo'];
                $array['costo_c'] = floatval($row['price_in']);
                $array['costo_d'] = floatval($row['price_in_d']);
                $array['precio_c'] = floatval($row['price_out']);
                $array['precio_d'] = floatval($row['price_out_d']);
                $array['precioe_c'] = floatval($row['price_out_es']);
                $array['precioe_d'] = floatval($row['price_out_es_d']);
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
            }
        ExecutorPDO::closeCon();	
        return $array;        
}
 

public static function getMovimientosById($id) {
    $sql = "SELECT o.id, o.product_id, o.q, o.price_in,o.price_in_d,o.price_out,o.price_out_d, o.discount, 
            s.facturano,s.status, if(o.operation_type_id=1,'Entrada','Salida') as tipo_operacion,  if(s.person_id=0,' - ',(if(s.person_id=1,'No registrado',CONCAT(pe.name,' ',pe.lastname)))) AS cliente,s.created_at as fecha,
            CONCAT(c.name,' ',p.marca,' ',p.modelo,' ',p.color) AS item,o.descripcion,status                     
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
            $array[$index]['fecha'] = $row['fecha'];
            $array[$index]['status'] =  $row['status'];
            $array[$index]['descripcion'] = $row['descripcion'];
            $array[$index]['item'] = $row['item'];
        }
    ExecutorPDO::closeCon();	
    return $array;        
}


public static function eliminarOperacion($oid,$pid){
 
    try {
        $con = ExecutorPDO::initCon();
        $con->beginTransaction();

        $sql_o = "SELECT sell_id as idventa,q,price_in as costoc,price_in_d as costod,price_out as precioc,price_out_d as preciod,
                       price_out_es as precio_espc, price_out_es_d as precio_espd,discount as descc, discount_d as descd,operation_type_id as otid
                  FROM operation
                  WHERE id='".$oid."' and product_id='".$pid."';";        
        ExecutorPDO::initPreparate($sql_o);
        $o = array();
        ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            $o['idventa'] = $r['idventa'];
            $o['q']       = $r['q'];
            $o['costoc']  = floatval($r['costoc']);
            $o['costod']  = floatval($r['costod']);
            $o['precioc'] = floatval($r['precioc']);
            $o['preciod'] = floatval($r['precio']);
            $o['precio_espc'] = floatval($r['precio_espc']);
            $o['precio_espd'] = floatval($r['precio_espd']);
            $o['descc'] = floatval($r['descc']);
            $o['descd'] = floatval($r['descd']);
            $o['otid'] = intval($r['otid']);
        }
  
        $sql_s = "SELECT COUNT(id) AS total_records  FROM operation WHERE sell_id='".$o['idventa']."';";
        ExecutorPDO::initPreparate($sql_s);
        $ts = 0;
        ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            $ts = $r['total_records'];
        }

      
        $del_op = false;
        $upd_sell= false;
        if($ts > 1){
            if(intval($o['otid']) == 1){
                $sql_del_op = "DELETE FROM operation WHERE id= :id;";
                ExecutorPDO::initPreparate($sql_del_op);
                ExecutorPDO::bind(':id', intval($oid),PDO::PARAM_INT);
                $del_op = ExecutorPDO::execute();

                $comprac = floatval($o['costoc']) * intval($o['q']);
                $comprad = floatval($o['costod']) * intval($o['q']);
                $sql_upd_sell = "UPDATE sell set total= total - :total,total_d= total_d - :totald,discount= discount - :discount,discount_d= discount_d - :discountd WHERE id= :id;";      
                ExecutorPDO::initPreparate($sql_upd_sell);
                ExecutorPDO::bind(':total', $comprac ,PDO::PARAM_STR);
                ExecutorPDO::bind(':totald', $comprad ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discount', $o['descc'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discountd', $o['descd'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':id', $o['idventa'] ,PDO::PARAM_INT);
                $upd_sell = ExecutorPDO::execute();

            }else if(intval($o['otid']) == 2){
              
                $sql_del_op = "DELETE FROM operation WHERE id= :id;";
                ExecutorPDO::initPreparate($sql_del_op);
                ExecutorPDO::bind(':id', intval($oid),PDO::PARAM_INT);
                $del_op = ExecutorPDO::execute();
            
                $ventac = ((floatval($o['precioc']) - floatval($o['precio_espc'])) * intval($o['q'])) - floatval($o['descc']);
                $ventad = ((floatval($o['preciod']) - floatval($o['precio_espd'])) * intval($o['q'])) - floatval($o['descd']);        
                $sql_upd_sell = "UPDATE sell SET 
                                        total= total - :total,
                                        total_d= total_d - :totald,
                                        cash= cash - :cash,
                                        cash_d= cash_d - :cashd,
                                        discount= discount - :discount,
                                        discount_d= discount_d - :discountd WHERE id= :id;";    
                ExecutorPDO::initPreparate($sql_upd_sell);
                ExecutorPDO::bind(':total', $ventac ,PDO::PARAM_STR);
                ExecutorPDO::bind(':totald', $ventad ,PDO::PARAM_STR);
                ExecutorPDO::bind(':cash', $ventac ,PDO::PARAM_STR);
                ExecutorPDO::bind(':cashd', $ventad ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discount', $o['descc'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discountd', $o['descd'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':id', intval($o['idventa']) ,PDO::PARAM_INT);
                $upd_sell = ExecutorPDO::execute();
            }
        }else{
                $sql_del_op = "DELETE FROM operation WHERE id= :id;";
                ExecutorPDO::initPreparate($sql_del_op);
                ExecutorPDO::bind(':id', intval($oid),PDO::PARAM_INT);
                $del_op = ExecutorPDO::execute();

                $sql_upd_sell = "DELETE FROM sell WHERE id= :id;";      
                ExecutorPDO::initPreparate($sql_upd_sell);
                ExecutorPDO::bind(':id', intval($o['idventa']) ,PDO::PARAM_INT);
                $upd_sell = ExecutorPDO::execute();
        }


        if($del_op && $upd_sell){
            $con->commit();
            ExecutorPDO::closeCon();
            return ["msg"=>"Datos de operacion  actualizados!!","code"=>true];
        }else{
            throw new PDOException("No se puede actualizar los datos de la operacion");
        }

    } catch (PDOException $ex) {
        $con->rollBack();
        ExecutorPDO::closeCon();
        return ["msg"=>$ex,"code"=>false];
    }	
}


public function save(){
    $idp = 0;
    $idc = 0;      
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
            $sql_producto = "INSERT INTO product (`barcode`, `codigo`, `imei2`, `imeivarios`, `type`,
                            `name`, `description`, `compatibilidad`,`inventary_min`,`price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                            `unit`,`presentation`, `user_id`, `person_id`,`marca`,`modelo`,`color`, `category_id`, `ingresado_type`, `created_at`, `facturano`,`is_active`,`justificacion`)
                            VALUES (' ', ' ', ' ', ' ',3, 
                            :name, :description, :compatibilidad, :invmin, :costoc, :costod, :ventac,:ventad, :espc, :espd,
                            '0', ' ', :user, :proveedor, :marca, :modelo,:color, :categoria,1,:fecha,:factura,1,' ');";           
                
                $stmt = $con->prepare($sql_producto);
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
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $this->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $this->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $this->color,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $this->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
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
                                     :comprac, :comprad, :ventac, :ventad, :espc, :espd,
                                     1, :compra, 0, 0, ' ', :fecha);";

                            $stmt = $con->prepare($sql_operation);                        
                            $stmt->bindParam(':product', $idp,PDO::PARAM_STR);
                            $stmt->bindParam(':units',$this->unit,PDO::PARAM_INT);
                            $stmt->bindParam(':comprac', $this->price_in,PDO::PARAM_STR);
                            $stmt->bindParam(':comprad', $this->price_in_d,PDO::PARAM_STR);
                            $stmt->bindParam(':ventac', $this->price_out,PDO::PARAM_STR);
                            $stmt->bindParam(':ventad', $this->price_out_d,PDO::PARAM_STR);
                            $stmt->bindParam(':espc', $this->price_out_es,PDO::PARAM_STR);
                            $stmt->bindParam(':espd', $this->price_out_es_d,PDO::PARAM_STR);
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
            $sql_producto = "INSERT INTO product (`barcode`, `codigo`, `imei2`, `imeivarios`, `type`,
                            `name`, `description`, `compatibilidad`,`inventary_min`,`price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                            `unit`,`presentation`, `user_id`, `person_id`,`marca`,`modelo`,`color`, `category_id`, `ingresado_type`, `created_at`, `facturano`,`is_active`,`justificacion`)
                            VALUES (' ', ' ', ' ', ' ',3, 
                            :name, :description, :compatibilidad, :invmin, :costoc, :costod, :ventac,:ventad, :espc, :espd,
                            '0', ' ', :user, :proveedor, :marca, :modelo,:color, :categoria,1,:fecha,:factura,1,' ');";           
                
                $stmt = $con->prepare($sql_producto);
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
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $this->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $this->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $this->color,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $this->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $producto = $stmt->execute();
                if(!$producto){
                   throw new PDOException("No se pudo guardar registrar el repuesto");
                }
                $idp = $con->lastInsertId(); 
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                    
                        return ["msg"=>"Producto registrado correctamente...","code"=>true,'id'=>$idp];      
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}

public function update(){   
    $idc = 0; 
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {            
            $sql_get = "SELECT id,price_in as pcc,price_in_d as pcd,price_out as pvc,price_out_d as pvd,price_out_es as pec,price_out_es_d as ped FROM product where id='".$this->id."';";  
            $stmt = $con->prepare($sql_get);
            $stmt->execute();
            $collect = $stmt->fetchAll(PDO::FETCH_CLASS, "Precios");
            $precios =$collect[0]; 

            $sql_producto = "UPDATE product SET 
                            name= :name, description= :description, compatibilidad= :compatibilidad,
                            inventary_min= :invmin,price_in= :costoc, price_in_d= :costod,
                            price_out= :ventac, price_out_d= :ventad, price_out_es= :espc, price_out_es_d= :espd,
                            user_id= :user, person_id= :proveedor,marca= :marca,modelo= :modelo,
                            color= :color, category_id= :categoria,created_at= :fecha, facturano= :factura , is_active= :active 
                            WHERE id= :id ;";           
                
                $stmt = $con->prepare($sql_producto);
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
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_STR);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                $stmt->bindParam(':marca', $this->marca,PDO::PARAM_STR);
                $stmt->bindParam(':modelo', $this->modelo,PDO::PARAM_STR);
                $stmt->bindParam(':color', $this->color,PDO::PARAM_STR);
                $stmt->bindParam(':categoria', $this->category_id,PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':active', $this->is_active,PDO::PARAM_INT);
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
                    /*$sql_sell = "INSERT INTO `sell` (`person_id`, `user_id`, `operation_type_id`,`id_caja_a_revertir`, 
                        `total`, `total_d`, `cash`, `cash_d`, `discount`, `discount_d`, `sell_type`, `saldo`,
                        `status`, `compra_type`, `compra_saldo`, `compra_status`, `facturano`, `clienteanonimo`,  `justificacion`, `created_at`) 
                        VALUES (:proveedor, :user, 1, 0,
                        0, 0, 0, 0, 0, 0, 0, 0,
                        0,3,0,0,0,0,' ',:fecha);";
                    $stmt = $con->prepare($sql_sell);
                    $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_STR);
                    $stmt->bindParam(':user',$this->user_id,PDO::PARAM_INT);               
                    $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                    $compra = $stmt->execute();                        
                        if(!$compra){
                            throw new PDOException("No se pudo guardar registrar la compra");
                        }
                        $idc = $con->lastInsertId(); 

                        $sql_operation = "INSERT INTO `operation` (`product_id`, `imei`, `color`, `q`,
                             `price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                             `operation_type_id`, `sell_id`, `discount`, `discount_d`, `descripcion`, `created_at`) 
                             VALUES (:product, ' ', ' ', 0,
                                     :comprac, :comprad, :ventac, :ventad, :espc, :espd,
                                     1, :compra, 0, 0,:descripcion,:fecha);";
                            $description = "Se realizo un cambio en el precio";
                            $stmt = $con->prepare($sql_operation);                        
                            $stmt->bindParam(':product', $this->id,PDO::PARAM_STR);
                            $stmt->bindParam(':comprac', $this->price_in,PDO::PARAM_STR);
                            $stmt->bindParam(':comprad', $this->price_in_d,PDO::PARAM_STR);
                            $stmt->bindParam(':ventac', $this->price_out,PDO::PARAM_STR);
                            $stmt->bindParam(':ventad', $this->price_out_d,PDO::PARAM_STR);
                            $stmt->bindParam(':espc', $this->price_out_es,PDO::PARAM_STR);
                            $stmt->bindParam(':espd', $this->price_out_es_d,PDO::PARAM_STR);
                            $stmt->bindParam(':compra', $idc,PDO::PARAM_STR);  
                            $stmt->bindParam(':descripcion', $description,PDO::PARAM_STR);            
                            $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                            $operacion = $stmt->execute();         
                            if(!$operacion){
                                throw new PDOException("No se pudo guardar registrar la compra");
                            }*/
                }
                
                $con->commit(); 
                $con = null;
                ExecutorPDO::closeConnection();                    
                return ["msg"=>"Datos del repuesto actualizados correctamente...","code"=>true];      
          
    }catch(\PDOException $e){
        if($idc > 0 ){$con->exec("DELETE FROM sell WHERE id = '".$idc."';");}
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
//            $collect = $stmt->fetchAll(PDO::FETCH_CLASS, "Precios");
 //           $precios =$collect[0]; 
                    $tipo_movimiento = ($this->price_in > 0)?1:2;
                    $tipo_movimiento = ($this->price_out > 0)?2:1;
                    $tcompra = ($this->price_in > 0)?3:4;
                    $tventa  = ($this->price_out > 0)?4:3;
                    $status = ($this->price_in > 0)?3:4;
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
                    $stmt->bindParam(':status',$status,PDO::PARAM_INT);
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
                           /* $stmt->bindParam(':comprac', $precios->pcc,PDO::PARAM_STR);
                            $stmt->bindParam(':comprad', $precios->pcd,PDO::PARAM_STR);
                            $stmt->bindParam(':ventac', $precios->pvc,PDO::PARAM_STR);
                            $stmt->bindParam(':ventad', $precios->pvd,PDO::PARAM_STR);
                            $stmt->bindParam(':espc', $precios->pec,PDO::PARAM_STR);
                            $stmt->bindParam(':espd', $precios->ped,PDO::PARAM_STR);*/
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
    //$idp = 0;
   // $idc = 0;      
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();  
    
    try {
        $stmt = $con->prepare("SELECT * from product where id=:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT );
        $stmt->execute();
        $p = $stmt->fetchAll(PDO::FETCH_CLASS,"RepuestosData");
        $p = $p[0];
   
            $sql_producto = "INSERT INTO product (`image`,`barcode`, `codigo`, `imei2`, `imeivarios`, `type`,
                            `name`, `description`, `compatibilidad`,`inventary_min`,`price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                            `unit`,`presentation`, `user_id`, `person_id`,`marca`,`modelo`,`color`,`calidad`, `category_id`, `ingresado_type`, `created_at`, `facturano`,`is_active`,`justificacion`)
                            VALUES (' ',:barcode, ' ', :imei2, :imeivarios,:type, 
                            :name, :description, :compatibilidad, :invmin, :costoc, :costod, :ventac,:ventad, :espc, :espd,
                            :unit, :presentation, :user, :proveedor, :marca, :modelo,:color,:calidad, :categoria, :ingresado_type,:fecha,:factura,:is_active,:justificacion);";           
                
                $stmt = $con->prepare($sql_producto);
                $stmt->bindParam(':barcode', $p->barcode,PDO::PARAM_STR);
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
                   throw new PDOException("No se pudo guardar registrar el repuesto");
                }
                $idp = $con->lastInsertId(); 
                ProductoHistorialData::save($idp,$con);
               /* $compra_c = floatval(floatval($p->price_in) * 0);
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
      //  if($idp > 0 ){$con->exec("DELETE FROM product WHERE id = '".$idp."';");}
     //   if($idc > 0 ){$con->exec("DELETE FROM sell WHERE id = '".$idc."';");}
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
}

















}
?>
