<?php
$cat_accesorios = CategoriaData::getAllBySubcategory('ACCESORIOS');
$cat_accesorios_autos = CategoriaData::getAllBySubcategory('ACCESORIOS DE AUTOS');
$cat_celulares = CategoriaData::getAllBySubcategory('CELULARES');
$cat_repuestos = CategoriaData::getAllBySubcategory('REPUESTOS');

$tipo = 0;
$categoria = 0;
$inicial = 0;
$final = 0;
$data = [];


if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    $categoria =  $_GET['categoria'];
    $inicial =  ($_GET['inicial'] != "")?$_GET['inicial']:0;
    $final =  ($_GET['final'] != "")?$_GET['final']:0;
    $data = ReportesData::getInventarios($tipo,$categoria,$inicial,$final);
   
}
 

?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title">
            Reporte de Inventario
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                    <span class="badge text-bg-primary">1) Seleccionar por:</span>
</br></br>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="accesorio" value="1" <?php echo (isset($_GET["tipo"]) && intval($_GET["tipo"]) == 1 )?"checked":" "; ?> >
                        <label class="form-check-label" for="accesorio">
                            Accesorios
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="accesorio-auto" value="4" <?php echo (isset($_GET["tipo"]) && $_GET["tipo"] == 4 )?"checked":" "; ?> >
                        <label class="form-check-label" for="accesorio-auto">
                            Accesorios de Autos
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="celular" value="2" <?php  echo (isset($_GET["tipo"]) && $_GET["tipo"] == 2 )?"checked":" "; ?> >
                        <label class="form-check-label" for="celular">
                            Celulares
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="repuesto" value="3" <?php echo(isset($_GET["tipo"]) && $_GET["tipo"] == 3 )?"checked":" "; ?> >
                        <label class="form-check-label" for="repuesto">
                            Repuesto
                        </label>
                    </div>



            </div>
            <div class="col-sm-4">
            <span class="badge text-bg-primary">2) Seleccionar por categoria:</span>
            </br></br>  
            <select class="form-select" aria-label="Default select example" id="accesorio-s" name="accesorio-s">
                <option selected value="0">Accesorios</option>
                <?php 
                    foreach ($cat_accesorios as $v) {
                        $selected = (isset($_GET['categoria']) && intval($_GET['categoria'])== $v['id'])?"selected":"";
                        echo '<option value="'.$v['id'].'"  '.$selected.'>'.$v['name'].'</option>';
                    }               
                ?>
            </select>
</br>
            <select class="form-select" aria-label="Default select example" id="accesorios-auto-s" name="accesorios-auto-s">
                <option selected value="0">Accesorios de Autos</option>
                <?php 
                    foreach ($cat_accesorios_autos as $v) {
                        $selected = (isset($_GET['categoria']) && intval($_GET['categoria'])== $v['id'])?"selected":"";
                        echo '<option value="'.$v['id'].'"  '.$selected.'>'.$v['name'].'</option>';
                    }               
                ?>
            </select>
