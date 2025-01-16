<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
?>
<div class="container-fluid bg-white p-5" style="border-radius: 25px;">
<h6><span id="title-page-inv"></span> | <small>Actualizar inventario</small> </h6>
<hr>
</br>
<form id="repuestosInvForm">
          <input type="hidden" name="idAccesorioInv" id="idAccesorioInv">
          
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Inventario Existente</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="inventario" name="inventario" value="1" min="0" max="1000" disabled >
            </div>
          </div>


          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Aumentar existencias</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="aumentar" name="aumentar" value="0" min="0" max="1000" onkeypress="validateInteger(event, this)">
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Decrementar existencias</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="decrementar" name="decrementar" value="0" min="0" max="1000"  onkeypress="validateInteger(event, this)">
            </div>
          </div>        

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Justificacion</label>
            <div class="col-sm-8">
               <textarea class="form-control" id="justificacion" name="justificacion" placeholder="Justifique porque aumenta o decrementa el inventario del accesorio de auto" rows="2"></textarea>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-3">
              &nbsp;
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-primary" onclick="actualizarInventario();"> Actualizar inventario</button>
              <button type="button" class="btn btn-secundary" onclick="window.location.href='./index.php?view=producto/accesorios';"> Ver inventario de accesorios</button>
              
            </div>
          </div>

            
        </form>


</div><!--./ container-fluid -->
</br>
<!-- ./modificar inventario -->
<div class="container-fluid bg-white p-5" style="border-radius: 25px;">
<h6><span id="title-page"></span> | editar accesorio de auto</h6>
<hr>
</br>

<form id="ClienteForm">
          <input type="hidden" name="idAccesorio" id="idAccesorio">
          <input type="hidden" name="method" id="method">
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Imagen</label>
            <div class="col-sm-8">
              
                 <input class="form-control" type="file" id="image" name="image" accept="image/*">
                 <input type="hidden" name="image-old" id="image-old" >
</br>
                 <div class="row">
                    <div class="col text-center"> 
                        <span style="font-weight: bold;">Nueva Imagen</span></br>
                        <img id="imagePreview" src=""  style="min-width:100px; max-width:200px; width: 100%; height: auto;"/>
                    </div>
                    <div class="col text-center"> 
                        <span style="font-weight: bold;">Imagen Actual</span></br>
                        <img id="imagePreview1" src=""  style="min-width:100px; max-width:200px; width: 100%; height: auto;" class="img-thumbnail"/>
                    </div>
                 </div>
                 
            </div>
            
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Proveedor <button class="btn" type="button" onclick="crearProveedor()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="proveedor" id="proveedor" class="form-select  js-example-basic-single">
               </select>
            </div>
          </div>
