<?php
class PagoTipoData {
    
	public static $tablename = "pagos_tipo";
    public $id;
	public $name;
	public $created_at;

    public function __construct() {
        $this->id = " ";
		$this->name = " ";
		$this->created_at = "NOW()";
    }

	public static function getAll(){
		$sql = "select id,name,created_at from ".self::$tablename." order by name; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['name'] = $r['name'];
				$array[$index]['create'] = date('d/m/Y', strtotime($r['created_at']));
			}
		ExecutorPDO::closeCon();	
		return $array;		
	}
	
	public function save(){
		try {
			$sql = "insert into ".self::$tablename." (name,created_at) values(:name,NOW());";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Tipo de gasto guardado correctamente!","code"=>true];
			}else{
				throw new PDOException("No se puede guardar los datos");
			}

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeCon();
			return ["msg"=>$ex,"code"=>false];
		}	
	}

	public static function getById($id){
		$sql = "select id,name,created_at from ".self::$tablename." where id=? ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $row) {
				$array['id'] = $row['id'];
				$array['name'] = $row['name'];
				$array['create'] = $row['created_at'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	public function update(){
		try {
			$sql = "UPDATE ".self::$tablename." SET name=:name,created_at=NOW() WHERE id=:id;";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);
			
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Tipo de gasto actualizado correctamente!","code"=>true];
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



}

?>
