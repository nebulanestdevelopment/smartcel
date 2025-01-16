<script>
    
    function showCelularesContent(){
        
      $('#celulares-content').css('display', 'block');
      $('#show-find-celulares-content').empty().css('display', 'none');
        getAllCategoryC("",0);
        getAllProveedoresC("",0);
    }

    
    $('#btn-find-celulares').on('click',function(e){

      e.preventDefault();
      $(this).html('Buscando....');
      $(this).attr('id','btn-find-celularesd');
      $('#celulares-content').css('display', 'none');
      var formData = new FormData();
      formData.append('imei', $('#query-celulares').val().trim());
      formData.append('modelo', $('#modelo-celulares').val().trim());

      $.ajax({
        url: './index.php?action=compras/find-celulares',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#show-find-celulares-content').css('display', 'block').empty().append(data);
         $('#btn-find-celularesd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Celular');
         $('#btn-find-celularesd').attr('id','btn-find-celulares');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#btn-find-celularesd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Celular');
          $('#btn-find-dcelulares').attr('id','btn-find-celulares');
        }
      });
      

    });

    function agregarCelularesToCart($index){
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
          $('#query-celulares').val('');
          $('#modelo-celulares').val('');
         $('#show-find-celulares-content').empty().css('display','none');
         loadCartCompras();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      });
    }
  
</script>

<script>
function getAllCategoryC($value,$id){
  $('#categoria-c').empty();
  $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=CELULARES", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == e.name)?"selected":"";
        $('#categoria-c').append('<option value="'+e.id+'" '+$selected+'>'+e.name+'</option>');
      });
       $('#categoria-c').val($id).change();
       $('#categoria-c').select2();
  });
}

function crearCategoriaCelulares(){
  var myModal = new coreui.Modal(document.getElementById('categoriaCModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#categoriaCModalTitle').html("Nueva Categoria");
  $('#categoriaCModalAction').html("Agregar Categoria");
  $('#cat-name-c').val("");
  $('#subcategoria-c').val("CELULARES").change();
  document.getElementById('categoriaCModalAction').setAttribute('onclick','guardarNuevaCategoriaCelulares()');
  myModal.show();
}

function guardarNuevaCategoriaCelulares(){  
        if($("#cat-name-c").val().trim().length < 3){
          alert("Debe escribir el nombre de la categoria...")
          return false;
        }
        var dataForm = {method:'save-return',nombre:$("#cat-name-c").val().trim(),subcategoria:'CELULARES'};
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
          $('#categoriaCModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          getAllCategoryC($("#cat-name-c").val().trim(),data.id);
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}

function getAllProveedoresC($value,$id){
  $('#proveedor-c').empty();
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor-c').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor-c').val($id).change();
      $('#proveedor-c').select2();
  });
}

function crearProveedorC(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorCModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorCModalTitle').html("Nuevo Proveedor");
  $('#ProveedorCModalAction').html("Agregar Proveedor");
  $('#method-c').val("save");
  $('#razon_social_c').val("");
  $('#nombre-c').val("");
  $('#apellido-c').val("");
  $('#direccion-c').val("");
  $('#email-c').val("");
  $('#telefono-c').val("");
  document.getElementById('ProveedorCModalAction').setAttribute('onclick','guardarNuevaProveedorC()');
  myModal.show();
}

function guardarNuevaProveedorC(){
  
  if($("#nombre-c").val().trim().length < 2){
    alert("Debe escribir el nombre del Proveedor...")
    return false;
  }

  if($("#apellido-c").val().trim().length < 2){
    alert("Debe escribir el apellido del Proveedor...")
    return false;
  }

  var emailField = document.getElementById('email-c');
  var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

  var phoneField = document.getElementById('telefono-c');
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
                    'method':'save','razon_social':$('#razon_social_c').val().trim(),
                    'nombre':$('#nombre-c').val().trim(),'apellido':$('#apellido-c').val().trim(),
                    'direccion':$('#direccion-c').val().trim(),'email':$('#email-c').val().trim(),
                    'telefono':$('#telefono-c').val().trim()
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
    var $pro = '['+$("#razon_social_c").val()+'] '+$("#nombre-c").val().trim()+' '+$("#apellido-c").val().trim();
    $('#ProveedorCModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllProveedoresC($pro,data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}

$("#CelularesForm").submit(function(event) {
  event.preventDefault(); 
  var formData = new FormData();
  formData.append("method", "save-celulares");
  formData.append("proveedor", parseInt($("#proveedor-c").find('option:selected').val()));
  formData.append("categoria", parseInt($("#categoria-c").find('option:selected').val()));
  formData.append("imei1", $("#imei1-c").val().trim());
  formData.append("imei2", $("#imei2-c").val().trim());
  formData.append("marca", $("#marca-c").val().trim());
  formData.append("modelo", $("#modelo-c").val().trim());
  formData.append("color", $("#color-c").val().trim());
  formData.append("compra_c", parseFloat($("#pcc-c").val().trim()));
  formData.append("compra_d", parseFloat($("#pcd-c").val().trim()));
  formData.append("venta_c", parseFloat($("#pvc-c").val().trim()));
  formData.append("venta_d", parseFloat($("#pvd-c").val().trim()));
  formData.append("esp_c", parseFloat($("#pec-c").val().trim()));
  formData.append("esp_d", parseFloat($("#ped-c").val().trim()));
  formData.append("mininv", parseInt($("#mininv-c").val()));
  formData.append("invini", ' ');
  formData.append("factura", ' ');
  formData.append("fecha", $("#fecha-c").val());
 
  $.ajax({
    url: "./index.php?action=compras/save-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      document.getElementById("CelularesForm").reset();
      toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
      $('#celulares-content').css('display', 'none');
      loadCartCompras();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
      toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
    }
  });
});

</script>