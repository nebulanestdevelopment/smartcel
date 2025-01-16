<?php
class SellData {
	public static $tablename = "sell";
	public $id;
	public $person_id;
	public $user_id;
	public $operation_type_id;
    public $is_boxed;
	public $box_id;
	public $related_box;
	public $id_caja_a_revertir;
	public $total;
	public $total_d;
	public $cash;
	public $cash_d;
	public $discount;
	public $discount_d;
	public $sell_type;
	public $saldo;
	public $status;
	public $compra_type;
	public $compra_saldo;
	public $compra_status;
	public $facturano;
	public $clienteanonimo;
	public $justificacion;
	public $created_at;

	public  function __construct(){
		$this->id = 0;
		$this->person_id = 0;
		$this->user_id = 0;
		$this->operation_type_id = 0;
        $this->is_boxed = 0;
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
		if(!isset($_SESSION["cart"])){
			 $_SESSION["cart"][] = $data ;        
		 }else{
				 $found = false;
				 $products = $_SESSION["cart"];
			 foreach ($products as $index => $v){
				 if(intval($v['product_id']) == intval($data['product_id'])){ 
					 $found = true; 
					 $_SESSION["cart"][$index]['q']   = intval($_SESSION["cart"][$index]['q']) +  intval($data['q']);
					 $_SESSION["cart"][$index]['pvc'] = floatval($data['pvc']);
					 $_SESSION["cart"][$index]['pvd'] = floatval($data['pvd']);
					 $_SESSION["cart"][$index]['is_esp'] = $data['is_esp'];
					 $_SESSION["cart"][$index]['pec'] = floatval($data['pec']);
					 $_SESSION["cart"][$index]['ped'] = floatval($data['ped']); 
					 $_SESSION["cart"][$index]['desc_c'] = floatval($data['desc_c']);
					 $_SESSION["cart"][$index]['desc_d'] = floatval($data['desc_d']);
					 break; 
				 } 
			 }
	 
			 if($found == false){
				 $_SESSION["cart"][] = $data ;
			 }
		 }
	 }

	 public static function getVentaData($id) {
    
        $sql = "SELECT s.id,s.facturano,s.created_at as fecha,
                       if(s.person_id=2,s.clienteanonimo,CONCAT(p.name,' ',p.lastname)) AS cliente,s.person_id as id_cli,
					   CONCAT(u.name,' ',u.lastname) as vendedor,s.sell_type
                FROM sell s
                     LEFT OUTER JOIN person p ON s.person_id = p.id
					 LEFT OUTER JOIN user u ON s.user_id = u.id
                WHERE s.id='".$id."';";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as  $row) {
            
            $array['id'] = $row['id'];
            $array['factura'] = $row['facturano'];
            $array['cliente'] = $row['cliente'];
			$array['cliente_id'] = $row['id_cli'];
			$array['vendedor'] = $row['vendedor'];
			$array['venta'] = $row['sell_type'];
            $array['fecha'] = date('Y-m-d h:m a', strtotime($row['fecha']));
            
        }
       
    ExecutorPDO::closeCon();	
    return $array;        
} 


