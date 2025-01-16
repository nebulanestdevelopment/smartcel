<?php
    $data = ReparacionData::getReparacionesCerradas();
    
 ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Historial de Reparaciones Cerradas</h5>
        </div>
        <div class="card-body">
             <br></br>
          <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    
            <table id="example" class="display table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col" class="text-center"> # </th>
                        <th >Reparacion Cerradas del Dia </th>
                        <th >Ganancia</th>
                        <th ></th>
                    </tr>
                </thead>  
                <tbody>
                    <?php
                    $total_c = 0;
                    $total_d = 0;
                    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                    $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
                        foreach ($data as $i => $v){
                            $dia = date('w',strtotime($v['fecha']) );
                            $mes = date('n',strtotime($v['fecha']) );
                            echo "<tr>";
                            echo "<td class='text-center'>".($i+1)."</td>";
                            echo '<td style="text-transform:uppercase;">'.$dias[$dia].', '.date('d',strtotime($v['fecha']) ).' DE '.$meses[$mes].' DEL '.date('Y',strtotime($v['fecha']) ).' '.date('h:m a',strtotime($v['fecha']) ).'</td>';
                            echo'<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($v['total_c']),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format(floatval($v['total_d']),2,'.',',') .'</span></td>';
                            echo '<td><button type="button" class="btn btn-outline-secondary" onclick="window.location.href = `./index.php?view=reparacion/cerradas-detalles&fecha='.$v['fecha'].'`;">Ver reparacion</button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-outline-danger" onclick="deleteReparacion(`'.$v['fecha'].'`)">Revertir</button></td>';
                            echo "</tr>";
                            $total_c += floatval($v['total_c']);
                            $total_d += floatval($v['total_d']);
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

function deleteReparacion($fecha){
  if (confirm('Desea revertir el registro de reparacion') == true) {
    
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=reparacion/reparacion-controller",
          type: "POST",
          data: {fecha:$fecha,method:'revertir-reparacion'}
      });
      request.done(function (data, textStatus, jqXHR){
        
        toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
        setTimeout(() => {
          window.location.href = './index.php?view=reparacion/abiertas';
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
