<div class="container-fluid bg-white p-5" style="border-radius: 25px;">
<h2>Agregar nuevo repuesto</h2>
<hr>
</br>
<form id="RepuestosForm">
          <input type="hidden" name="method-r" id="method-r">
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Proveedor <button class="btn" type="button" onclick="crearProveedorR()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="proveedor-r" id="proveedor-r" class="form-select  js-example-basic-single">
               </select>
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Categoria <button class="btn" type="button" onclick="crearCategoriaR()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="categoria-r" id="categoria-r" class="form-select js-example-basic-single"></select>
            </div>
          </div>


          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Marca</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="marca-r" name="marca-r" placeholder="Marca del Repuesto" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Modelo</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="modelo-r" name="modelo-r" placeholder="Modelo del Repuesto" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Color</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="color-r" name="color-r" placeholder="Color del Repuesto" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descripcion</label>
            <div class="col-sm-8">
               <textarea class="form-control" id="description-r" name="description-r" placeholder="Descripcion del Repuesto" rows="2"></textarea>
            </div>
          </div>
         
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Compatibilidad</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="compatibilidad-r" name="compatibilidad-r" placeholder="Compatibilidad con otro Repuesto" >
            </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de entrada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pcc-r" name="pcc-r" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pcc-r','pcd-r')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pcd-r" name="pcd-r" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pcd-r','pcc-r')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de salida</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc-r" name="pvc-r" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc-r','pvd-r')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd-r" name="pvd-r" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd-r','pvc-r')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio especial</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pec-r" name="pec-r" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pec-r','ped-r')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ped-r" name="ped-r" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ped-r','pec-r')" value="0">
                    </div>

                </div>
          </div>
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Minima en inventario</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="mininv-r" name="mininv-r" value="1" min="0" max="1000" >
            </div>
          </div>

        
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
            <div class="col-sm-6">
               <input type="date" class="form-control" id="fecha-r" name="fecha-r" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-3">
              &nbsp;
            </div>
            <div class="col-6">
              <button type="submit" class="btn btn-primary" > Agregar repuesto</button>
            </div>
          </div>

            
        </form>


</div><!--./ container-fluid -->
</br>

<!-- modal -->
<div class="modal fade" id="categoriaRModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoriaRModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoriaRForm">         
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="cat-name-r" name="cat-name-r" placeholder="Categoria" onkeyup="this.value = this.value.toUpperCase();">
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Subcategoria</label>
            <select class="form-select" name="subcategoria-r" id="subcategoria-r">
              <option value="ACCESORIOS" disabled>ACCESORIOS</option>
              <option value="CELULARES" disabled>CELULARES</option>
              <option value="REPUESTOS" selected>REPUESTOS</option>              
              <option value="ACCESORIOS DE AUTOS" disabled>ACCESORIOS DE AUTOS</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="categoriaRModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->

<!-- modal -->
<div class="modal modal-lg fade" id="ProveedorRModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorRModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorRForm">
          <input type="hidden" name="method" id="method" value="save">         
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon-social-r" name="razon-social-r" placeholder="Razon Social o Empresa" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre-r" name="nombre-r" placeholder="Nombre" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="apellido-r" name="apellido-r" placeholder="Apellido" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="direccion-r" name="direccion-r" placeholder="Direccion" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email-r" name="email-r" placeholder="Example@mail.com" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" id="telefono-r" name="telefono-r" placeholder="Telefono/Celular" >
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ProveedorRModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->