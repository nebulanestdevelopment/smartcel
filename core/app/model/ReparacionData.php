<?php

class ReparacionData {
    public static $tableName = "reparaciones";

    public $id;
    public $status;
    public $client_id;
	public $cliente;
    public $facturano;
	public $sell_id;
    public $tecnico;
	public $tecnico_id;
    public $descripcion;
    public $repuesto;
	public $repuesto_id;
    public $costo_repuesto;
	public $costo_repuesto_d;
    public $costo_reparacion;
	public $costo_reparacion_d;
    public $total;
	public $total_d;
	public $nota;
	public $estado_taller;
    public $fecha_reparacion;
    public $hora_reparacion;
    public $created_at;

	public function __construct(){
		$this->id = 0;
		$this->status = 0;
		$this->client_id = 0;
		$this->cliente = "";
		$this->facturano = 0;
		$this->sell_id = 0;
		$this->tecnico = "";
		$this->tecnico_id = 0;
		$this->descripcion = "";
		$this->repuesto = 0;
		$this->repuesto_id = 0;
		$this->costo_repuesto = 0;
		$this->costo_repuesto_d = 0;
		$this->costo_reparacion = 0;
		$this->costo_reparacion_d = 0;
		$this->total = 0;
		$this->total_d = 0;
		$this->nota = 0;
		$this->estado_taller = 0;
		$this->fecha_reparacion = date('Y-m-d');
		$this->hora_reparacion =date('h:m');
		$this->created_at = "NOW()";
	}


    public static function addToCart($data){
		if(!isset($_SESSION["cart-repair"])){
			 $_SESSION["cart-repair"][] = $data ;        
		 }else{
				 $found = false;
				 $products = $_SESSION["cart-repair"];
			 foreach ($products as $index => $v){
				 if(intval($v['product_id']) == intval($data['product_id'])){ 
					 $found = true; 
					 $_SESSION["cart-repair"][$index]['q']   = intval($_SESSION["cart-repair"][$index]['q']) +  intval($data['q']);
					 $_SESSION["cart-repair"][$index]['pvc'] = floatval($data['pvc']);
					 $_SESSION["cart-repair"][$index]['pvd'] = floatval($data['pvd']);
					 $_SESSION["cart-repair"][$index]['desc_c'] = floatval($data['desc_c']);
					 $_SESSION["cart-repair"][$index]['desc_d'] = floatval($data['desc_d']);
					 break; 
				 } 
			 }
	 
			 if($found == false){
				 $_SESSION["cart-repair"][] = $data ;
			 }
		 }
	 }

	 public  function save($data){
		$idv = 0;
		$idr = 0;
		$con = ExecutorPDO::getConnection(); 
		$con->beginTransaction();
		try {

if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0){	
													
	$sql_venta = "INSERT INTO sell (person_id, user_id, operation_type_id, is_boxed, box_id,
								related_box,id_caja_a_revertir,total,total_d,cash,cash_d,
								discount,discount_d,sell_type,saldo,status,compra_type,
								compra_saldo,compra_status,facturano,clienteanonimo,justificacion,
								created_at)  VALUES 
								(:cliente,:vendedor,2,0, NULL, 
								 0,0, :total_c, :total_d, :cash_c, :cash_d,
								 :desc_c, :desc_d,1,0,1,0, 
								 0,0, :factura, :cliente_anonimo,' ', :fecha);";     
			

					$stmt = $con->prepare($sql_venta);
					$stmt->bindParam(':cliente', $data['cliente_id'],PDO::PARAM_INT);
					$stmt->bindParam(':vendedor', $data['vendedor'],PDO::PARAM_INT);
					$stmt->bindParam(':total_c', $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':total_d', $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_c',  $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_d',  $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_c', $data['discount'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_d', $data['discount_d'],PDO::PARAM_STR);
					$stmt->bindParam(':factura', $data['factura'],PDO::PARAM_STR);
					$stmt->bindParam(':cliente_anonimo', $this->cliente,PDO::PARAM_STR);
					$stmt->bindParam(':fecha', $data['fecha'],PDO::PARAM_STR);              
				   
					$venta = $stmt->execute();
					if(!$venta){
					   throw new PDOException("No se pudo guardar la venta");
					}

						$idv = $con->lastInsertId(); 
						$cart = $_SESSION['cart-repair'];
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
	
						   $ventac = floatval($v['pvc']);     
						   $ventad = floatval($v['pvd']);       
						   $espc = 0;     
						   $espd = 0;        
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
						   $stmt->bindParam(':fecha', $data['fecha'],PDO::PARAM_STR);
						   $operacion = $stmt->execute();         
						   if(!$operacion){
							   throw new PDOException("No se pudo guardar registrar la venta");
						   }                      
						 }					
}//agregar venta