public static function getDetalleVenta($id) {
    
    $sql = "SELECT o.id,o.product_id,o.q,o.price_in,o.price_in_d,o.price_out,o.price_out_d,o.price_out_es,o.price_out_es_d,o.discount,o.discount_d 
			FROM operation o
			WHERE o.sell_id ='".$id."';";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $i => $v) {            
				$array[$i]['id']= $v['id'];    
                $array[$i]['codigo']= ProductoData::getProductCode($v['product_id']);
                $array[$i]['nombre']= ProductoData::getProductName($v['product_id']);  
                $array[$i]['q'] = $v['q'];
                $array[$i]['costo_c'] = floatval($v['price_in']);
                $array[$i]['costo_d'] = floatval($v['price_in_d']);  
				$array[$i]['venta_c'] = floatval($v['price_out']);
                $array[$i]['venta_d'] = floatval($v['price_out_d']);  
				$array[$i]['esp_c']   = floatval($v['price_out_es']);
                $array[$i]['esp_d']   = floatval($v['price_out_es_d']); 
				$array[$i]['desc_c']  = floatval($v['discount']);
                $array[$i]['desc_d']  = floatval($v['discount_d']);  
                $array[$i]['total_c'] = (floatval($v['price_out']) + floatval($v['price_out_es']) - floatval($v['discount'])) * intval($v['q']); 
                $array[$i]['total_d'] = (floatval($v['price_out_d']) + floatval($v['price_out_es_d']) - floatval($v['discount_d'])) * intval($v['q']);                
            }
        
        ExecutorPDO::closeCon();	
        return $array;        
} 

public static function getAllSells() {
        $sql = "SELECT 
                       s.id,s.created_at as fecha,s.total,s.total_d,id_caja_a_revertir as id_revertir,
                       if(s.person_id=2,s.clienteanonimo,CONCAT(p.name,' ',p.lastname)) AS cliente
                FROM sell s
                     LEFT OUTER JOIN person p ON s.person_id = p.id
                WHERE s.operation_type_id='2' AND  s.box_id is NULL AND convert(s.total,decimal) > 0   ORDER BY fecha DESC;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
            
            $array[$index]['id'] = $row['id'];
            $array[$index]['id_revertir'] = $row['id_revertir'];            
            $array[$index]['cliente'] = $row['cliente'];
            $array[$index]['fecha'] = date('Y-m-d H:m a', strtotime($row['fecha']));
            $array[$index]['total_c'] = floatval($row['total']);
            $array[$index]['total_d'] = floatval($row['total_d']);
            $json=[];
            $sql_o = "SELECT o.id,o.product_id,o.q,o.price_in, o.price_in_d,o.price_out,o.price_out_d,
                            o.price_out_es,o.price_out_es_d,o.discount,o.discount_d
                      FROM operation o 
                      WHERE o.sell_id='".$row['id']."';";
            $con = ExecutorPDO::getConnection(); 
            $stmt = $con->prepare($sql_o);
            $stmt->execute();
            $operation_data = $stmt->fetchAll();
            foreach($operation_data as $i => $v){
                $json[$i]['codigo']= ProductoData::getProductCode($v['product_id']);
                $json[$i]['nombre']= ProductoData::getProductName($v['product_id']);   
                $json[$i]['costo_c']= floatval($v['price_in']);
                $json[$i]['costo_d']= floatval($v['price_in_d']);
                $json[$i]['precio_c']= floatval($v['price_out']) + floatval($v['price_out_es']);
                $json[$i]['precio_d']= floatval($v['price_out_d']) + floatval($v['price_out_es_d']);
                $json[$i]['esp_c']= floatval($v['price_out_es']);
                $json[$i]['esp_d']= floatval($v['price_out_es_d']);
                $json[$i]['q']= $v['q'];
                $total_c = ((floatval($v['price_out']) + floatval($v['price_out_es'])) * intval($v['q'])) - floatval($v['discount']);
                $total_d = ((floatval($v['price_out_d']) + floatval($v['price_out_es_d'])) * intval($v['q'])) - floatval($v['discount_d']);
                $json[$i]['total_c']= floatval($total_c);
                $json[$i]['total_d']= floatval($total_d);
            }
            $con = null;   //Cerramos la conexion a la base de datos      
            $array[$index]['json'] = json_encode($json);
        }
       
    ExecutorPDO::closeCon();	
    return $array;        
} 
public static function getAllSellsType($type) {

        $sql = "SELECT s.id,s.created_at,
                        o.product_id,o.q,o.price_in, o.price_in_d,o.price_out,o.price_out_d,
                            o.price_out_es,o.price_out_es_d,o.discount,o.discount_d
                FROM product p
                INNER JOIN operation o ON o.product_id = p.id
                INNER JOIN sell s ON o.sell_id = s.id
                WHERE p.type = '".$type."' AND o.operation_type_id = 2  AND s.box_id is NULL AND s.status != 3  ORDER BY s.created_at DESC;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $json = array();
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $i => $v) {
            
                $json[$i]['id'] = $v['id'];
                $json[$i]['fecha'] = date('Y-m-d H:m a', strtotime($v['created_at']));
           
                $json[$i]['codigo']  = ProductoData::getProductCode($v['product_id']);
                $json[$i]['nombre']  = ProductoData::getProductName($v['product_id']);   
                $json[$i]['costo_c'] = number_format(floatval($v['price_in']),2,'.',',');
                $json[$i]['costo_d'] = number_format(floatval($v['price_in_d']),2,'.',',');
                $json[$i]['precio_c'] = floatval($v['price_out']);
                $json[$i]['precio_d'] = floatval($v['price_out_d']);
                $json[$i]['esp_c']  = floatval($v['price_out_es']);
                $json[$i]['esp_d']  = floatval($v['price_out_es_d']);
                $json[$i]['desc_c'] = floatval($v['discount']);
                $json[$i]['desc_d'] = floatval($v['discount_d']);
                $json[$i]['is_esp'] = (floatval($v['price_out_es_d']) == 0)? 'No':'Si';
                $json[$i]['q']= $v['q'];
                $total_c = ((floatval($v['price_out']) + floatval($v['price_out_es'])) * intval($v['q']))  - floatval($v['discount']);
                $total_d = ((floatval($v['price_out_d']) + floatval($v['price_out_es_d'])) * intval($v['q']))  - floatval($v['discount_d']);
                $json[$i]['total_c'] = floatval($total_c);
                $json[$i]['total_d'] = floatval($total_d);
           
        }
       
    ExecutorPDO::closeCon();	
    return $json;        
} 

