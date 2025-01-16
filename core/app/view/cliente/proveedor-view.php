<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Directorio de Proveedores</h4>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-outline-dark" onclick="crearProveedor()">Nuevo Proveedor</button>
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
<div class="modal modal-lg fade" id="ProveedorModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorForm">
          <input type="hidden" name="idProveedor" id="idProveedor">
          <input type="hidden" name="method" id="method">
         
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razon Social o Empresa" >
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
        <button type="button" class="btn btn-primary" id="ProveedorModalAction" >Guardar</button>
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
  table += '<thead class="table-dark"><tr><th>Razon Social/Nombre completo</th><th>Direccion</th><th>Email</th><th>Telefono</th><th>Acciones</th></tr></thead>';
  table += '<tbody></tbody></table>';
function drawTable(){
    $(".table-responsive").empty().append(table);    
    new DataTable('#example', {
    ajax: './index.php?action=cliente/proveedor-controller&method=get-all',
    columns: [
      { data: null,
                render: function(data,type){
                    return '[ '+data.razon_social+' ] '+data.name+' '+data.lastname;                     
                }
        },
        { data: 'address1' },
        { data: 'email1' },
        { data: 'phone1' },
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarProveedor('+data.id+')">Editar</button>&nbsp;&nbsp;';
                        render += '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteProveedor('+data.id+',`'+data.name+'`)">Eliminar</button>';
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

function crearProveedor(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorModalTitle').html("Nuevo Proveedor");
  $('#ProveedorModalAction').html("Agregar Proveedor");
  $('#method').val("save");
  $('#razon_social').val("");
  $('#nombre').val("");
  $('#apellido').val("");
  $('#direccion').val("");
  $('#email').val("");
  $('#telefono').val("");
  $('#idProveedor').val(0);
  document.getElementById('ProveedorModalAction').setAttribute('onclick','guardarNuevaProveedor()');
  myModal.show()

}




function guardarNuevaProveedor(){
  
        if($("#nombre").val().trim().length < 2){
          alert("Debe escribir el nombre del Proveedor...")
          return false;
        }

        if($("#apellido").val().trim().length < 2){
          alert("Debe escribir el apellido del Proveedor...")
          return false;
        }

        var emailField = document.getElementById('email');
        var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

        var phoneField = document.getElementById('telefono');
        var validPhone = /^\d{8}$/;

        if (!validEmail.test(emailField.value)) {
            alert('El email es obligatorio');
            return false;
        }

        if (!validPhone.test(phoneField.value)) {
            alert('El teléfono debe tener exactamente 8 dígitos');
            return false;
        }
        
        var request;
        var FormData = $("#ProveedorForm").serialize();
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=cliente/proveedor-controller",
            type: "post",
            data: FormData
        });
        request.done(function (data, textStatus, jqXHR){
          drawTable();
          $('#ProveedorModal').modal('hide');
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

function editarProveedor(id){
  var myModal = new coreui.Modal(document.getElementById('ProveedorModal'), {
      keyboard: false,
      backdrop:'static'
    });

    $.get("./index.php?action=cliente/proveedor-controller&method=edit&id="+id, function(data, status){
      $('#razon_social').val(data.razon_social);
      $('#nombre').val(data.name);
      $('#apellido').val(data.lastname);
      $('#direccion').val(data.address1);
      $('#email').val(data.email1);
      $('#telefono').val(data.phone1);
      $('#subProveedor').val(data.subProveedor).change();
      $('#ProveedorModalTitle').html("Actualizar Proveedor");
      $('#ProveedorModalAction').html("Actualizar Proveedor");
      $('#method').val("update");
      $('#idProveedor').val(data.id);
      document.getElementById('ProveedorModalAction').setAttribute('onclick','actualizarProveedor()');
      myModal.show()
    });
}

function actualizarProveedor(){
  
  if($("#nombre").val().trim().length < 2){
    alert("Debe escribir el nombre del Proveedor...")
    return false;
  }

  if($("#apellido").val().trim().length < 2){
    alert("Debe escribir el apellido del Proveedor...")
    return false;
  }

    var emailField = document.getElementById('email');
    var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

    var phoneField = document.getElementById('telefono');
    var validPhone = /^\d{8}$/;

    if (!validEmail.test(emailField.value)) {
        alert('El email es obligatorio');
        return false;
    }

    if (!validPhone.test(phoneField.value)) {
        alert('El teléfono debe tener exactamente 8 dígitos');
        return false;
    }


  var request;
  var FormData = $("#ProveedorForm").serialize();
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=cliente/proveedor-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    drawTable();
    $('#ProveedorModal').modal('hide');
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

function deleteProveedor(id,Proveedor){
  if (confirm('Desea eliminar el Proveedor: "'+Proveedor+'"') == true) {
      var request;
        if (request) {
          request.abort();
      }  
      request = $.ajax({
          url: "./index.php?action=cliente/proveedor-controller",
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