$sql_reparacion = "INSERT INTO reparaciones ( `status`, `client_id`, `cliente`, `facturano`, `sell_id`,
											 `tecnico`, `tecnico_id`, `descripcion`, `repuesto`, `repuestos_id`, 
											 `costo_repuesto`, `costo_repuesto_d`, `costo_reparacion`, `costo_reparacion_d`,
											 `total`, `total_d`, `nota`, `estado_taller`, `fecha_reparacion`, `hora_reparacion`, `created_at`)
								      VALUES (0, :cliente_id, :cliente, :factura,:venta_id,
									  		  :tecnico, :tecnico_id, :descripcion,:repuesto, :repuesto_id,
											   :costo_c, :costo_d, :costor_c, :costor_d, 
											   :total_c, :total_d, :nota, :estado,:fecha, :hora,:created_at);";
																		
							$stmt = $con->prepare($sql_reparacion);
							$stmt->bindParam(':cliente_id', $this->client_id,PDO::PARAM_INT);
							$stmt->bindParam(':cliente', $this->cliente,PDO::PARAM_STR);
							$stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
							$stmt->bindParam(':venta_id', $idv,PDO::PARAM_STR);
							$stmt->bindParam(':tecnico',  $this->tecnico,PDO::PARAM_STR);
							$stmt->bindParam(':tecnico_id', $this->tecnico_id,PDO::PARAM_INT);
							$stmt->bindParam(':descripcion', $this->descripcion,PDO::PARAM_STR);
							$stmt->bindParam(':repuesto', $this->repuesto,PDO::PARAM_STR);
							$stmt->bindParam(':repuesto_id', $this->repuesto_id,PDO::PARAM_STR);

							$stmt->bindParam(':costo_c', $this->costo_repuesto,PDO::PARAM_STR);
							$stmt->bindParam(':costo_d', $this->costo_repuesto_d,PDO::PARAM_STR);
							$stmt->bindParam(':costor_c', $this->costo_reparacion,PDO::PARAM_STR);
							$stmt->bindParam(':costor_d', $this->costo_reparacion_d,PDO::PARAM_STR);
							$stmt->bindParam(':total_c', $this->total,PDO::PARAM_STR);
							$stmt->bindParam(':total_d', $this->total_d,PDO::PARAM_STR);
							$stmt->bindParam(':nota', $this->nota,PDO::PARAM_STR);
							$stmt->bindParam(':estado', $this->estado_taller,PDO::PARAM_STR);
							$stmt->bindParam(':fecha', $this->fecha_reparacion,PDO::PARAM_STR);
							$stmt->bindParam(':hora', $this->hora_reparacion,PDO::PARAM_STR);
							$stmt->bindParam(':created_at', $this->created_at,PDO::PARAM_STR);

							$reparacion = $stmt->execute();
							$idr = $con->lastInsertId(); 
							if(!$reparacion){
							throw new PDOException("No se pudo guardar la reparacion");
							}

							unset($_SESSION['cart-repair']); 
							$con->commit(); 
							$con = null;
							ExecutorPDO::closeConnection();              
							return ["msg"=>"Reparacion registrada...","code"=>true,"id"=> $idr];      
			  
		}catch(\PDOException $e){
			$con->rollback();
			$con = null;
			ExecutorPDO::closeConnection(); 
			return ["msg"=>$e->getMessage(),"code"=>false,"id"=>0];        
		}
	/*********************************/
}