</br>
            <select class="form-select" aria-label="Default select example" id="celulares-s" name="celulares-s" >
                <option selected value="0">Celulares</option>
                <?php 
                    foreach ($cat_celulares as $v) {
                        $selected = (isset($_GET['categoria']) && intval($_GET['categoria'])== $v['id'])?"selected":"";
                        echo '<option value="'.$v['id'].'"  '.$selected.'>'.$v['name'].'</option>';
                    }               
                ?>
            </select>
            </br>
            <select class="form-select" aria-label="Default select example" id="repuestos-s" name="repuestos-s">
                <option selected value="0">Repuestos</option>
                <?php 
                    foreach ($cat_repuestos as $v) {
                        $selected = (isset($_GET['categoria']) && intval($_GET['categoria'])== $v['id'])?"selected":"";
                        echo '<option value="'.$v['id'].'"  '.$selected.'>'.$v['name'].'</option>';
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
                          <input type="date" class="form-control" id="inicial" name="inicial"  value="<?php echo isset($_GET["inicial"])?$_GET["inicial"]:" "; ?>" >
                        </div>
                    </div>
                    <div class="col-12">
                       <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">Fecha final</label>
                          <input type="date" class="form-control" id="final" name="final" value="<?php echo isset($_GET["final"])?$_GET["final"]:" "; ?>">
                        </div>
                    </div>
                    <div class="col-12">
                            <button type="button" class="btn btn-success btn-md text-white" id="btn-procesar">Processar</button>
                            
                    </div>
                </div>
            </div>

        </div>
                    <hr>
        <div class="section">
            <?php 
                $tipo_array =[0 => " ",1 =>"Accesorios",2 =>"Celulares",3 =>"Repuestos",4 =>"Accesorios de Autos"];
               if(isset($_GET['tipo'])){echo '<h4 class="badge rounded-pill text-bg-primary" style="font-size: 1.3em;">'.$tipo_array[$_GET['tipo']].'</h4><br>';}
               if(isset($_GET['categoria']) && intval($_GET['categoria']) > 0){ echo '<h5 class="badge rounded-pill text-bg-primary" style="font-size: 1.1em;">Seccion: '.$tipo_array[$_GET['tipo']].' Categoria: '.CategoriaData::getById($_GET['categoria'])['name'].'</h5>';}
            ?>
            <br><br><br>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="example">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Costo Unit.</th>
                            <th>Costo Total</th>
                            <th>Precio Unit.</th>
                            <th>Precio Total</th>
                            <th style="color:red;">Ganancia</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        $costo_total_general= 0;
                        $precio_total_general = 0;
                            foreach($data as $r){
                                $qreal = ReportesData::CantidadRealxProducto($r['id']);
                                $costo_total = intval($qreal) * floatval($r['price_in']);
                                $costo_total_general += floatval($costo_total); 
                                $precio_total = intval($qreal) * floatval($r['price_out']);
                                $precio_total_general += floatval($precio_total); 
                              
                                echo '<tr>';
                                echo '<td>'. ProductoData::getProductCode($r['id']) .'</td>';
                                echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                                echo '<td class="text-center">'. $qreal.'</td>';
                                echo '<td class="text-center">C$ '.number_format(floatval($r['price_in']),2,'.',',').'</td>';
                                echo '<td class="text-center">C$ '.number_format($costo_total,2,'.',',').'</td>';
                                echo '<td class="text-center">C$ '.number_format(floatval($r['price_out']),2,'.',',').'</td>';
                                echo '<td class="text-center">C$ '.number_format($precio_total,2,'.',',').'</td>';
                                echo '<td class="text-center" style="color:red;">C$ '.number_format(($precio_total - $costo_total),2,'.',',').'</td>';
                                echo '<td>'.date('d/m/Y H:m a', strtotime($r['created_at'])).'</td>';
                                echo '</tr>';
                            }                     
                        ?>
                    </tbody>
                </table>
                <br><br><br>
                <?php 
                    if(count($data) > 0 ){
                        echo '<table class="table table-bordered">';
                        
                        echo '<tbody>';
                            echo '<tr>';
                                echo '<td><strong>Total General (Compras) </strong></td>';  
                                echo '<td>C$ '.number_format($costo_total_general,2,'.',',').'</td>'; 
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td><strong>Total General (Ventas) </strong></td>';  
                                echo '<td><span >C$ '.number_format($precio_total_general,2,'.',',').'</span></td>'; 
                            echo '</tr>';
                            echo '<tr>';
                                echo '<td><strong>Total General (Ganancias)  </strong></td>';  
                                echo '<td><span>C$ '.number_format(($precio_total_general - $costo_total_general ),2,'.',',').'</span></td>'; 
                            echo '</tr>';
                        echo '</tbody>';
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
        if ($('input[name="flexRadioDefault"]:checked').length === 0) {
            alert("Debe seleccionar un tipo de inventario");
            return false;
        }

        var tipo = $('input[name="flexRadioDefault"]:checked').val();
        var categoria = 0;
        if(parseInt(tipo) == 1){
            categoria = $("#accesorio-s").find(':selected').val();
        }else if(parseInt(tipo) == 2){
            categoria = $("#celulares-s").find(':selected').val();
        }else if(parseInt(tipo) == 3){
            categoria = $("#repuestos-s").find(':selected').val();
        }else if(parseInt(tipo) == 4){
            categoria = $("#accesorios-auto-s").find(':selected').val();
        }

        var inicial = $("#inicial").val(); 
        var final   = $("#final").val();  
         window.location.href = "./index.php?view=reportes/inventario&tipo="+tipo+"&categoria="+categoria+"&inicial="+inicial+"&final="+final;
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