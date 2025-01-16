<?php
Session::isLogin();

$data = SellData::getAllSells($_POST['fechainicio'],$_POST['fechafinal']);
echo '&nbsp;<strong>Total de registro encontrados: </strong> '.count($data).'</br></br>';
?>

<div class="table-responsive">
<table id="get-all" class="table table-striped table-bordered table-hover table-sm" >
    <thead class="table-dark">
        <tr>
            <th> Ver </th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Total Venta</th>
            <th>Fecha</th>
            <th>Accion</th>
        </tr>    
    </thead>      
    <tbody>
    <?php
     $total_c = 0;
     $total_d = 0;
        foreach($data as $v){
            $productos = json_decode($v['json']);
            $table = '<table class="table" style="border: 0px;background: white !important;" border="0"><tbody>';
            foreach ($productos as $p) {
                $table .= '<tr><td><strong>'.$p->codigo.'</strong>   '.$p->nombre.' <br> '.$p->q.' x C$ '.number_format(floatval($p->precio_c),2,'.',',').' = C$ '.number_format((floatval($p->precio_c) * intval($p->q)),2,'.',',')    .'<br> '.$p->q.' x $ '.number_format(floatval($p->precio_d),2,'.',',').' = $ '.number_format((floatval($p->precio_d) * intval($p->q)),2,'.',',').'</td><tr>';
            } 
            $table .= '</tbody></table>';


            echo '<tr>';
            echo '<td><button type="button" class="btn  btn-info text-white btn-xs" onclick="verDetalleVenta('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom-in"></use></svg></button>&nbsp;&nbsp;</td>';  
            echo '<td>'.$table.'</td>';
            echo '<td>'.$v['cliente'].'</td>';
            echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($v['total_c']),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format(floatval($v['total_d']),2,'.',',') .'</span></td>';
            echo '<td>'.$v['fecha'].'</td>';
            echo '<td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteVenta('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button></td>';
            echo '</tr>';
            $total_c += floatval($v['total_c']);
            $total_d += floatval($v['total_d']);
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