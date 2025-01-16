<?php
Session::isLogin();

$data = SellData::getAllSellsType($_POST['type']);
echo '&nbsp;<strong>Total de registro encontrados: </strong> '.count($data).'</br></br>';
$tipo = array("","Accesorio ","Celulares ","Repuestos ","Accesorios de Autos ");
?>

<div class="table-responsive">
<table id="get-all" class="table table-striped table-bordered table-hover table-sm" >
    <thead class="table-dark">
        <tr>
            <th>Ver</th>
            <th><?php  echo $tipo[$_POST['type']]; ?> Vendidos </th>
            <th>Precio</th>
            <th>Descuento</th>
            <th>Total</th>
            <th>Fecha de venta</th>
        </tr>    
    </thead>      
    <tbody>
    <?php
    $total_c = 0;
    $total_d = 0;
        foreach($data as $p){
                echo '<tr>';
                echo '<td><button type="button" class="btn  btn-info text-white btn-xs" onclick="verDetalleVenta('.$p['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom-in"></use></svg></button>&nbsp;&nbsp;</td>';  
                echo '<td><strong>'.$p['codigo'].'</strong>   '.$p['nombre'].' </td>';
                if($p['is_esp'] == "Si"){
                    echo '<td><small> '.$p['q'].' x C$ '.number_format((floatval($p['precio_c'])+ floatval($p['esp_c'])),2,'.',',').' = C$ '.number_format(((floatval($p['precio_c'])+ floatval($p['esp_c'])) * intval($p['q'])),2,'.',',').'</small></br><small> '.$p['q'].' x $ '.number_format((floatval($p['precio_d'])+ floatval($p['esp_d'])),2,'.',',') .' = $ '.number_format(( (floatval($p['precio_d'])+ floatval($p['esp_d'])) * intval($p['q'])),2,'.',',').' </small> </br> <small>Es precio especial</small></td>';
                }else{
                    echo '<td><small> '.$p['q'].' x C$ '.number_format(floatval($p['precio_c']),2,'.',',').' = C$ '.number_format((floatval($p['precio_c']) * intval($p['q'])),2,'.',',').'</small></br><small> '.$p['q'].' x $ '.number_format(floatval($p['precio_d']),2,'.',',') .' = $ '.number_format((floatval($p['precio_d']) * intval($p['q'])),2,'.',',').' </small> </td>';
                }
                echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($p['desc_c']),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format(floatval($p['desc_d']),2,'.',',') .'</span></td>';
                echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($p['total_c']),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format(floatval($p['total_d']),2,'.',',') .'</span></td>';
                echo '<td>'.$p['fecha'].'</td>';
                echo '</tr>';
                $total_c += floatval($p['total_c']);
                $total_d += floatval($p['total_d']);

            }             
        
    ?>
    </tbody>
</table>
</div>
<table class="table" style="width:100%;">
                <thead><tr>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Ingresos Generados en Cordobas (C$)</th>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Ingresos Generados en Dolares ($)</th>
                </tr></thead>
                <tbody>
                    <tr>
                        <td class="text-center"><span class="cordoba moneda"><?php echo number_format($total_c,2,'.',','); ?></span></td>
                        <td class="text-center"><span class="dolar  moneda"><?php echo number_format($total_d,2,'.',','); ?></span></td>
                    </tr>
                </tbody>
              </table>