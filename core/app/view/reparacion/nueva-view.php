
<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
unset($_SESSION["cart-repair"]);
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
                <h4 class="card-title mb-0">Nueva reparacion</h4>
            </div>
        </div>
        <hr>

        <form id="reparacionForm" class="p-4" >

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Factura #</label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="factura" name="factura">
                    </div>
                </div>

                <div class="row mb-3">
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
                  </div>  
                  <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Vendedor </label>
                    <div class="col-sm-5">
                      <select name="vendedor-venta" id="vendedor-venta" class="form-select  js-example-basic-single">
                      </select>
                    </div>
                  </div>

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Tecnico</label>
                    <div class="col-sm-5">
                        <select class="form-select  js-example-basic-single" name="tecnico" id="tecnico">
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descripcion</label>
                    <div class="col-sm-5">
                      <textarea type="area" rows="2" class="form-control" id="descripcion" name="descripcion" placeholder="descripcion" onkeyup="this.value = this.value.toLowerCase();"></textarea> 
                    </div>
                </div>

                <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Costo del repuesto(s)</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc" name="pvc" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc','pvd')" value="0" >
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd" name="pvd" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd','pvc')" value="0" >
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Costo de la reparacion</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="total_c" name="total_c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('total_c','total_d'),obtenerGanancias()" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="total_d" name="total_d" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('total_d','total_c'),obtenerGanancias()" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Ganancia esperada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="ganancia_c" name="ganancia_c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('ganancia_c','ganancia_d')" value="0" readonly>
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ganancia_d" name="ganancia_d" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ganancia_d','ganancia_c')" value="0" readonly>
                    </div>

                </div>
          </div>
      
             


                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
                    <div class="col-sm-5">
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" >
                    </div>
                </div>   
                
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">&nbsp;</label>
                    <div class="col-sm-5">
                    <button type="submit" class="btn btn-primary" id="procesar-venta" >Guardar</button>
                    <button type="button" class="btn btn-secundary" id="clear-cart" onclick="clearCart()">Eliminar Repuestos</button>
                    </div>
                </div> 



                
        </form>
        <!-- ./card-body -->
    </div>
    <div class="card-footer d-grid gap-1">
            
    </div><!-- ./card-footer -->
</div><!-- ./card -->

<div class="card mb-4 mt-1">
    <div class="card-body">
        <form id="reparacionImgsForm" class="p-4 dropzone" enctype="multipart/form-data"  >
        <div class="fallback">
          <input name="file" type="file" multiple />
        </div>

                
        </form>
        <!-- ./card-body -->
    </div>
</div><!-- ./card -->







<!-- modal -->
<div class="modal modal-lg fade" id="ClienteModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ClienteModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ClienteForm">       
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Cedula</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="cedula" name="cedula" placeholder="161-000000-00001A" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Direccion" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email" name="email" placeholder="Example@mail.com" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono/Celular" >
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ClientesModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->


<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">

<style>
  .moneda {font-size: 1.5em;color: red;}
</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script src="./vendors/select2/select2.min.js"></script>
<script src="./vendors/dropzone/dropzone.min.js"></script>

<script>
    
  // Disable auto-discovery of Dropzone
  Dropzone.autoDiscover = false;
  var myDropzone;
  // Initialize Dropzone
  $(document).ready(function () {
    // Configure Dropzone for the form
  
  myDropzone = new Dropzone("#reparacionImgsForm",{
      url: "/storage/reparaciones", // URL where files will be uploaded
      paramName: "file", // Name of the file parameter
      maxFilesize: 4, // Maximum file size in MB
      acceptedFiles: "image/*", // Accept only image files
      addRemoveLinks: true, // Show remove links
      dictDefaultMessage: "Arrastra tus imágenes aquí o haz clic para subir", // Default message
      dictRemoveFile: "Eliminar", // Text for remove link
      dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo permitido: {{maxFilesize}}MB.",
  });


   /* $("#reparacionImgsForm").dropzone({
      url: "/storage/reparaciones", // URL where files will be uploaded
      paramName: "file", // Name of the file parameter
      maxFilesize: 4, // Maximum file size in MB
      acceptedFiles: "image/*", // Accept only image files
      addRemoveLinks: true, // Show remove links
      dictDefaultMessage: "Arrastra tus imágenes aquí o haz clic para subir", // Default message
      dictRemoveFile: "Eliminar", // Text for remove link
      dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo permitido: {{maxFilesize}}MB.", // Error message for file size
      init: function () {
         // Event: When a file is added
         this.on("addedfile", function(file) {
                console.log("File added: " + file.name);
                console.log("File size: " + file.size + " bytes");
                console.log("File type: " + file.type);
                console.log(file);
            });

            // Event: When a file is successfully uploaded
            this.on("success", function(file, response) {
                console.log("File uploaded successfully: " + file.name);
            });

            // Event: When a file upload fails
            this.on("error", function(file, message) {
                console.log("Error uploading file: " + file.name);
                console.log("Error message: " + message);
            });

            // Event: When a file is removed
            this.on("removedfile", function(file) {
                console.log("File removed: " + file.name);
            });

            // Event: When all files are uploaded
            this.on("queuecomplete", function() {
              console.log(file);
            });
      },
    });*/
  });
</script>

<?php include('partials.php');  ?> 
<?php include('repuestos-partials.php');  ?> 
