<?php
    $data = ReparacionData::getReparacionesCerradasDetalle($_GET['fecha']);
    
 ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Reparaciones Mes Actual</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href = './index.php?view=reparacion/cerradas';">Regresar a reparaciones cerradas</button>
                </div>
            </div>
          </br> <br></br>
          <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    
            <table id="example" class="display table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">Ver Detalle</th>
                        <th scope="col">Factura</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tecnico</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Repuesto</th>
                        <th scope="col">Costo de Repuesto</th>
                        <th scope="col">Total</th>
                        <th scope="col">Ganancia</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col"></th>
                    </tr>
                </thead>  
                <tbody>
                    <?php
                    $total_c = 0;
                    $total_d = 0;
                    $tecnico = array();
                        foreach ($data as $v){
                          if(!isset($tecnico[$v['tecnico']])){
                            $tecnico[$v['tecnico']] = ["total_c"=>floatval($v['ganancia_c']),"total_d"=>floatval($v['ganancia_d'])];
                          }else{
                            $totalt_c = floatval($tecnico[$v['tecnico']]['total_c']) + floatval($v['ganancia_c']);
                            $totalt_d = floatval($tecnico[$v['tecnico']]['total_d']) + floatval($v['ganancia_d']);
                            $tecnico[$v['tecnico']] = ["total_c"=>$totalt_c,"total_d"=>$totalt_d];
                          }
                            
                            echo "<tr>";
                            echo '<td><a href="./index.php?view=reparacion/ver-reparacion&id='.$v['id'].'"class="btn btn-link">Ver</a></td>';
                            echo '<td>'.$v['factura'].'</td>';
                            echo '<td>'.$v['cliente'].'</td>';
                            echo '<td>'.$v['tecnico'].'</td>';
                            echo '<td>'.$v['descripcion'].'</td>';
                            echo '<td>'.$v['repuesto'].'</td>';
                            echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['costo_repuesto_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['costo_repuesto_d']),2,'.',',').'</span></td>';
                            echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['total_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['total_d']),2,'.',',').'</span></td>';
                            echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['ganancia_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['ganancia_d']),2,'.',',').'</span></td>';
                            echo '<td>'.$v['estado'].'</td>';
                            echo '<td>'.$v['fecha'].'</td>';
                           if(Roles::hasAdmin()){echo '<td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteReparacion('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button></td>';}else{ echo '<td>*-*</td>';};
                            echo "</tr>";
                            $total_c += floatval($v['ganancia_c']);
                            $total_d += floatval($v['ganancia_d']);
                        }

                     ?>   
                </tbody>
            </table>
            
            </div><!-- ./ responsive -->
            </div><!-- ./ col -->
          </div><!-- ./ row -->
          <br><br>
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
              <br><br>
              <?php

              foreach ($tecnico as $t => $v) {
                echo  '<Strong>Reparaciones a pagar técnico: </Strong> '.ucwords(strtolower($t)).'&nbsp;&nbsp;';
                echo  "<Strong> C$ </Strong> ".number_format($v["total_c"],2,'.',',').' &nbsp;&nbsp;';
                echo  "<Strong> $ </Strong> ".number_format($v["total_d"],2,'.',',').' <br>';
              }




              ?>
    <!-- ./todos -->
  </div>
</div>
        </div>
    </div>

</div>


<link rel="stylesheet" href="./vendors/datatable/dataTables.dataTables.css">
<link rel="stylesheet" href="./vendors/datatable/buttons.dataTables.css">
<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<script src="./vendors/datatable/jquery-3.7.1.js"></script>
<script src="./vendors/datatable/datatables.js"></script>
<script src="./vendors/datatable/dataTables.buttons.min.js"></script>
<script src="./vendors/datatable/jszip.min.js"></script>
<script src="./vendors/datatable/pdfmake.min.js"></script>
<script src="./vendors/datatable/vfs_fonts.js"></script>
<script src="./vendors/datatable/buttons.html5.min.js"></script>
<script src="./vendors/datatable/buttons.print.min.js"></script>

<script src="./vendors/toastr/toastr.min.js"></script>




<script>
function drawTable(){ 
    new DataTable('#example', {
        language: {
                url: './vendors/datatable/es-ES.json'
            },
        layout: {
            bottomStart: {
                buttons: ['csv', 'excel', 'pdf', 'print']
            }
        }
    });
}



function deleteReparacion(id){
  if (confirm('Desea eliminar el registro de reparacion') == true) {
    
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=reparacion/reparacion-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
        
        toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
        setTimeout(() => {
          window.location.reload();
        }, 1500);
      });
      request.fail(function (jqXHR, textStatus, errorThrown){
        toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
          console.error(
              "The following error occurred: "+
              textStatus, errorThrown
          );
      });
  } 
}


$(document).ready(function() {

  drawTable();

});

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>
