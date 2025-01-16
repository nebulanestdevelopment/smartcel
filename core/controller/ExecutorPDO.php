<?php

class ExecutorPDO {
	 static $con;
	 static $sentencia;

	public static function initCon(){
		self::$con = DatabasePDO::getCon();
		return self::$con;
	}

	public static function getConnection(){
		return  DatabasePDO::getCon();
	}

	public static function initPreparate($sql){
		self::$sentencia = self::$con->prepare($sql);
	}
	

	public static function bind($campo,$valor,$tipo=null){
		self::$sentencia->bindParam($campo,$valor,$tipo);
	}
	
	public static function execute(){
		return self::$sentencia->execute();
	}	

	public static function executeParams($params){
		self::$sentencia->execute($params);
	}

	public static function fetchAll(){
		return self::$sentencia->fetchAll();
	}

    public static function closeCon(){
		DatabasePDO::closeCon();
		self::$con = null;
		self::$sentencia = null;
	}
	public static function closeConnection(){
		DatabasePDO::closeCon();
	}
}
?>