public static function getAllSellsTypeBox($type) {

    $sql = "SELECT s.id,s.created_at,o.product_id,o.q,o.price_in, o.price_in_d,o.price_out,o.price_out_d,
                   o.price_out_es,o.price_out_es_d,o.discount,o.discount_d
            FROM product p
            INNER JOIN operation o ON o.product_id = p.id
            INNER JOIN sell s ON o.sell_id = s.id
            WHERE p.type = '".$type."' AND o.operation_type_id = 2  AND s.box_id is NULL AND s.status != 3  ORDER BY s.created_at DESC;";
ExecutorPDO::initCon();
ExecutorPDO::initPreparate($sql);
$json = array();
ExecutorPDO::executeParams(array());
    foreach  (ExecutorPDO::fetchAll()  as $i => $v) {
        
        $json[$i]['id'] = $v['id'];
        $json[$i]['fecha'] = date('Y-m-d H:m a', strtotime($v['created_at']));
        $json[$i]['codigo']  = ProductoData::getProductCode($v['product_id']);
        $json[$i]['nombre']  = ProductoData::getProductName($v['product_id']);   
        $json[$i]['costo_c'] = number_format(floatval($v['price_in']),2,'.',',');
        $json[$i]['costo_d'] = number_format(floatval($v['price_in_d']),2,'.',',');
        $json[$i]['precio_c'] = floatval($v['price_out']);
        $json[$i]['precio_d'] = floatval($v['price_out_d']);
        $json[$i]['esp_c']  = floatval($v['price_out_es']);
        $json[$i]['esp_d']  = floatval($v['price_out_es_d']);
        $json[$i]['desc_c'] = floatval($v['discount']);
        $json[$i]['desc_d'] = floatval($v['discount_d']);
        $json[$i]['is_esp'] = (floatval($v['price_out_es_d']) == 0)? 'No':'Si';
        $json[$i]['q']= $v['q'];
        $total_c = ((floatval($v['price_out']) + floatval($v['price_out_es'])) * intval($v['q']))  - floatval($v['discount']);
        $total_d = ((floatval($v['price_out_d']) + floatval($v['price_out_es_d'])) * intval($v['q']))  - floatval($v['discount_d']);
        $json[$i]['total_c'] = floatval($total_c);
        $json[$i]['total_d'] = floatval($total_d);
        
    } 
ExecutorPDO::closeCon();	
return $json;        
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
        return ["msg"=>"Se elimino la venta!!","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}

public  function deleteItem($oid){
	try {
        $con = ExecutorPDO::initCon();
        $con->beginTransaction();

        $sql_o = "SELECT sell_id as idventa,q,price_in as costoc,price_in_d as costod,price_out as precioc,price_out_d as preciod,
                       price_out_es as precio_espc, price_out_es_d as precio_espd,discount as descc, discount_d as descd,operation_type_id as otid
                  FROM operation
                  WHERE id='".$oid."' ;";        
        ExecutorPDO::initPreparate($sql_o);
        $o = array();
        ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            $o['idventa'] = $r['idventa'];
            $o['q']       = intval($r['q']);
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
        $total = 0;
        if($ts > 1){
            $total = 1;
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
            return ["msg"=>"Item eliminado!!","code"=>true,'total'=>$total];
        }else{
            throw new PDOException("No se puede actualizar los datos de la operacion");
        }

    } catch (PDOException $ex) {
        $con->rollBack();
        ExecutorPDO::closeCon();
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
/*********************************/
}

public  function save(){
    $idv = 0;
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
                                                
$sql_venta = "INSERT INTO sell (person_id, user_id, operation_type_id, is_boxed, box_id,
                            related_box,id_caja_a_revertir,total,total_d,cash,cash_d,
                            discount,discount_d,sell_type,saldo,status,compra_type,
                            compra_saldo,compra_status,facturano,clienteanonimo,justificacion,
                            created_at)  VALUES 
                            (:cliente,:vendedor, :ot,:is_boxed, :box_id, 
                             :related_box, :revertir, :total_c, :total_d, :cash_c, :cash_d,
                             :desc_c, :desc_d, :sell_type, :saldo, :estado, :tipo_compra, 
                             :saldo_compra, :compra_estado, :factura, :cliente_anonimo, :justificacion, :fecha);";     
                
                $stmt = $con->prepare($sql_venta);
                $stmt->bindParam(':cliente', $this->person_id,PDO::PARAM_INT);
                $stmt->bindParam(':vendedor', $this->user_id,PDO::PARAM_INT);
                $stmt->bindParam(':ot', $this->operation_type_id,PDO::PARAM_INT);
                $stmt->bindParam(':is_boxed', $this->is_boxed,PDO::PARAM_INT);
                $stmt->bindParam(':box_id', $this->box_id,PDO::PARAM_INT);
                $stmt->bindParam(':related_box', $this->related_box,PDO::PARAM_INT);
                $stmt->bindParam(':revertir', $this->id_caja_a_revertir,PDO::PARAM_INT);
                $stmt->bindParam(':total_c', $this->total,PDO::PARAM_STR);
                $stmt->bindParam(':total_d', $this->total_d,PDO::PARAM_STR);
                $stmt->bindParam(':cash_c', $this->cash,PDO::PARAM_STR);
                $stmt->bindParam(':cash_d', $this->cash_d,PDO::PARAM_STR);
                $stmt->bindParam(':desc_c', $this->discount,PDO::PARAM_STR);
                $stmt->bindParam(':desc_d', $this->discount_d,PDO::PARAM_STR);
                $stmt->bindParam(':sell_type', $this->sell_type,PDO::PARAM_INT);
                $stmt->bindParam(':saldo', $this->saldo,PDO::PARAM_STR);
                $stmt->bindParam(':estado', $this->status,PDO::PARAM_STR);
                $stmt->bindParam(':tipo_compra', $this->compra_type,PDO::PARAM_STR);
                $stmt->bindParam(':saldo_compra', $this->compra_saldo,PDO::PARAM_STR);
                $stmt->bindParam(':compra_estado', $this->compra_status,PDO::PARAM_STR);
                $stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
                $stmt->bindParam(':cliente_anonimo', $this->clienteanonimo,PDO::PARAM_STR);
                $stmt->bindParam(':justificacion', $this->justificacion,PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);              
               
                $venta = $stmt->execute();
                if(!$venta){
                   throw new PDOException("No se pudo guardar la venta");
                }
                    $idv = $con->lastInsertId(); 
                    $cart = $_SESSION['cart'];
                    foreach ($cart as $v) {
                       
                        $producto_sql ="SELECT price_in AS costo_c,price_in_d AS costo_d FROM product WHERE id='".$v["product_id"]."';";
                        $stmt = $con->prepare($producto_sql);
                        $stmt->execute();
                        $producto = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $sql_operation = "INSERT INTO `operation` (`product_id`, `imei`, `color`, `q`,
                        `price_in`, `price_in_d`, `price_out`, `price_out_d`, `price_out_es`, `price_out_es_d`,
                        `operation_type_id`, `sell_id`, `discount`, `discount_d`, `descripcion`, `created_at`) 
                        VALUES (:product, ' ', ' ', :units,
                                :comprac, :comprad, :ventac, :ventad, :espc, :espd,
                                2, :venta, :desc_c, :desc_d, ' ', :fecha);";
                       $comprac = floatval($producto[0]['costo_c']);
                       $comprad = floatval($producto[0]['costo_d']);        

                       $ventac = ($v['is_esp']=='false')?floatval($v['pvc']):0;     
                       $ventad = ($v['is_esp']=='false')?floatval($v['pvd']):0;       
                       $espc = ($v['is_esp']=='false')?0:floatval($v['pec']);     
                       $espd = ($v['is_esp']=='false')?0:floatval($v['ped']);        
                       $desc_c = floatval($v['desc_c']);    
                       $desc_d = floatval($v['desc_d']);          

                       $stmt = $con->prepare($sql_operation);                        
                       $stmt->bindParam(':product', $v['product_id'],PDO::PARAM_INT);
                       $stmt->bindParam(':units',$v['q'],PDO::PARAM_INT);
                       $stmt->bindParam(':comprac',  $comprac,PDO::PARAM_STR);
                       $stmt->bindParam(':comprad',  $comprad,PDO::PARAM_STR);
                       $stmt->bindParam(':ventac', $ventac,PDO::PARAM_STR);
                       $stmt->bindParam(':ventad', $ventad,PDO::PARAM_STR);
                       $stmt->bindParam(':espc', $espc,PDO::PARAM_STR);
                       $stmt->bindParam(':espd', $espd,PDO::PARAM_STR);
                       $stmt->bindParam(':venta', $idv,PDO::PARAM_STR);                          
                       $stmt->bindParam(':desc_c', $desc_c,PDO::PARAM_STR);
                       $stmt->bindParam(':desc_d', $desc_d,PDO::PARAM_STR);             
                       $stmt->bindParam(':fecha', $this->created_at,PDO::PARAM_STR);
                       $operacion = $stmt->execute();         
                       if(!$operacion){
                           throw new PDOException("No se pudo guardar registrar la venta");
                       }                      
                     }
                    
                        unset($_SESSION['cart']);    
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                  
                        return ["msg"=>"La venta se registrado correctamente...","code"=>true,"id"=> $idv];      
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false,"id"=>0];        
    }
