<?php 

Session::isLogin();


if(isset($_POST)){
    if(isset($_POST['method']) && $_POST['method'] == "delete-item"){

        if(isset($_SESSION['reabastecer'])){
            unset($_SESSION['reabastecer'][$_POST['index']]);
        }
        exit;    
    }else if(isset($_POST['method']) && $_POST['method'] == "clear-cart"){

        if(isset($_SESSION['reabastecer'])){
            unset($_SESSION['reabastecer']);
        }
        exit;    
    }   
}
exit;

?>