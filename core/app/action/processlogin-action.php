<?php

// define('LBROOT',getcwd()); // LegoBox Root ... the server root
// include("core/controller/Database.php");


if(!isset($_SESSION["user_id"])) {
		$user = $_POST['username'];
		$pass = sha1(md5($_POST['password']));
		Executor::initCon();
		try {
			$sql = "select id from user where username=? and password=? and is_active=1 ;";
			ExecutorPDO::initCon();
			ExecutorPDO::initPreparate($sql);
			ExecutorPDO::executeParams(array($user,$pass));
			$found = false;
			$userid = null;
				foreach  (ExecutorPDO::fetchAll()  as $row) {
					$found = true ;
					$userid = $row['id'];
				}
			if($found==true) {
				ExecutorPDO::closeCon();
				$_SESSION['user_id']=$userid ;
				setcookie('userid',$userid);
				print "<script>window.location='index.php?view=home';</script>";
			}else {
				ExecutorPDO::closeCon();
				print "<script>window.location='index.php?view=login';</script>";
			}	
		} catch (\Throwable $th) {
			//throw $th;
		}
	}else{
		print "<script>window.location='index.php?view=home';</script>";
	}


?>