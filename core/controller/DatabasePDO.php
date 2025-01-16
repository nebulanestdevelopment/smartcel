<?php
class DatabasePDO {
	public static $db;
	public static $con;
	private $user;
	private $ddbb;
	private $host;
	private $pass;

	public function __construct() {
		$this->user="root";$this->pass="toor";$this->host="localhost";$this->ddbb="scw";
	}
	function DatabasePDO(){
		$this->user="root";$this->pass="toor";$this->host="localhost";$this->ddbb="scw";
	}

	function connect(){
		$con = new PDO('mysql:host='.$this->host.';dbname='.$this->ddbb, $this->user, $this->pass,array(PDO::ATTR_PERSISTENT => true));
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new DatabasePDO();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}

	public static function closeCon(){
		if(self::$con!=null && self::$db!=null){
			 self::$con=null;
			 self::$db=null;
		}
	}
	
}
?>
