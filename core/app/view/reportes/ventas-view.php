<?php
$clientes = ClienteData::getAll();

$tipo = 0;
$categoria = 0;
$inicial = 0;
$final = 0;
$data = [];


if(isset($_GET['tipo'])){
    $tipo    = $_GET['tipo'];
    $cliente =  $_GET['cliente'];
    $inicial =  $_GET['inicial'];
    $final   = $_GET['final'];
    $data    = ReportesData::getVentas($tipo,$inicial,$final,2,1,$cliente,'','');
}else if(isset($_GET['mesactual'])){

}
 
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">
            Reporte de Ventas
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-4">
                    <span class="badge text-bg-primary">1) Seleccionar tipo de Inventario:</span>
</br></br>
            <select class="form-select" aria-label="Default select example" id="tipo" name="tipo">
                <option selected value="0">Seleccionar Inventario</option>
                <option value="1" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 1 )?"selected":" ";?> >Accesorios</option>
                <option value="4" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 4 )?"selected":" ";?> >Accesorios de Autos</option>
                <option value="2" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 2 )?"selected":" ";?> >Celulares</option>
                <option value="3" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == 3 )?"selected":" ";?> >Repuestos</option>
          
            </select>



            </div>
            <div class="col-sm-4">
            <span class="badge text-bg-primary">2) Seleccionar cliente:</span>
            </br></br>  
          
            <select class="form-select" aria-label="Default select example" id="cliente" name="cliente">
                <option selected value="0">Seleccionar cliente</option>
                <?php 
                    foreach ($clientes as $v) {
                        $selected = (isset($_GET["cliente"]) && $_GET["cliente"] == $v['id'] )?"selected":" ";
                        echo '<option value="'.$v['id'].'" '.$selected.'>'.$v['name'].' '.$v['lastname'].'</option>';
                    }               
                ?>
            </select>
