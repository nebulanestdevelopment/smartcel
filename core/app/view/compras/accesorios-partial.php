<script>
    
    function showAccesoriosContent(){
        
      $('#accesorios-content').css('display', 'block');
      $('#show-find-accesorios-content').empty().css('display', 'none');
        getAllCategoryA("",0);
        getAllProveedoresA("",0);
    }

    
    $('#btn-find-accesorios').on('click',function(e){

      e.preventDefault();
      $(this).html('Buscando....');
      $(this).attr('id','btn-find-accesoriosd');
      $('#accesorios-content').css('display', 'none');
      var formData = new FormData();
      formData.append('query', $('#query-accesorios').val().trim());

      $.ajax({
        url: './index.php?action=compras/find-accesorios',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#show-find-accesorios-content').css('display', 'block').empty().append(data);
         $('#btn-find-accesoriosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio');
         $('#btn-find-accesoriosd').attr('id','btn-find-accesorios');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#btn-find-accesoriosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio');
          $('#btn-find-accesoriosd').attr('id','btn-find-accesorios');
        }
      });
      

    });

    function agregarAccesorioToCart($index){
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
         $('#query-accesorios').val('');
         $('#show-find-accesorios-content').empty().css('display','none');
         loadCartCompras();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      });
    }
  
</script>

<script>
function getAllCategoryA($value,$id){
  $('#categoria-a').empty();
  $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=ACCESORIOS", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == e.name)?"selected":"";
        $('#categoria-a').append('<option value="'+e.id+'" '+$selected+'>'+e.name+'</option>');
      });
       $('#categoria-a').val($id).change();
       $('#categoria-a').select2();
  });
}


function crearCategoriaAccesorios(){
  var myModal = new coreui.Modal(document.getElementById('categoriaAccesoriosModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#categoriaAccesoriosModalTitle').html("Nueva Categoria");
  $('#categoriaAccesoriosModalAction').html("Agregar Categoria");
  $('#cat-name-a').val("");
  $('#subcategoria-a').val("ACCESORIOS").change();
  document.getElementById('categoriaAccesoriosModalAction').setAttribute('onclick','guardarNuevaCategoriaAccesorios()');
  myModal.show();
}

function guardarNuevaCategoriaAccesorios(){  
        if($("#cat-name-a").val().trim().length < 3){
          alert("Debe escribir el nombre de la categoria...")
          return false;
        }
        var dataForm = {method:'save-return',nombre:$("#cat-name-a").val().trim(),subcategoria:'ACCESORIOS'};
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
          $('#categoriaAccesoriosModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          getAllCategoryA($("#cat-name-a").val().trim(),data.id);
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}

function getAllProveedoresA($value,$id){
  $('#proveedor-a').empty();
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor-a').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor-a').val($id).change();
      $('#proveedor-a').select2();
  });
}

function crearProveedorA(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorAModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorAModalTitle').html("Nuevo Proveedor");
  $('#ProveedorAModalAction').html("Agregar Proveedor");
  $('#method-a').val("save");
  $('#razon_social_a').val("");
  $('#nombre-a').val("");
  $('#apellido-a').val("");
  $('#direccion-a').val("");
  $('#email-a').val("");
  $('#telefono-a').val("");
  document.getElementById('ProveedorAModalAction').setAttribute('onclick','guardarNuevaProveedorA()');
  myModal.show();
}

function guardarNuevaProveedorA(){
  
  if($("#nombre-a").val().trim().length < 2){
    alert("Debe escribir el nombre del Proveedor...")
    return false;
  }

  if($("#apellido-a").val().trim().length < 2){
    alert("Debe escribir el apellido del Proveedor...")
    return false;
  }

  var emailField = document.getElementById('email-a');
  var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

  var phoneField = document.getElementById('telefono-a');
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
                    'method':'save','razon_social':$('#razon_social_a').val().trim(),
                    'nombre':$('#nombre-a').val().trim(),'apellido':$('#apellido-a').val().trim(),
                    'direccion':$('#direccion-a').val().trim(),'email':$('#email-a').val().trim(),
                    'telefono':$('#telefono-a').val().trim()
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
    var $pro = '['+$("#razon_social_a").val()+'] '+$("#nombre-a").val().trim()+' '+$("#apellido-a").val().trim();
    $('#ProveedorAModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllProveedoresA($pro,data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}





$("#AccesoriosForm").submit(function(event) {
    event.preventDefault();  
  var imageFile = $("#image-a")[0].files[0];
  var formData = new FormData();
  formData.append("image", imageFile);
  formData.append("method", "save-accesorios");
  formData.append("proveedor", parseInt($("#proveedor-a").find('option:selected').val()));
  formData.append("categoria", parseInt($("#categoria-a").find('option:selected').val()));
  formData.append("codigo", $("#codigo-a").val().trim());
  formData.append("name", $("#name-a").val().trim());
  formData.append("compra_c", parseFloat($("#pcc-a").val().trim()));
  formData.append("compra_d", parseFloat($("#pcd-a").val().trim()));
  formData.append("venta_c", parseFloat($("#pvc-a").val().trim()));
  formData.append("venta_d", parseFloat($("#pvd-a").val().trim()));
  formData.append("esp_c", parseFloat($("#pec-a").val().trim()));
  formData.append("esp_d", parseFloat($("#ped-a").val().trim()));
  formData.append("description", $("#description-a").val().trim());
  formData.append("presentation", $("#presentation-a").val().trim());
  formData.append("mininv", parseInt($("#mininv-a").val()));
  formData.append("invini", 0);
  formData.append("factura", " ");
  formData.append("fecha", $("#fecha-a").val());
 
  $.ajax({
    url: "./index.php?action=compras/save-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      document.getElementById("AccesoriosForm").reset();
      $('#imagePreview-a').removeAttr('src').removeClass('img-thumbnail');
      toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
      $('#accesorios-content').css('display', 'none');
      loadCartCompras();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
      toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
    }
  });
});

</script>