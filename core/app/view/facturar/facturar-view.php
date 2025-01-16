
<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
?>

<div class="container-fluid bg-white">
    <br>
<h4>FACTURAR</h4>
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
    </div>
  </div>
  </br>  </br>
  <div id="show-find-accesorios-content" style="display: none;"> 
      
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
    </div>
  </div>
  </br>  </br>
  <div id="show-find-accesorios-autos-content" style="display: none;"> 
      
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
        </div>
      </div>
      </br>  </br>
      <div id="show-find-celulares-content" style="display: none;"> 
          
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
        </div>
      </div>
      </br>  </br>
      <div id="show-find-repuestos-content" style="display: none;"> 
          
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
<h5>Resumen de la Venta</h5>
<br>
<form id="nueva-venta">
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
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Tipo de venta</label>
            <div class="col-sm-5">
               <select name="tipo-venta" id="tipo-venta" class="form-select">
                <option value="1" selected>Contado</option>
                <option value="2">Credito</option>
               </select>
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
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha de venta</label>
            <div class="col-sm-5">
               <input type="date" class="form-control" id="fecha-venta" name="fecha-venta" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Factura #</label>
            <div class="col-sm-5">
               <input type="text" class="form-control" id="factura-venta" name="factura-venta" placeholder="Numero de factura segun talonario" >
            </div>
          </div>
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descuento aplicado (C$) </label>
            <div class="col-sm-5">
               <input type="text" class="form-control" id="descuentoc-venta" name="descuentoc-venta" value="0.00" disabled>
            </div>
          </div>
          
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descuento aplicado ($) </label>
            <div class="col-sm-5">
               <input type="text" class="form-control" id="descuentod-venta" name="descuentod-venta" value="0.00" disabled>
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Efectivo (C$) </label>
            <div class="col-sm-5">
               <input type="text" class="form-control" id="efectivoc-venta" name="efectivoc-venta" value="0" onkeyup="validateFloat(event, this),changeDolar('efectivoc-venta','efectivod-venta')" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Efectivo ($) </label>
            <div class="col-sm-5">
               <input type="text" class="form-control" id="efectivod-venta" name="efectivod-venta" value="0" onkeyup="validateFloat(event, this),changeCordoba('efectivod-venta','efectivoc-venta')" >
            </div>
          </div>
          
          
          <div id="table-total">

          </div>

          <div class="row mb-3">
              <div class="col-sm-3">
</div>  
              <div class="col-sm-5">
                <button type="submit" class="btn btn-primary" id="procesar-venta">Procesar venta</button>
                <button type="button" class="btn btn-secundary" id="cancelar-venta" onclick="clearCart()">Cancelar Venta </button>
            </div>
          </div>
</form>  
<br>
</div>
<!-- procesar-compra -->


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
<?php include('accesorios-partial.php');  ?>
<?php include('accesorios-autos-partial.php');  ?> 
<?php include('celulares-partial.php');  ?> 
<?php include('repuestos-partial.php');  ?> 
