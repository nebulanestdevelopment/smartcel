<?php
class CategoriaData {
    
	public static $tablename = "category";
    public $id;
    public $image;
	public $name;
	public $subcategoria;
	public $description;
	public $created_at;

    public function __construct() {
        $this->id = " ";
        $this->image = " ";
		$this->name = " ";
		$this->subcategoria = " ";
		$this->description = " ";
		$this->created_at = "NOW()";
    }

    public function CategoriaData() {
        $this->id = "";
        $this->image = "";
		$this->name = "";
		$this->subcategoria = "";
		$this->description = "";
		$this->created_at = "NOW()";
    }


	public static function getAll(){
	
		$sql = "select id,name,subcategoria from ".self::$tablename." order by name, subcategoria ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['name'] = $r['name'];
				$array[$index]['subcategoria'] = $r['subcategoria'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	public static function getAllBySubcategory($subcategory){	
		$sql = "select id,name,subcategoria from ".self::$tablename." where subcategoria='".$subcategory."' order by name ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['name'] = $r['name'];
				$array[$index]['subcategoria'] = $r['subcategoria'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	
	public function save(){
		try {
			$sql = "insert into ".self::$tablename." (image,name,subcategoria,description,created_at) values(' ',:name,:subcategoria,' ',NOW());";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':subcategoria', $this->subcategoria,PDO::PARAM_STR);
			
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Categoría guardada correctamente!","code"=>true];
			}else{
				throw new PDOException("No se puede guardar los datos");
			}

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeCon();
			return ["msg"=>$ex,"code"=>false];
		}	
	}

	public function saveReturn(){
		$con = ExecutorPDO::getConnection();		
		try {
			$con->beginTransaction();
			$sql = "INSERT INTO ".self::$tablename." (image,name,subcategoria,description,created_at) values(' ',:name,:subcategoria,' ',NOW());";
			
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':name', $this->name,PDO::PARAM_STR);
			$stmt->bindParam(':subcategoria', $this->subcategoria,PDO::PARAM_STR);
			$categoria = $stmt->execute();
			
			if(!$categoria){ throw new PDOException("No se puede guardar los datos");}
			
			$id = $con->lastInsertId();
			$con->commit();
			$con = null;
			ExecutorPDO::closeConnection();
			return ["msg"=>"Categoría guardada correctamente!","id"=>$id ,"code"=>true];
			

		} catch (PDOException $ex) {
			$con->rollBack();
			$con= null;
			ExecutorPDO::closeConnection();
			return ["msg"=>$ex,"id"=> 0, "code"=>false];
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
			ExecutorPDO::bind(':image', $this->image,PDO::PARAM_STR);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':subcategoria', $this->subcategoria,PDO::PARAM_STR);
			ExecutorPDO::bind(':description', $this->description,PDO::PARAM_STR);
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