<div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Categoria <button class="btn" type="button" onclick="crearCategoria()"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-plus"></use></svg></button></label>
            <div class="col-sm-8">
               <select name="categoria" id="categoria" class="form-select js-example-basic-single"></select>
            </div>
          </div>


          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Codigo</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo del accesorio" >
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Nombre</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del accesorio" >
            </div>
          </div>   
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Descripcion</label>
            <div class="col-sm-8">
               <textarea class="form-control" id="description" name="description" placeholder="Descripcion del accesorio" rows="2"></textarea>
            </div>
          </div>
         
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Presentacion</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="presentation" name="presentation" placeholder="Presentacion del accesorio" >
            </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de entrada</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pcc" name="pcc" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pcc','pcd')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pcd" name="pcd" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pcd','pcc')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio de salida</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pvc" name="pvc" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pvc','pvd')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="pvd" name="pvd" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('pvd','pvc')" value="0">
                    </div>

                </div>
          </div>

          <div class="row mb-3">
                <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Precio especial</label>
                <div class="col-sm-8 row">
                    <div class="input-group col">
                        <span class="input-group-text">C$</span>
                        <input type="text" class="form-control" id="pec" name="pec" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar('pec','ped')" value="0">
                    </div>
                    <div class="input-group col">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" id="ped" name="ped" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba('ped','pec')" value="0">
                    </div>

                </div>
          </div>

          
          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Minima en inventario</label>
            <div class="col-sm-6">
               <input type="number" class="form-control" id="mininv" name="mininv" value="1" min="0" max="1000" onkeypress="validateInteger(event, this)">
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Unidades en existencias</label>
            <div class="col-sm-6">
               <input type="text" class="form-control" id="invini" name="invini" disabled >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Factura #</label>
            <div class="col-sm-6">
               <input type="text" class="form-control" id="factura" name="factura" placeholder="# de factura segun la compra" >
            </div>
          </div>

          <div class="row mb-3"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;">Fecha</label>
            <div class="col-sm-6">
               <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" >
            </div>
          </div>
          <div class="row mt-4"> 
            <label for="nombre" class="col-sm-3 col-form-label" style="text-align: right;"></label>
            <div class="col-sm-6">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="active" id="active" >
                  <label class="form-check-label" for="flexCheckChecked">
                   <strong>Esta Activo</strong>
                </label>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-3">
              &nbsp;
            </div>
            <div class="col-6">
              <!--button type="button" class="btn btn-primary" onclick="guardarRepuesto();"> Agregar accesorio</button-->
              
              <button type="submit" class="btn btn-primary"> Actualizar informacion</button>
              <button type="button" class="btn btn-success" onclick="duplicarProducto()"> Duplicar accesorio</button>
              <button type="button" class="btn btn-secundary" onclick="window.location.href='./index.php?view=producto/accesorios';"> Ver inventario de accesorios</button>
              
            </div>
          </div>

            
        </form>


</div><!--./ container-fluid -->
</br>

<!-- modal -->
<div class="modal fade" id="categoriaModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoriaModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoriaForm">
          <input type="hidden" name="idCategoria" id="idCategoria">
          <input type="hidden" name="method" id="method">
         
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="cat-name" name="cat-name" placeholder="Categoria" onkeyup="this.value = this.value.toUpperCase();">
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Subcategoria</label>
            <select class="form-select" name="subcategoria" id="subcategoria">
              <option value="ACCESORIOS" selected>ACCESORIOS</option>
              <option value="CELULARES" disabled>CELULARES</option>
              <option value="REPUESTOS" disabled>REPUESTOS</option>              
              <option value="ACCESORIOS DE AUTOS" disabled>ACCESORIOS DE AUTOS</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="categoriaModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->

<!-- modal -->
<div class="modal modal-lg fade" id="ProveedorModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ProveedorModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ProveedorForm">
          <input type="hidden" name="method" id="method" value="save">         
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Razon social</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razon Social o Empresa" >
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
        <button type="button" class="btn btn-primary" id="ProveedorModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->

<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>

<script src="./vendors/select2/select2.min.js"></script>

<script>

function getAllCategory($value,$id){
  $('#categoria').empty();
  $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=ACCESORIOS", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == e.name)?"selected":"";
        $('#categoria').append('<option value="'+e.id+'" '+$selected+'>'+e.name+'</option>');
      });
       $('#categoria').val($id).change();
       $('#categoria').select2();
  });
}

function getAllProveedores($value,$id){
  $('#proveedor').empty();
  $.get("./index.php?action=cliente/proveedor-controller&method=get-all", function(data, status){
      data.data.forEach(e => {
        var $selected = ($value == '['+e.razon_social+'] '+e.completo)?"selected":"";
        $('#proveedor').append('<option value="'+e.id+'" '+$selected+'>['+e.razon_social+'] '+e.completo+'</option>');
      });
      $('#proveedor').val($id).change();
      $('#proveedor').select2();
  });
}