public  function updateRepair($data){
		$idv = 0;
		$idr = 0;
		$con = ExecutorPDO::getConnection(); 
		$con->beginTransaction();
		try {
$idv = intval($data['idv']);
if($idv > 0 ){

	if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) == 0){
		$delete_sell ="DELETE FROM sell WHERE id='".$data['idv']."';";
		$stmt = $con->prepare($delete_sell);
		$stmt->execute();
		$delete_op ="DELETE FROM operation WHERE sell_id='".$data['idv']."';";
		$stmt = $con->prepare($delete_op);
		$stmt->execute();
		$idv = 0;
	}else if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0){
		$delete_op ="DELETE FROM operation WHERE sell_id='".$data['idv']."';";
		$stmt = $con->prepare($delete_op);
		$stmt->execute();
		$sql_venta = "UPDATE sell SET person_id=:cliente, user_id=:vendedor,
								total=:total_c,total_d=:total_d,cash=:cash_c,cash_d=:cash_d,
								discount=:desc_c,discount_d=:desc_d,
								facturano=:factura,clienteanonimo=:cliente_anonimo,created_at=:fecha
					  WHERE id=:id ;";			

					$stmt = $con->prepare($sql_venta);
					$stmt->bindParam(':cliente',  $data['cliente_id'],PDO::PARAM_INT);
					$stmt->bindParam(':vendedor', $data['vendedor'],PDO::PARAM_INT);
					$stmt->bindParam(':total_c', $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':total_d', $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_c',  $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_d',  $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_c',  $data['discount'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_d',  $data['discount_d'],PDO::PARAM_STR);
					$stmt->bindParam(':factura', $data['factura'],PDO::PARAM_STR);
					$stmt->bindParam(':cliente_anonimo', $this->cliente,PDO::PARAM_STR);
					$stmt->bindParam(':fecha', $data['fecha'],PDO::PARAM_STR);       
					$stmt->bindParam(':id', $idv,PDO::PARAM_INT);       
				   
					$venta = $stmt->execute();
					if(!$venta){
					   throw new PDOException("No se pudo guardar la venta");
					}

						$cart = $_SESSION['cart-repair'];
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
	
						   $ventac = floatval($v['pvc']);     
						   $ventad = floatval($v['pvd']);       
						   $espc = 0;     
						   $espd = 0;        
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
						   $stmt->bindParam(':fecha', $data['fecha'],PDO::PARAM_STR);
						   $operacion = $stmt->execute();         
						   if(!$operacion){
							   throw new PDOException("No se pudo guardar registrar la venta");
						   }                      
						 }			
	}

}else if($idv == 0 && isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0){	
													
	$sql_venta = "INSERT INTO sell (person_id, user_id, operation_type_id, is_boxed, box_id,
								related_box,id_caja_a_revertir,total,total_d,cash,cash_d,
								discount,discount_d,sell_type,saldo,status,compra_type,
								compra_saldo,compra_status,facturano,clienteanonimo,justificacion,
								created_at)  VALUES 
								(:cliente,:vendedor,2,0, NULL, 
								 0,0, :total_c, :total_d, :cash_c, :cash_d,
								 :desc_c, :desc_d,1,0,1,0, 
								 0,0, :factura, :cliente_anonimo,' ', :fecha);";     
			

					$stmt = $con->prepare($sql_venta);
					$stmt->bindParam(':cliente', $data['cliente_id'],PDO::PARAM_INT);
					$stmt->bindParam(':vendedor', $data['vendedor'],PDO::PARAM_INT);
					$stmt->bindParam(':total_c', $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':total_d', $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_c',  $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_d',  $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_c', $data['discount'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_d', $data['discount_d'],PDO::PARAM_STR);
					$stmt->bindParam(':factura', $data['factura'],PDO::PARAM_STR);
					$stmt->bindParam(':cliente_anonimo', $this->cliente,PDO::PARAM_STR);
					$stmt->bindParam(':fecha', $data['fecha'],PDO::PARAM_STR);              
				   
					$venta = $stmt->execute();
					if(!$venta){
					   throw new PDOException("No se pudo guardar la venta");
					}

						$idv = $con->lastInsertId(); 
						$cart = $_SESSION['cart-repair'];
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
	
						   $ventac = floatval($v['pvc']);     
						   $ventad = floatval($v['pvd']);       
						   $espc = 0;     
						   $espd = 0;        
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
						   $stmt->bindParam(':fecha', $data['fecha'],PDO::PARAM_STR);
						   $operacion = $stmt->execute();         
						   if(!$operacion){
							   throw new PDOException("No se pudo guardar registrar la venta");
						   }                      
						 }					
}//agregar venta

