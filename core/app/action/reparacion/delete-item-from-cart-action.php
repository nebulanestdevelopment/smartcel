<?php 

Session::isLogin();


if(isset($_POST)){
    if(isset($_POST['method']) && $_POST['method'] == "delete-item"){

        if(isset($_SESSION['cart-repair'])){
            unset($_SESSION['cart-repair'][$_POST['index']]);
        }
        exit;    
    }else if(isset($_POST['method']) && $_POST['method'] == "clear-cart"){

        if(isset($_SESSION['cart-repair'])){
            unset($_SESSION['cart-repair']);
        }
        exit;    
    }   
}
exit;

?>