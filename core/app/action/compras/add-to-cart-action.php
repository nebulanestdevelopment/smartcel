<?php 

Session::isLogin();

if(isset($_POST)){

        $cart = [
            'product_id'=> filter_var($_POST['product_id'], FILTER_VALIDATE_INT),
            'q'=> filter_var($_POST['q'], FILTER_VALIDATE_INT),
            'pcc' => filter_var($_POST['compra_c'], FILTER_VALIDATE_FLOAT),
            'pcd' => filter_var($_POST['compra_d'], FILTER_VALIDATE_FLOAT),
            'pvc' => filter_var($_POST['venta_c'], FILTER_VALIDATE_FLOAT),
            'pvd' => filter_var($_POST['venta_d'], FILTER_VALIDATE_FLOAT),
            'pec' => filter_var($_POST['esp_c'], FILTER_VALIDATE_FLOAT),
            'ped' => filter_var($_POST['esp_d'], FILTER_VALIDATE_FLOAT)
    ];
    ComprasData::addToCart($cart);
    exit;
}
exit;
?>