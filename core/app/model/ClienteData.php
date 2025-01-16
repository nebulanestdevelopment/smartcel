<?php
class ClienteData {
    public static $tablename = "person";
    public $id;
    public $image;
	public $razon_social;
	public $cedula;
	public $codigo;
	public $name;
	public $lastname;
	public $company;
	public $address1;
	public $address2;
	public $phone1;
	public $phone2;
	public $email1;
	public $email2;
	public $kind;
	public $created_at;


    public function __construct() {
        $this->id = 0;
		$this->image = " ";
		$this->razon_social = " ";
		$this->cedula = " ";
		$this->codigo = " ";
		$this->name = " ";
		$this->lastname = " ";
		$this->company = " ";
		$this->address1 = " ";
		$this->address2 = " ";
		$this->phone1 = " ";
		$this->phone2 = " ";
		$this->email1 = " ";
		$this->email2 = " ";
		$this->kind = " ";
		$this->created_at = "NOW()";
    }

	public static function getAll(){
		$sql = "select * from ".self::$tablename." WHERE kind ='1' order by id ;";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
				$array[$index]['id'] = $row['id'];
				$array[$index]['image'] = $row['image'];
				$array[$index]['razon_social'] = $row['razon_social'];
				$array[$index]['cedula'] = $row['cedula'];
				$array[$index]['codigo'] = $row['codigo'];
				$array[$index]['name'] = $row['name'];
				$array[$index]['lastname'] = $row['lastname'];
				$array[$index]['completo'] = $row['name'].' '.$row['lastname'];
				$array[$index]['company'] = $row['company'];
				$array[$index]['address1'] = $row['address1'];
				$array[$index]['address2'] = $row['address2'];
				$array[$index]['phone1'] = $row['phone1'];
				$array[$index]['phone2'] = $row['phone2'];
				$array[$index]['email1'] = $row['email1'];
				$array[$index]['email2'] = $row['email2'];
				$array[$index]['kind'] = $row['kind'];
				$array[$index]['created_at'] = $row['created_at'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}


	public static function getAllRepair(){
		$sql = "select * from ".self::$tablename." WHERE kind ='3' order by id ;";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
				$array[$index]['id'] = $row['id'];
				$array[$index]['image'] = $row['image'];
				$array[$index]['razon_social'] = $row['razon_social'];
				$array[$index]['cedula'] = $row['cedula'];
				$array[$index]['codigo'] = $row['codigo'];
				$array[$index]['name'] = $row['name'];
				$array[$index]['lastname'] = $row['lastname'];
				$array[$index]['completo'] = $row['name'].' '.$row['lastname'];
				$array[$index]['company'] = $row['company'];
				$array[$index]['address1'] = $row['address1'];
				$array[$index]['address2'] = $row['address2'];
				$array[$index]['phone1'] = $row['phone1'];
				$array[$index]['phone2'] = $row['phone2'];
				$array[$index]['email1'] = $row['email1'];
				$array[$index]['email2'] = $row['email2'];
				$array[$index]['kind'] = $row['kind'];
				$array[$index]['created_at'] = $row['created_at'];
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

public function save(){
$con = ExecutorPDO::getConnection(); 
$con->beginTransaction();
try {
                                                
$save = "INSERT INTO person (image,razon_social,cedula,codigo,name,lastname,company,address1,address2,phone1,phone2,email1,email2,kind,created_at) VALUES (:image, :razon_social, :cedula, :codigo, :name, :lastname, :company, :address1, :address2, :phone1, :phone2, :email1, :email2, :kind, NOW());";    
$stmt = $con->prepare($save);   
		$stmt->bindParam(':image', $this->image,PDO::PARAM_STR);
		$stmt->bindParam(':razon_social', $this->razon_social,PDO::PARAM_STR);
		$stmt->bindParam(':cedula', $this->cedula,PDO::PARAM_STR);
		$stmt->bindParam(':codigo', $this->codigo,PDO::PARAM_STR);
		$stmt->bindParam(':name', $this->name,PDO::PARAM_STR);
		$stmt->bindParam(':lastname', $this->lastname,PDO::PARAM_STR);
		$stmt->bindParam(':company', $this->company,PDO::PARAM_STR);
		$stmt->bindParam(':address1', $this->address1,PDO::PARAM_STR);
		$stmt->bindParam(':address2', $this->address2,PDO::PARAM_STR);
		$stmt->bindParam(':phone1', $this->phone1,PDO::PARAM_STR);
		$stmt->bindParam(':phone2', $this->phone2,PDO::PARAM_STR);
		$stmt->bindParam(':email1', $this->email1,PDO::PARAM_STR);
		$stmt->bindParam(':email2', $this->email2,PDO::PARAM_STR);
		$stmt->bindParam(':kind', $this->kind,PDO::PARAM_INT);                
		$stmt->execute(); 
		$id = $con->lastInsertId();                  
		$con->commit(); 
		$con = null;
		ExecutorPDO::closeConnection();  
		return ["msg"=>"Cliente guardado correctamente!","code"=>true,"id"=>$id];               
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return ["msg"=>$e,"code"=>false,'id'=>0]; 
    }
}


public static function getById($id){
	$sql = "select * from ".self::$tablename." WHERE kind !='2' and id='".$id."' order by id ;";
	ExecutorPDO::initCon();
	ExecutorPDO::initPreparate($sql);
	$array = array();
	ExecutorPDO::executeParams(array());
		foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
			$array['id'] = $row['id'];
			$array['image'] = $row['image'];
			$array['razon_social'] = $row['razon_social'];
			$array['cedula'] = $row['cedula'];
			$array['codigo'] = $row['codigo'];
			$array['name']   = $row['name'];
			$array['lastname'] = $row['lastname'];
			$array['company']  = $row['company'];
			$array['address1'] = $row['address1'];
			$array['address2'] = $row['address2'];
			$array['phone1'] = $row['phone1'];
			$array['phone2'] = $row['phone2'];
			$array['email1'] = $row['email1'];
			$array['email2'] = $row['email2'];
			$array['kind'] = $row['kind'];
			$array['created_at'] = $row['created_at'];
		}
	ExecutorPDO::closeCon();	
	return $array;
}


public function update(){
	try {
		$sql = "UPDATE ".self::$tablename." SET cedula=:cedula,codigo=:codigo, name=:name, lastname=:lastname,address1=:address1, phone1=:phone1, email1=:email1,kind=:kind,created_at=NOW() WHERE id=:id;";
		$con = ExecutorPDO::initCon();
		$con->beginTransaction();
		ExecutorPDO::initPreparate($sql);
		
		ExecutorPDO::bind(':cedula', $this->cedula,PDO::PARAM_STR);	
		ExecutorPDO::bind(':codigo', $this->codigo,PDO::PARAM_STR);
		ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
		ExecutorPDO::bind(':lastname', $this->lastname,PDO::PARAM_STR);
		ExecutorPDO::bind(':address1', $this->address1,PDO::PARAM_STR);
		ExecutorPDO::bind(':phone1', $this->phone1,PDO::PARAM_STR);
		ExecutorPDO::bind(':email1', $this->email1,PDO::PARAM_STR);
		ExecutorPDO::bind(':kind', $this->kind,PDO::PARAM_INT);
		ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);
		
		if(ExecutorPDO::execute()){
			$con->commit();
			ExecutorPDO::closeCon();
			return ["msg"=>"Datos del cliente actualizados!!","code"=>true];
		}else{
			throw new PDOException("No se puede actualizar los datos del cliente revise los campos");
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
			return ["msg"=>"Cliente eliminado correctamenta!!","code"=>true];
		}else{
			throw new PDOException("No se puede eliminar el cliente!!");
		}

	} catch (PDOException $ex) {
		$con->rollBack();
		ExecutorPDO::closeCon();
		return ["msg"=>$ex,"code"=>false];
	}	
}



}
?>