<?php
Session::isLogin();
$sells = SellData::getAllSells();

if(count($sells) > 0){
    $box = intval($_GET['id']);
    $success = false;
    foreach ($sells as  $sell) {
        
        $upd_sell = new  SellData();
        $upd_sell->id = $sell['id'];
        $upd_sell->box_id = $box;        
        $code = $upd_sell->revertirCaja();
        $success=$code['code'];
    }
    if($success){
        header("Location: ./index.php?view=caja/detail&id=".intval($box));
    }else{
        header("Location: ./index.php?view=caja/historial");
    }
}else{
   header("Location: ./index.php?view=caja/historial");
}
?>