function crearCategoria(){
  var myModal = new coreui.Modal(document.getElementById('categoriaModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#categoriaModalTitle').html("Nueva Categoria");
  $('#categoriaModalAction').html("Agregar Categoria");
  $('#cat-name').val("");
  $('#subcategoria').val("ACCESORIOS").change();
  $('#idCategoria').val(0);
  document.getElementById('categoriaModalAction').setAttribute('onclick','guardarNuevaCategoria()');
  myModal.show();
}

function guardarNuevaCategoria(){  
        if($("#cat-name").val().trim().length < 3){
          alert("Debe escribir el nombre de la categoria...")
          return false;
        }
        var dataForm = {method:'save-return',nombre:$("#cat-name").val().trim(),subcategoria:'ACCESORIOS'};
        var request;
        
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=categoria-controller",
            type: "POST",
            data: dataForm
        });
        request.done(function (data, textStatus, jqXHR){
          $('#categoriaModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          getAllCategory($("#cat-name").val().trim(),data.id);
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}
function crearProveedor(){
  var myModal = new coreui.Modal(document.getElementById('ProveedorModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#ProveedorModalTitle').html("Nuevo Proveedor");
  $('#ProveedorModalAction').html("Agregar Proveedor");
  $('#method').val("save");
  $('#razon_social').val("");
  $('#nombre').val("");
  $('#apellido').val("");
  $('#direccion').val("");
  $('#email').val("");
  $('#telefono').val("");
  $('#idProveedor').val(0);
  document.getElementById('ProveedorModalAction').setAttribute('onclick','guardarNuevaProveedor()');
  myModal.show();
}

function guardarNuevaProveedor(){
  
        if($("#nombre").val().trim().length < 2){
          alert("Debe escribir el nombre del Proveedor...")
          return false;
        }

        if($("#apellido").val().trim().length < 2){
          alert("Debe escribir el apellido del Proveedor...")
          return false;
        }

        var emailField = document.getElementById('email');
        var validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

        var phoneField = document.getElementById('telefono');
        var validPhone = /^\d{8}$/;

        if (!validEmail.test(emailField.value)) {
            alert('El email es obligatorio');
            return false;
        }

        if (!validPhone.test(phoneField.value)) {
            alert('El teléfono debe tener exactamente 8 dígitos');
            return false;
        }
        
        var request;
        var FormData = $("#ProveedorForm").serialize();
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=cliente/proveedor-controller",
            type: "post",
            data: FormData
        });
        request.done(function (data, textStatus, jqXHR){
          var $pro = '['+$("#razon_social").val()+'] '+$("#nombre").val().trim()+' '+$("#apellido").val().trim();
          $('#ProveedorModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          getAllProveedores($pro,data.id);
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}

/********/
function validateFloat(event, input) {
  const regex = /^\d*\.?\d{0,2}$/;
  const inputValue = input.value;
  if (!regex.test(inputValue)) {
    toastr.error('solo se permiten numeros con 2 decimales o enteros', 'Error', {timeOut: 3000});
    input.value = inputValue.slice(0, -1);
  }
}

function validateInteger(event, input) {
  const regex = /^\d*$/;
  const inputValue = input.value;
  if (!regex.test(inputValue)) {
    toastr.error('Solo se permiten numeros', 'Error', {timeOut: 3000});
    input.value = inputValue.slice(0, -1);
  }
}


function changeDolar($in,$out){
  if($('#'+$in).val().trim().length > 0 ){
    var tasaCambio = parseFloat(sessionStorage.getItem("tasaCambio")).toFixed(2);
    var cordoba = parseFloat($('#'+$in).val()).toFixed(2);
    var cambio = (cordoba / tasaCambio).toFixed(2);
    $('#'+$out).val(cambio);
  } 
}

function changeCordoba($in,$out){
  if($('#'+$in).val().trim().length > 0 ){
    var tasaCambio = parseFloat(sessionStorage.getItem("tasaCambio")).toFixed(2);
    var dolar = parseFloat($('#'+$in).val()).toFixed(2);
    var cambio = (dolar * tasaCambio).toFixed(2);
    $('#'+$out).val(cambio);
  }
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#imagePreview').attr('src', e.target.result);
      $('#imagePreview').attr('class', 'img-thumbnail');      
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$("#image").change(function() {
  readURL(this);
});

function duplicarProducto(){
  var dataForm = {method:'duplicar-producto',
                        id:parseInt($("#idAccesorio").val().trim())
                        };
        var request;        
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=producto/accesorios-controller",
            type: "POST",
            data: dataForm
        });
        request.done(function (data, textStatus, jqXHR){
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          setTimeout(function(){window.location.href= './index.php?view=producto/accesorios-edit&id='+data.id ;},2500);
          

        });
        request.fail(function (jqXHR, textStatus, errorThrown){       
          toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000})           
        });
}
function actualizarInventario(){
  
  var dataForm = {method:'update-inventario',
                        id:parseInt($("#idAccesorioInv").val().trim()),
                        aumentar:parseInt($("#aumentar").val().trim()),
                        decrementar:parseInt($("#decrementar").val().trim()),
                        justificacion:$("#justificacion").val().trim(),
                        };
        var request;        
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=producto/accesorios-controller",
            type: "POST",
            data: dataForm
        });
        request.done(function (data, textStatus, jqXHR){
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
          setTimeout(function(){window.location.reload();},500);
          

        });
        request.fail(function (jqXHR, textStatus, errorThrown){
       
          toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000})           
        });
}


