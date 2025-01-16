<?php
class UsuarioData {
	public static $tablename = "user";
		public $id;
		public $name ;
		public $lastname;
		public $username;
		public $email;		
		public $password;
		public $image;
		public $is_active;
		public $is_admin;
		public $is_repairman;
		public $is_seller;
		public $created_at;



	public function __construct(){
		$this->id = 0;
		$this->name = "";
		$this->lastname = "";
		$this->username = "";
		$this->email = "";		
		$this->password = "";
		$this->image = "";
		$this->is_active = 0;
		$this->is_admin = 0;
		$this->is_repairman = 0;
		$this->is_seller = 0;
		$this->created_at = "NOW()";
	}

	public static function getAll(){	
		$sql = "select * from ".self::$tablename." order by id asc; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['nombre'] = $r['name'];
				$array[$index]['apellido'] = $r['lastname'];
				$array[$index]['user'] = $r['username'];
				$array[$index]['activo'] = ($r['is_active'])?'Activo':'Inactivo';
				$tipo  = ($r['is_admin'] == 1)?'Administrador':'';
				$tipo .= ($r['is_repairman'] == 1)?'Técnico':'';
				$tipo .= ($r['is_seller'] == 1)?'Vendedor':'';
				$array[$index]['tipo'] = $tipo;
			}
		ExecutorPDO::closeCon();
		return $array;
	}

	public static function getUserData(){	
		$sql = "select name,name from ".self::$tablename." where id='".$_SESSION['user_id']."' ; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$nombre = " ";
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$nombre = $r['name'].' '.$r['name'];
			}
		ExecutorPDO::closeCon();
		return $nombre;
	}
	public static function getAllVendedores(){	
		$sql = "select * from ".self::$tablename." where is_seller=1 and is_active=1 order by id asc; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['nombre'] = $r['name'];
				$array[$index]['apellido'] = $r['lastname'];
				$array[$index]['user'] = $r['username'];
				$array[$index]['activo'] = ($r['is_active'])?'Activo':'Inactivo';
			}
		ExecutorPDO::closeCon();
		return $array;
	}

	public static function getAllTecnicos(){	
		$sql = "select * from ".self::$tablename." where is_repairman=1 and is_active=1 order by id asc; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				$array[$index]['id'] = $r['id'];
				$array[$index]['nombre'] = $r['name'];
				$array[$index]['apellido'] = $r['lastname'];
				$array[$index]['user'] = $r['username'];
				$array[$index]['activo'] = ($r['is_active'])?'Activo':'Inactivo';
			}
		ExecutorPDO::closeCon();
		return $array;
	}

	public function save(){
		try {
			$sql = "INSERT INTO ".self::$tablename." (name,lastname,username,email,password,image,is_active,is_admin,is_repairman,is_seller,created_at) values(:name,:lastname,:username,:email,:password,:image,:active,:admin,:repairman,:seller,NOW());";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':lastname', $this->lastname,PDO::PARAM_STR);
			ExecutorPDO::bind(':username', $this->username,PDO::PARAM_STR);
			ExecutorPDO::bind(':email', $this->email,PDO::PARAM_STR);
			ExecutorPDO::bind(':password', $this->password,PDO::PARAM_STR);
			ExecutorPDO::bind(':image', $this->image,PDO::PARAM_STR);
			ExecutorPDO::bind(':active', $this->is_active,PDO::PARAM_INT);
			ExecutorPDO::bind(':admin', $this->is_admin,PDO::PARAM_INT);
			ExecutorPDO::bind(':repairman', $this->is_repairman,PDO::PARAM_INT);
			ExecutorPDO::bind(':seller', $this->is_seller,PDO::PARAM_INT);
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Usuario guardado correctamente!","code"=>true];
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
		$sql = "SELECT * FROM ".self::$tablename." WHERE id=?; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$array = array();
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $r) {
				$array['id'] = $r['id'];
				$array['nombre'] = $r['name'];
				$array['apellido'] = $r['lastname'];
				$array['activo'] = ($r['is_active'])?'activo':'inactivo';
				$tipo  = ($r['is_admin'] == 1)?'admin':'';
				$tipo .= ($r['is_repairman'] == 1)?'tecnico':'';
				$tipo .= ($r['is_seller'] == 1)?'vendedor':'';
				$array['tipo'] = $tipo;
			}
		ExecutorPDO::closeCon();	
		return $array;
	}

	
	public function update(){
		try {
			$sql = "UPDATE ".self::$tablename." SET name= :name,lastname= :lastname,is_active= :active,is_admin= :admin,is_repairman= :repairman,is_seller= :seller,created_at=NOW() WHERE id= :id;";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':name', $this->name,PDO::PARAM_STR);
			ExecutorPDO::bind(':lastname', $this->lastname,PDO::PARAM_STR);
			ExecutorPDO::bind(':active', $this->is_active,PDO::PARAM_INT);
			ExecutorPDO::bind(':admin', $this->is_admin,PDO::PARAM_INT);
			ExecutorPDO::bind(':repairman', $this->is_repairman,PDO::PARAM_INT);
			ExecutorPDO::bind(':seller', $this->is_seller,PDO::PARAM_INT);
			ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Datos de usuario actualizados correctamente!","code"=>true];
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
			$sql = "DELETE FROM  ".self::$tablename." WHERE id= :id;";
			$con = ExecutorPDO::initCon();
			$con->beginTransaction();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::bind(':id', $this->id,PDO::PARAM_INT);
			if(ExecutorPDO::execute()){
				$con->commit();
				ExecutorPDO::closeCon();
				return ["msg"=>"Usuario eliminado correctamente!","code"=>true];
			}else{
				throw new PDOException("No se puede eliminar el usuario");
			}
		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeCon();
			return ["msg"=>$ex,"code"=>false];
		}	
	}

	public static function updatePassword($data){
		$con = ExecutorPDO::getConnection(); 
		$con->beginTransaction();
		try {
			$id = $_SESSION["user_id"];
			$get_user = "SELECT password FROM user WHERE id='".$id."';";
			$stmt = $con->prepare($get_user);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$get_old_password = $row['password'];
			$old_password = sha1(md5($data['old-password']));
			if ($get_old_password != $old_password) {
				throw new PDOException("La contraseñas anteriores no cooinciden");
			}
			$new_password = sha1(md5($data['new-password']));
			$update_pass = "UPDATE user SET password= :new where id = :id ;";
			$stmt = $con->prepare($update_pass);
			$stmt->bindParam(':new',$new_password,PDO::PARAM_STR);
			$stmt->bindParam(':id',$id,PDO::PARAM_STR);
			$save = $stmt->execute();
			if(!$save){
			throw new PDOException("No se pudo actualizar la contraseña");
			}

			$con->commit(); 
			$con = null;
			ExecutorPDO::closeConnection();              
			return ["msg"=>"Contraseña actualizada","code"=>true]; 

			
		} catch (PDOException $ex) {
			$con->rollback();
			$con = null;
			ExecutorPDO::closeConnection(); 
			return ["msg"=>$ex->getMessage(),"code"=>false];   
		}	
	}

	public static function hasRoleAdmin($id){	
		
		$sql = "SELECT id FROM ".self::$tablename." WHERE id=? AND is_admin=1 AND is_active=1; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$user_id = 0;
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $r) {
				$user_id = $r['id'];
			}
		ExecutorPDO::closeCon();	
		return (intval($user_id) > 0)?true:false;
	}

	public static function hasRoleSeller($id){	
		
		$sql = "SELECT id FROM ".self::$tablename." WHERE id=? AND is_admin=0 AND is_seller=1 AND is_active=1; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$user_id = 0;
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $r) {
				$user_id = $r['id'];
			}
		ExecutorPDO::closeCon();	
		return (intval($user_id) > 0)?true:false;
	}

	public static function hasRepairMan($id){	
		
		$sql = "SELECT id FROM ".self::$tablename." WHERE id=? AND is_admin=0 AND is_repairman=1 AND is_active=1; ";
		ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		$user_id = 0;
		ExecutorPDO::executeParams(array($id));
			foreach  (ExecutorPDO::fetchAll()  as $r) {
				$user_id = $r['id'];
			}
		ExecutorPDO::closeCon();	
		return (intval($user_id) > 0)?true:false;
	}


}

?>