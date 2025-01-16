
<div class="container-fluid bg-white p-5" style="border-radius: 25px;">
<h2>Agregar nuevo equipo celular</h2>
<hr>
</br>

<form id="CelularesForm">
          <input type="hidden" name="method" id="method">
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Proveedor <button class="btn" type="button" onclick="crearProveedorC()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="proveedor-c" id="proveedor-c" class="form-select  js-example-basic-single">
               </select>
            </div>
          </div>



          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">IMEI #1</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="imei1-c" name="imei1-c" placeholder="CODIGO IMEI #1" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">IMEI #2</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="imei2-c" name="imei2-c" placeholder="CODIGO IMEI #2" >
            </div>
          </div>  
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Marca</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="marca-c" name="marca-c" placeholder="Marca del celular" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Modelo</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="modelo-c" name="modelo-c" placeholder="Modelo del celular" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">color</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="color-c" name="color-c" placeholder="Color del celular" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Categoria <button class="btn" type="button" onclick="crearCategoriaCelulares()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="categoria-c" id="categoria-c" class="form-select js-example-basic-single"></select>
            </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de entrada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pcc-c" name="pcc-c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pcc-c','pcd-c')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pcd-c" name="pcd-c" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pcd-c','pcc-c')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de salida</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc-c" name="pvc-c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc-c','pvd-c')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd-c" name="pvd-c" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd-c','pvc-c')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio especial</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pec-c" name="pec-c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pec-c','ped-c')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ped-c" name="ped-c" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ped-c','pec-c')" value="0">
                    </div>

                </div>
          </div>

          
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Minima en inventario</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="mininv-c" name="mininv-c" value="1" min="0" max="1000" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
            <div class="col-sm-6">
               <input type="date" class="form-control" id="fecha-c" name="fecha-c" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-3">
              &nbsp;
            </div>
            <div class="col-6">
              <!--button type="button" class="btn btn-primary" onclick="guardarRepuesto();"> Agregar accesorio</button-->
              
              <button type="submit" class="btn btn-primary"> Agregar celular</button>
              
            </div>
          </div>

            
        </form>


</div><!--./ container-fluid -->
</br>

<!-- modal -->
<div class="modal fade" id="categoriaCModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoriaCModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoriaCForm">
          <input type="hidden" name="method-c" id="method-c">
         
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="cat-name-c" name="cat-name-c" placeholder="Categoria" onkeyup="this.value = this.value.toUpperCase();">
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Subcategoria</label>
            <select class="form-select" name="subcategoria-c" id="subcategoria">
              <option value="ACCESORIOS" disabled>ACCESORIOS</option>
              <option value="CELULARES" selected>CELULARES</option>
              <option value="REPUESTOS" disabled>REPUESTOS</option>              
              <option value="ACCESORIOS DE AUTOS" disabled>ACCESORIOS DE AUTOS</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="categoriaCModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->

<!-- modal -->
<div class="modal modal-lg fade" id="ProveedorCModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorCModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorCForm">
          <input type="hidden" name="method-c" id="method-c" value="save">         
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon_social_c" name="razon_social_c placeholder="Razon Social o Empresa" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre-c" name="nombre-c" placeholder="Nombre" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="apellido-c" name="apellido-c" placeholder="Apellido" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="direccion-c" name="direccion-c" placeholder="Direccion" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email-c" name="email-c" placeholder="Example@mail.com" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" id="telefono-c" name="telefono-c" placeholder="Telefono/Celular" >
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ProveedorCModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->