</br>            
            </div>
            <div class="col-sm-4">
            <span class="badge text-bg-primary">3) Seleccionar rango de fecha:</span>
            </br></br>  
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">Fecha inicial:</label>
                          <input type="date" class="form-control" id="inicial" name="inicial" value="<?php echo isset($_GET["inicial"])?$_GET["inicial"]:" "; ?>">
                        </div>
                    </div>
                    <div class="col-12">
                       <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">Fecha final</label>
                          <input type="date" class="form-control" id="final" name="final" value="<?php echo isset($_GET["final"])?$_GET["final"]:" "; ?>">
                        </div>
                    </div>
                    <div class="col-12">
                            <button type="button" class="btn btn-success btn-md text-white" id="btn-procesar">Processar</button>&nbsp;&nbsp;
                            <a href="./index.php?view=reportes/ventas" type="button" class="btn btn-outline-secondary">Limpiar busqueda</a>
                        </div>
                        
                </div>
            </div>

        </div>
                    <hr>
        <div class="section">
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="example">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th></th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Comprado por</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_aa = 0;
                        $total_aa_d = 0;
                        $total_aa_g = 0;
                        $total_a = 0;
                        $total_a_d = 0;
                        $total_a_g = 0;
                        $total_c = 0;
                        $total_c_d = 0;
                        $total_c_g = 0;  
                        $total_r = 0;
                        $total_r_d = 0;
                        $total_r_g = 0;  

                        $total_total = 0;
                        $total_ganancia = 0;
                        $total_descuento = 0;
                            foreach($data as $r){


                                $subtotal = (floatval($r['discount']) > 0)?floatval($r['price_out']) : floatval($r['total']) / floatval($r['q']) ;
                                $subtotal_print =  (intval($r['price_out_es']) == intval($subtotal))? 'C$ '.number_format(floatval($r['price_out_es']),2,'.',',') : 'C$ '.number_format(floatval($subtotal),2,'.',','); 
                                $subtotal =  (intval($r['price_out_es']) == intval($subtotal))? floatval($r['price_out_es']) : floatval($subtotal);
                                $descuento = (intval($r['descuento']) > 0)?floatval($r['descuento']):0;
                                $descuento_print = 'C$ '.number_format(floatval($descuento),2,'.',',');
                             
                                $total = (intval($r['q']) * floatval($subtotal)) - floatval($descuento);
                                $ganancia =  floatval($total) - (intval($r['q']) * floatval($r['price_in']));
                                

                                $total_total += floatval(round($total,2));
                                $total_ganancia += floatval(round($ganancia,2));
                                $total_descuento += floatval(round($descuento,2));

$color = " ";
                                         
if($r['type'] == 1){
    $total_a += floatval($total);
    $total_a_d += floatval($descuento);
    $total_a_g += floatval($ganancia);
    $color = 'rgba(249, 177, 21, 0.50) !important';  
  }
  
  if($r['type'] == 2){
    $total_c += floatval($total);
    $total_c_d += floatval($descuento);
    $total_c_g += floatval($ganancia);
    $color = 'rgba(51, 153, 255, 0.50) !important';  
  }
  
  if($r['type'] == 3){
    $total_r += floatval($total);
    $total_r_d += floatval($descuento);
    $total_r_g += floatval($ganancia);   
    $color = 'rgba(46, 184, 92, 0.50) !important';  
  } 

  if($r['type'] == 4){
    $total_aa += floatval($total);
    $total_aad += floatval($descuento);
    $total_aa_g += floatval($ganancia);
    $color = 'rgba(50, 31, 219, 0.50) !important';  
  }


	$cliente = "";
	$cliente .= (isset(ClienteData::getById($r['person_id'])['name']))?(new ClienteData)->getById($r['person_id'])['name']:" ";
	$cliente .= (isset(ClienteData::getById($r['person_id'])['lastname']))?(new ClienteData)->getById($r['person_id'])['lastname']:" ";
   
                              
                                echo '<tr style=" background-color:'.$color.'">';
                                echo '<td><a type="button" class="btn  btn-warning text-white btn-xs" href="./index.php?view=ventas/historial-detalle&id='.$r['id'].'"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-magnifying-glass"></use></svg></a></td>';
                                echo '<td>'. ProductoData::getProductCode($r['id_pro']) .'</td>';
                                echo '<td>'. ProductoData::getProductName($r['id_pro']) .'</td>';
                                echo '<td class="text-center">'. $r['q'].'</td>';
                                echo '<td class="text-center">'. $subtotal_print .'</td>';
                                echo '<td class="text-center">'. $descuento_print .'</td>';
                                echo '<td class="text-center">C$ '.number_format(floatval($total),2,'.',',').'</td>';
                                echo '<td class="text-center">'. $cliente .'</td>';
                                echo '<td>'.date('d/m/Y H:m a', strtotime($r['created_at'])).'</td>';
                                echo '</tr>';
                            }                     
                        ?>
                    </tbody>
                </table>
                <br><br><br>
                <?php 
                   if(count($data) > 0 ){
                        echo '<h4>Resumen de ventas del '.date('d/m/Y', strtotime($_GET['inicial'])).' hasta '.date('d/m/Y', strtotime($_GET['final'])).'</h4>';
                        echo '<table class="table table-bordered">';
                        echo '<thead><tr><td></td><td>Total</td><td>Ganancia</td><td>Descuento</td></tr></thead>';
                        echo '<tbody>';
                            echo '<tr style="background-color:rgba(249, 177, 21, 0.50) !important;">';
                                echo '<td>Accesorios </td>';  
                                echo '<td>C$ '.number_format($total_a,2,'.',',').'</td>'; 
                                echo '<td>C$ '.number_format($total_a_g,2,'.',',').'</td>';  
                                echo '<td>C$ '.number_format($total_a_d,2,'.',',').'</td>'; 
                            echo '</tr>';
                            echo '<tr style="background-color:rgba(51, 153, 255, 0.50) !important">';
                                echo '<td>Accesorios de Autos </td>';  
                                echo '<td>C$ '.number_format($total_aa,2,'.',',').'</td>'; 
                                echo '<td>C$ '.number_format($total_aa_g,2,'.',',').'</td>';  
                                echo '<td>C$ '.number_format($total_aa_d,2,'.',',').'</td>'; 
                            echo '</tr>';
                            echo '<tr style="background-color:rgba(46, 184, 92, 0.50) !important">';
                                echo '<td>Celulares  </td>';  
                                echo '<td>C$ '.number_format($total_c,2,'.',',').'</td>'; 
                                echo '<td>C$ '.number_format($total_c_g,2,'.',',').'</td>';  
                                echo '<td>C$ '.number_format($total_c_d,2,'.',',').'</td>';  
                            echo '</tr>';
                            echo '<tr style="background-color:rgba(50, 31, 219, 0.50) !important">';
                                echo '<td>Repuestos  </td>';  
                                echo '<td>C$ '.number_format($total_r,2,'.',',').'</td>'; 
                                echo '<td>C$ '.number_format($total_r_g,2,'.',',').'</td>';  
                                echo '<td>C$ '.number_format($total_r_d,2,'.',',').'</td>'; 
                            echo '</tr>';
                        echo '</tbody>';
                        echo '<tfoot>';
                        echo '<tr>';
                                echo '<td></td>';  
                                echo '<td><strong>C$ '.number_format(floatval($total_total),2,'.',',').'</strong></td>'; 
                                echo '<td><strong>C$ '.number_format(floatval($total_ganancia),2,'.',',').'</strong></td>';  
                                echo '<td><strong>C$ '.number_format(floatval($total_descuento),2,'.',',').'</strong></td>'; 
                            echo '</tr>';
                        echo '</tfoot>';
                        echo '</table>';
                    }              
                ?>

            </div>

        </div>
        
    </div><!-- card-body -->
</div>

<link rel="stylesheet" href="./vendors/datatable/dataTables.dataTables.css">
<link rel="stylesheet" href="./vendors/datatable/buttons.dataTables.css">

<script src="./vendors/datatable/jquery-3.7.1.js"></script>
<script src="./vendors/datatable/datatables.js"></script>
<script src="./vendors/datatable/dataTables.buttons.min.js"></script>
<script src="./vendors/datatable/jszip.min.js"></script>
<script src="./vendors/datatable/pdfmake.min.js"></script>
<script src="./vendors/datatable/vfs_fonts.js"></script>
<script src="./vendors/datatable/buttons.html5.min.js"></script>
<script src="./vendors/datatable/buttons.print.min.js"></script>

<script >
    $("#btn-procesar").on('click',function(e){
        e.preventDefault();

        var tipo = $("#tipo").find(':selected').val(); 
        var cliente   = $("#cliente").find(':selected').val();  
        var inicial = $("#inicial").val(); 
        var final   = $("#final").val();  

        if(inicial.trim() == "" || final.trim() ==""){
            alert("Debe seleccinar una fecha de inicio y una final para generar el reporte");
            return false;
        }
         window.location.href = "./index.php?view=reportes/ventas&tipo="+tipo+"&cliente="+cliente+"&inicial="+inicial+"&final="+final;
    });


    $(document).ready(function() {
   
        new DataTable('#example', {
                    
                
            select: {
                style: 'os',
                selector: 'td:first-child'
            }, 
            language: {
                    url: './vendors/datatable/es-ES.json'
                },
            layout: {
                bottomStart: {
                    buttons: ['csv', 'excel', 'pdf', 'print']
                }
            }
                } );
    });
</script>
