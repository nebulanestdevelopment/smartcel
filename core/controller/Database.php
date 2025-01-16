<?php
class Database {
	public static $db;
	public static $con;
	private $user;
	private $ddbb;
	private $host;
	private $pass;

	public function __construct() {
		$this->user="root";$this->pass="toor";$this->host="localhost";$this->ddbb="scw";
	}
	function Database(){
		$this->user="root";$this->pass="toor";$this->host="localhost";$this->ddbb="scw";
	}

	function connect(){
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		$con->query("set sql_mode=''");
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}

	public static function closeCon(){
		if(self::$con!=null && self::$db!=null){
			 self::$con->close();
			 self::$con=null;
			 self::$db=null;
			 
		}
	}
	
}
?>
