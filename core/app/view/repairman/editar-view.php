
<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';

$data = RepairmanData::getDataFromReparacion($_GET['id']);
?>

<div class="container-fluid bg-white">
<br>
<h4>Buscar Repuesto</h4>

 <!-- repuestos -->
 </br>
      <div class="alert alert-info col-md-6">
        <p> Buscar <b>Repuesto </b> por Categoria, Marca o Modelo:</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
        <select name="categoria-repuestos" id="categoria-repuestos" class="form-select js-example-basic-single"></select>
</br></br>
        <input type="text" class="form-control" id="modelo-repuestos" name="modelo-repuestos" placeholder="Buscar por modelo del repuesto">
        </div>
        <div class="col-sm-6">
          <button type="button" class="btn btn-primary" id="btn-find-repuestos"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar repuestos</button>
        </div>
      </div>
      </br>  </br>
      <div id="show-find-repuestos-content" style="display: none;"> 
          
      </div>
    <!-- ./repuestos -->

</div><!-- Container -->

</br>

<div class="container-fluid bg-white">
    <br>
      <h5>Lista de Repuestos Agregados</h5>
      <br>
      <div id="cart-content">

      </div>
      <br>
</div>
<!-- cart-content -->
</br>

<div class="card mb-4 mt-1">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">Editar reparacion</h4>
            </div>
        </div>
        <hr>

        <form id="reparacionForm" class="p-4">
          <input type="hidden" name="idr" id="idr" value="<?php echo $data['id']; ?>" >
          <input type="hidden" name="idv" id="idv" value="<?php echo $data['idv']; ?>">

                <!--div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Factura #</label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="factura" name="factura">
                    </div>
                </div-->

                <!--div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Cliente <button class="btn" type="button" onclick="crearCliente()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
                    <div class="col-sm-5">
                      <select name="cliente-venta" id="cliente-venta" class="form-select  js-example-basic-single">
                      </select>
                    </div>
                  </div>
                  <div id="cliente-anonimo" style="display:none ;">
                    <div class="row mb-3" > 
                      <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Cliente anonimo</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="cliente-a" name="cliente-a" placeholder="Nombre y Apellido" >
                      </div>
                    </div>
                  </div-->  
                  <!--div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Vendedor </label>
                    <div class="col-sm-5">
                      <select name="vendedor-venta" id="vendedor-venta" class="form-select  js-example-basic-single">
                      </select>
                    </div>
                  </div-->

                <!--div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Tecnico</label>
                    <div class="col-sm-5">
                        <select class="form-select  js-example-basic-single" name="tecnico" id="tecnico">
                        </select>
                    </div>
                </div-->

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descripcion</label>
                    <div class="col-sm-5">
                      <textarea type="area" rows="2" class="form-control" id="descripcion" name="descripcion" placeholder="descripcion" onkeyup="this.value = this.value.toLowerCase();"><?php echo $data['descripcion']; ?></textarea> 
                    </div>
                </div>

                <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Costo del repuesto(s)</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc" name="pvc" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc','pvd')" value="<?php echo $data['costo_repuesto_c']; ?>" readonly>
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd" name="pvd" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd','pvc')" value="<?php echo $data['costo_repuesto_d']; ?>" readonly>
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Total de la reparacion</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="total_c" name="total_c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('total_c','total_d'),obtenerGanancias()" value="<?php echo $data['ganancia_c']; ?>">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="total_d" name="total_d" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('total_d','total_c'),obtenerGanancias()" value="<?php echo $data['ganancia_d']; ?>">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Ganancia esperada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="ganancia_c" name="ganancia_c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('ganancia_c','ganancia_d')" value="<?php echo $data['total_c']; ?>" readonly>
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ganancia_d" name="ganancia_d" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ganancia_d','ganancia_c')" value="<?php echo $data['total_d']; ?>" readonly>
                    </div>

                </div>
          </div>
      
             


              <!--div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
                    <div class="col-sm-5">
                    <input type="date" class="form-control" id="fecha" name="fecha" >
                    </div>
                </div-->   
                
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">&nbsp;</label>
                    <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" id="procesar-venta" >Actualizar datos de reparacion</button>
                    <!--button type="button" class="btn btn-secundary" id="clear-cart" onclick="clearCart()">Eliminar Repuestos</button-->
                    </div>
                </div> 
                
        </form>
        <!-- ./card-body -->
    </div>
    <div class="card-footer d-grid gap-1">
            
    </div><!-- ./card-footer -->
