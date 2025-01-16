<?php

class RepairmanData {
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
					 $_SESSION["cart-repair"][$index]['ido']   = 0;
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
		$idv = intval($data['idv']);
		$con = ExecutorPDO::getConnection(); 
		$con->beginTransaction();
		try {
if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0 && $idv == 0){	
	throw new PDOException("La reparacion no tiene registro de venta solicite al vendedor que edite el registro y cree la venta");
}else if(isset($_SESSION['cart-repair']) && count($_SESSION['cart-repair']) > 0 && $idv > 0){	
													
	$sql_venta = "UPDATE sell SET total= :total_c, total_d= :total_d,cash=:cash_c,cash_d= :cash_d,
								 discount= :desc_c,discount_d= :desc_d
							  WHERE id= :id;";     
			

					$stmt = $con->prepare($sql_venta);
					$stmt->bindParam(':total_c', $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':total_d', $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_c',  $data['cash_c'],PDO::PARAM_STR);
					$stmt->bindParam(':cash_d',  $data['cash_d'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_c', $data['discount'],PDO::PARAM_STR);
					$stmt->bindParam(':desc_d', $data['discount_d'],PDO::PARAM_STR); 
					$stmt->bindParam(':id', $data['idv'],PDO::PARAM_INT);    
				   
					$venta = $stmt->execute();
					if(!$venta){
					   throw new PDOException("No se pudo guardar la venta");
					}
						
						$delete_op ="DELETE FROM operation WHERE sell_id='".$idv."';";
						$stmt = $con->prepare($delete_op);
						$stmt->execute();
						$cart = $_SESSION['cart-repair'];
						foreach ($cart as $v) {
							$fecha = date('Y-m-d H:m:s');
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
						   $stmt->bindParam(':fecha', $fecha,PDO::PARAM_STR);
						   $operacion = $stmt->execute();         
						   if(!$operacion){
							   throw new PDOException("No se pudo guardar registrar la venta");
						   }                      
						 }			
}else if($idv > 0 && (!isset($_SESSION['cart-repair']) || count($_SESSION['cart-repair']) == 0)){	

	$delete_op ="DELETE FROM operation WHERE sell_id='".$idv."';";
	$stmt = $con->prepare($delete_op);
	$stmt->execute();

	$delete_sell ="DELETE FROM sell WHERE id='".$idv."';";
	$stmt = $con->prepare($delete_sell);
	$stmt->execute();
	$idv = 0;
}//agregar venta

$sql_reparacion = "UPDATE reparaciones SET descripcion= :descripcion,repuesto= :repuesto,repuestos_id= :repuesto_id,
										   costo_repuesto= :costo_c, costo_repuesto_d= :costo_d,
										   costo_reparacion= :costor_c, costo_reparacion_d= :costor_d, 
										   total= :total_c, total_d= :total_d,sell_id=:sell_id
									   WHERE id=:id;";
																		
							$stmt = $con->prepare($sql_reparacion);
							$stmt->bindParam(':descripcion', $this->descripcion,PDO::PARAM_STR);
							$stmt->bindParam(':repuesto', $this->repuesto,PDO::PARAM_STR);
							$stmt->bindParam(':repuesto_id', $this->repuesto_id,PDO::PARAM_STR);

							$stmt->bindParam(':costo_c', $this->costo_repuesto,PDO::PARAM_STR);
							$stmt->bindParam(':costo_d', $this->costo_repuesto_d,PDO::PARAM_STR);
							$stmt->bindParam(':costor_c', $this->costo_reparacion,PDO::PARAM_STR);
							$stmt->bindParam(':costor_d', $this->costo_reparacion_d,PDO::PARAM_STR);
							$stmt->bindParam(':total_c', $this->total,PDO::PARAM_STR);
							$stmt->bindParam(':total_d', $this->total_d,PDO::PARAM_STR);
							$stmt->bindParam(':sell_id', $idv,PDO::PARAM_STR);
							$stmt->bindParam(':id', $this->id,PDO::PARAM_STR);

							$reparacion = $stmt->execute();
							if(!$reparacion){
							throw new PDOException("No se pudo guardar la reparacion");
							}

							unset($_SESSION['cart-repair']); 
							$con->commit(); 
							$con = null;
							ExecutorPDO::closeConnection();              
							return ["msg"=>"Datos de reparacion actualizados..","code"=>true,"id"=> $this->id];      
			  
		}catch(\PDOException $e){
			$con->rollback();
			$con = null;
			ExecutorPDO::closeConnection(); 
			return ["msg"=>$e->getMessage(),"code"=>false,"id"=>0];        
		}
	/*********************************/
	}

public static function getReparacionesAbiertas($tecnico) {
		$sql = "SELECT r.id,r.facturano as factura, if(r.client_id=2,r.cliente,CONCAT(p.name,' ',p.lastname)) as cliente,
				r.tecnico,r.descripcion,r.repuesto,r.costo_repuesto as costo_repuesto_c,r.costo_repuesto_d as costo_repuesto_d,
				r.total as total_c, r.total_d as total_d, r.costo_reparacion as ganancia_c, r.costo_reparacion_d as ganancia_d,
				r.estado_taller as estado,r.created_at as fecha
				FROM  reparaciones r
				LEFT OUTER JOIN person p ON r.client_id=p.id
				WHERE r.status = 0 AND r.estado_taller !='No se pudo' AND tecnico='".$tecnico."' ORDER BY r.created_at DESC";
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


public static function getDataFromReparacion($id) {
	$sql = "SELECT r.id,r.descripcion,r.costo_repuesto as costo_repuesto_c,r.costo_repuesto_d as costo_repuesto_d,
			r.total as total_c, r.total_d as total_d, r.costo_reparacion as ganancia_c, r.costo_reparacion_d as ganancia_d,sell_id as idv
			FROM  reparaciones r
			WHERE r.id='".$id."';";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	ExecutorPDO::executeParams(array());
	$obj = [];
		foreach  (ExecutorPDO::fetchAll()  as $row) {
			if(intval($row['idv']) > 0){
				self::llenarCarrito($row['idv']);
			}	
			$obj['id'] = $row['id'];
			$obj['idv'] = $row['idv'];
			$obj['descripcion'] =  $row['descripcion'];
			$obj['costo_repuesto_c'] = floatval($row['costo_repuesto_c']);
			$obj['costo_repuesto_d'] = floatval($row['costo_repuesto_d']);
			$obj['total_c'] = floatval($row['total_c']);
			$obj['total_d'] = floatval($row['total_d']);
			$obj['ganancia_c'] = floatval($row['ganancia_c']);
			$obj['ganancia_d'] = floatval($row['ganancia_d']);
		}
	ExecutorPDO::closeCon();	
	return $obj;        
}

public static function llenarCarrito($id){
	$sql = "SELECT product_id,q,price_out,price_out_d,discount,discount_d
	FROM  operation 
	WHERE sell_id='".$id."';";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		ExecutorPDO::executeParams(array());
		$obj = [];
		foreach  (ExecutorPDO::fetchAll() as $index => $row) {
			$_SESSION["cart-repair"][$index]['product_id']   = intval($row['product_id']);
			$_SESSION["cart-repair"][$index]['q']   = intval($row['q']);
			$_SESSION["cart-repair"][$index]['pvc'] = floatval($row['price_out']);
			$_SESSION["cart-repair"][$index]['pvd'] = floatval($row['price_out_d']);
			$_SESSION["cart-repair"][$index]['desc_c'] = floatval($row['discount']);
			$_SESSION["cart-repair"][$index]['desc_d'] = floatval($row['discount_d']);
		}
		ExecutorPDO::closeCon();	
		return $obj;  

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


public static function reparacionEnProceso($id){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET estado_taller='En proceso' WHERE id='".$id."';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Reparacion en proceso","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}

public static function reparacionTerminada($id){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET estado_taller='Reparado' WHERE id='".$id."';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Reparacion terminada","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}
public static function reparacionNoSePudo($id,$nota){
    $con = ExecutorPDO::getConnection(); 
    try {
		$upd_reparacion = "UPDATE reparaciones SET estado_taller='No se pudo',nota='".$nota."' WHERE id='".$id."';";
		$stmt = $con->prepare($upd_reparacion);
		$stmt->execute();		
        $con = null;
        ExecutorPDO::closeConnection();   
        return ["msg"=>"Reparacion dada de baja","code"=>true];
        
    } catch (PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();    
        return ["msg"=>$ex->getMessage(),"code"=>false];
    }	
}

/**************************************************/
}

?>