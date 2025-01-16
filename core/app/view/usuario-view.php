<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Usuarios del sistema</h4>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-outline-dark" onclick="crearUsuario()">Nuevo Usuario</button>
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
<div class="modal modal-lg fade" id="usuarioModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usuarioModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
        </div>
<!-- Modal body -->
      <div class="modal-body">
        <form id="usuarioForm">
          <input type="hidden" name="idUsuario" id="idUsuario">
          <input type="hidden" name="method" id="method">
         
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombres</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Juan">
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellidos</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Perez">
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre de usuario</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="username" name="username" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Contraseña</label>
            <div class="col-sm-8">
               <input type="password" class="form-control" id="password" name="password" autocomplete="off" />
               <span id="password-toggle" class="fa-eye" style="position: absolute;
                                                                width: 75px;
                                                                height: 38px;
                                                                z-index: 1000;
                                                                margin-top: -38px;
                                                                right: 11%;
                                                                padding: 10px">Mostrar</span>
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Tipo de usuario</label>
            <div class="col-sm-8">
            <select class="form-select" name="tipo" id="tipo">
              <option value="vendedor" selected>Vendedor</option>
              <option value="tecnico">Tecnico</option>
              <option value="admin">Administrador</option>              
            </select>
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Estado</label>
            <div class="col-sm-8">
            <select class="form-select" name="estado" id="estado">
              <option value="activo" selected>Activo</option>
              <option value="inactivo">Inactivo</option>              
            </select>
            </div>
          </div>

        </form>
        </div>
<!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="usuarioModalAction" >Guardar</button>
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
  table += '<thead class="table-dark"><tr><th>Nombre Completo</th><th>Nombre de usuario</th><th>Tipo de usuario</th><th>Activo</th><th>Acciones</th></tr></thead>';
  table += '<tbody></tbody></table>';
function drawTable(){
    $(".table-responsive").empty().append(table);    
    new DataTable('#example', {
    ajax: './index.php?action=usuario/usuario-controller&method=get-all',
    columns: [
		{ data: null,
                render: function(data,type){
                    return data.nombre+" "+data.apellido;
                }
        },
        { data: 'user' },
        { data: 'tipo'},
        { data: 'activo'},
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarUsuario('+data.id+')">Editar</button>&nbsp;&nbsp;';
                        render += '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteUsuario('+data.id+',`'+data.nombre+' '+data.apellido+'`)">Eliminar</button>';
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

function crearUsuario(){
  var myModal = new coreui.Modal(document.getElementById('usuarioModal'), {
      keyboard: false,
      backdrop:'static'
    });

  $('#usuarioModalTitle').html("Nuevo Usuario del sistema");
  $('#usuarioModalAction').html("Agregar Usuario");
  $('#method').val("save");
  $('#nombre').val("");
  $('#apellido').val("");
  $('#username').attr('disabled',false).val("");
  $('input:password').attr('disabled',false).val('');
  $('#tipo').val("vendedor").change();
  $('#estado').val("activo").change();
  $('#idUsuario').val(0);
  document.getElementById('usuarioModalAction').setAttribute('onclick','guardarNuevoUsuario()');
  myModal.show()
}

function guardarNuevoUsuario(){ 
        var request;
        var FormData = $("#usuarioForm").serialize();
        console.log(FormData);
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=usuario/usuario-controller",
            type: "post",
            data: FormData
        });
        request.done(function (data, textStatus, jqXHR){
          drawTable();
          $('#usuarioModal').modal('hide');
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

function editarUsuario(id){
  var myModal = new coreui.Modal(document.getElementById('usuarioModal'), {
      keyboard: false,
      backdrop:'static'
    });
    
    $.get("./index.php?action=usuario/usuario-controller&method=edit&id="+id, function(data, status){
        $('#usuarioModalTitle').html("Nuevo Usuario del sistema");
        $('#usuarioModalAction').html("Actualizar datos");
        $('#method').val("update");
        $('#nombre').val(data.nombre);
        $('#apellido').val(data.apellido);
        $('#username').attr('disabled',true).val("");
        $('input:password').attr('disabled',true).val('');
        $('#tipo').val(data.tipo).change();
        $('#estado').val(data.activo).change();
        $('#idUsuario').val(data.id);
      document.getElementById('usuarioModalAction').setAttribute('onclick','actualizarUsuario()');
      myModal.show()
    });
}

function actualizarUsuario(){
  var request;
  var FormData = $("#usuarioForm").serialize();
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=usuario/usuario-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    drawTable();
    $('#usuarioModal').modal('hide');
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

function deleteUsuario(id,usuario){
  if (confirm('Desea eliminar el usuario: "'+usuario+'"') == true) {
      var request;
        if (request) {
          request.abort();
      }  
      request = $.ajax({
          url: "./index.php?action=usuario/usuario-controller",
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
$('#password-toggle').click(function() {
    if ($(this).hasClass('fa-eye-slash')) {
      $(this).removeClass('fa-eye-slash').addClass('fa-eye').empty().html('Ocultar');
      $('#password').attr('type', 'text');
    } else {
      $(this).removeClass('fa-eye').addClass('fa-eye-slash').empty().html('Mostrar');;
      $('#password').attr('type', 'password');
    }
  });

});

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>