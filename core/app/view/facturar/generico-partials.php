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

 function onlyNumber(event, input){
    const regex = /^\d*\.?\d+$/;
    const inputValue = input.value;
    if (!regex.test(inputValue)) {
      toastr.error('solo se permiten numeros', 'Error', {timeOut: 3000});
      input.value = 1
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

function loadCartVentas(){
    var urlName = window.location.origin + window.location.pathname+"?action=ventas/cart-ventas";
    $("#cart-content").load(urlName);
    var urlNameTable = window.location.origin + window.location.pathname+"?action=ventas/table-total";
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
        url: './index.php?action=ventas/delete-item-from-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {          
            loadCartVentas();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
}

function clearCart(){  
      var formData = new FormData();
      formData.append('method', 'clear-cart');
      
      $.ajax({
        url: './index.php?action=ventas/delete-item-from-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {          
            loadCartVentas();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
}
function obtenerDescuento(){
  $.get("./index.php?action=ventas/get-total-descuento", function(data, status){
      $("#descuentoc-venta").val(data.desc_c);
      $("#descuentod-venta").val(data.desc_d);
  });
}


$('#cliente-venta').on('change',function(e){
    e.preventDefault();
    var id = $(this).find(':selected').val();
    if(parseInt(id) == 2){
      $("#cliente-anonimo").css('display','block');
    }else{
      $("#cliente-anonimo").css('display','none');
    }

});

function getAllClientes($id){
  $('#cliente-venta').empty();
  $('#cliente-venta').append('<option value="0" Selected>Seleccione un cliente o agregue uno nuevo</option>');
  $('#cliente-venta').append('<option value="2">Cliente Anonimo</option>');
  $.get("./index.php?action=cliente/cliente-controller&method=get-all", function(data, status){
      data.data.forEach(e => {        
        $('#cliente-venta').append('<option value="'+e.id+'" >'+e.completo+'</option>');
      });      
      if(parseInt($id) > 0 ){
        $('#cliente-venta').val($id).change();
      }
      $('#cliente-venta').select2();
  });
}

function getAllVendedores(){
  $('#vendedor-venta').empty();
  $.get("./index.php?action=usuario/usuario-controller&method=get-all-vendedores", function(data, status){
      data.data.forEach(e => {        
        $('#vendedor-venta').append('<option value="'+e.id+'" >'+e.nombre+' '+e.apellido+'</option>');
      });      
      
     
      $('#vendedor-venta').select2();
  });
}

function crearCliente(){
  var myModal = new coreui.Modal(document.getElementById('ClienteModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ClienteModalTitle').html("Nuevo Cliente");
  $('#ClienteModalAction').html("Agregar Cliente");
  $('#cedula').val("");
  $('#nombre').val("");
  $('#apellido').val("");
  $('#direccion').val("");
  $('#email').val("");
  $('#telefono').val("");
  document.getElementById('ClientesModalAction').setAttribute('onclick','guardarNuevoCliente()');
  myModal.show();
}

function guardarNuevoCliente(){  
  var request;
  var FormData = {
                    'method':'save','cedula':$('#cedula').val().trim(),
                    'nombre':$('#nombre').val().trim(),'apellido':$('#apellido').val().trim(),
                    'direccion':$('#direccion').val().trim(),'email':$('#email').val().trim(),
                    'telefono':$('#telefono').val().trim(),'tipo':'1'
                  }
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=cliente/cliente-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    $('#ClienteModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
    getAllClientes(data.id);
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
}



$("#nueva-venta").submit(function(e){
  
  e.preventDefault(); 
  $("#procesar-venta").prop("type","button");
  $.get("./index.php?action=ventas/get-total", function(data, status){
      var total_c = data.total_c;
      var total_d = data.total_d;

  var formData = new FormData();
  formData.append("method", "save-venta");
  formData.append("cliente_id", parseInt($("#cliente-venta").find(':selected').val()));
  formData.append("cliente_anonimo", $("#cliente-a").val());
  formData.append("tipo_venta", parseInt($("#tipo-venta").find(':selected').val()));
  formData.append("vendedor", parseInt($("#vendedor-venta").find(':selected').val()));
  formData.append("fecha", $("#fecha-venta").val());
  formData.append("factura", $("#factura-venta").val());
  formData.append("cashc", parseFloat($("#efectivoc-venta").val()));
  formData.append("cashd", parseFloat($("#efectivod-venta").val()));

  if(parseInt($("#cliente-venta").find(':selected').val()) == 0){
    alert("Debe seleccionar un cliente");
    $("#procesar-venta").prop("type","submit");
    return false;
  }

  if(parseFloat($("#efectivoc-venta").val()) != parseFloat(total_c) ){
    alert("El efectivo recibido no coincide con el esperado");
    $("#procesar-venta").prop("type","submit");
    return false;
  }

  $.ajax({
    url: "./index.php?action=ventas/ventas-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
      setTimeout(() => {
        window.location.href = './index.php?view=ventas/historial-detalle&id='+data.id;
      }, 1000);
    },
    error: function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
            $("#procesar-venta").prop("type","submit");
    }
  });








  });  

});
$(document).ready(function(){
    allHide();
    loadCartVentas();
    getAllClientes(0);
    getAllVendedores();
    obtenerDescuento();
});
</script>