$sql_reparacion = "UPDATE reparaciones SET client_id=:cliente_id, cliente=:cliente, facturano=:factura, sell_id=:venta_id,
											 tecnico=:tecnico, tecnico_id=:tecnico_id, descripcion=:descripcion, repuesto=:repuesto, repuestos_id=:repuesto_id, 
											 costo_repuesto=:costo_c, costo_repuesto_d=:costo_d, costo_reparacion=:costor_c, costo_reparacion_d=:costor_d,
											 total=:total_c, total_d=:total_d, fecha_reparacion=:fecha
								       WHERE id=:id;";
																		
							$stmt = $con->prepare($sql_reparacion);
							$stmt->bindParam(':cliente_id', $this->client_id,PDO::PARAM_INT);
							$stmt->bindParam(':cliente', $this->cliente,PDO::PARAM_STR);
							$stmt->bindParam(':factura', $this->facturano,PDO::PARAM_STR);
							$stmt->bindParam(':venta_id', $idv,PDO::PARAM_STR);
							$stmt->bindParam(':tecnico',  $this->tecnico,PDO::PARAM_STR);
							$stmt->bindParam(':tecnico_id', $this->tecnico_id,PDO::PARAM_INT);
							$stmt->bindParam(':descripcion', $this->descripcion,PDO::PARAM_STR);
							$stmt->bindParam(':repuesto', $this->repuesto,PDO::PARAM_STR);
							$stmt->bindParam(':repuesto_id', $this->repuesto_id,PDO::PARAM_STR);

							$stmt->bindParam(':costo_c', $this->costo_repuesto,PDO::PARAM_STR);
							$stmt->bindParam(':costo_d', $this->costo_repuesto_d,PDO::PARAM_STR);
							$stmt->bindParam(':costor_c', $this->costo_reparacion,PDO::PARAM_STR);
							$stmt->bindParam(':costor_d', $this->costo_reparacion_d,PDO::PARAM_STR);
							$stmt->bindParam(':total_c', $this->total,PDO::PARAM_STR);
							$stmt->bindParam(':total_d', $this->total_d,PDO::PARAM_STR);
							$stmt->bindParam(':fecha', $this->fecha_reparacion,PDO::PARAM_STR);
							$stmt->bindParam(':id', $this->id,PDO::PARAM_INT);
							$reparacion = $stmt->execute();
							if(!$reparacion){
							throw new PDOException("No se pudo guardar la reparacion");
							}

							unset($_SESSION['cart-repair']); 
							$con->commit(); 
							$con = null;
							ExecutorPDO::closeConnection();              
							return ["msg"=>"Datos de Reparacion Actualizados...","code"=>true,"id"=> $idr];      
			  
		}catch(\PDOException $e){
			$con->rollback();
			$con = null;
			ExecutorPDO::closeConnection(); 
			return ["msg"=>$e->getMessage(),"code"=>false,"id"=>0];        
		}
	/*********************************/
}



public static function getReparacionesAbiertas() {
		$sql = "SELECT r.id,r.facturano as factura, if(r.client_id=2,r.cliente,CONCAT(p.name,' ',p.lastname)) as cliente,
				r.tecnico,r.descripcion,r.repuesto,r.costo_repuesto as costo_repuesto_c,r.costo_repuesto_d as costo_repuesto_d,
				r.total as total_c, r.total_d as total_d, r.costo_reparacion as ganancia_c, r.costo_reparacion_d as ganancia_d,
				r.estado_taller as estado,r.created_at as fecha
				FROM  reparaciones r
				LEFT OUTER JOIN person p ON r.client_id=p.id
				WHERE r.status = 0 AND r.estado_taller !='No se pudo' ORDER BY r.created_at DESC";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
				$array[$index]['id'] = $row['id'];
				$array[$index]['factura'] = $row['factura'];
				$array[$index]['cliente'] = $row['cliente'];
				$array[$index]['tecnico'] = $row['tecnico'];
				$array[$index]['descripcion'] =  $row['descripcion'];
				$array[$index]['repuesto'] = $row['repuesto'];
				$array[$index]['costo_repuesto_c'] = $row['costo_repuesto_c'];
				$array[$index]['costo_repuesto_d'] = $row['costo_repuesto_d'];
				$array[$index]['total_c'] = $row['total_c'];
				$array[$index]['total_d'] = $row['total_d'];
				$array[$index]['ganancia_c'] = $row['ganancia_c'];
				$array[$index]['ganancia_d'] = $row['ganancia_d'];
				$array[$index]['estado'] = $row['estado'];
				$array[$index]['fecha'] = date('d/m/Y H:m:s a', strtotime($row['fecha']));
			}
		ExecutorPDO::closeCon();	
		return $array;        
}


