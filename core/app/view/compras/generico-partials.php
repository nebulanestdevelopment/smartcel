<script>
    /********/
function validateFloat(event, input) {
  const regex = /^\d*\.?\d{0,2}$/;
  const inputValue = input.value;
  if (!regex.test(inputValue)) {
    toastr.error('solo se permiten numeros con 2 decimales o enteros', 'Error', {timeOut: 3000});
    input.value = inputValue.slice(0, -1);
  }
}

function changeDolar($in,$out){
  if($('#'+$in).val().trim().length > 0 ){
    var tasaCambio = parseFloat(sessionStorage.getItem("tasaCambio")).toFixed(2);
    var cordoba = parseFloat($('#'+$in).val()).toFixed(2);
    var cambio = (cordoba / tasaCambio).toFixed(2);
    $('#'+$out).val(cambio);
  } 
}

function changeCordoba($in,$out){
  if($('#'+$in).val().trim().length > 0 ){
    var tasaCambio = parseFloat(sessionStorage.getItem("tasaCambio")).toFixed(2);
    var dolar = parseFloat($('#'+$in).val()).toFixed(2);
    var cambio = (dolar * tasaCambio).toFixed(2);
    $('#'+$out).val(cambio);
  }
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#imagePreview-a').attr('src', e.target.result);
      $('#imagePreview-a').attr('class', 'img-thumbnail');      
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function readURLAc(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#imagePreview-ac').attr('src', e.target.result);
      $('#imagePreview-ac').attr('class', 'img-thumbnail');      
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$("#image-a").change(function() {
  readURL(this);
});
$("#image-ac").change(function() {
  readURLAc(this);
});

function allHide(){
    $('#accesorios-content').css('display','none');
    $('#accesorios-autos-content').css('display','none');
    $('#celulares-content').css('display','none');
    $('#repuestos-content').css('display','none');
    $('#show-find-accesorios-content').empty().css('display', 'none');
    $('#show-find-celulares-content').empty().css('display', 'none');    
    $('#show-find-repuestos-content').empty().css('display', 'none');
    $('#show-find-accesorios-autos-content').empty().css('display', 'none');
}

function loadCartCompras(){
    var urlName = window.location.origin + window.location.pathname+"?action=compras/cart-compras";
    $("#cart-content").load(urlName);
    var urlNameTable = window.location.origin + window.location.pathname+"?action=compras/table-total";
    $("#table-total").load(urlNameTable);
}

$('button.nav-link').on('click',function(e){
    e.preventDefault();
    allHide();
});


function deleteItemFromCart($index){  
      var formData = new FormData();
      formData.append('index', $index);
      formData.append('method', 'delete-item');
      
      $.ajax({
        url: './index.php?action=compras/delete-item-from-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {          
            loadCartCompras();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
}

function clearCart(){  
      var formData = new FormData();
      formData.append('method', 'clear-cart');
      
      $.ajax({
        url: './index.php?action=compras/delete-item-from-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {          
            loadCartCompras();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
}

function getAllProveedoresCompras($value,$id){
  $('#proveedor-compra').empty();
  $('#proveedor-compra').append('<option value="0" >Seleccione un proveedor</option>');
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor-compra').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor-compra').val($id).change();
      if(parseInt($id) == 0 ){
        $('#proveedor-compra').val('0'); 
      }
      $('#proveedor-compra').select2();
  });
}

function crearProveedorCompras(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorComprasModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorComprasModalTitle').html("Nuevo Proveedor");
  $('#ProveedorComprasModalAction').html("Agregar Proveedor");
  $('#razon-social-compras').val("");
  $('#nombre-compras').val("");
  $('#apellido-compras').val("");
  $('#direccion-compras').val("");
  $('#email-compras').val("");
  $('#telefono-compras').val("");
  document.getElementById('ProveedorComprasModalAction').setAttribute('onclick','guardarNuevaProveedorCompras()');
  myModal.show();
}

function guardarNuevaProveedorCompras(){
  
  if($("#nombre-compras").val().trim().length < 2){
    alert("Debe escribir el nombre del Proveedor...")
    return false;
  }

  if($("#apellido-compras").val().trim().length < 2){
    alert("Debe escribir el apellido del Proveedor...")
    return false;
  }

  var emailField = document.getElementById('email-compras');
  var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

  var phoneField = document.getElementById('telefono-compras');
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
                    'method':'save','razon_social':$('#razon-social-compras').val().trim(),
                    'nombre':$('#nombre-compras').val().trim(),'apellido':$('#apellido-compras').val().trim(),
                    'direccion':$('#direccion-compras').val().trim(),'email':$('#email-compras').val().trim(),
                    'telefono':$('#telefono-compras').val().trim()
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
    var $pro = '['+$("#razon-social-compras").val()+'] '+$("#nombre-compras").val().trim()+' '+$("#apellido-compras").val().trim();
    $('#ProveedorComprasModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllProveedoresCompras($pro,data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}
$("#nueva-compra").submit(function(e){
  
  e.preventDefault(); 

  $("#procesar-compra").prop("type","button");
  var formData = new FormData();
  formData.append("method", "save-compra");
  formData.append("proveedor", parseInt($("#proveedor-compra").find(':selected').val()));
  formData.append("tipo", parseInt($("#tipo-compra").find(':selected').val()));
  formData.append("factura", $("#factura-compra").val());
  formData.append("fecha", $("#fecha-compra").val());
 
  $.ajax({
    url: "./index.php?action=compras/compras-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
      setTimeout(() => {
        window.location.href = './index.php?view=compras/historial-detalle&id='+data.id;
      }, 1000);
    },
    error: function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
            $("#procesar-compra").prop("type","submit");
    }
  });

});
$(document).ready(function(){
    allHide();
    loadCartCompras();
    getAllProveedoresCompras("",0);
});
</script>