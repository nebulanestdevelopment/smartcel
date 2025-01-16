<div class="container-fluid bg-white p-5" style="border-radius: 25px;">
<h2>Agregar nuevo accesorio de auto</h2>
<hr>
</br>
<div class="col-md-6 alert alert-warning" style="text-align: left;margin-left:165px;" >
        <h6 style="margin: 0px;"><strong style="color: red;"><?php echo ProductoData::getLastCode(4)['codigo']; ?></strong> Ultimo Código Ingresado</h6>
    </div>
    </br>
<form id="accesoriosAutosForm">
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Imagen</label>
            <div class="col-sm-8">
                 <input class="form-control" type="file" id="image-ac" name="image-ac" accept="image/*">
                  </br>
                 <img id="imagePreview-ac" src=""  style="min-width:100px; max-width:200px; width: 100%; height: auto;"/>
            </div>
            
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Proveedor <button class="btn" type="button" onclick="crearProveedorAc()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="proveedor-ac" id="proveedor-ac" class="form-select  js-example-basic-single">
               </select>
            </div>
          </div>
<div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Categoria <button class="btn" type="button" onclick="crearCategoriaAc()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="categoria-ac" id="categoria-ac" class="form-select js-example-basic-single"></select>
            </div>
          </div>


          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Codigo</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="codigo-ac" name="codigo-ac" placeholder="Codigo del accesorio" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Nombre</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="name-ac" name="name-ac" placeholder="Nombre del accesorio" >
            </div>
          </div>         

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de entrada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pcc-ac" name="pcc-ac" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pcc-ac','pcd-ac')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pcd-ac" name="pcd-ac" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pcd-ac','pcc-ac')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de salida</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc-ac" name="pvc-ac" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc-ac','pvd-ac')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd-ac" name="pvd-ac" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd-ac','pvc-ac')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio especial</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pec-ac" name="pec-ac" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pec-ac','ped-ac')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ped-ac" name="ped-ac" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ped-ac','pec-ac')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descripcion</label>
            <div class="col-sm-8">
               <textarea class="form-control" id="description-ac" name="description-ac" placeholder="Descripcion del accesorio" rows="2"></textarea>
            </div>
          </div>
         
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Presentacion</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="presentation-ac" name="presentation-ac" placeholder="Presentacion del accesorio" >
            </div>
          </div>
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Minima en inventario</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="mininv-ac" name="mininv-ac" value="1" min="0" max="1000" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
            <div class="col-sm-6">
               <input type="date" class="form-control" id="fecha-ac" name="fecha-ac" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-3">
              &nbsp;
            </div>
            <div class="col-6">
             
              <button type="submit" class="btn btn-primary"> Agregar accesorio de auto</button>
             
            </div>
          </div>            
        </form>
</div><!--./ container-fluid -->
</br>

<!-- modal -->
<div class="modal fade" id="categoriaAccesoriosAutosModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoriaAccesoriosAutosModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoriaAccesoriosAutosForm">         
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="cat-name-ac" name="cat-name-ac" placeholder="Categoria" onkeyup="this.value = this.value.toUpperCase();">
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Subcategoria</label>
            <select class="form-select" name="subcategoria-ac" id="subcategoria-ac">
              <option value="ACCESORIOS" disabled>ACCESORIOS</option>
              <option value="CELULARES" disabled>CELULARES</option>
              <option value="REPUESTOS" disabled>REPUESTOS</option>              
              <option value="ACCESORIOS DE AUTOS" selected>ACCESORIOS DE AUTOS</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="categoriaAccesoriosAutosModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->

<!-- modal -->
<div class="modal modal-lg fade" id="ProveedorAcModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorAcModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorAcForm">      
        <input type="hidden" name="method-ac" id="method-ac" value="save">  
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon_social_ac" name="razon_social_ac" placeholder="Razon Social o Empresa" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="nombre-ac" name="nombre-ac" placeholder="Nombre" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Apellido</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="apellido-ac" name="apellido-ac" placeholder="Apellido" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Direccion</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="direccion-ac" name="direccion-ac" placeholder="Direccion" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control" id="email-ac" name="email-ac" placeholder="Example@mail.com" >
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Telefono</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" id="telefono-ac" name="telefono-ac" placeholder="Telefono/Celular" >
                </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="ProveedorAcModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->