public static function getReparacionesCerradas() {
	$sql = "SELECT client_id, SUM(costo_reparacion) as totalre,SUM(costo_reparacion_d) as totalred, fecha_reparacion FROM reparaciones 
			WHERE status = 1  
			GROUP BY (fecha_reparacion)
			ORDER BY created_at DESC";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = array();
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array[$index]['id'] = $row['client_id'];
			$array[$index]['total_c'] = $row['totalre'];
			$array[$index]['total_d'] = $row['totalred'];
			$array[$index]['fecha'] = $row['fecha_reparacion'];
		}
	ExecutorPDO::closeCon();	
	return $array;        
}

public static function getReparacionesCerradasDetalle($fecha) {
	$sql = "SELECT r.id,r.facturano as factura, if(r.client_id=2,r.cliente,CONCAT(p.name,' ',p.lastname)) as cliente,
			r.tecnico,r.descripcion,r.repuesto,r.costo_repuesto as costo_repuesto_c,r.costo_repuesto_d as costo_repuesto_d,
			r.total as total_c, r.total_d as total_d, r.costo_reparacion as ganancia_c, r.costo_reparacion_d as ganancia_d,
			r.estado_taller as estado,r.created_at as fecha
			FROM  reparaciones r
			LEFT OUTER JOIN person p ON r.client_id=p.id
			WHERE r.status = 1 and r.fecha_reparacion='".$fecha."' ORDER BY tecnico, r.created_at DESC";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = array();
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array[$index]['id'] = $row['id'];
			$array[$index]['factura'] = $row['factura'];
			$array[$index]['cliente'] = $row['cliente'];
			$array[$index]['tecnico'] = $row['tecnico'];
			$array[$index]['descripcion'] =  $row['descripcion'];
			$array[$index]['repuesto'] = $row['repuesto'];
			$array[$index]['costo_repuesto_c'] = $row['costo_repuesto_c'];
			$array[$index]['costo_repuesto_d'] = $row['costo_repuesto_d'];
			$array[$index]['total_c'] = $row['total_c'];
			$array[$index]['total_d'] = $row['total_d'];
			$array[$index]['ganancia_c'] = $row['ganancia_c'];
			$array[$index]['ganancia_d'] = $row['ganancia_d'];
			$array[$index]['estado'] = $row['estado'];
			$array[$index]['fecha'] = date('d/m/Y H:m:s a', strtotime($row['fecha']));
		}
	ExecutorPDO::closeCon();	
	return $array;        
}

public static function getReparacionesFalladas() {
	$sql = "SELECT r.id,r.facturano as factura, if(r.client_id=2,r.cliente,CONCAT(p.name,' ',p.lastname)) as cliente,
			r.tecnico,r.descripcion,r.repuesto,r.costo_repuesto as costo_repuesto_c,r.costo_repuesto_d as costo_repuesto_d,
			r.total as total_c, r.total_d as total_d, r.costo_reparacion as ganancia_c, r.costo_reparacion_d as ganancia_d,
			r.estado_taller as estado,r.nota as nota,r.created_at as fecha
			FROM  reparaciones r
			LEFT OUTER JOIN person p ON r.client_id=p.id
			WHERE r.estado_taller='No se pudo' ORDER BY tecnico, r.created_at DESC";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = array();
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array[$index]['id'] = $row['id'];
			$array[$index]['factura'] = $row['factura'];
			$array[$index]['cliente'] = $row['cliente'];
			$array[$index]['tecnico'] = $row['tecnico'];
			$array[$index]['descripcion'] =  $row['descripcion'];
			$array[$index]['repuesto'] = $row['repuesto'];
			$array[$index]['costo_repuesto_c'] = $row['costo_repuesto_c'];
			$array[$index]['costo_repuesto_d'] = $row['costo_repuesto_d'];
			$array[$index]['total_c'] = $row['total_c'];
			$array[$index]['total_d'] = $row['total_d'];
			$array[$index]['ganancia_c'] = $row['ganancia_c'];
			$array[$index]['ganancia_d'] = $row['ganancia_d'];
			$array[$index]['estado'] = $row['estado'];
			$array[$index]['nota'] = $row['nota'];
			$array[$index]['fecha'] = date('d/m/Y H:m:s a', strtotime($row['fecha']));
		}
	ExecutorPDO::closeCon();	
	return $array;        
}