$("#ClienteForm").submit(function(event) {
  event.preventDefault(); 
  var imageFile = $("#image")[0].files[0];
  var active = (document.getElementById('active').checked) ? 1 : 0;
  var formData = new FormData();
  formData.append("image", imageFile);
  formData.append("method", "update");
  formData.append("id", parseInt($("#idAccesorio").val()));
  formData.append("img",$("#image-old").val());
  formData.append("proveedor", parseInt($("#proveedor").find('option:selected').val()));
  formData.append("categoria", parseInt($("#categoria").find('option:selected').val()));
  formData.append("codigo", $("#codigo").val().trim());
  formData.append("name", $("#name").val().trim());  
  formData.append("description", $("#description").val().trim());
  formData.append("presentation", $("#presentation").val().trim());
  formData.append("compra_c", parseFloat($("#pcc").val().trim()));
  formData.append("compra_d", parseFloat($("#pcd").val().trim()));
  formData.append("venta_c", parseFloat($("#pvc").val().trim()));
  formData.append("venta_d", parseFloat($("#pvd").val().trim()));
  formData.append("esp_c", parseFloat($("#pec").val().trim()));
  formData.append("esp_d", parseFloat($("#ped").val().trim()));
  formData.append("mininv", parseInt($("#mininv").val()));
  formData.append("factura", $("#factura").val().trim());
  formData.append("fecha", $("#fecha").val());
  formData.append("active", parseInt(active));
 
  $.ajax({
    url: "./index.php?action=producto/accesorios-controller",
    type: "POST",
    data: formData,
    processData: false, // Tell jQuery not to process the data
    contentType: false, // Tell jQuery not to set the content type
    success: function(data, textStatus, jqXHR) {
      document.getElementById("ClienteForm").reset();
      $('#imagePreview').removeAttr('src').removeClass('img-thumbnail');
      toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
      window.location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error(textStatus, errorThrown);
      toastr.error(jqXHR.responseText, 'Fallo', {timeOut: 5000});
    }
  });
});


$(document).ready(function(){
  const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    $("#idAccesorio").val(id);
    $("#idAccesorioInv").val(id);
    $.getJSON('./index.php?action=producto/accesorios-controller&method=edit&id='+id, function(v) {
      getAllCategory(v.categoria,v.categoriaid);
      getAllProveedores(v.proveedor,v.proveedorid);
      const $title =  v.categoria+' '+v.name; 
      $("#title-page, #title-page-inv").html($title);
      $("#imagePreview1").attr('src','./storage/products/'+v.image);
      $("#image-old").val(v.image);
      $("#description").val(v.description);
      $("#presentation").val(v.presentation);
      $("#codigo").val(v.codigo);
      $("#name").val(v.name);
      $("#pcc").val(v.costo_c);
      $("#pcd").val(v.costo_d);
      $("#pvc").val(v.precio_c);
      $("#pvd").val(v.precio_d);
      $("#pec").val(v.precio_es_c);
      $("#ped").val(v.precio_es_d);
      $("#mininv").val(v.min_inv);
      $("#unit").val(v.unidades);
      $("#invini").val(v.unidades);
      $("#inventario").val(v.unidades);
      $("#factura").val(v.factura);
      $("#fecha").val(v.fecha_input);
      const state = (parseInt(v.active) === 1)?true:false;
      $("#active").prop('checked',state).trigger('change');     
});  
 
});


$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>