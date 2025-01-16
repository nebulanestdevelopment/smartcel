<?php  

$v = SystemData::GetDatos();

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Informacion adicional del sistema</h5>
        </div>
        <div class="card-body">
        <form id="sistemaDataForm" class="p-4">
                <input type="hidden"  name="ids" id="ids" value="<?php echo $v->id; ?>" >
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Tecnicos en Reparacion</label>
                    <div class="col-sm-5">
                    <textarea  class="form-control" id="tecnicos" name="tecnicos" ><?php echo $v->tecnicos; ?></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Nueva Tasa de Cambio</label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="tasa-cambios" name="tasa-cambios" value="<?php echo $v->tasa_cambio; ?>" onkeyup="validateFloat(event, this)">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">&nbsp;</label>
                    <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" id="procesar-cambios" >Actualizar datos</button>
                    </div>
                </div> 
                
        </form>
        </div>
        <div class="card-footer text-center pt-5 pb-5">
            <div class="row mb-4">
              <form id="updateTasaInventarioForm">
                <div class="col-12"><button type="submit" class="btn btn-primary" id="update-tasa" >Actualizar Inventario con Nueva Tasa de Cambio</button></div>
              </form>
            </div>
            <div class="row mt-2">
                <div class="col-12"><button type="button" class="btn btn-primary">Respaldar Base de Datos al Dia de Hoy</button></div>
            </div>
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
    /********/
function validateFloat(event, input) {
  const regex = /^\d*\.?\d{0,2}$/;
  const inputValue = input.value;
  if (!regex.test(inputValue)) {
    toastr.error('solo se permiten numeros con 2 decimales o enteros', 'Error', {timeOut: 3000});
    input.value = inputValue.slice(0, -1);
  }
}

$("#sistemaDataForm").submit(function(e){
  
  e.preventDefault(); 
  $("#procesar-cambios").prop("type","button");

  var formData = new FormData();
  formData.append("method", "update-data");
  formData.append("id", $("#ids").val());
  formData.append("tecnicos", $("#tecnicos").val());
  formData.append("tasa-cambio", parseFloat($("#tasa-cambios").val()));
  
  $.ajax({
    url: "./index.php?action=system-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
     setTimeout(() => {
        window.location.href = './index.php?view=sistemadata';
      }, 1000);
    },
    error: function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
            $("#procesar-cambios").prop("type","submit");
    }
  });
 

});


$("#updateTasaInventarioForm").submit(function(e){
  
  e.preventDefault(); 
  $("#update-tasa").prop("type","button");

  var formData = new FormData();
  formData.append("method", "update-tasa-inventario");
  
  $.ajax({
    url: "./index.php?action=system-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      toastr.success(data.msg, 'Exitoso', {timeOut: 500});
     setTimeout(() => {
        window.location.href = './index.php?view=sistemadata';
      }, 1000);
    },
    error: function(jqXHR, textStatus, errorThrown) {
            toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
            $("#update-tasa").prop("type","submit");
    }
  });
 

});



</script>