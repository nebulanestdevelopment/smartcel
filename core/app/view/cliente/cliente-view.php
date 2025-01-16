<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Directorio de Clientes</h4>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-outline-dark" onclick="crearCliente()">Nuevo cliente</button>
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
<div class="modal modal-lg fade" id="ClienteModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ClienteModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="ClienteForm">
        <input type="hidden" name="idCliente" id="idCliente">
        <input type="hidden" name="method" id="method">
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label"> Tipo de cliente</label>
          <div class="col-sm-8">
              <select name="tipo" id="tipo" class="form-select ">
              <option value="1" selected>Cliente de tienda</option>
              <option value="3">Cliente de taller</option>
              </select>
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label"> Codigo</label>
          <div class="col-sm-8">
              <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo del cliente" >
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label"> Cedula</label>
          <div class="col-sm-8">
              <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula del cliente" >
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" >
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" >
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" >
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-8">
            <input type="email" class="form-control" id="email" name="email" placeholder="Example@mail.com" >
          </div>
        </div>
        <div class="row mb-3">
          <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono/Celular" >
              </div>
        </div>

      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ClienteModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->
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
<script src="./vendors/select2/select2.min.js"></script>
<script>
  var table = '<table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr><th>Código</th><th>Cédula</th><th>Tipo de cliente</th><th>Nombre completo</th><th>Direccion</th><th>Email</th><th>Telefono</th><th>Acciones</th></tr></thead>';
  table += '<tbody></tbody></table>';
function drawTable(){
    $(".table-responsive").empty().append(table);    
    new DataTable('#example', {
    ajax: './index.php?action=cliente/cliente-controller&method=get-all',
    columns: [
      { data: 'codigo' },
      { data: 'cedula' },
      { data: null,
                render: function(data,type){
                   return (parseInt(data.kind) == 1)?"Tienda":"Taller";
                }
        },
        { data: null,
                render: function(data,type){
                    return  data.name+' '+data.lastname;                     
                }
        },
        { data: 'address1' },
        { data: 'email1' },
        { data: 'phone1' },
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarCliente('+data.id+')">Editar</button>&nbsp;&nbsp;';
                        render += '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteCliente('+data.id+',`'+data.name+'`)">Eliminar</button>';
                     return render;
                }
        }
    ],
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

function crearCliente(){
  var myModal = new coreui.Modal(document.getElementById('ClienteModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ClienteModalTitle').html("Nuevo Cliente");
  $('#ClienteModalAction').html("Agregar Cliente");
  $('#method').val("save");
  $('#codigo').val("");
  $('#cedula').val("");
  $('#nombre').val("");
  $('#apellido').val("");
  $('#direccion').val("");
  $('#email').val("");
  $('#telefono').val("");
  $('#idCliente').val(0);
  document.getElementById('ClienteModalAction').setAttribute('onclick','guardarNuevoCliente()');
  myModal.show()

}

function guardarNuevoCliente(){
  
        if($("#nombre").val().trim().length < 2){
          alert("Debe escribir el nombre del cliente...")
          return false;
        }

        var request;
        var FormData = $("#ClienteForm").serialize();
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=cliente/cliente-controller",
            type: "post",
            data: FormData
        });
        request.done(function (data, textStatus, jqXHR){
          drawTable();
          $('#ClienteModal').modal('hide');
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

function editarCliente(id){
  var myModal = new coreui.Modal(document.getElementById('ClienteModal'), {
      keyboard: false,
      backdrop:'static'
    });

    $.get("./index.php?action=cliente/cliente-controller&method=edit&id="+id, function(data, status){
      $('#codigo').val(data.codigo);
      $('#cedula').val(data.cedula);
      $('#nombre').val(data.name);
      $('#apellido').val(data.lastname);
      $('#direccion').val(data.address1);
      $('#email').val(data.email1);
      $('#telefono').val(data.phone1);
      $('#tipo').val(data.kind).change();
      $('#ClienteModalTitle').html("Actualizar Cliente");
      $('#ClienteModalAction').html("Actualizar Cliente");
      $('#method').val("update");
      $('#idCliente').val(data.id);
      document.getElementById('ClienteModalAction').setAttribute('onclick','actualizarCliente()');
      myModal.show()
    });
}

function actualizarCliente(){
  
  if($("#nombre").val().trim().length < 2){
    alert("Debe escribir el nombre del cliente...")
    return false;
  }

  var request;
  var FormData = $("#ClienteForm").serialize();
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=cliente/cliente-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    drawTable();
    $('#ClienteModal').modal('hide');
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

function deleteCliente(id,Cliente){
  if (confirm('Desea eliminar el cliente: "'+Cliente+'"') == true) {
      var request;
        if (request) {
          request.abort();
      }  
      request = $.ajax({
          url: "./index.php?action=cliente/cliente-controller",
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