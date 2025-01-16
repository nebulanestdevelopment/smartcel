
<?php  
    if(isset($_GET['id']) && intval($_GET['id']) && $_GET['id'] !=0){
        $boxes_details = SellData::getBoxDetailswithProducts($_GET['id']);
        $total_descuento = SellData::getSumaDescuentoenVentas($_GET['id']) ;
    }
?>


<div class="card">
    <div class="card-header">
        <h4>Detalle de Caja # <?php echo $_GET['id'];?></h4>
    </div>
    <div class="card-body">
            <table class="table">
                <thead>
                    <tr class="bg-danger">
                        <th>Item</th>
                        <th>Fecha</th>
                        <th class="text-center text-bold">Cantidad</th>
                        <th>Articulo</th>
                        <th>Precio Unit</th> 
                        <th>Precio</th>  
                        <th>Descuento</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $general_c =0;
                    $general_d =0;
                    $neto_c =0;
                    $neto_d =0;
                    $desc_c =0;
                    $desc_d =0;
                    $total_a = 0;
                    $total_ac = 0;
                    $total_c = 0;
                    $total_r = 0;
                    $total_a_c = 0;
                    $total_ac_c = 0;
                    $total_c_c = 0;
                    $total_r_c = 0;
                    $total_a_d = 0;
                    $total_ac_d = 0;
                    $total_c_d = 0;
                    $total_r_d = 0;
                    foreach ($boxes_details as $i => $bd) {
                        
                        $precio_c = floatval($bd->precio_c) + floatval($bd->precio_es_c) ;
                        $precio_d = floatval($bd->precio_d) + floatval($bd->precio_es_d) ;
                        $sub_c = floatval($precio_c * intval($bd->q)) - floatval($bd->desco_c) ;
                        $sub_d = floatval($precio_d * intval($bd->q)) - floatval($bd->desco_d) ;
                        $general_c +=$sub_c;
                        $general_d +=$sub_d;
                        $neto_c +=floatval($precio_c * intval($bd->q));
                        $neto_d +=floatval($precio_d * intval($bd->q));
                        $desc_c +=floatval($bd->desco_c);
                        $desc_d +=floatval($bd->desco_d);
                        $is_esp = (floatval($bd->precio_es_c) > 0)?"<br><small>Precio Especial</small>":"";
                        
                        
                        switch ($bd->type) {
                            case '1':
                                $total_a += 1;//$bd->q;
                                $total_a_c += floatval($sub_c);
                                $total_a_d += floatval($sub_d);
                                break;
                            case '2':
                                $total_c += 1;//$bd->q;
                                $total_c_c += floatval($sub_c);
                                $total_c_d += floatval($sub_d);
                                break; 
                            case '3':
                                $total_r += 1;//$bd->q;
                                $total_r_c += floatval($sub_c);
                                $total_r_d += floatval($sub_d);
                                break;
                            case '4':
                                $total_ac += 1;//$bd->q;
                                $total_ac_c += floatval($sub_c);
                                $total_ac_d += floatval($sub_d);
                                break;
                            default:
                                # code...
                                break;
                        }
                        
                        
                        echo '<tr>';
                        echo '<td>'.  ($i+1) .'</td>';
                        echo '<td>'. $bd->date .'</td>';
                        echo '<td class="text-center text-bold">'. $bd->q .'</td>';
                        echo '<td>'. $bd->name .'</td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($precio_c),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format(floatval($precio_d),2,'.',',') .'</span>'. $is_esp .'</td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($precio_c * intval($bd->q)),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format(floatval($precio_d * intval($bd->q)),2,'.',',') .'</span></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($bd->desco_c),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format(floatval($bd->desco_d),2,'.',',') .'</td>';
                        echo '<td style="text-align: right;"><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($sub_c,2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format($sub_d,2,'.',',') .'</td>';
                        echo '</tr>';
                    }


                ?>
                </tbody>
            </table>
            
            

           
            
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
    <table class="table table-bordered">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>Total Neto</th>
                        <th>Total Descuento</th>
                        <th >Total General</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    echo '<tr>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($neto_c),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format(floatval($neto_d),2,'.',',') .'</span></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($desc_c ),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format(floatval($desc_d),2,'.',',') .'</span></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($general_c),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format(floatval($general_d),2,'.',',') .'</td>';
                    echo '</tr>';
                ?>
                </tbody>
            </table>
    </div>
</div> 

<br>
<div class="card">
    <div class="card-body">
    <table class="table table-bordered">
                
                <tbody>
                <?php
              //  echo '<tr><td class="text-center">Unidades</td><td>Producto</td><td>Total</td></tr>';
                    echo '<tr>';
                        echo '<td class="text-center">'.$total_a.'</td>';
                        echo '<td><strong>Accesorios</strong></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($total_a_c,2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format($total_a_d,2,'.',',') .'</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td class="text-center">'.$total_c.'</td>';
                        echo '<td><strong> Celulares</strong></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($total_c_c,2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format($total_c_d,2,'.',',') .'</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td class="text-center">'.$total_r.'</td>';
                        echo '<td><strong>Repuestos</strong></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($total_r_c,2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format($total_r_d,2,'.',',') .'</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td class="text-center">'.$total_ac.'</td>';
                        echo '<td><strong>Accesorios de Autos</strong></td>';
                        echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($total_ac_c,2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success"> $ '. number_format($total_ac_d,2,'.',',') .'</td>';
                    echo '</tr>';
                ?>
                </tbody>
            </table>
    </div>
</div> 

                </br>
                <a href="index.php?view=caja/historial-caja" class="btn btn-primary">Regresar a Historial de Cajas</a>
                </br></br>