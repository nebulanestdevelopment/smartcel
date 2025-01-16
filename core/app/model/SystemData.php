<?php

class SystemData {
    public $id;
    public $tecnicos;
    public $tasa_cambio;
    public static $tasaCambio;
    public static $tableName = "sistema_data";

    public function __construct(){
        $this->id = 0;
        $this->tecnicos = " ";
        $this->tasa_cambio = 0;
        self::$tasaCambio = 0.00;
    }

    public static function obtenerTasaCambio(){
        $sql ="SELECT tasa_cambio as tasa from ".self::$tableName.' limit 1;';
        ExecutorPDO::initCon();
		ExecutorPDO::initPreparate($sql);
		self::$tasaCambio = 0.00;
		ExecutorPDO::executeParams(array());
			foreach  (ExecutorPDO::fetchAll()  as $index => $r) {
				self::$tasaCambio = $r['tasa'];
			}
		ExecutorPDO::closeCon();	
        self::$tasaCambio = number_format(floatval(self::$tasaCambio), 2, '.', ',');
		return self::$tasaCambio;	
       

    }

    public static function GetDatos(){
        $con = ExecutorPDO::getConnection();
        $sql = "Select id,tecnicos,tasa_cambio from ".self::$tableName;
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $query = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        foreach ($query as $v) {
            $obj->id = $v['id'];
            $obj->tecnicos = $v['tecnicos'];
            $obj->tasa_cambio = $v['tasa_cambio'];
        }
        $con = null;
		ExecutorPDO::closeConnection(); 
        return $obj;
    }

    public function update(){
        $con = ExecutorPDO::getConnection();
        $con->beginTransaction();
        try {
			$sql = "UPDATE sistema_data SET tecnicos=:tecnicos,tasa_cambio=:tasa_cambio WHERE id=:id;";
		
			$stmt = $con->prepare($sql);
			$stmt->bindParam(':tecnicos', $this->tecnicos,PDO::PARAM_STR);
			$stmt->bindParam(':tasa_cambio', $this->tasa_cambio,PDO::PARAM_STR);
			$stmt->bindParam(':id', $this->id,PDO::PARAM_INT);
			$save = $stmt->execute();
			if(!$save){
                throw new PDOException("No se puede actualizar los datos");
            }	
            $con->commit();
			ExecutorPDO::closeConnection();
            $con = null;
			return ["msg"=>"Datos actualizadados correctamente!","code"=>true];
			

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeConnection();
            $con = null;
			return ["msg"=>$ex->getMessage(),"code"=>false];
		}	
    }

    public function updateTasaInventario(){
        
        $con = ExecutorPDO::getConnection();
        $con->beginTransaction();
        try {

            $tasa = floatval(self::obtenerTasaCambio());
            $sql = "UPDATE product SET price_out_d=price_out/".$tasa.",price_out_es_d=price_out_es/".$tasa." WHERE price_out_d <> 0 or price_out_es_d <> 0;";
		    $stmt = $con->prepare($sql);
			$save = $stmt->execute();
			if(!$save){
                throw new PDOException("No se puede actualizar los datos");
            }	
            $con->commit();
			ExecutorPDO::closeConnection();
            $con = null;
			return ["msg"=>"La tasa de cambio se actualizo en todos los productos!","code"=>true];
			

		} catch (PDOException $ex) {
			$con->rollBack();
			ExecutorPDO::closeConnection();
            $con = null;
			return ["msg"=>$ex->getMessage(),"code"=>false];
		}	
    }




}




?>