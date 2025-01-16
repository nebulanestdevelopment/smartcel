<div class="container-fluid">
    <div class="card">
        <div class="card-header">
        <h5 class="card-title">Cambiar contraseña</h5>
        </div>
        <div class="card-body">
        <form id="reparacionForm" class="p-4">
                <input type="hidden"  name="idr" id="idr" >
                <input type="hidden"  name="idv" id="idv" >
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Contraseña actual</label>
                    <div class="col-sm-5">
                    <input type="password" class="form-control" id="old-password" name="old-password" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Nueva Contraseña</label>
                    <div class="col-sm-5">
                    <input type="password" class="form-control" id="new-password" name="new-password" >
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Confirmar Nueva Contraseña</label>
                    <div class="col-sm-5">
                    <input type="password" class="form-control" id="renew-password" name="renew-password" >
                    </div>
                </div>

                

                
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">&nbsp;</label>
                    <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" id="procesar-venta" >Actualizar datos</button>
                    <!--button type="button" class="btn btn-secundary" id="clear-cart" onclick="clearCart()">Eliminar Repuestos</button-->
                    </div>
                </div> 
                
        </form>
        </div>
    </div>
</div>


<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<style>
  .moneda {font-size: 1.5em;color: red;}
</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script>
    $("#reparacionForm").submit(function(e){
  
  e.preventDefault(); 
  $("#procesar-venta").prop("type","button");



        var newPassword = $("#new-password").val().trim();
        var reNewPassword = $("#renew-password").val().trim();
  if(newPassword != reNewPassword){
    alert("La confirmacion de contraseña no coinciden");
    $("#procesar-venta").prop("type","submit");
    return false;
  }

  var formData = new FormData();
  formData.append("method", "update-password");
  formData.append("old-password", $("#old-password").val());
  formData.append("new-password", $("#new-password").val());
  
  $.ajax({
    url: "./index.php?action=usuario/usuario-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
     setTimeout(() => {
        window.location.href = './index.php?view=home';
      }, 1000);
    },
    error: function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
            $("#procesar-venta").prop("type","submit");
    }
  });
 

});

</script>