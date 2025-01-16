<?php
Session::isLogin();
 
    $revertirventas =  BoxData::RevertirCaja($_GET["id"]);
	
    if($revertirventas['code']){
      //  $cajaencontrada = BoxData::getById($_GET["id"]);  
        header("Location: ./index.php?view=caja/historial");
    }else{
        header("Location: ./index.php?view=caja/historial-caja");
    }
	
?>
