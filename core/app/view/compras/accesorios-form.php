
<div class="container-fluid bg-white p-5" style="border-radius: 25px;">
<h2>Agregar nuevo accesorio</h2>
<hr>
</br>
<div class="col-md-6 alert alert-warning" style="text-align: left;margin-left:165px;" >
        <h6 style="margin: 0px;"><strong style="color: red;"><?php echo ProductoData::getLastCode(1)['codigo']; ?></strong> Ultimo Código Ingresado</h6>
    </div>
    </br>
<form id="AccesoriosForm">          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Imagen</label>
            <div class="col-sm-8">
                 <input class="form-control" type="file" id="image-a" name="image-a" accept="image/*">
                  </br>
                 <img id="imagePreview-a" src=""  style="min-width:100px; max-width:200px; width: 100%; height: auto;"/>
            </div>
            
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Proveedor <button class="btn" type="button" onclick="crearProveedorA()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="proveedor-a" id="proveedor-a" class="form-select  js-example-basic-single">
               </select>
            </div>
          </div>
<div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Categoria <button class="btn" type="button" onclick="crearCategoriaAccesorios()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="categoria-a" id="categoria-a" class="form-select js-example-basic-single"></select>
            </div>
          </div>


          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Codigo</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="codigo-a" name="codigo-a" placeholder="Codigo del accesorio" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Nombre</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="name-a" name="name-a" placeholder="Nombre del accesorio" >
            </div>
          </div>         

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de entrada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pcc-a" name="pcc-a" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pcc-a','pcd-a')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pcd-a" name="pcd-a" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pcd-a','pcc-a')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de salida</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc-a" name="pvc-a" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc-a','pvd-a')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd-a" name="pvd-a" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd-a','pvc-a')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio especial</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pec-a" name="pec-a" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pec-a','ped-a')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ped-a" name="ped-a" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ped-a','pec-a')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descripcion</label>
            <div class="col-sm-8">
               <textarea class="form-control" id="description-a" name="description-a" placeholder="Descripcion del accesorio" rows="2"></textarea>
            </div>
          </div>
         
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Presentacion</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="presentation-a" name="presentation-a" placeholder="Presentacion del accesorio" >
            </div>
          </div>
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Minima en inventario</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="mininv-a" name="mininv-a" value="1" min="0" max="1000" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
            <div class="col-sm-6">
               <input type="date" class="form-control" id="fecha-a" name="fecha-a" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-3">
              &nbsp;
            </div>
            <div class="col-6">             
              <button type="submit" class="btn btn-primary"> Agregar accesorio</button>              
            </div>
          </div>            
        </form>


</div><!--./ container-fluid -->
</br>

<!-- modal -->
<div class="modal fade" id="categoriaAccesoriosModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoriaAccesoriosModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoriaAForm">
          <input type="hidden" name="method-a" id="method-a">
         
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="cat-name-a" name="cat-name-a" placeholder="Categoria" onkeyup="this.value = this.value.toUpperCase();">
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Subcategoria</label>
            <select class="form-select" name="subcategoria-a" id="subcategoria-a">
              <option value="ACCESORIOS" selected>ACCESORIOS</option>
              <option value="CELULARES" disabled>CELULARES</option>
              <option value="REPUESTOS" disabled>REPUESTOS</option>              
              <option value="ACCESORIOS DE AUTOS"  disabled>ACCESORIOS DE AUTOS</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="categoriaAccesoriosModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->

<!-- modal -->
<div class="modal modal-lg fade" id="ProveedorAModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorAModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorForm">
          <input type="hidden" name="method" id="method" value="save">         
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon_social_a" name="razon_social_a" placeholder="Razon Social o Empresa" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre-a" name="nombre-a" placeholder="Nombre" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="apellido-a" name="apellido-a" placeholder="Apellido" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="direccion-a" name="direccion-a" placeholder="Direccion" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email-a" name="email-a" placeholder="Example@mail.com" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" id="telefono-a" name="telefono-a" placeholder="Telefono/Celular" >
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ProveedorAModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->



