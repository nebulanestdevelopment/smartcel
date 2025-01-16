<?php
class BoxData {
	public static $tablename = "box";
		
	public $name;
	public $lastname;
	public $email;
	public $image;
	public $password;
	public $created_at;	


	public function __construct()
	{
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	/*public function add(){
		$sql = "insert into box (created_at) ";
		$sql .= "value ($this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto BoxData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new BoxData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['id'];
			$data->created_at = $r['created_at'];
			$found = $data;
			break;
		}
		return $found;
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}
*/

public static function add(){
	
	$con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
                                                
$sql_box = "INSERT INTO box (created_at) VALUE (NOW());";     
$stmt = $con->prepare($sql_box);                        
                $box = $stmt->execute();
                if(!$box){
                   throw new PDOException("No se pudo actualizar la reversion de caja");
                }    
				$id = $con->lastInsertId();                  
				$con->commit(); 
				$con = null;
				ExecutorPDO::closeConnection();                  
                return $id;     
          
    }catch(\PDOException $e){
        $con->rollback();
        $con = null;
        ExecutorPDO::closeConnection(); 
        return 0;        
    }
}





public static function getAll(){
	$con = ExecutorPDO::getConnection();                                      
    $box_detail ="select id,created_at from box order by created_at desc  ;";     
                    
                    $stmt = $con->prepare($box_detail);                   
                    $stmt->execute();
                    $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);  
                    $rows = array();
                    foreach ($data as $i => $row) {
                        $sc = new stdClass();
                        $sc->id = $row['id'];   
			$sc->created_at = $row['created_at'];    
                        $rows[$i] = $sc; 
                    }                     
                            $con = null;
                            ExecutorPDO::closeConnection();    
                            
                    return $rows;    
}

public static function getByBoxIdTotal($id){
	$con = ExecutorPDO::getConnection();                                      
        $box_detail ="SELECT sum(s.total) as total_c,sum(s.total_d) as total_d,sum(s.discount) as desc_c,
		      sum(s.discount_d) as desc_d,s.sell_type as tipo, s.created_at  
	 			  FROM sell s 
				  WHERE s.operation_type_id='2' AND s.box_id='".$id."' AND s.sell_type ='1' group by s.created_at 
					order by s.created_at desc  ;";     
                    
                    $stmt = $con->prepare($box_detail);                   
                    $stmt->execute();
                    $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);  
                    $rows = array();
                    foreach ($data as $i => $row) {
                        $sc = new stdClass();
                        $sc->total_c = $row['total_c']; 
						$sc->total_d = $row['total_d'];
						$sc->desc_c  = $row['desc_c']; 
						$sc->desc_d  = $row['desc_d'];  
						$sc->tipo    = $row['tipo'];   
						$sc->created_at = $row['created_at'];    
                        $rows[$i] = $sc; 
                    }                     
                            $con = null;
                            ExecutorPDO::closeConnection();    
                            
                    return $rows;    
}

public static function RevertirCaja($id){
	$con = ExecutorPDO::getConnection(); 
    $con->beginTransaction();
    try {
                                                
$sql_venta = "UPDATE sell SET is_boxed=0,box_id=NULL,related_box=NULL,id_caja_a_revertir=:box WHERE box_id =:box OR related_box =:box AND operation_type_id = 2;";     
                
                $stmt = $con->prepare($sql_venta);
                $stmt->bindParam(':box', $id,PDO::PARAM_INT);                         
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
        return ["msg"=>$e->getMessage(),"code"=>false];        
    }
/*********************************/
  }





/*****************************************/
}

?>
