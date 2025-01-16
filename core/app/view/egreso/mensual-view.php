<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
?>
<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Pagos del Mes en curso</h4>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-outline-dark" onclick="crearPago()">Agregar pago</button>
                </div>
              </div>
              <div class="c-chart-wrapper" style="margin-top:60px;">
              <!-- table -->

              <div class="table-responsive">
                  
              </div>
              <!-- ./table -->
              </div>
            </div>
            <div class="card-footer">
              <table class="table" style="width:100%;">
                <thead><tr>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Egresos en Cordobas (C$)</th>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Egresos en Dolares ($)</th>
                </tr></thead>
                <tbody>
                    <tr>
                        <td class="text-center"><span class="cordoba moneda"></span></td>
                        <td class="text-center"><span class="dolar  moneda"></span></td>
                    </tr>
                </tbody>
              </table>

            </div><!-- ./card-footer -->
          </div><!-- ./card -->

<!-- modal -->
<div class="modal modal-lg fade" id="pagoModal" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pagoModalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="pagoForm">
          <input type="hidden" name="idpago" id="idpago">
          <input type="hidden" name="method" id="method">
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Tipo de pago</label>
            <div class="col-sm-8">
              <select class="form-select" name="tipo" id="tipo">
              </select>
            </div>
          </div>
          
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Descripcion</label>
            <div class="col-sm-8">
            <textarea type="area" rows="2" class="form-control" id="descripcion" name="descripcion" placeholder="descripcion" onkeyup="this.value = this.value.toLowerCase();"></textarea> 
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Pago en Cordobas</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="c" name="c" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar()" onfocusout="">
            </div>
          </div>

          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Pago en Dolares</label>
            <div class="col-sm-8">
               <input type="text" class="form-control" id="d" name="d" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba()" onfocusout="">
            </div>
          </div>
          <div class="row mb-3">
            <label for="nombre" class="col-sm-3 col-form-label">Fecha de pago</label>
            <div class="col-sm-8">
               <input type="date" class="form-control" id="fecha" name="fecha" >
            </div>
          </div>
          
 </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="pagoModalAction" >Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- ./modal -->
<link rel="stylesheet" href="./vendors/datatable/datatables.min.css">
<link rel="stylesheet" href="./vendors/datatable/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<style>
  .moneda {font-size: 1.5em;color: red;}
</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/datatable/datatables.min.js"></script>
<script src="./vendors/datatable/dataTables.bootstrap5.min.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script>
  var table = '<table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr><th>Tipo de pago</th><th>Descripcion</th><th>Moneda (C$)</th><th>Moneda ($)</th><th>Fecha</th><th>Acciones</th></tr></thead>';
  table += '<tbody></tbody></table>';
function drawTable(){
    $(".table-responsive").empty().append(table);    
    new DataTable('#example', {
    ajax: './index.php?action=egreso/pago-controller&method=get-mes-actual',
    columns: [
        { data: 'name' },
        { data: 'descripcion' },
        { data: 'c' },
        { data: 'd' },
        { data: 'create' },
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarPago('+data.id+')">Editar</button>&nbsp;&nbsp;';
                        render += '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deletePago('+data.id+',`'+data.name+'`)">Eliminar</button>';
                     return render;
                }
        }
    ],
    /*search: {
        return: true
    },*/
    processing: true,
    paging: false,
    language: {
        url: './vendors/datatable/es-ES.json'
    },
    scrollCollapse: true,
    scrollY: '50vh',
    columnDefs: [
        {
            targets: [0],
            orderData: [0, 1]
        },
        {
            targets: [1],
            orderData: [1, 0]
        }
            ]
    });
}
function validateFloat(event, input) {
  const regex = /^\d*\.?\d{0,2}$/;
  const inputValue = input.value;
  if (!regex.test(inputValue)) {
    toastr.error('solo se permiten numeros con 2 decimales o enteros', 'Error', {timeOut: 3000});
    input.value = inputValue.slice(0, -1);
  }
}

