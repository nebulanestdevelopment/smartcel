
<?php

$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
unset($_SESSION["cart-repair"]);
?>



<div class="card mb-4 mt-1">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0" id="titulo"></h4>
            </div>
        </div>
        <div>
            <a href="./index.php?view=reparacion/abiertas">Ver reparaciones</a>
        </div>
        <hr>

        <form id="reparacionForm" class="p-4">
                <input type="hidden"  name="idr" id="idr" >
                <input type="hidden"  name="idv" id="idv" >
                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Factura #</label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="factura" name="factura" >
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Cliente </label>
                    <div class="col-sm-5">
                      <select name="cliente-venta" id="cliente-venta" class="form-select  js-example-basic-single" disabled>
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
                      <select name="vendedor-venta" id="vendedor-venta" class="form-select  js-example-basic-single" disabled>
                      </select>
                    </div>
                  </div>

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Tecnico</label>
                    <div class="col-sm-5">
                        <select class="form-select  js-example-basic-single" name="tecnico" id="tecnico" disabled>
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
                        <input type="text" class="form-control" id="pvc" name="pvc" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc','pvd')" value="0" readonly>
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd" name="pvd" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd','pvc')" value="0" readonly>
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Total de la reparacion</label>
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
                    <input type="date" class="form-control" id="fecha" name="fecha" >
                    </div>
                </div>   

                <div class="row mb-3">
                    <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Estado de la reparacion</label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control" id="estado" name="estado" readonly>
                    </div>
                </div>   
                
                
                
        </form>
        <!-- ./card-body -->
    </div>
</div><!-- ./card -->
<!-- ./modal -->

<div class="container-fluid bg-white">
    <br>
      <h5>Lista de Repuestos Usados</h5>
      <br>
      <div id="cart-content">

      </div>
      <br>
</div>
<!-- cart-content -->
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
                        $file_name = basename($file);
                            echo '<div class="col-6 col-md-3">';
                            echo '<a href="' . $simplePath. '/' . $file_name . '" data-lightbox="image-1" >';
                            echo '<img src="' . $simplePath. '/' . $file_name . '"'; 
                            echo 'class="img-responsive img-thumbnail" style="width: 100%; height: 150px; margin: 10px">';
                            echo '</a>';                            
                            echo '</div>';
                    }

            ?>
            </div>
      </div>
      <br>
      <div>
        <h6>Imagenes de como salio el equipo del taller</h6>
            <div class="row">
            <?php
            $simplePath = '/storage/reparaciones/'.$_GET['id'].'/salida';
            $assetsPath = $rootPath . $simplePath;
                $filess = glob($assetsPath . '/*'); // Get all files in the directory
               
                    foreach ($filess as $file) {
                        $file_name = basename($file);
                            echo '<div class="col-6 col-md-3">';
                            echo '<a href="' . $simplePath. '/' . $file_name . '" data-lightbox="image-1" >';
                            echo '<img src="' . $simplePath. '/' . $file_name . '"'; 
                            echo 'class="img-responsive img-thumbnail" style="width: 100%; height: 150px; margin: 10px">';
                            echo '</a>';                            
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
</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script src="./vendors/select2/select2.min.js"></script>
<script src="./vendors/lightbox/script.min.js"></script>


<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>


<?php include('partials-ver.php');  ?> 
