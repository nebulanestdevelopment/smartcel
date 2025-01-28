<?php

class ComprasData extends SellData {

   
	public  function __construct(){
		$this->id = 0;
		$this->person_id = 0;
		$this->user_id = 0;
		$this->operation_type_id = 0;
		$this->box_id = 0;
		$this->related_box = 0;
		$this->id_caja_a_revertir = 0;
		$this->total = 0;
		$this->total_d = 0;
		$this->cash = 0;
		$this->cash_d = 0;
		$this->discount = 0;
		$this->discount_d = 0;
		$this->sell_type = 0;
		$this->saldo = 0;
		$this->status = 0;
		$this->compra_type = 1;
		$this->compra_saldo = 0;
		$this->compra_status = 0;
		$this->facturano = " ";
		$this->clienteanonimo = " ";
		$this->justificacion = " ";
		$this->created_at = " ";
	}

public static function addToCart($data){
   if(!isset($_SESSION["reabastecer"])){
        $_SESSION["reabastecer"][] = $data ;        
    }else{
            $found = false;
            $products = $_SESSION["reabastecer"];
        foreach ($products as $index => $v){
            if(intval($v['product_id']) == intval($data['product_id'])){ 
                $found = true; 
                $_SESSION["reabastecer"][$index]['q']   = intval($_SESSION["reabastecer"][$index]['q']) +  intval($data['q']);
                $_SESSION["reabastecer"][$index]['pcc'] = floatval($data['pcc']);
                $_SESSION["reabastecer"][$index]['pcd'] = floatval($data['pcd']);
                $_SESSION["reabastecer"][$index]['pvc'] = floatval($data['pvc']);
                $_SESSION["reabastecer"][$index]['pvd'] = floatval($data['pvd']);
                $_SESSION["reabastecer"][$index]['pec'] = floatval($data['pec']);
                $_SESSION["reabastecer"][$index]['ped'] = floatval($data['ped']);          
                break; 
            } 
        }

        if($found == false){
            $_SESSION["reabastecer"][] = $data ;
        }
    }
}


public static function getProducts($query,$query2,$type) {

    $where = '';
    
        if($type==1){
            if(trim($query) != ''){
                 $where .= " (codigo LIKE '%".$query."%' OR NAME LIKE '%".$query."%') AND "; 
            }
        }else if($type==2){
            if(trim($query) != ''){
                $where .= " (barcode='".$query."' OR imei2= '".$query."') AND "; 
            }else if(trim($query2) != ''){
                $where .= " ( marca LIKE '%".$query2."%' OR modelo LIKE '%".$query2."%') AND "; 
            }else if($query != '' && $query2 != '' ){
                $where .= " (barcode='".$query."' OR imei2= '".$query."') OR ( marca LIKE '%".$query2."%' OR modelo LIKE '%".$query2."%') AND "; 
            }
           
        }else if ($type==3){
            if(intval($query) > 0 && !empty($query2)){
                $where .= " (category_id='".$query."') AND ( marca LIKE '%".$query2."%' OR modelo LIKE '%".$query2."%') AND "; 
            }else if(intval($query) > 0 && empty($query2)){
                $where .= " category_id='".$query."'  AND "; 
            }else if(intval($query) == 0 && !empty($query2)){
                $where .= " ( marca LIKE '%".$query2."%' OR modelo LIKE '%".$query2."%') AND "; 
            }
        }else if ($type==4) {
            if(trim($query) != ''){
              $where .= " (codigo LIKE '%".$query."%' OR NAME LIKE '%".$query."%') AND "; 
            } 
        }
    

    $where .= " type='".$type."'";

    $sql = "SELECT * FROM product WHERE ".$where." AND is_active=1 Order BY id ASC";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
            $categoria = CategoriaData::getById($row['category_id']);
            $array[$index]['id'] = $row['id'];
            $array[$index]['barcode'] = $row['barcode'];
            $array[$index]['codigo'] = $row['codigo'];
            $array[$index]['imei2'] = $row['imei2'];
            $array[$index]['type'] = $row['type'];
            $array[$index]['name'] = isset($row['name'])?$row['name']:" ";
            $array[$index]['description'] = $row['description'];
            $array[$index]['costo_c'] = $row['price_in'];
            $array[$index]['costo_d'] = $row['price_in_d'];
            $array[$index]['precio_c'] = $row['price_out'];
            $array[$index]['precio_d'] = $row['price_out_d'];
            $array[$index]['precioe_c'] = $row['price_out_es'];
            $array[$index]['precioe_d'] = $row['price_out_es_d'];
            $array[$index]['unidades'] = OperationData::getUnitsTotalByProductoId($row['id']);
            $array[$index]['presentation'] = $row['presentation'];
            $array[$index]['marca'] = $row['marca'];
            $array[$index]['modelo'] = $row['modelo'];
            $array[$index]['color'] = $row['color'];
            $array[$index]['categoria'] = isset($categoria['name'])?$categoria['name']:" ";
        }
    ExecutorPDO::closeCon();	
    return $array;        
}             