function tipoPago(inputValue){
    $.get("./index.php?action=egreso/tipos-pago-controller&method=get-all", function(data, status){
      $('#tipo').empty();
        data.data.forEach(e => {
          $('#tipo').append('<option value="'+e.name+'">'+e.name+'</option>');
        });
        if(inputValue === ""){
          $("#tipo").prop("selectedIndex", 0).val();
        }else{
          $("#tipo").val(inputValue).change();
        }
         
    });
}

function getGastosMesActual(){
    $.get("./index.php?action=egreso/pago-controller&method=get-total-gastos-mes-actual", function(data, status){
      $(".cordoba").empty().html(data.cordoba);
      $(".dolar").empty().html(data.dolar);      
    });
}

function changeDolar(){
  var tasaCambio = parseFloat(sessionStorage.getItem("tasaCambio")).toFixed(2);
  var cordoba = parseFloat($('#c').val()).toFixed(2);
  var cambio = (cordoba / tasaCambio).toFixed(2);
  $('#d').val(cambio);
}

function changeCordoba(){
  var tasaCambio = parseFloat(sessionStorage.getItem("tasaCambio")).toFixed(2);
  var dolar = parseFloat($('#d').val()).toFixed(2);
  var cambio = (dolar * tasaCambio).toFixed(2);
  $('#c').val(cambio);
}

function crearPago(){
  var myModal = new coreui.Modal(document.getElementById('pagoModal'), {
      keyboard: false,
      backdrop:'static'
    });
  $('#pagoModalTitle').html("Nuevo pago");
  $('#pagoModalAction').html("Agregar pago");
  $('#method').val("save");
  $('#nombre').val("");
  $('#idpago').val(0);
  document.getElementById('pagoModalAction').setAttribute('onclick','guardarNuevoPago()');
  tipoPago("");
  myModal.show()

}

function guardarNuevoPago(){
        if($('#fecha').val().trim() === ""){
          toastr.error("Ingrese una fecha de pago válida","Fecha vacía",{timeOut: 3000});
          return false;
        }
        var request;
        var FormData = $("#pagoForm").serialize();
        if (request) {
            request.abort();
        }  
        request = $.ajax({
            url: "./index.php?action=egreso/pago-controller",
            type: "post",
            data: FormData
        });
        request.done(function (data, textStatus, jqXHR){
         drawTable();
         getGastosMesActual();
         $('#pagoModal').modal('hide');
          toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
          toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
}


function editarPago(id){
  var myModal = new coreui.Modal(document.getElementById('pagoModal'), {
      keyboard: false,
      backdrop:'static'
    });

    $.get("./index.php?action=egreso/pago-controller&method=edit&id="+id, function(data, status){
      tipoPago(data.name);
      $('#descripcion').val(data.descripcion);
      $('#c').val(data.c);
      $('#d').val(data.d);
      $('#fecha').val(data.create);
      $('#pagoModalTitle').html("Actualizar pago");
      $('#pagoModalAction').html("Actualizar pago");
      $('#method').val("update");
      $('#idpago').val(data.id);
      document.getElementById('pagoModalAction').setAttribute('onclick','actualizarPago()');
      myModal.show()
    });
    return true;
}

function actualizarPago(){
  
  
  var request;
  var FormData = $("#pagoForm").serialize();
  if (request) {
      request.abort();
  }  
  request = $.ajax({
      url: "./index.php?action=egreso/pago-controller",
      type: "post",
      data: FormData
  });
  request.done(function (data, textStatus, jqXHR){
    drawTable();
    getGastosMesActual();
    $('#pagoModal').modal('hide');
    toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
  });
  request.fail(function (jqXHR, textStatus, errorThrown){
    toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
      console.error(
          "The following error occurred: "+
          textStatus, errorThrown
      );
  });
} 

function deletePago(id,pago){
  if (confirm('Desea eliminar la pago: "'+pago+'"') == true) {
      var request;
        if (request) {
          request.abort();
      }  
      request = $.ajax({
          url: "./index.php?action=egreso/pago-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
        drawTable();
        getGastosMesActual();
        toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
      });
      request.fail(function (jqXHR, textStatus, errorThrown){
        toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
          console.error(
              "The following error occurred: "+
              textStatus, errorThrown
          );
      });
  } 
}


$(document).ready(function() {

drawTable();
getGastosMesActual();
});

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>