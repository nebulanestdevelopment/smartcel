<?php
class PagoData {
    
	public static $tablename = "pagos";
    public $id;
	public $name;
	public $descripcion;
	public float $total_c;
	public float $total_d;
	public $created_at;

    public function __construct() {
        $this->id = " ";
		$this->name = " ";
		$this->descripcion = " ";
		$this->total_c = 0.00;
		$this->total_d = 0.00;
		$this->created_at = "NOW()";
    }

	public static function getAll(){
		$sql = "select id,name,descripcion,total_c,total_d,created_at from ".self::$tablename." order by created_at asc; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['name'] = $r['name'];
				$array[$index]['descripcion'] = $r['descripcion'];
				$array[$index]['c'] = $r['total_c'];
				$array[$index]['d'] = $r['total_d'];
				$array[$index]['create'] = date('d/m/Y HH:mm', strtotime($r['created_at']));
			}
		ExecutorPDO::closeCon();	
		return $array;		
	}

	public static function getPagosMesActual(){
		$lastDate  = new DateTime(date("Y").'-'.date("m").'-01');
		$lastDate  = $lastDate->modify('-1 day');
		$lastMonth = $lastDate->format('Y-m-d H:i:s');

		$nextDate  = new DateTime(date("Y").'-'.date("m").'-01');
		$nextDate  = $nextDate->modify('+1 month');
		$nextMonth = $nextDate->format('Y-m-d H:i:s');
		$sql = "select id,name,descripcion,total_c,total_d,created_at 
		from ".self::$tablename." WHERE created_at > '".$lastMonth."' AND created_at < '".$nextMonth."' order by created_at asc; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['name'] = $r['name'];
				$array[$index]['descripcion'] = $r['descripcion'];
				$array[$index]['c'] = $r['total_c'];
				$array[$index]['d'] = $r['total_d'];
				$array[$index]['create'] = date('d/m/Y', strtotime($r['created_at']));
			}
		ExecutorPDO::closeCon();	
		return $array;		
	}
	
	public function save(){
		try {
			$sql = "INSERT INTO ".self::$tablename." (name,descripcion,total_c,total_d,created_at) values(:name,:descripcion,:c,:d,:create);";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':descripcion', $this->descripcion,PDO::PARAM_STR);
			ExecutorPDO::bind(':c', $this->total_c,PDO::PARAM_STR);
			ExecutorPDO::bind(':d', $this->total_d,PDO::PARAM_STR);
			ExecutorPDO::bind(':create', $this->created_at,PDO::PARAM_STR);
			 
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Pago guardado correctamente!","code"=>true];
			}else{
				throw new PDOException("No se puede guardar los datos");
			}

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeCon();
			var_dump($ex);die();
			return ["msg"=>$ex,"code"=>false];
		}	
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=? ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $r) {
				$array['id'] = $r['id'];
				$array['name'] = $r['name'];
				$array['descripcion'] = $r['descripcion'];
				$array['c'] = $r['total_c'];
				$array['d'] = $r['total_d'];
				$array['create'] = date('Y-m-d', strtotime($r['created_at']));
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	public function update(){
		try {
			$sql = "UPDATE ".self::$tablename." SET name = :name,descripcion= :descripcion,total_c =:c,total_d= :d, created_at= :create WHERE id= :id;";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':descripcion', $this->descripcion,PDO::PARAM_STR);
			ExecutorPDO::bind(':c', $this->total_c,PDO::PARAM_STR);
			ExecutorPDO::bind(':d', $this->total_d,PDO::PARAM_STR);
			ExecutorPDO::bind(':create', $this->created_at,PDO::PARAM_STR);
			ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Egreso actualizado correctamente!","code"=>true];
			}else{
				throw new PDOException("No se puede actualizar los datos");
			}

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeCon();
			return ["msg"=>$ex,"code"=>false];
		}	
	}

	public function delete(){
		try {
			$sql = "DELETE FROM ".self::$tablename." WHERE id=:id;";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);			
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Registro eliminado correctamente!","code"=>true];
			}else{
				throw new PDOException("No se puede eliminar los datos");
			}

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeCon();
			return ["msg"=>$ex,"code"=>false];
		}	
	}

	public function getTotalGastosMesActual(){
		$lastDate  = new DateTime(date("Y").'-'.date("m").'-01');
		$lastDate  = $lastDate->modify('-1 day');
		$lastMonth = $lastDate->format('Y-m-d H:i:s');

		$nextDate  = new DateTime(date("Y").'-'.date("m").'-01');
		$nextDate  = $nextDate->modify('+1 month');
		$nextMonth = $nextDate->format('Y-m-d H:i:s');
		
		$sql = "select sum(total_c) as cordoba,sum(total_d) as dolar from ".self::$tablename." WHERE created_at > '".$lastMonth."' AND created_at < '".$nextMonth."' ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as  $r) {
				$array['cordoba'] = number_format($r['cordoba'],2,".",",");
				$array['dolar'] = number_format($r['dolar'],2,".",",");
			}
		ExecutorPDO::closeCon();	
		return $array;	

	}
	public function getTotalHistorialEgresos($data){
		$inicial = ($data['inicial'] == "")?0:$data['inicial'];
		$final = ($data['final'] == "")?0:$data['final'];
		$where = "";
		if ($inicial == 0 || $final == 0) {
			$where = " order by created_at asc;";
		}else{
			$iniDate  = new DateTime($inicial);
			$iniDated  = $iniDate->modify('-1 day');
			$ini = $iniDated->format('Y-m-d H:i:s');

			$finDate  = new DateTime($final);
			$finDated  = $finDate->modify('+1 day');
			$fin = $finDated->format('Y-m-d H:i:s');

			$where =" WHERE created_at > '".$ini."' AND created_at < '".$fin."' ; ";
		}	
		$sql = "select sum(total_c) as cordoba, sum(total_d) as dolar from ".self::$tablename."  ".$where;
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $r) {
			$array['cordoba'] = number_format($r['cordoba'],2,".",",");
			$array['dolar'] = number_format($r['dolar'],2,".",",");
		}
		ExecutorPDO::closeCon();	
		return $array;

	}

	public function getHistorialEgresos($data){
		$inicial = ($data['inicial'] == "")?0:$data['inicial'];
		$final = ($data['final'] == "")?0:$data['final'];
		$where = "";
		if ($inicial == 0 || $final == 0) {
			$where = " order by created_at asc;";
		}else{
			$iniDate  = new DateTime($inicial);
			$iniDated  = $iniDate->modify('-1 day');
			$ini = $iniDated->format('Y-m-d H:i:s');

			$finDate  = new DateTime($final);
			$finDated  = $finDate->modify('+1 day');
			$fin = $finDated->format('Y-m-d H:i:s');

			$where =" WHERE created_at > '".$ini."' AND created_at < '".$fin."' ; ";
		}	
		$sql = "select * from ".self::$tablename."  ".$where;
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
			$array[$index]['id'] = $r['id'];
			$array[$index]['name'] = $r['name'];
			$array[$index]['descripcion'] = $r['descripcion'];
			$array[$index]['c'] = $r['total_c'];
			$array[$index]['d'] = $r['total_d'];
			$array[$index]['create'] = date('Y-m-d', strtotime($r['created_at']));
		}
		ExecutorPDO::closeCon();	
		return $array;

	}
	


}

?>
