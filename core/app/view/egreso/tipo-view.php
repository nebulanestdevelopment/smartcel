<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Tipos de Pagos</h4>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-outline-dark" onclick="crearGastosTipo()">Nuevo Tipo de Pago</button>
                </div>
              </div>
              <div class="c-chart-wrapper" style="margin-top:60px;">
              <!-- table -->

              <div class="table-responsive">
                  
              </div>
              <!-- ./table -->
              </div>
            </div>
            <div class="card-footer">
              
            </div><!-- ./card-footer -->
          </div><!-- ./card -->

<!-- modal -->
<div class="modal fade" id="GastosTipoModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="GastosTipoModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="GastosTipoForm">
          <input type="hidden" name="idGastosTipo" id="idGastosTipo">
          <input type="hidden" name="method" id="method">
         
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" onkeyup="this.value = this.value.toUpperCase();">
          </div>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="GastosTipoModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->
<link rel="stylesheet" href="./vendors/datatable/datatables.min.css">
<link rel="stylesheet" href="./vendors/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/datatable/datatables.min.js"></script>
<script src="./vendors/datatable/dataTables.bootstrap5.min.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script>
  var table = '<table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr><th>Nombre</th><th>Modificado</th><th>Acciones</th></tr></thead>';
  table += '<tbody></tbody></table>';
function drawTable(){
    $(".table-responsive").empty().append(table);    
    new DataTable('#example', {
    ajax: './index.php?action=egreso/tipos-pago-controller&method=get-all',
    columns: [
        { data: 'name' },
        { data: 'create' },
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarGastosTipo('+data.id+')">Editar</button>&nbsp;&nbsp;';
                        render += '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteGastosTipo('+data.id+',`'+data.name+'`)">Eliminar</button>';
                     return render;
                }
        }
    ],
    /*search: {
        return: true
    },*/
    processing: true,
    paging: false,
    language: {
        url: './vendors/datatable/es-ES.json'
    },
    scrollCollapse: true,
    scrollY: '50vh',
    columnDefs: [
        {
            targets: [0],
            orderData: [0, 1]
        },
        {
            targets: [1],
            orderData: [1, 0]
        }
            ]
    });
}

function crearGastosTipo(){
  var myModal = new coreui.Modal(document.getElementById('GastosTipoModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#GastosTipoModalTitle').html("Nuevo Tipo de Pago");
  $('#GastosTipoModalAction').html("Agregar Tipo de pago");
  $('#method').val("save");
  $('#name').val("");
  $('#idGastosTipo').val(0);
  document.getElementById('GastosTipoModalAction').setAttribute('onclick','guardarNuevaGastosTipo()');
  myModal.show()

}

function guardarNuevaGastosTipo(){
        var request;
        var FormData = $("#GastosTipoForm").serialize();
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=egreso/tipos-pago-controller",
            type: "post",
            data: FormData
        });
        request.done(function (data, textStatus, jqXHR){
          drawTable();
          $('#GastosTipoModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}

function editarGastosTipo(id){
  var myModal = new coreui.Modal(document.getElementById('GastosTipoModal'), {
      keyboard: false,
      backdrop:'static'
    });

    $.get("./index.php?action=egreso/tipos-pago-controller&method=edit&id="+id, function(data, status){
      $('#name').val(data.name);
      $('#GastosTipoModalTitle').html("Actualizar Tipo de Pago");
      $('#GastosTipoModalAction').html("Actualizar tipo de pago");
      $('#method').val("update");
      $('#idGastosTipo').val(data.id);
      document.getElementById('GastosTipoModalAction').setAttribute('onclick','actualizarGastosTipo()');
      myModal.show()
    });
}

function actualizarGastosTipo(){
  
  var request;
  var FormData = $("#GastosTipoForm").serialize();
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=egreso/tipos-pago-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    drawTable();
    $('#GastosTipoModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
} 

function deleteGastosTipo(id,GastosTipo){
  if (confirm('Desea eliminar el tipo de egreso: "'+GastosTipo+'"') == true) {
      var request;
        if (request) {
          request.abort();
      }  
      request = $.ajax({
          url: "./index.php?action=egreso/tipos-pago-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
        drawTable();
        toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
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