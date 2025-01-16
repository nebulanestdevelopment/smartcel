<?php
    $data = ReparacionData::getReparacionesAbiertas();
    
 ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Reparaciones Mes Actual</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href = './index.php?view=reparacion/nueva';">Agregar reparacion</button>
                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href = './index.php?view=reparacion/cerradas';">Historial de reparaciones cerradas</button>
                </div>
            </div>
          </br> <br></br>
          <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    
            <table id="example" class="display table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">Ver</th>
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
                        foreach ($data as $v){
                          $color = array('Pendiente'=>'text-bg-warning','En proceso'=>'text-bg-info','Reparado'=>'text-bg-success','No se pudo'=>'text-bg-danger');
                            echo "<tr>";
                            echo '<td><a href="./index.php?view=reparacion/ver-reparacion&id='.$v['id'].'"class="btn btn-link">Ver</a></td>';
                            echo '<td>'.$v['factura'].'</td>';
                            echo '<td>'.$v['cliente'].'</td>';
                            echo '<td>'.$v['tecnico'].'</td>';
                            echo '<td>'.$v['descripcion'].'</td>';
                            echo '<td>'.$v['repuesto'].'</td>';
                            echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['costo_repuesto_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['costo_repuesto_d']),2,'.',',').'</span></td>';
                            echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['total_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['total_c']),2,'.',',').'</span></td>';
                            echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['ganancia_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['ganancia_c']),2,'.',',').'</span></td>';
                            echo '<td><span class="badge '.$color[$v['estado']].'" >'.$v['estado'].'</span></td>';
                            echo '<td>'.$v['fecha'].'</td>';
                            echo '<td>';
                           if(Roles::hasAdmin()){echo '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteReparacion('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button>&nbsp;<br>';}
                           if($v['estado'] == "En proceso"){
                            echo '<button type="button" class="btn  btn-success text-white btn-xs" 
                                          onclick="editarReparacion('.$v['id'].')">
                                          <svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use></svg>
                                  </button>&nbsp;<br>';
                            echo '<button type="button" class="btn  btn-info text-white btn-xs" 
                                          onclick="marcarReparado('.$v['id'].')">
                                          Reparado
                                  </button>&nbsp;<br>';
                            echo '<button type="button" class="btn  btn-danger   text-white btn-xs" 
                                          onclick="marcarNoReparado('.$v['id'].')">
                                          No se pudo reparar
                                  </button>';
                            }else if($v['estado'] == "Reparado"){
                              echo '<br><button type="button" class="btn  btn-info text-white btn-xs" 
                                          onclick="marcarReparado('.$v['id'].')">
                                          Cerrar Reparacion
                                  </button>&nbsp;<br>';
                            }
                           echo '</td>';
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
            <div class="d-flex justify-content-start">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                  <button type="button" class="btn btn-outline-primary" onclick="window.location.href = './index.php?action=reparacion/reparacion-controller&method=cerrar-reparaciones';">Cerrar Reparaciones Registradas</button>
                </div>
            </div>
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

function finalizarReparacion(id){
  if (confirm('Desea marcar la reparacion como terminada') == true) {
    
    var request;
      if (request) {
        request.abort();
    }
    request = $.ajax({
        url: "./index.php?action=reparacion/reparacion-controller",
        type: "post",
        data: {id:id,method:'reparado'}
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

function marcarReparado(id){
  if (confirm('Desea marcar la reparacion como terminada') == true) {
    
    var request;
      if (request) {
        request.abort();
    }
    request = $.ajax({
        url: "./index.php?action=reparacion/reparacion-controller",
        type: "post",
        data: {id:id,method:'reparado'}
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

function marcarNoReparado(id){
  if (confirm('Desea marcar como reparacion fallida') == true) {
    
    var request;
      if (request) {
        request.abort();
    }
    request = $.ajax({
        url: "./index.php?action=reparacion/reparacion-controller",
        type: "post",
        data: {id:id,method:'no-reparado'}
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

function editarReparacion(id){
  window.location.href = './index.php?view=reparacion/edit&id='+id;
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
