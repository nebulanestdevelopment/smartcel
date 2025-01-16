<?php
$clientes = ClienteData::getAll();

$tipo = 0;
$categoria = 0;
$inicial = 0;
$final = 0;
$data = [];


if(isset($_GET['tipo']) && intval($_GET['tipo']) > 0){
    $tipo    = $_GET['tipo'];
    $inicial =  $_GET['inicial'];
    $final   = $_GET['final'];
    $data    = ReportesData::getAllGanancias($tipo,$inicial,$final);
}
 

?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">
         Reporte de Ganancia Proyectada
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
            <span class="badge text-bg-primary">2) Seleccionar rango de fecha:</span>
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
                    <div class="col-12 mt-4">
                            <button type="button" class="btn btn-success btn-md text-white" id="btn-procesar">Processar</button>&nbsp;&nbsp;
                         
                            <a href="./index.php?view=reportes/ganancias" type="button" class="btn btn-outline-secondary">Limpiar busqueda</a>
                    </div>
                        
                </div>
</br>            
            </div>
         
        </div>
                    <hr>
        <div class="section">
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="example">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Código</th>
                            <th>Articulo</th>
                            <th>Qty</th>
                            <th>Costo Unitario</th>
                            <th>Costo Total</th>
                            <th>Precio Unitario</th>
                            <th>Descuento</th>
                            <th>Total Venta</th>
                            <th>Ganancia</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                       
                        $costo_total = 0;
                        $total_total = 0;
                        $total_ganancia = 0;
                        $ganancia_total_c = 0;
                        $ganancia_total_d = 0;                  
                            foreach($data as $r){


                                $costo_tc = intval($r['q']) * floatval($r['price_in']);
                                $costo_td = intval($r['q']) * floatval($r['price_in_d']);
                                $precio_c = floatval($r['price_out']) + floatval($r['price_out_es']);
                                $precio_d = floatval($r['price_out_d']) + floatval($r['price_out_es_d']);
                                $precio_tc = (intval($r['q']) * $precio_c) -  floatval($r['discount']);
                                $precio_td = (intval($r['q']) * $precio_d) -  floatval($r['discount_d']);
                                $gain_c = floatval($precio_tc) -  floatval($costo_tc);
                                $gain_d = floatval($precio_td) -  floatval($costo_td);

                                $ganancia_total_c += floatval($gain_c);
                                $ganancia_total_d += floatval($gain_d); 
                                
                                echo '<tr>';
                                echo '<td>'. ProductoData::getProductCode($r['id']) .'</td>';
                                echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                                echo '<td class="text-center">'. $r['q'] .'</td>';
                                echo '<td class="text-center"><span class="badge me-1 rounded-pill bg-info">C$ '.number_format(floatval($r['price_in']),2,'.',',').'</span><br><span class="badge me-1 rounded-pill bg-success">$ '.number_format(floatval($r['price_in_d']),2,'.',',').'</span></td>';
                                echo '<td class="text-center"><span class="badge me-1 rounded-pill bg-info">C$ '.number_format(floatval($costo_tc),2,'.',',').'</span><br><span class="badge me-1 rounded-pill bg-success">$ '.number_format(floatval($costo_td),2,'.',',').'</span></td>';
                                echo '<td class="text-center"><span class="badge me-1 rounded-pill bg-info">C$ '.number_format( $precio_c ,2,'.',',').'</span><br><span class="badge me-1 rounded-pill bg-success">$ '.number_format( $precio_d,2,'.',',').'</span></td>';
                                echo '<td class="text-center"><span class="badge me-1 rounded-pill bg-info">C$ '.number_format(floatval($r['discount']),2,'.',',').'</span><br><span class="badge me-1 rounded-pill bg-success">$ '.number_format(floatval($r['discount_d']),2,'.',',').'</span></td>';
                                echo '<td class="text-center"><span class="badge me-1 rounded-pill bg-info">C$ '.number_format(floatval($precio_tc),2,'.',',').'</span><br><span class="badge me-1 rounded-pill bg-success">$ '.number_format(floatval($precio_td),2,'.',',').'</span></td>';
                                echo '<td class="text-center" style="color:red;"><span class="badge me-1 rounded-pill bg-info">C$ '.number_format(floatval($gain_c),2,'.',',').'</span><br><span class="badge me-1 rounded-pill bg-success">$ '.number_format(floatval($gain_d),2,'.',',').'</span></td>';
                                echo '<td>'.date('d/m/Y H:m a', strtotime($r['created_at'])).'</td>';
                                echo '</tr>';
                            }                     
                        ?>
                    </tbody>
                </table>
                <br><br><br>
                <table class="table" style="width:100%;">
                    <thead><tr>
                        <th class="text-center" style="font-size: 1.2rem;">Total de Ganancia Proyectada en Cordobas (C$)</th>
                        <th class="text-center" style="font-size: 1.2rem;">Total de Ganancia Proyectada en Dolares ($)</th>
                    </tr></thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><span class="cordoba moneda"><?php echo number_format($ganancia_total_c,2,'.',','); ?></span></td>
                            <td class="text-center"><span class="dolar  moneda"><?php echo number_format($ganancia_total_d,2,'.',','); ?></span></td>
                        </tr>
                    </tbody>
              </table>
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
        var inicial = $("#inicial").val(); 
        var final   = $("#final").val();  

        if(parseInt(tipo) == 0 ){
            alert("Debe seleccionar un tipo de inventario");
            return false;
        }

        if(inicial.trim() == "" || final.trim() ==""){
            alert("Debe seleccinar una fecha de inicio y una final para generar el reporte");
            return false;
        }


         window.location.href = "./index.php?view=reportes/ganancias&tipo="+tipo+"&inicial="+inicial+"&final="+final;
    });


    $(document).ready(function() {
   
        new DataTable('#example', {
                    
          
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