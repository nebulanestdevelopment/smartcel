<?php
    $tecnico_data =  UsuarioData::getById($_SESSION['user_id']);
    $tecnico = $tecnico_data['nombre'].' '.$tecnico_data['apellido'];
    $data = RepairmanData::getReparacionesAbiertas($tecnico);
    unset($_SESSION["cart-repair"]);  
    
 ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Reparaciones Activas</h5>
        </div>
        <div class="card-body">
          </br>
          <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    
            <table id="example" class="display table table-bordered table-striped" style="width:100%">
            <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">Factura</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tecnico</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Repuesto</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col"></th>
                        <th scope="col">No se pudo</th>
                    </tr>
                </thead>  
                <tbody>
                    <?php
                        foreach ($data as $v){
                          $color = array('Pendiente'=>'text-bg-warning','En proceso'=>'text-bg-info','Reparado'=>'text-bg-success','No se pudo'=>'text-bg-danger');
                            echo "<tr>";
                            echo '<td>'.$v['factura'].'</td>';
                            echo '<td>'.$v['cliente'].'</td>';
                            echo '<td>'.$v['tecnico'].'</td>';
                            echo '<td>'.$v['descripcion'].'</td>';
                            echo '<td>'.$v['repuesto'].'</td>';
                            echo '<td><span class="badge '.$color[$v['estado']].'" >'.$v['estado'].'</span></td>';
                            echo '<td>'.$v['fecha'].'</td>';
                            echo '<td>';
                            if($v['estado'] == "Pendiente") { 
                              echo '<button type="button" onclick="reparacionEnProceso('.$v["id"].')" class="btn btn-info text-white btn-xs">En Proceso</button>&nbsp;&nbsp;';
                            }
                            if($v['estado'] == "En proceso") { 
                              echo '<button type="button" onclick="reparacionTerminada('.$v["id"].')" class="btn btn-success text-white btn-xs">Terminar</button>&nbsp;&nbsp;';
                            }

                            if($v['estado'] == "Reparado") { 
                              echo '<button type="button" onclick="reparacionEnProceso('.$v["id"].')" class="btn btn-info text-white btn-xs">En Proceso</button>&nbsp;&nbsp;';
                            }

                            echo '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarReparacion('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use></svg> Editar</button></td>';
                            echo '<td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="darDeBaja('.$v['id'].',`'.$v['descripcion'].'`)"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-arrow-thick-from-top"></use></svg> No se pudo</button></td>';
                            echo "</tr>";
                        }

                     ?>   
                </tbody>
            </table>
            
            </div><!-- ./ responsive -->
            </div><!-- ./ col -->
          </div><!-- ./ row -->
          <br><br>
            
    <!-- ./todos -->
  </div>
</div>
        </div>
    </div>

</div>


<!-- modal -->
<div class="modal modal-lg fade" id="ClienteModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ClienteModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="ClienteForm">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="method" id="method">
        
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label"> Motivo del porque no se pudo concluir la reparacion</label>
          <div class="col-sm-8">
              <textarea class="form-control" id="nota" name="nota"  ></textarea>
          </div>
        </div>
       

      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="baja-action" >Dar de baja</button>
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

function darDeBaja(id,nota){
  var myModal = new coreui.Modal(document.getElementById('ClienteModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ClienteModalTitle').html(nota);
  $('#baja-action').html("Dar de baja");
  $('#method').val("no-se-pudo");
  $('#id').val(id);
  document.getElementById('baja-action').setAttribute('onclick','actualizarEstadoDeReparacion()');
  myModal.show()
}

function actualizarEstadoDeReparacion(){

  var id =parseInt($('#id').val());
  var method =$("#method").val();
  var nota =$("#nota").val();
  var $data = {id:id,nota:nota,method:method};
  request = $.ajax({
          url: "./index.php?action=repairman/repairman-controller",
          type: "post",
          data: $data
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



function reparacionEnProceso(id){
  if (confirm('Proceder a la reparacion del equipo') == true) {
    
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=repairman/repairman-controller",
          type: "post",
          data: {id:id,method:'en-proceso'}
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

function reparacionTerminada(id){
  if (confirm('Dar por terminada la reparacion') == true) {
    
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=repairman/repairman-controller",
          type: "post",
          data: {id:id,method:'terminar'}
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
  window.location.href = "./index.php?view=repairman/editar&id="+id;
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