public static function getHistorialReparacion($tecnico,$inicial,$final) {
	$tecnico =  ($tecnico != "0")?"AND r.tecnico ='".$tecnico."'" : " ";
	$fecha = " ";
	if(trim($inicial) != "" && trim($final) != ""){
		$fecha = " AND r.fecha_reparacion >= '".date("Y-m-d",strtotime($inicial))."' AND r.fecha_reparacion <= '".date("Y-m-d",strtotime($final))."'";
	}
	
	$sql = "SELECT r.id,r.facturano as factura, if(r.client_id=2,r.cliente,CONCAT(p.name,' ',p.lastname)) as cliente,
			r.tecnico,r.descripcion,r.repuesto,r.costo_repuesto as costo_repuesto_c,r.costo_repuesto_d as costo_repuesto_d,
			r.total as total_c, r.total_d as total_d, r.costo_reparacion as ganancia_c, r.costo_reparacion_d as ganancia_d,
			r.estado_taller as estado,r.created_at as fecha
			FROM  reparaciones r
			LEFT OUTER JOIN person p ON r.client_id=p.id
			WHERE r.status = 1 ".$tecnico." ".$fecha." ORDER BY tecnico, r.created_at DESC";

	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = array();
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array[$index]['id'] = $row['id'];
			$array[$index]['factura'] = $row['factura'];
			$array[$index]['cliente'] = $row['cliente'];
			$array[$index]['tecnico'] = $row['tecnico'];
			$array[$index]['descripcion'] =  $row['descripcion'];
			$array[$index]['repuesto'] = $row['repuesto'];
			$array[$index]['costo_repuesto_c'] = number_format($row['costo_repuesto_c'],2,'.',',');
			$array[$index]['costo_repuesto_d'] = number_format($row['costo_repuesto_d'],2,'.',',');
			$array[$index]['total_c'] = number_format($row['total_c'],2,'.',',');
			$array[$index]['total_d'] = number_format($row['total_d'],2,'.',',');
			$array[$index]['ganancia_c'] = $row['ganancia_c'];
			$array[$index]['ganancia_d'] = $row['ganancia_d'];
			$array[$index]['ganancia_c1'] = number_format($row['ganancia_c'],2,'.',',');
			$array[$index]['ganancia_d1'] = number_format($row['ganancia_d'],2,'.',',');
			$array[$index]['estado'] = $row['estado'];
			$array[$index]['fecha'] = date('d/m/Y H:m:s a', strtotime($row['fecha']));
			$array[$index]['admin'] = Roles::hasAdmin();
		}
	ExecutorPDO::closeCon();	
	return $array;        
}

public static function getTecnicos() {
	$sql = "SELECT tecnico FROM reparaciones GROUP BY tecnico ORDER BY tecnico;";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = array();
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array[$index]['tecnico'] = $row['tecnico'];
		}
	ExecutorPDO::closeCon();	
	return $array;        
}


public static function cerrarReparaciones(){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET status=1, estado_taller='Reparado' WHERE status=0 AND estado_taller ='Reparado';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Se dieron de alta a las reparaciones","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}	


public static function marcarReparado($id){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET status=1, estado_taller='Reparado' WHERE id='".$id."';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Se marco reparacion terminada","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}	

public static function marcarNoReparado($id){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET status=0, estado_taller='No se pudo' WHERE id='".$id."';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Se marco como no se pudo reparar","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}	


