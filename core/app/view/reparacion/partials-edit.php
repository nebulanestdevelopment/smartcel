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

function loadCartVentas(){
    var urlName = window.location.origin + window.location.pathname+"?action=reparacion/cart-ventas";
    $("#cart-content").load(urlName);
}

function loadTotalCosto(){
  $.get("./index.php?action=reparacion/costo-total", function(data, status){
      $('#pvc').val(data.total_c);
      $('#pvd').val(data.total_d);
      obtenerGanancias();
  });
}


function deleteItemFromCart($index){  
      var formData = new FormData();
      formData.append('index', $index);
      formData.append('method', 'delete-item');
      
      $.ajax({
        url: './index.php?action=reparacion/delete-item-from-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {          
            loadCartVentas();
            loadTotalCosto();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
}

function clearCart(){  
      var formData = new FormData();
      formData.append('method', 'clear-cart');
      
      $.ajax({
        url: './index.php?action=reparacion/delete-item-from-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {          
            loadCartVentas();
            loadTotalCosto();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
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

function obtenerGanancias(){
    var precio_c = parseFloat($("#pvc").val());
    var total_c  = parseFloat($("#total_c").val());
    $('#ganancia_c').val((parseFloat(total_c)-parseFloat(precio_c)).toFixed(2));
    var precio_d = parseFloat($("#pvd").val());
    var total_d  = parseFloat($("#total_d").val());
    $('#ganancia_d').val((parseFloat(total_d)-parseFloat(precio_d)).toFixed(2));
    
}


function getAllClientes($id){
  $('#cliente-venta').empty();
  $('#cliente-venta').append('<option value="0" Selected>Seleccione un cliente o agregue uno nuevo</option>');
  $('#cliente-venta').append('<option value="2" >Cliente Anonimo</option>');
  $.get("./index.php?action=cliente/cliente-controller&method=get-all-repair", function(data, status){
      data.data.forEach(e => {        
        $('#cliente-venta').append('<option value="'+e.id+'" >'+e.completo+'</option>');
      });      
      if(parseInt($id) > 0 ){
        $('#cliente-venta').val($id).change();
      }else if (parseInt($id) == 2){
        $("#cliente-anonimo").css('display','block');
      }
      $('#cliente-venta').select2();
  });
}

function getAllVendedores(id,name){
  $('#vendedor-venta').empty();
  $.get("./index.php?action=usuario/usuario-controller&method=get-all-vendedores", function(data, status){
      data.data.forEach(e => {        
        $('#vendedor-venta').append('<option value="'+e.id+'" >'+e.nombre+' '+e.apellido+'</option>');
      });   
      if(parseInt(id) > 0 ){
        $('#vendedor-venta').val(id).change();
      }  
      $('#vendedor-venta').select2();
  });
}

function getAllTecnicos($id){
  $('#tecnico').empty();
  $.get("./index.php?action=usuario/usuario-controller&method=get-all-tecnicos", function(data, status){
      data.data.forEach(e => {        
        $('#tecnico').append('<option value="'+e.id+'" >'+e.nombre+' '+e.apellido+'</option>');
      });     
      if(parseInt($id) > 0 ){
        $('#tecnico').val($id).change();
      }
      $('#tecnico').select2();
  });
}


function getReparacionData(){
  loadCartVentas();
  loadTotalCosto();
  const url = new URL(window.location.href);
  const $id = url.searchParams.get('id');
  $.get("./index.php?action=reparacion/reparacion-controller&method=get-reparacion-data&id="+$id, function(data, status){
     getAllClientes(data.cliente_id);
     getAllVendedores(data.id_vendedor,data.n_vendedor);
     getAllTecnicos(data.tecnico_id);
    $("#idr").val(data.idr);
    $("#idv").val(data.idv);
    $("#factura").val(data.factura);
    
    $("#descripcion").val(data.descripcion);
    $("#pvc").val(data.crc);
    $("#pvd").val(data.crd);
    $("#total_c").val(data.crec);
    $("#total_d").val(data.cred);
    $("#ganancia_c").val(parseFloat(data.crec) - parseFloat(data.crc));
    $("#ganancia_d").val(parseFloat(data.cred) - parseFloat(data.crd));
    $("#fecha").val(data.fecha);

    $("#cliente-a").val(data.cliente);
    

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
                    'telefono':$('#telefono').val().trim(),'tipo':'3'
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



$("#reparacionForm").submit(function(e){
  
  e.preventDefault(); 
  $("#procesar-venta").prop("type","button");

  var formData = new FormData();
  formData.append("method", "update-reparacion");
  formData.append("idr", $("#idr").val());
  formData.append("idv", $("#idv").val());
  formData.append("factura", $("#factura").val());
  formData.append("cliente_id", parseInt($("#cliente-venta").find(':selected').val()));
  formData.append("cliente_anonimo", $("#cliente-a").val());    
  formData.append("vendedor", parseInt($("#vendedor-venta").find(':selected').val()));
  formData.append("tecnico", parseInt($("#tecnico").find(':selected').val()));
  formData.append("descripcion", $("#descripcion").val());
  formData.append("costo_c", $("#pvc").val());
  formData.append("costo_d", $("#pvd").val());
  formData.append("total_c", $("#total_c").val());
  formData.append("total_d", $("#total_d").val());
  formData.append("ganancia_c", $("#ganancia_c").val());
  formData.append("ganancia_d", $("#ganancia_d").val());
  formData.append("fecha", $("#fecha").val());

  if(parseInt($("#cliente-venta").find(':selected').val()) == 0){
    alert("Debe seleccionar un cliente");
    $("#procesar-venta").prop("type","submit");
    return false;
  }

  $.ajax({
    url: "./index.php?action=reparacion/reparacion-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
     setTimeout(() => {
        window.location.href = './index.php?view=reparacion/abiertas';
      }, 1000);
    },
    error: function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
            $("#procesar-venta").prop("type","submit");
    }
  });
 

});




$(document).ready(function(){
    loadCartVentas();
    loadTotalCosto();
    getReparacionData();

});
</script>