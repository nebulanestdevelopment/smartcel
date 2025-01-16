<?php
Session::isLogin();

if(!isset($_SESSION["cart"])){
?>    
    <table class="table table-bordered table-hover">
    <thead style="background-color: #4e555a;color: #fff;">
        <th>Codigo</th>
        <th width="32%">Producto</th>
        <th>Cantidad</th>
        <th>Precio Lista</th>
        <th>Precio Especial</th>
        <th>Descuento Aplicado</th>
        <th>Precio Total</th>
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
        <th width="15%">Precio Lista</th>
        <th width="10%" >Precio Aplicado</th>
        <th width="15%">Descuento Aplicado</th>
        <th width="15%">Precio Total</th>
        <th style="width:10px;"></th>
    </thead>
    <tbody>
    <?php
    $productos = $_SESSION['cart'];
    foreach($productos as $k => $v){  
        
    $code = ProductoData::getProductCode($v['product_id']);    
    $name = ProductoData::getProductName($v['product_id']);   
    $q = $v['q'];  
    $color = ($v['is_esp'] == "true")?'style="color:red;"':'style="color:green;"'; 
    $precio_c = ($v['is_esp'] == "true")?$v['pec']:$v['pvc'];
    $precio_d = ($v['is_esp'] == "true")?$v['ped']:$v['pvd'];
    $totalc = (floatval($precio_c) * intval($q)) - floatval($v['desc_c']) ;
    $totald = (floatval($precio_d)  * intval($q)) - floatval($v['desc_d'])  ;
    ?>

        <tr>
            <td><?php echo $code  ?></td>
            <td><?php echo $name ?></td>
            <td class="text-center fo"><?php echo $q ?></td>
            <td class="text-end"><?php echo 'C$ '.number_format($v['pvc'],2,'.',',') ?><br><?php echo ' $ '.number_format($v['pvd'],2,'.',',') ?></td> 
            <td class="text-end" <?php echo $color; ?> ><?php echo 'C$ '.number_format($precio_c,2,'.',',') ?><br><?php echo ' $ '.number_format($precio_d,2,'.',','); if($v['is_esp'] == "true"){ echo '<br><span style="font-size:12px;color:black;">Precio Especial</span>'; } ?></td> 
            <td class="text-end"><?php echo 'C$ '.number_format($v['desc_c'],2,'.',',') ?><br><?php echo ' $ '.number_format($v['desc_d'],2,'.',',') ?></td> 
            <td class="text-end"><?php echo 'C$ '.number_format($totalc,2,'.',',') ?><br><?php echo ' $ '.number_format($totald,2,'.',',') ?></td> 
            <td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteItemFromCart(<?php echo $k ?>)"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button></td>  
        </tr>    
    <?php } ?>
    </tbody>
</table>
<?php

}







?>