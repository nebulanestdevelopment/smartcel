
<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
?>

<div class="container-fluid bg-white">
    <br>
<h4>Nueva Compra</h4>
<br>
<br>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-accesorios-tab" data-coreui-toggle="tab" data-coreui-target="#nav-accesorios" type="button" role="tab" aria-controls="nav-accesorios" aria-selected="true">Accesorios</button>
    <button class="nav-link " id="nav-accesorios-autos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-accesorios-autos" type="button" role="tab" aria-controls="nav-accesorios-autos" aria-selected="false">Accesorios de Autos</button>
    <button class="nav-link " id="nav-celulares-tab" data-coreui-toggle="tab" data-coreui-target="#nav-celulares" type="button" role="tab" aria-controls="nav-celulares" aria-selected="false">Celulares</button>
    <button class="nav-link " id="nav-repuestos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-repuestos" type="button" role="tab" aria-controls="nav-repuestos" aria-selected="false">Repuestos</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-accesorios" role="tabpanel" aria-labelledby="nav-accesorios-tab" tabindex="0">
</br>
  <div class="alert alert-info col-md-6">
    <p> Buscar <b>Accesorio</b> por CODIGO o por NOMBRE:</p>
  </div>
  <div class="row">
    <div class="col-sm-6">
    <input type="text" class="form-control" id="query-accesorios" name="query-accesorios" >
    </div>
    <div class="col-sm-6">
      <button type="button" class="btn btn-primary" id="btn-find-accesorios"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio</button>
      <button type="button" class="btn btn-danger" onclick="showAccesoriosContent()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg> Nuevo Accesorio</button>
    </div>
  </div>
  </br>  </br>
  <div id="show-find-accesorios-content" style="display: none;"> 
      
  </div>
  <div id="accesorios-content" style="display: none;"> 
      <?php include('accesorios-form.php'); ?>
  </div>

<!-- fin del tab accesorios -->
  </div>
  <div class="tab-pane fade" id="nav-accesorios-autos" role="tabpanel" aria-labelledby="nav-accesorios-autos-tab" tabindex="0">
    <!-- tab accesorios autos -->
    </br>
  <div class="alert alert-info col-md-6">
    <p> Buscar <b>Accesorio de Auto</b> por CODIGO o por NOMBRE:</p>
  </div>
  <div class="row">
    <div class="col-sm-6">
    <input type="text" class="form-control" id="query-accesorios-autos" name="query-accesorios-autos" >
    </div>
    <div class="col-sm-6">
      <button type="button" class="btn btn-primary" id="btn-find-accesorios-autos"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio</button>
      <button type="button" class="btn btn-danger" onclick="showAccesoriosAutosContent()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg> Nuevo Accesorio de Auto</button>
    </div>
  </div>
  </br>  </br>
  <div id="show-find-accesorios-autos-content" style="display: none;"> 
      
  </div>
  <div id="accesorios-autos-content" style="display: none;"> 
      <?php include('accesorios-autos-form.php'); ?>
  </div>
  
  
  <!-- ./tab accesorios autos -->
  </div>
  <div class="tab-pane fade" id="nav-celulares" role="tabpanel" aria-labelledby="nav-celulares-tab" tabindex="0">
    <!-- tab celulares -->
    </br>
      <div class="alert alert-info col-md-6">
        <p> Buscar <b>Celular</b> por IMIE1, IMEI2 o Modelo:</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
        <input type="text" class="form-control" id="query-celulares" name="query-celulares" placeholder="Buscar por IMEI1 o IMEI2" >