public static function getAllBuys($fechainicial,$fechafinal) {
    $date = " ";
    if($fechainicial != ''){
        if($fechafinal != ''){
            $date = " AND s.created_at >= '".$fechainicial."' AND s.created_at <= '".$fechafinal."' ";
        }
    }

        $sql = "SELECT 
                       s.id,s.facturano,s.created_at as fecha,s.total,s.total_d,
                       CONCAT('[',p.razon_social,'] ',p.name,' ',p.lastname) AS proveedor
                FROM sell s
                     LEFT OUTER JOIN person p ON s.person_id = p.id
                WHERE s.operation_type_id='1' AND convert(s.total,decimal) > 0  ".$date."   ORDER BY fecha DESC;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
            
            $array[$index]['id'] = $row['id'];
            $array[$index]['factura'] = $row['facturano'];
            $array[$index]['proveedor'] = $row['proveedor'];
            $array[$index]['fecha'] = date('Y-m-d', strtotime($row['fecha']));
            $array[$index]['total_c'] = number_format(floatval($row['total']),2,'.',',');
            $array[$index]['total_d'] = number_format(floatval($row['total_d']),2,'.',',');
            $json=[];
            $sql_o = "SELECT o.id,o.product_id,o.q,o.price_in, o.price_in_d FROM operation o WHERE o.sell_id='".$row['id']."';";
            $con = ExecutorPDO::getConnection(); 
            $stmt = $con->prepare($sql_o);
            $stmt->execute();
            $operation_data = $stmt->fetchAll();
            foreach($operation_data as $i => $v){
                $json[$i]['codigo']= ProductoData::getProductCode($v['product_id']);
                $json[$i]['nombre']= ProductoData::getProductName($v['product_id']);   
                $json[$i]['costo_c']= number_format(floatval($v['price_in']),2,'.',',');
                $json[$i]['costo_d']= number_format(floatval($v['price_in_d']),2,'.',',');
                $json[$i]['q']= $v['q'];
                $total_c = floatval($v['price_in']) * intval($v['q']);
                $total_d = floatval($v['price_in_d']) * intval($v['q']);
                $json[$i]['total_c']= number_format(floatval($total_c),2,'.',',');
                $json[$i]['total_d']= number_format(floatval($total_d),2,'.',',');
            }
            $con = null;   //Cerramos la conexion a la base de datos      
            $array[$index]['json'] = json_encode($json);
        }
       
    ExecutorPDO::closeCon();	
    return $array;        
} 

public static function delete($id){
    $con = ExecutorPDO::getConnection(); 
    try {

        $sql_o = "DELETE FROM operation WHERE sell_id='".$id."';";
        $stmt = $con->prepare($sql_o);
        $stmt->execute();
        $sql_c = "DELETE FROM sell WHERE id='".$id."';";
        $stmt1 = $con->prepare($sql_c);
        $stmt1->execute();
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>"Se elimino el registro de compra!!","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}


public static function getCompraData($id) {
    
        $sql = "SELECT s.id,s.facturano,s.created_at as fecha,
                       CONCAT('[',p.razon_social,'] ',p.name,' ',p.lastname) AS proveedor
                FROM sell s
                     LEFT OUTER JOIN person p ON s.person_id = p.id
                WHERE s.id='".$id."';";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as  $row) {
            
            $array['id'] = $row['id'];
            $array['factura'] = $row['facturano'];
            $array['proveedor'] = $row['proveedor'];
            $array['fecha'] = date('Y-m-d h:m a', strtotime($row['fecha']));
            
        }
       
    ExecutorPDO::closeCon();	
    return $array;        
} 

public static function getDetalleCompra($id) {
    
    $sql = "SELECT o.product_id,o.q, o.price_in,o.price_in_d FROM operation o WHERE o.sell_id ='".$id."';";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $i => $v) {                
                $array[$i]['codigo']= ProductoData::getProductCode($v['product_id']);
                $array[$i]['nombre']= ProductoData::getProductName($v['product_id']);  
                $array[$i]['q'] = $v['q'];
                $array[$i]['costo_c'] = $v['price_in'];
                $array[$i]['costo_d'] = $v['price_in_d'];  
                $array[$i]['total_c'] = floatval($v['price_in']) * intval($v['q']); 
                $array[$i]['total_d'] = floatval($v['price_in_d']) * intval($v['q']);                
            }
        
        ExecutorPDO::closeCon();	
        return $array;        
} 


