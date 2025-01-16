<?php
class ReparacionTipoData {
    
	public static $tablename = "reparaciones_tipo";
    public $id;
	public $name;
	public $precio_d;
	public $precio_c;
	public $created_at;

    public function __construct() {
        $this->id = " ";
		$this->name = " ";
		$this->precio_d =0.00;
		$this->precio_c = 0.00;
		$this->created_at = "NOW()";
    }

	public static function getAll(){
	
		$sql = "select id,name,precio_d,precio_c from ".self::$tablename." order by name; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['nombre'] = $r['name'];
				$array[$index]['dolar'] = $r['precio_d'];
				$array[$index]['cordoba'] = $r['precio_c'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	
	public function save(){
		try {
			$sql = "insert into ".self::$tablename." (name,precio_d,precio_c,created_at) values(:name,:dolar,:cordoba,NOW());";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':dolar', $this->precio_d,PDO::PARAM_STR);
			ExecutorPDO::bind(':cordoba', $this->precio_c,PDO::PARAM_STR);		
			
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"TIpo de reparacion guardada correctamente!","code"=>true];
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
		$sql = "select id,name,subcategoria from ".self::$tablename." where id=? ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $row) {
				$array['id'] = $row['id'];
				$array['name'] = $row['name'];
				$array['subcategoria'] = $row['subcategoria'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	public function update(){
		try {
			$sql = "UPDATE ".self::$tablename." SET image=:image,name=:name,subcategoria=:subcategoria,description=:description,created_at=:created_at WHERE id=:id;";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':created_at', $this->created_at);
			ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);
			
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Categoría actualizada correctamente!","code"=>true];
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
				return ["msg"=>"Categoría eliminada correctamente!","code"=>true];
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