</br>
        <input type="text" class="form-control" id="modelo-celulares" name="modelo-celulares" placeholder="Buscar por modelo de celular">
        </div>
        <div class="col-sm-6">
          <button type="button" class="btn btn-primary" id="btn-find-celulares"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Celular</button>
          <button type="button" class="btn btn-danger" onclick="showCelularesContent()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg> Nuevo Celular </button>
        </div>
      </div>
      </br>  </br>
      <div id="show-find-celulares-content" style="display: none;"> 
          
      </div>
      <div id="celulares-content" style="display: none;"> 
          <?php include('celulares-form.php'); ?>
      </div>
    <!-- tab celulares -->
  </div>
  <div class="tab-pane fade " id="nav-repuestos" role="tabpanel" aria-labelledby="nav-repuestos-tab" tabindex="0">
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
          <button type="button" class="btn btn-danger" onclick="showRepuestosContent()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg> Nuevo repuesto </button>
        </div>
      </div>
      </br>  </br>
      <div id="show-find-repuestos-content" style="display: none;"> 
          
      </div>
      <div id="repuestos-content" style="display: none;"> 
          <?php include('repuestos-form.php'); ?>
      </div>
    <!-- ./repuestos -->
  </div>
</div>

<br>
</div>
<!-- product-content -->
</br>
<div class="container-fluid bg-white">
    <br>
      <h5>Lista de Items Agregados</h5>
      <br>
      <div id="cart-content">

      </div>
      <br>
</div>
<!-- cart-content -->
</br>
<div class="container-fluid bg-white">
    <br>
<h5>Resumen de compra</h5>
<br>
<form id="nueva-compra">
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Proveedor <button class="btn" type="button" onclick="crearProveedorCompras()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-5">
               <select name="proveedor-compra" id="proveedor-compra" class="form-select  js-example-basic-single">
               </select>
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha de compra</label>
            <div class="col-sm-5">
               <input type="date" class="form-control" id="fecha-compra" name="fecha-compra" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Factura #</label>
            <div class="col-sm-5">
               <input type="text" class="form-control" id="factura-compra" name="factura-compra" placeholder="Numero de factura segun la orden" >
            </div>
          </div>
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Tipo de compra</label>
            <div class="col-sm-5">
               <select name="tipo-compra" id="tipo-compra" class="form-select">
                <option value="1" selected>Contado</option>
                <option value="2">Credito</option>
               </select>
            </div>
          </div>
          <div id="table-total">

          </div>

          <div class="row mb-3">
              <div class="col-sm-3">
</div>  
              <div class="col-sm-5">
                <button type="submit" class="btn btn-primary" id="procesar-compra">Procesar Compra</button>
                <button type="button" class="btn btn-secundary" id="cancelar-compra" onclick="clearCart()">Cancelar Compra </button>
            </div>
          </div>
</form>  
<br>
</div>
<!-- procesar-compra -->


<!-- modal -->
<div class="modal modal-lg fade" id="ProveedorComprasModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorComprasModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorComprasForm">       
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon-social-compras" name="razon-social-compras" placeholder="Razon Social o Empresa" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre-compras" name="nombre-compras" placeholder="Nombre" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="apellido-compras" name="apellido-compras" placeholder="Apellido" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="direccion-compras" name="direccion-compras" placeholder="Direccion" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email-compras" name="email-compras" placeholder="Example@mail.com" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" id="telefono-compras" name="telefono-compras" placeholder="Telefono/Celular" >
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ProveedorComprasModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->



<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<style>
#nav-tab > .nav-link {
	display: block;
	padding: var(--cui-nav-link-padding-y) var(--cui-nav-link-padding-x);
	font-size: var(--cui-nav-link-font-size);
	font-weight: var(--cui-nav-link-font-weight);
	color: white !important;
	text-decoration: none;
	transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
	background: #337ab7;
	border-radius: 6px;
	margin-right: 4px;
}

#nav-tab > .nav-link.active {
	/* color: var(--cui-nav-tabs-link-active-color); */
	/* background-color: var(--cui-nav-tabs-link-active-bg); */
	border-color: #337ab7;
	background: white !important;
	color: #337ab7 !important;
	border-width: 2px;
	font-weight: 700;
}


</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script src="./vendors/select2/select2.min.js"></script>

<?php include('generico-partials.php');  ?> 
<?php include('proveedor-partial.php');  ?> 
<?php include('accesorios-partial.php');  ?>
<?php include('accesorios-autos-partial.php');  ?> 
<?php include('celulares-partial.php');  ?> 
<?php include('repuestos-partial.php');  ?> 
