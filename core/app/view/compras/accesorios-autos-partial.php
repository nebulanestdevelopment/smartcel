<script>
    
    function showAccesoriosAutosContent(){        
        $('#accesorios-autos-content').css('display', 'block');
        $('#show-find-accesorios-autos-content').empty().css('display', 'none');
        getAllCategoryAc("",0);
        getAllProveedoresAc("",0);
    }

    
    $('#btn-find-accesorios-autos').on('click',function(e){
          e.preventDefault();
          $(this).html('Buscando....');
          $(this).attr('id','btn-find-accesorios-autosd');
          $('#accesorios-autos-content').css('display', 'none');
          var formData = new FormData();
          formData.append('query', $('#query-accesorios-autos').val().trim());

          $.ajax({
            url: './index.php?action=compras/find-accesorios-autos',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data, textStatus, jqXHR) {
            $('#show-find-accesorios-autos-content').css('display', 'block').empty().append(data);
            $('#btn-find-accesorios-autosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio');
            $('#btn-find-accesorios-autosd').attr('id','btn-find-accesorios-autos');
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $('#btn-find-accesorios-autosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio');
              $('#btn-find-accesorios-autosd').attr('id','btn-find-accesorios-autos');
            }
          });     
    });

    function agregarAccesoriosAutosToCart($index){
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
         $('#query-accesorios-autos').val('');
         $('#show-find-accesorios-autos-content').empty().css('display','none');
         loadCartCompras();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      });
    }
  
</script>

<script>
function getAllCategoryAc($value,$id){
  $('#categoria-ac').empty();
  $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=ACCESORIOS DE AUTOS", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == e.name)?"selected":"";
        $('#categoria-ac').append('<option value="'+e.id+'" '+$selected+'>'+e.name+'</option>');
      });
       $('#categoria-ac').val($id).change();
       $('#categoria-ac').select2();
  });
}

function crearCategoriaAc(){
  var myModal = new coreui.Modal(document.getElementById('categoriaAccesoriosAutosModal'), {
      keyboard: false,
      backdrop:'static'
    });
    $('#categoriaAccesoriosAutosModalTitle').html("Nueva Categoria");
  $('#categoriaAccesoriosAutosModalAction').html("Agregar Categoria");
  $('#cat-name-ac').val("");
  $('#subcategoria-ac').val("ACCESORIOS DE AUTOS").change();
  document.getElementById('categoriaAccesoriosAutosModalAction').setAttribute('onclick','guardarNuevaCategoriaAc()');
  myModal.show();
}

function guardarNuevaCategoriaAc(){  
        if($("#cat-name-ac").val().trim().length < 3){
          alert("Debe escribir el nombre de la categoria...")
          return false;
        }
        var dataForm = {method:'save-return',nombre:$("#cat-name-ac").val().trim(),subcategoria:'ACCESORIOS DE AUTOS'};
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
          $('#categoriaAccesoriosAutosModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          getAllCategoryAc($("#cat-name-ac").val().trim(),data.id);
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}


function getAllProveedoresAc($value,$id){
  $('#proveedor-ac').empty();
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor-ac').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor-ac').val($id).change();
      $('#proveedor-ac').select2();
  });
}

function crearProveedorAc(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorAcModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorAcModalTitle').html("Nuevo Proveedor");
  $('#ProveedorAcModalAction').html("Agregar Proveedor");
  $('#method-ac').val("save");
  $('#razon_social_ac').val("");
  $('#nombre-ac').val("");
  $('#apellido-ac').val("");
  $('#direccion-ac').val("");
  $('#email-ac').val("");
  $('#telefono-ac').val("");
  document.getElementById('ProveedorAcModalAction').setAttribute('onclick','guardarNuevoProveedorAc()');
  myModal.show();
}

function guardarNuevoProveedorAc(){
  
  if($("#nombre-ac").val().trim().length < 2){
    alert("Debe escribir el nombre del Proveedor...")
    return false;
  }

  if($("#apellido-ac").val().trim().length < 2){
    alert("Debe escribir el apellido del Proveedor...")
    return false;
  }

  var emailField = document.getElementById('email-ac');
  var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

  var phoneField = document.getElementById('telefono-ac');
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
                    'method':'save','razon_social':$('#razon_social_ac').val().trim(),
                    'nombre':$('#nombre-ac').val().trim(),'apellido':$('#apellido-ac').val().trim(),
                    'direccion':$('#direccion-ac').val().trim(),'email':$('#email-ac').val().trim(),
                    'telefono':$('#telefono-ac').val().trim()
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
    var $pro = '['+$("#razon_social_ac").val()+'] '+$("#nombre-ac").val().trim()+' '+$("#apellido-ac").val().trim();
    $('#ProveedorAcModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllProveedoresAc($pro,data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}

$("#accesoriosAutosForm").submit(function(event) {
    event.preventDefault();  
  var imageFile = $("#image-ac")[0].files[0];
  var formData = new FormData();
  formData.append("image", imageFile);
  formData.append("method", "save-accesorios-autos");
  formData.append("proveedor", parseInt($("#proveedor-ac").find('option:selected').val()));
  formData.append("categoria", parseInt($("#categoria-ac").find('option:selected').val()));
  formData.append("codigo", $("#codigo-ac").val().trim());
  formData.append("name", $("#name-ac").val().trim());
  formData.append("compra_c", parseFloat($("#pcc-ac").val().trim()));
  formData.append("compra_d", parseFloat($("#pcd-ac").val().trim()));
  formData.append("venta_c", parseFloat($("#pvc-ac").val().trim()));
  formData.append("venta_d", parseFloat($("#pvd-ac").val().trim()));
  formData.append("esp_c", parseFloat($("#pec-ac").val().trim()));
  formData.append("esp_d", parseFloat($("#ped-ac").val().trim()));
  formData.append("description", $("#description-ac").val().trim());
  formData.append("presentation", $("#presentation-ac").val().trim());
  formData.append("mininv", parseInt($("#mininv-ac").val()));
  formData.append("invini", 0);
  formData.append("factura", " ");
  formData.append("fecha", $("#fecha-ac").val());
 
  $.ajax({
    url: "./index.php?action=compras/save-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      document.getElementById("accesoriosAutosForm").reset();
      $('#imagePreview-ac').removeAttr('src').removeClass('img-thumbnail');
      toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
      $('#accesorios-autos-content').css('display', 'none');
      loadCartCompras();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
      toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
    }
  });
});

</script>