public static function delete($id){
    $con = ExecutorPDO::getConnection(); 
    try {
		$get_reparacion = "SELECT sell_id FROM reparaciones WHERE id='".$id."';";
		$idv = 0;
		$stmt = $con->prepare($get_reparacion);
		$stmt->execute();
		$reparacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() > 0) { $idv = $reparacion[0]["sell_id"]; }
		$delete_reparacion = "DELETE FROM reparaciones WHERE id='" . $id . "' ; ";
		$stmt = $con->prepare($delete_reparacion);
		$stmt->execute();
		//Si no hay más reparaciones de la venta se elimina la venta
		if(intval($idv) > 0 ){
			$sql_o = "DELETE FROM operation WHERE sell_id='".$idv."';";
			$stmt = $con->prepare($sql_o);
			$stmt->execute();
			$sql_c = "DELETE FROM sell WHERE id='".$idv."';";
			$stmt1 = $con->prepare($sql_c);
			$stmt1->execute();
		}
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Se elimino la reparacion!!","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}

public static function revertirReparaciones($fecha){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET status=0, estado_taller='Pendiente' WHERE status=1 AND fecha_reparacion='".$fecha."';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Se revirtieron las reparaciones","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}	



public static function llenarCarrito($id){
	$con = ExecutorPDO::getConnection(); 
    try {
		$get_reparacion = "SELECT product_id,q,price_out,price_out_d,discount,discount_d FROM operation WHERE sell_id ='".$id."';";
		$stmt = $con->prepare($get_reparacion);
		$stmt->execute();
		$reparacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($reparacion as $index => $data) {
			$_SESSION["cart-repair"][$index]['product_id']   = $data['product_id'];
			$_SESSION["cart-repair"][$index]['q']   = intval($data['q']);
			$_SESSION["cart-repair"][$index]['pvc'] = floatval($data['price_out']);
			$_SESSION["cart-repair"][$index]['pvd'] = floatval($data['price_out_d']);
			$_SESSION["cart-repair"][$index]['desc_c'] = floatval($data['discount']);
			$_SESSION["cart-repair"][$index]['desc_d'] = floatval($data['discount_d']);
		}
        $con = null;
        ExecutorPDO::closeConnection();   
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }
}


public static function getReparacionesData($id) {
	$sql = "SELECT r.id,r.facturano,r.tecnico_id,r.descripcion,r.costo_repuesto,r.costo_repuesto_d,
				   r.costo_reparacion,r.costo_reparacion_d,r.total,r.total_d,r.fecha_reparacion,
				   r.sell_id,r.client_id,r.cliente,s.user_id,CONCAT(u.name,' ',u.lastname) AS vendedor,r.estado_taller,r.nota
			FROM  reparaciones r
			LEFT OUTER JOIN sell s ON r.sell_id = s.id
			LEFT OUTER JOIN user u ON s.user_id = u.id 
			WHERE r.id='".$id."';";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = [];
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array['idr'] = $row['id'];			
			$array['idv'] =  intval($row['sell_id']);
			$array['factura'] = $row['facturano'];			
			$array['cliente_id'] = $row['client_id'];
			$array['cliente'] = $row['cliente'];
			$array['vendedor'] = intval($row['user_id']);
			$array['id_vendedor'] = ($row['user_id'] === null || trim($row['user_id']) == "")?0:$row['user_id'];
			$array['n_vendedor'] = ($row['user_id'] === null || trim($row['user_id']) == "")?0:$row['vendedor'];
			$array['tecnico_id'] = $row['tecnico_id'];			
			$array['descripcion'] =  $row['descripcion'];
			$array['nota'] =  $row['nota'];

			$array['crc'] =  floatval($row['costo_repuesto']);
			$array['crd'] =  floatval($row['costo_repuesto_d']);
			$array['crec'] =  floatval($row['costo_reparacion']);
			$array['cred'] =  floatval($row['costo_reparacion_d']);
			$array['total_c'] =  floatval($row['total']);
			$array['total_d'] =  floatval($row['total_d']);
			$array['fecha'] = date('Y-m-d', strtotime($row['fecha_reparacion']));
			$array['estado'] = $row['estado_taller'];
		
		}
	ExecutorPDO::closeCon();	
	if(intval($array['idv']) > 0){
		self::llenarCarrito($array['idv']);
		return $array;   
	}else{
		return $array;   
	}
	     
}


















/**************************************************/
}

?>
