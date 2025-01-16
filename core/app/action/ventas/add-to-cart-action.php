<?php 

Session::isLogin();

if(isset($_POST)){
    
        $cart = [
            'product_id'=> filter_var($_POST['product_id'], FILTER_VALIDATE_INT),
            'q'=> filter_var($_POST['q'], FILTER_VALIDATE_INT),            
            'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
            'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT),            
            'is_esp' => $_POST['is_esp'],  
            'pec' => filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT),
            'ped' => filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT),
            'desc_c' => filter_var($_POST['desc_c'], FILTER_VALIDATE_FLOAT),
            'desc_d' => filter_var($_POST['desc_d'], FILTER_VALIDATE_FLOAT)
    ];
    SellData::addToCart($cart);
    exit;
}
exit;
?>