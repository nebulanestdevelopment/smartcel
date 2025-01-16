<?php

class Executor {
	 static $con;

	public static function initCon(){
		self::$con = Database::getCon();
	}

	public static function read($sql){
		return self::$con->query($sql);
	}
	public static function create($sql){
		return array(self::$con->query($sql),self::$con->insert_id);
	}
	public static function update($sql){
		return self::$con->query($sql);
	}
	public static function delete($sql){
		return self::$con->query($sql);
	}

	public static function doit($sql){
		if(Core::$debug_sql){
			print "<pre>".$sql."</pre>";
		}
		return array(self::$con->query($sql),self::$con->insert_id);
	}

	public static function hasRow($con){		
		return $con->num_rows;
	}	

	public static function initT(){		
		self::$con->begin_transaction();
	}

	public static function commit(){
		self::$con->commit();
	}
	public static function rollback(){
		self::$con->rollback();
	}

	public static function closeCon(){
		self::$con = null;
		Database::closeCon();
	}
}
?>