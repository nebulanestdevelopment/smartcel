<script>

function getAllProveedores($value,$id){
  $('#proveedor').empty();
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor').val($id).change();
      $('#proveedor').select2();
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
  myModal.show();
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
    var $pro = '['+$("#razon_social").val()+'] '+$("#nombre").val().trim()+' '+$("#apellido").val().trim();
    $('#ProveedorModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllProveedores($pro,data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}
</script>