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
    var urlName = window.location.origin + window.location.pathname+"?action=repairman/cart-ventas";
    $("#cart-content").load(urlName);
}

function loadTotalCosto(){
  $.get("./index.php?action=repairman/costo-total", function(data, status){
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
        url: './index.php?action=repairman/delete-item-from-cart',
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
        url: './index.php?action=repairman/delete-item-from-cart',
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



function obtenerGanancias(){
    var precio_c = parseFloat($("#pvc").val());
    var total_c  = parseFloat($("#total_c").val());
    $('#ganancia_c').val((parseFloat(total_c)-parseFloat(precio_c)).toFixed(2));
    var precio_d = parseFloat($("#pvd").val());
    var total_d  = parseFloat($("#total_d").val());
    $('#ganancia_d').val((parseFloat(total_d)-parseFloat(precio_d)).toFixed(2));
    
}






$("#reparacionForm").submit(function(e){
  
  e.preventDefault(); 
  $("#procesar-venta").prop("type","button");

  var formData = new FormData();
  formData.append("method", "update-reparacion");
  formData.append("idr", $("#idr").val());    
  formData.append("idv", $("#idv").val());    
  formData.append("descripcion", $("#descripcion").val());
  formData.append("total_c", $("#total_c").val());
  formData.append("total_d", $("#total_d").val());
  formData.append("ganancia_c", $("#ganancia_c").val());
  formData.append("ganancia_d", $("#ganancia_d").val());


  $.ajax({
    url: "./index.php?action=repairman/repairman-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
     setTimeout(() => {
        window.location.href = './index.php?view=repairman/home';
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
});
</script>