public  function save(){
    $idc = 0;
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
                                                
$sql_compra = "INSERT INTO sell (person_id, user_id, operation_type_id, box_id, related_box, 
                id_caja_a_revertir,total,total_d,cash,cash_d,
                discount, discount_d, sell_type, saldo, status,
                compra_type,compra_saldo,compra_status,facturano,clienteanonimo,created_at) VALUES 
                (:proveedor,:user,:ot,0,0,
                    0,:total,:totald,:cash,:cashd,
                    :desc,:descd,:vt,:saldo,:estado, 
                    :ct,:saldoc,:comprae,:factura,0,:fecha);";     
                
                $stmt = $con->prepare($sql_compra);
                $stmt->bindParam(':proveedor', $this->person_id,PDO::PARAM_INT);
                $stmt->bindParam(':user', $this->user_id,PDO::PARAM_INT);
                $stmt->bindParam(':ot', $this->operation_type_id,PDO::PARAM_INT);
                $stmt->bindParam(':total', $this->total,PDO::PARAM_STR);
                $stmt->bindParam(':totald', $this->total_d,PDO::PARAM_STR);
                $stmt->bindParam(':cash', $this->cash,PDO::PARAM_STR);
                $stmt->bindParam(':cashd', $this->cash_d,PDO::PARAM_STR);
                $stmt->bindParam(':desc', $this->discount,PDO::PARAM_STR);
                $stmt->bindParam(':descd', $this->discount_d,PDO::PARAM_STR);
                $stmt->bindParam(':vt', $this->sell_type,PDO::PARAM_INT);
                $stmt->bindParam(':saldo', $this->saldo,PDO::PARAM_STR);
                $stmt->bindParam(':estado', $this->status,PDO::PARAM_STR);
                $stmt->bindParam(':ct', $this->compra_type,PDO::PARAM_STR);
                $stmt->bindParam(':saldoc', $this->compra_saldo,PDO::PARAM_STR);
                $stmt->bindParam(':comprae', $this->compra_status,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);              
               
                $compra = $stmt->execute();
                if(!$compra){
                   throw new PDOException("No se pudo guardar la compra");
                }
                    $idc = $con->lastInsertId(); 
                    $cart = $_SESSION['reabastecer'];
                    foreach ($cart as $v) {
                        $sql_operation = "INSERT INTO `operation` (`product_id`, `imei`, `color`, `q`,
                        `price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                        `operation_type_id`, `sell_id`, `discount`, `discount_d`, `descripcion`, `created_at`) 
                        VALUES (:product, ' ', ' ', :units,
                                :comprac, :comprad, 0, 0, 0, 0,
                                1, :compra, 0, 0, ' ', :fecha);";

                       $stmt = $con->prepare($sql_operation);                        
                       $stmt->bindParam(':product', $v['product_id'],PDO::PARAM_INT);
                       $stmt->bindParam(':units',$v['q'],PDO::PARAM_INT);
                       $stmt->bindParam(':comprac', $v['pcc'],PDO::PARAM_STR);
                       $stmt->bindParam(':comprad', $v['pcd'],PDO::PARAM_STR);
                       $stmt->bindParam(':compra', $idc,PDO::PARAM_STR);                
                       $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                       $operacion = $stmt->execute();         
                       if(!$operacion){
                           throw new PDOException("No se pudo guardar registrar la compra");
                       }

                       $sql_product = "UPDATE product SET price_in = :pcc,price_in_d= :pcd,price_out= :pvc,price_out_d= :pvd,
                                        price_out_es= :pec ,price_out_es_d= :ped WHERE  id=:id;";

                       $stmt = $con->prepare($sql_product);                        
                       
                       $stmt->bindParam(':pcc', $v['pcc'],PDO::PARAM_STR);
                       $stmt->bindParam(':pcd', $v['pcd'],PDO::PARAM_STR);
                       $stmt->bindParam(':pvc', $v['pvc'],PDO::PARAM_STR);
                       $stmt->bindParam(':pvd', $v['pvd'],PDO::PARAM_STR);
                       $stmt->bindParam(':pec', $v['pec'],PDO::PARAM_STR);
                       $stmt->bindParam(':ped', $v['ped'],PDO::PARAM_STR);            
                       $stmt->bindParam(':id', $v['product_id'],PDO::PARAM_INT);
                       $producto = $stmt->execute();         
                       if(!$producto){
                           throw new PDOException("No se pudo guardar registrar la compra");
                       }
                       ProductoHistorialData::save($v['product_id'],$con);
                     }

                         unset($_SESSION['reabastecer']);       
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                    
                        return ["msg"=>"Compra se  registrado correctamente...","code"=>true,"id"=> $idc];      
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false,"id"=>0];        
    }
/*********************************/
}

}










?>