</div><!-- ./card -->

<!-- cart-content -->
<br>
 <div class="card mb-4 mt-1">
  <div class="card-header"><h5 class="card-title">Agregar Imagenes de entrada del equipo a taller</h5></div>
    <div class="card-body">
        <form id="reparacionImgEntradaForm" class="p-4 dropzone" enctype="multipart/form-data"  >
        <div class="fallback">
          <input name="file" type="file" multiple />
        </div>

                
        </form>
        <!-- ./card-body -->
    </div>
    <div class="card-footer d-grid gap-1">
      <button type="button" class="btn btn-success text-white" onclick="agregarImagenes('<?php echo $_GET['id']; ?>','entrada')">Agregar Imagenes</button>
    </div>
</div><!-- ./card -->
<br>
 <div class="container-fluid bg-white">
    <br>
      <h4>Imagenes de la reparación</h4>
      <br>
      <div>
        <h6>Imagenes de como ingreso el equipo al taller</h6>
            <div class="row">
            <?php
                $rootPath = realpath(__DIR__ . '/../../../../');                
                $simplePath = '/storage/reparaciones/'.$_GET['id'].'/entrada';
                $assetsPath = $rootPath . $simplePath;
                
                $filese = glob($assetsPath . '/*');
                
                    foreach ($filese as $file) {
                        $name =  basename($file);         
                            echo '<div class="col-6 col-md-3">';
                            echo '<div class="image-container"><a href="' . $simplePath. '/' . $name . '" data-lightbox="image-1" >';
                            echo '<img src="' . $simplePath. '/' . $name . '"'; 
                            echo 'class="img-responsive img-thumbnail" style="width: 100%; height: 150px; margin: 10px">';
                            echo '</a><button class="delete-button" onclick="deleteImage(this,`entrada`,`'.$name.'`)">×</button></div>';                            
                            echo '</div>';  
                    }

            ?>
            </div>
      </div>
      <br>
</div>
<br>
 <div class="card mb-4 mt-1">
  <div class="card-header"><h5 class="card-title">Agregar Imagenes de salida de la reparacion</h5></div>
    <div class="card-body">
        <form id="reparacionImgSalidaForm" class="p-4 dropzone" enctype="multipart/form-data"  >
        <div class="fallback">
          <input name="file" type="file" multiple />
        </div>

                
        </form>
        <!-- ./card-body -->
    </div>
    <div class="card-footer d-grid gap-1">
      <button type="button" class="btn btn-success text-white" onclick="agregarImagenes('<?php echo $_GET['id']; ?>','salida')">Agregar Imagenes</button>
    </div>
</div><!-- ./card -->
<br>

<div class="container-fluid bg-white">
    <br>
      <h4>Imagenes de la reparación</h4>
      <br>
      
      <div>
        <h6>Imagenes de como salio el equipo del taller</h6>
            <div class="row">
            <?php
            $simplePath = '/storage/reparaciones/'.$_GET['id'].'/salida';
            $assetsPath = $rootPath . $simplePath;
                $filess = glob($assetsPath . '/*'); // Get all files in the directory
               
                    foreach ($filess as $file) {
                        $name =  basename($file);       
                            echo '<div class="col-6 col-md-3">';
                            echo '<div class="image-container"><a href="' . $simplePath. '/' . $name . '" data-lightbox="image-1" >';
                            echo '<img src="' . $simplePath. '/' . $name . '"'; 
                            echo 'class="img-responsive img-thumbnail" style="width: 100%; height: 150px; margin: 10px">';
                            echo '</a><button class="delete-button" onclick="deleteImage(this,`salida`,`'.$name.'`)">×</button></div>';                            
                            echo '</div>';  
                    }

            ?>
            </div>
      </div>
      <br>