/*********************************/
}
	
/*******************************/
/*******caja**********/













public  function revertirCaja(){
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
                                                
$sql_venta = "UPDATE sell SET is_boxed=1,box_id= :box,related_box=NULL,id_caja_a_revertir=0 WHERE id= :id ;";     
                
                $stmt = $con->prepare($sql_venta);
                $stmt->bindParam(':box', $this->box_id,PDO::PARAM_INT);    
                $stmt->bindParam(':id', $this->id,PDO::PARAM_INT);                     
                $venta = $stmt->execute();
                if(!$venta){
                   throw new PDOException("No se pudo actualizar la reversion de caja");
                }                      
                        $con->commit(); 
                        $con = null;
                        ExecutorPDO::closeConnection();                  
                        return ["msg"=>"La reversion de caja exitosa","code"=>true];      
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e->getMessage(),"code"=>false,"id"=>0];        
    }
/*********************************/
}

public static function getBoxDetailswithProducts($box_id){
    $con = ExecutorPDO::getConnection();                                      
$box_detail = "SELECT p.id,p.type,o.q,
                o.discount as desco_c,o.discount_d as desco_d,
                o.price_out,o.price_out_d,
                o.price_out_es,o.price_out_es_d,
                s.discount as desc_c,s.discount_d as desc_d, s.total,s.total_d, o.sell_id, s.created_at as date,
                s.box_id
               FROM sell s
               LEFT OUTER JOIN operation o ON o.sell_id = s.id
               LEFT OUTER JOIN product p ON o.product_id = p.id
               WHERE  o.operation_type_id = 2 AND s.sell_type = 1 AND s.box_id = $box_id ORDER BY p.type, s.created_at desc ;";     
                
                $stmt = $con->prepare($box_detail);                   
                $stmt->execute();
                $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);  
                $rows = array();
                foreach ($data as $i => $row) {
                    $sc = new stdClass();
                    $sc->product_id = $row['id'];
                    $sc->type = $row['type'];                                     
                    $sc->q = $row['q'];
                    $sc->barcode= ProductoData::getProductCode($row['id']);
                    $sc->name= ProductoData::getProductName($row['id']);
                    $sc->desco_c = $row['desco_c'];       
                    $sc->desco_d = $row['desco_d'];  
                    $sc->desc_c = $row['desc_c'];       
                    $sc->desc_d = $row['desc_d'];                   
                    $sc->precio_c = $row['price_out'];  
                    $sc->precio_d = $row['price_out_d'];  
                    $sc->precio_es_c = $row['price_out_es'];  
                    $sc->precio_es_d = $row['price_out_es_d'];   
                    $sc->total_c = $row['total'];
                    $sc->total_d = $row['total_d'];
                    $sc->sell_id = $row['sell_id'];
                    $sc->date = date('d/m/Y h:i a', strtotime($row['date']));
                    $sc->box_id = $row['box_id'];

                    $rows[$i] = $sc; 
                }                     
                        $con = null;
                        ExecutorPDO::closeConnection();    
                        
                return $rows;        
}


public static function getSumaDescuentoenVentas($box_id){
    $con = ExecutorPDO::getConnection();                                      
    $box_detail = "select SUM(discount) as total from sell where box_id=$box_id";     
                    
                    $stmt = $con->prepare($box_detail);                   
                    $stmt->execute();
                    $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);  
                    $rows = array();
                    foreach ($data as $i => $row) {
                        $sc = new stdClass();
                        $sc->total = $row['total'];    
                        $rows[$i] = $sc; 
                    }                     
                            $con = null;
                            ExecutorPDO::closeConnection();    
                            
                    return $rows;    
 }

 public static function delboxvacias(){
    $con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
                                                
$clear_box = "delete from box WHERE NOT EXISTS ( SELECT box_id  FROM sell  WHERE box_id=box.id);";    
                
                $stmt = $con->prepare($clear_box);                   
                $stmt->execute();                   
                $con->commit(); 
                $con = null;
                ExecutorPDO::closeConnection();  
                return true ;                 
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return false;        
    }
}
/****************************/
}

?>
