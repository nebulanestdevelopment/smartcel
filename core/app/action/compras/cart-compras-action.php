<?php
Session::isLogin();

if(!isset($_SESSION["reabastecer"])){
?>    
    <table class="table table-bordered table-hover">
    <thead style="background-color: #4e555a;color: #fff;">
        <th>Codigo</th>
        <th width="32%">Producto</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Precio Especial</th>
        <th>Precio Venta</th>
        <th>Costo Total</th>
        <th style="width:10px;"></th>
    </thead>
</table>
<?php
}else{
?>
<table class="table table-bordered table-hover">
    <thead style="background-color: #4e555a;color: #fff;">
        <th>Codigo</th>
        <th width="30%">Producto</th>
        <th>Cantidad</th>
        <th width="15%">Precio Compra</th>
        <th width="15%" >Precio Especial</th>
        <th width="15%">Precio Venta</th>
        <th width="15%">Costo Total</th>
        <th style="width:10px;"></th>
    </thead>
    <tbody>
    <?php
    $productos = $_SESSION['reabastecer'];
    foreach($productos as $k => $v){  
        
    $code = ProductoData::getProductCode($v['product_id']);    
    $name = ProductoData::getProductName($v['product_id']);   
    $q = $v['q'];    
    $totalc = floatval($v['pcc']) * intval($q);
    $totald = floatval($v['pcd']) * intval($q);
    ?>

        <tr>
            <td><?php echo $code ?></td>
            <td><?php echo $name ?></td>
            <td class="text-center fo"><?php echo $q ?></td>
            <td class="text-end"><?php echo 'C$ '.number_format($v['pcc'],2,'.',',') ?><br><?php echo ' $ '.number_format($v['pcd'],2,'.',',') ?></td> 
            <td class="text-end"><?php echo 'C$ '.number_format($v['pec'],2,'.',',') ?><br><?php echo ' $ '.number_format($v['ped'],2,'.',',') ?></td> 
            <td class="text-end"><?php echo 'C$ '.number_format($v['pvc'],2,'.',',') ?><br><?php echo ' $ '.number_format($v['pvd'],2,'.',',') ?></td> 
            <td class="text-end"><?php echo 'C$ '.number_format($totalc,2,'.',',') ?><br><?php echo ' $ '.number_format($totald,2,'.',',') ?></td> 
            <td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteItemFromCart(<?php echo $k ?>)"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button></td>  
        </tr>    
    <?php } ?>
    </tbody>
</table>
<?php

}







?>