</div>



<!-- cart-content -->



<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<link rel="stylesheet" href="./vendors/lightbox/style.min.css">
<style>
  .moneda {font-size: 1.5em;color: red;}
  .image-container {
    position: relative;
    display: inline-block;
}

.delete-button {
    position: absolute;
    top: 15px;
    right: 0px;
    background-color: rgba(255, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.delete-button:hover {
    background-color: rgba(255, 0, 0, 1);
}
</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script src="./vendors/select2/select2.min.js"></script>
<script src="./vendors/dropzone/dropzone.min.js"></script>
<script src="./vendors/lightbox/script.min.js"></script>


<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
<script>
    
  // Disable auto-discovery of Dropzone
  Dropzone.autoDiscover = false;
  var myDropzone1;
  var myDropzone2;
  // Initialize Dropzone
  $(document).ready(function () {

  
  myDropzone1 = new Dropzone("#reparacionImgEntradaForm",{
      url: "/storage/reparaciones", // URL where files will be uploaded
      paramName: "file", // Name of the file parameter
      maxFilesize: 4, // Maximum file size in MB
      acceptedFiles: "image/*", // Accept only image files
      addRemoveLinks: true, // Show remove links
      dictDefaultMessage: "Arrastra tus imágenes aquí o haz clic para subir", // Default message
      dictRemoveFile: "Eliminar", // Text for remove link
      dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo permitido: {{maxFilesize}}MB.",
  });
  myDropzone2 = new Dropzone("#reparacionImgSalidaForm",{
      url: "/storage/reparaciones", // URL where files will be uploaded
      paramName: "file", // Name of the file parameter
      maxFilesize: 4, // Maximum file size in MB
      acceptedFiles: "image/*", // Accept only image files
      addRemoveLinks: true, // Show remove links
      dictDefaultMessage: "Arrastra tus imágenes aquí o haz clic para subir", // Default message
      dictRemoveFile: "Eliminar", // Text for remove link
      dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo permitido: {{maxFilesize}}MB.",
  });

  });

  function agregarImagenes(id,tipo){
    var formData = new FormData();
    formData.append("method", "subir-imagenes");
    formData.append("id", id);
    formData.append("tipo", tipo);
    if(tipo == "entrada"){
      if(myDropzone1.files.length > 0){
          myDropzone1.files.forEach(e => {
            formData.append("imagenes[]", e);
          });
        }
    }else{
        if(myDropzone2.files.length > 0){
          myDropzone2.files.forEach(e => {
            formData.append("imagenes[]", e);
          });
        }
     }   

        
      $.ajax({
        url: "./index.php?action=repairman/repairman-controller",
        type: "POST",
        data: formData,
        processData: false, // Tell jQuery not to process the data
        contentType: false, // Tell jQuery not to set the content type
        success: function(data, textStatus, jqXHR) {
          toastr.success(data.msg, 'Exitoso', {timeOut: 500});
        setTimeout(() => {
            window.location.reload();
          }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
                $("#procesar-venta").prop("type","submit");
        }
      });
 
  }

  function deleteImage(button,tipo,img) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta imagen?")) {
        return; // Exit the function if the user cancels
    }
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    var formData = new FormData();
    formData.append("method", "eliminar-imagenes");
    formData.append("id", id);
    formData.append("tipo", tipo);
    formData.append("img", img);
    const imageContainer = button.closest('.image-container');
    $.ajax({
        url: "./index.php?action=repairman/repairman-controller",
        type: "POST",
        data: formData,
        processData: false, // Tell jQuery not to process the data
        contentType: false, // Tell jQuery not to set the content type
        success: function(data, textStatus, jqXHR) {
          toastr.success(data.msg, 'Exitoso', {timeOut: 500});
        setTimeout(() => {
            imageContainer.parentElement.remove();
          }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
                $("#procesar-venta").prop("type","submit");
        }
      });
    
  }
</script>

<?php include('partials.php');  ?> 
<?php include('repuestos-partials.php');  ?> 