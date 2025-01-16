<script>
    
    function showRepuestosContent(){
        
      $('#repuestos-content').css('display', 'block');
      $('#show-find-repuestos-content').empty().css('display', 'none');
        getAllCategoryR("",0);
        getAllProveedoresR("",0);
    }

    
    $('#btn-find-repuestos').on('click',function(e){

      e.preventDefault();
      $(this).html('Buscando....');
      $(this).attr('id','btn-find-repuestosd');
      $('#repuestos-content').css('display', 'none');
      var formData = new FormData();
      formData.append('categoria', $('#categoria-repuestos').find(':selected').val());
      formData.append('modelo', $('#modelo-repuestos').val().trim());

      $.ajax({
        url: './index.php?action=compras/find-repuestos',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#show-find-repuestos-content').css('display', 'block').empty().append(data);
         $('#btn-find-repuestosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Repuesto');
         $('#btn-find-repuestosd').attr('id','btn-find-repuestos');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#btn-find-repuestosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Repuesto');
          $('#btn-find-repuestosd').attr('id','btn-find-repuestos');
        }
      });
      

    });

    function agregarRepuestosToCart($index){
      var formData = new FormData();
      formData.append('product_id', parseInt($('#id'+$index).val().trim()));
      formData.append('q', parseInt($('#q'+$index).val().trim()));
      formData.append('compra_c', parseFloat($('#pcc'+$index).val().trim()));
      formData.append('compra_d', parseFloat($('#pcd'+$index).val().trim()));
      formData.append('venta_c', parseFloat($('#pvc'+$index).val().trim()));
      formData.append('venta_d', parseFloat($('#pvd'+$index).val().trim()));
      formData.append('esp_c', parseFloat($('#pec'+$index).val().trim()));
      formData.append('esp_d', parseFloat($('#ped'+$index).val().trim()));      

      $.ajax({
        url: './index.php?action=compras/add-to-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
          $('#modelo-repuestos').val('');
          $('#show-find-repuestos-content').empty().css('display','none');
          loadCartCompras();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      });
    }
  
</script>

<script>

$('#nav-repuestos-tab').on('click',function(){
  setTimeout(() => {
    $('#categoria-repuestos').empty();
    $('#categoria-repuestos').append('<option value="0" selected>Seleccione una categoria</option>');
    $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=REPUESTOS", function(data, status){
        data.data.forEach(e => {
          $('#categoria-repuestos').append('<option value="'+e.id+'">'+e.name+'</option>');
        });
        $('#categoria-repuestos').select2();
    });
  }, 500);
})
function getAllCategoryR($value,$id){
  $('#categoria-r').empty();
  $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=REPUESTOS", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == e.name)?"selected":"";
        $('#categoria-r').append('<option value="'+e.id+'" '+$selected+'>'+e.name+'</option>');
      });
       $('#categoria-r').val($id).change();
       $('#categoria-r').select2();
  });
}

function crearCategoriaR(){
  var myModal = new coreui.Modal(document.getElementById('categoriaRModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#categoriaRModalTitle').html("Nueva Categoria");
  $('#categoriaRModalAction').html("Agregar Categoria");
  $('#cat-name-r').val("");
  $('#subcategoria-r').val("REPUESTOS").change();
  document.getElementById('categoriaRModalAction').setAttribute('onclick','guardarNuevaCategoriaR()');
  myModal.show();
}

function guardarNuevaCategoriaR(){  
  if($("#cat-name-r").val().trim().length < 3){
          alert("Debe escribir el nombre de la categoria...")
          return false;
        }
        var dataForm = {method:'save-return',nombre:$("#cat-name-r").val().trim(),subcategoria:'REPUESTOS'};
        var request;
        
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=categoria-controller",
            type: "POST",
            data: dataForm
        });
        request.done(function (data, textStatus, jqXHR){
          $('#categoriaRModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          getAllCategoryR($("#cat-name-r").val().trim(),data.id);
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}

function getAllProveedoresR($value,$id){
  $('#proveedor-r').empty();
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor-r').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor-r').val($id).change();
      $('#proveedor-r').select2();
  });
}

function crearProveedorR(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorRModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorRModalTitle').html("Nuevo Proveedor");
  $('#ProveedorRModalAction').html("Agregar Proveedor");
  $('#method-r').val("save");
  $('#razon-social-r').val("");
  $('#nombre-r').val("");
  $('#apellido-r').val("");
  $('#direccion-r').val("");
  $('#email-r').val("");
  $('#telefono-r').val("");
  document.getElementById('ProveedorRModalAction').setAttribute('onclick','guardarNuevaProveedorR()');
  myModal.show();
}

function guardarNuevaProveedorR(){
  
  if($("#nombre-r").val().trim().length < 2){
    alert("Debe escribir el nombre del Proveedor...")
    return false;
  }

  if($("#apellido-r").val().trim().length < 2){
    alert("Debe escribir el apellido del Proveedor...")
    return false;
  }

  var emailField = document.getElementById('email-r');
  var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

  var phoneField = document.getElementById('telefono-r');
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
  var FormData = {
                    'method':'save','razon_social':$('#razon-social-r').val().trim(),
                    'nombre':$('#nombre-r').val().trim(),'apellido':$('#apellido-r').val().trim(),
                    'direccion':$('#direccion-r').val().trim(),'email':$('#email-r').val().trim(),
                    'telefono':$('#telefono-r').val().trim()
                  }
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=cliente/proveedor-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    var $pro = '['+$("#razon-social-r").val()+'] '+$("#nombre-r").val().trim()+' '+$("#apellido-r").val().trim();
    $('#ProveedorRModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllProveedoresR($pro,data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}

$("#RepuestosForm").submit(function(event) {                      
                  
  event.preventDefault(); 
  var formData = new FormData();
  formData.append("method", "save-repuestos");
  formData.append("proveedor", parseInt($("#proveedor-r").find('option:selected').val()));
  formData.append("categoria", parseInt($("#categoria-r").find('option:selected').val()));
  formData.append("marca", $("#marca-r").val().trim());
  formData.append("modelo", $("#modelo-r").val().trim());
  formData.append("color", $("#color-r").val().trim());
  formData.append("description", $("#description-r").val().trim());
  formData.append("compatibilidad", $("#compatibilidad-r").val().trim());
  formData.append("compra_c", parseFloat($("#pcc-r").val().trim()));
  formData.append("compra_d", parseFloat($("#pcd-r").val().trim()));
  formData.append("venta_c", parseFloat($("#pvc-r").val().trim()));
  formData.append("venta_d", parseFloat($("#pvd-r").val().trim()));
  formData.append("esp_c", parseFloat($("#pec-r").val().trim()));
  formData.append("esp_d", parseFloat($("#ped-r").val().trim()));
  formData.append("mininv", parseInt($("#mininv-r").val()));
  formData.append("invini", ' ');
  formData.append("factura", ' ');
  formData.append("fecha", $("#fecha-r").val());
 
  $.ajax({
    url: "./index.php?action=compras/save-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      document.getElementById("RepuestosForm").reset();
      toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
      $('#repuestos-content').css('display', 'none');
      loadCartCompras();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
      toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
    }
  });
});

</script>