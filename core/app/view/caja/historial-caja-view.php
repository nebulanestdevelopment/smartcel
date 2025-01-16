<div class="card">

    <div class="card-header">
    <?php

if(isset($_GET['clearbox']) && $_GET['clearbox'] == 1){
    $resultado = SellData::delboxvacias();
if($resultado){
    echo '<br><p class="alert alert-success">Las Cajas Vacías han sido Eliminadas!!!...</p><a class="btn btn-danger" href="./index.php?view=caja/historial-caja">Refrescar</a></br>';
}

}

?>
<h4 class="mt-3"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-briefcase"></use></svg>  Historial de Caja      <a href="./index.php?view=caja/historial-caja&clearbox=1" title="Eliminar Cajas Vacias"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-reload"></use></svg></a> </h4>
<div class="clearfix"></div>
    </div>
    <div class="card-body">

<?php
        $boxes = BoxData::getAll();
        
?>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th class="text-uppecase text-bold">
                    Caja Cerrada del Dia
                </th>
                <th class="text-uppecase text-bold">
                    Total
                </th>
                <th class="text-uppecase text-bold">
                    Fecha de Venta
                </th>
                <th>

                </th>
            </tr>
        </thead>
        <tbody> 
<?php
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $totales_c=0;
    $totales_d=0;    
    foreach($boxes as $k => $v) {
        $dia = date('w',strtotime($v->created_at) );
        $mes = date('n',strtotime($v->created_at) );
        $sells = BoxData::getByBoxIdTotal($v->id);
$total_c = 0;
$total_d = 0;
		foreach($sells as $sell){
        $total_c += floatval($sell->total_c) - floatval($sell->desc_c);
        $total_d += floatval($sell->total_d) - floatval($sell->desc_d);
		}
        $totales_c += $total_c;
        $totales_d += $total_d;
       echo'<tr>';
                echo'<td><a type="button" class="btn  btn-info text-white btn-xs" href="./index.php?view=caja/detail&id='.$v->id.'"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-right"></use></svg></a></td>';

                echo'<td style="text-transform:uppercase;">'.$dias[$dia].', '.date('d',strtotime($v->created_at) ).' DE '.$meses[$mes].' DEL '.date('Y',strtotime($v->created_at) ).' '.date('h:m a',strtotime($v->created_at) ).'</td>';
                echo'<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($total_c),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format(floatval($total_d),2,'.',',') .'</span></td>';
                echo'<td>'.date('d/m/Y',strtotime($v->created_at) ).'</td>';
                if(Roles::hasAdmin()) {
                    echo'<td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="revertirCaja('.$v->id.')">revertir caja</button></td>';
                }else{echo'<td> *-* </td>';}
                echo'</tr>';
       }
?>
        </tbody>
    </table>

    <table class="table" style="width:100%;">
                <thead><tr>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Ingresos Generados en Cordobas (C$)</th>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Ingresos Generados en Dolares ($)</th>
                </tr></thead>
                <tbody>
                    <tr>
                        <td class="text-center"><span class="cordoba moneda"><?php echo number_format($totales_c,2,'.',','); ?></span></td>
                        <td class="text-center"><span class="dolar  moneda"><?php echo number_format($totales_d,2,'.',','); ?></span></td>
                    </tr>
                </tbody>
              </table>


    </div>
</div>

<?php if(Roles::hasAdmin()) {?>
    
<script src="./vendors/datatable/jquery.js"></script>
<script type="text/javascript">

function revertirCaja(id){
  if (confirm('Esta seguro que desea revertir este registro de caja') == true) {
     window.location.href =  "./index.php?action=caja/modificar-caja&id="+id;         
  } 
}


$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>
<?php } ?>
