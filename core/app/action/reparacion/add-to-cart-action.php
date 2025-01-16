<?php 

Session::isLogin();

if(isset($_POST)){
    
        $cart = [
            'product_id'=> filter_var($_POST['product_id'], FILTER_VALIDATE_INT),
            'q'=> filter_var($_POST['q'], FILTER_VALIDATE_INT),            
            'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
            'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT), 
            'desc_c' => filter_var($_POST['desc_c'], FILTER_VALIDATE_FLOAT),
            'desc_d' => filter_var($_POST['desc_d'], FILTER_VALIDATE_FLOAT)
    ];
    ReparacionData::addToCart($cart);
    exit;
}
exit;
?>