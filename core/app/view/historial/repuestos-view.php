<?php

$entrada = intval(OperationData::getEntradaTotalByProductoId($_GET['id'])['q']);
$salida = intval(OperationData::getSalidaTotalByProductoId($_GET['id'])['q']);
$existencia = intval(OperationData::getUnitsTotalByProductoId($_GET['id']));

if($entrada == 0 && $salida == 0){
  header('location: ./index.php?view=producto/repuestos');
}
$salida_p = ($salida /  $entrada) *100;  //Probabilidad de salida
$existencia_p = ($existencia /  $entrada) *100;;   //Prob

?>

<div class="row mb-3">
                      <div class="col-6 col-lg-4">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-truck"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-primary"><?php echo $entrada; ?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">ENTRADAS</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-6 col-lg-4">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-success text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-check"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-success"><?php echo $existencia; ?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">DISPONIBLE</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-6 col-lg-4">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-danger text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-6 fw-semibold text-warning"><?php echo $salida; ?></div>
                              <div class="text-medium-emphasis text-uppercase fw-semibold small">SALIDAS</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-->

                      <!-- /.col-->
                    </div>



<div class="card mb-4 mt-1">
    <div class="card-body">
        <h3 class="p-4 pl-0 pb-0" style="padding-left: 10px !important;" id="titles-product-top"></h3><a href="./index.php?view=producto/repuestos" class="btn btn-link mb-4">Regresar al inventario de repuestos</a>

        

        <!-- otro -->
    <!--div class="row">
            <div class="col-sm-6 col-lg-4">
              <div class="card mb-4 text-white bg-success bg-opacity-75">
                <div class="card-body pb-5">
                    <div class="fs-1 fw-semibold text-center">Entradas</div>
                    <div class="display-2 text-center">0</div>                 
                </div>
              </div>
            </div>
          <!-- /.col-->
          <!--div class="col-sm-6 col-lg-4">
              <div class="card mb-4 text-white bg-info bg-opacity-75">
                <div class="card-body pb-5">
                    <div class="fs-1 fw-semibold text-center">Disponibles</div>
                    <div class="display-2 text-center">0</div>                 
                </div>
              </div>
            </div>
          <!-- /.col-->
          <!--div class="col-sm-6 col-lg-4">
              <div class="card mb-4 text-white bg-danger bg-opacity-75">
                <div class="card-body pb-5">
                    <div class="fs-1 fw-semibold text-center">Salidas</div>
                    <div class="display-2 text-center">0</div>                 
                </div>
              </div>
            </div>
          <!-- /.col-->
<!--/div-->          

    
    <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-primary bg-opacity-75">
                        <div class="card-body">
                        <div class="fs-4 fw-semibold">100%</div>
                        <div>Adquirida</div>
                        <div class="progress progress-white progress-thin my-2">
                            <div class="progress-bar" role="progressbar" style="width: 99%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><small class="text-uppercase"><?php echo $entrada; ?> unidades compradas</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-success bg-opacity-75">
                        <div class="card-body">
                        <div class="fs-4 fw-semibold"><?php echo number_format($existencia_p,2);;?>%</div>
                        <div>Disponibles</div>
                        <div class="progress progress-white progress-thin my-2">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo number_format($existencia_p,2); ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><small class="text-uppercase"><?php echo $existencia; ?> unidades en existencias</small>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card text-white bg-danger bg-opacity-75">
                        <div class="card-body">
                        <div class="fs-4 fw-semibold"><?php echo number_format($salida_p,2);?>%</div>
                        <div>Vendidas</div>
                        <div class="progress progress-white progress-thin my-2">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo number_format($salida_p,2); ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><small class="text-uppercase"><?php echo $salida;?> unidades vendidas</small>
                        </div>
                    </div>
                </div>

    </div>
<div style="width: 100%;height: 30px;"></div>
<h5 class="p-4 pl-0" style="padding-left: 6px !important;" id="titles-product-bottom"></h5>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
            <th scope="col">Cliente/Proveedor</th>
            <th scope="col">Nombre del Item</th>
            <th scope="col" class="text-center">Factura #</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Costo</th>
            <th scope="col">Precio</th>
            <th scope="col">Descuento</th>
            <th scope="col">Total</th>
            <th scope="col">Tipo</th>
            <th scope="col">Fecha</th>
            <th scope="col">Descripcion</th>
            <?php if(Roles::hasAdmin()){ ?> <th scope="col">Acciones</th><?php } ?>
            
            </tr>
        </thead>
        <tbody id="table-body">
        
        </tbody>
    </table>
</div>


</div>
</div><!-- ./card -->

<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script>
function formatMoney(amount) {
  return amount.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
}

function llenarTabla(id){
    var url = './index.php?action=historial/repuestos-controller&method=movimientos&id='+id;
    $.ajax({
        method: "GET",
        url: url,
        dataType: "json",
        success: function(data){
            
            $("#table-body").empty();
            var tipoOperacion = ['','Entrada','Salida','Entrada Manual','Salida Manual'];
            for (var i=0; i<data.length;i++) {
                var fila  = '<td>'+data[i].cliente+'</td><td >'+data[i].item+'</td><td>'+data[i].factura+'</td><td class="text-center">'+data[i].unidades+'</td>';
                    fila += '<td class="text-right"><span class="badge me-1 rounded-pill bg-info">'+formatMoney(data[i].costo_c).replace('$','C$ ')+'</span><br>';
                    fila += '<span class="badge me-1 rounded-pill bg-success">'+formatMoney(data[i].costo_d)+'</span></td>';
                    fila += '<td class="text-right"><span class="badge me-1 rounded-pill bg-info">'+formatMoney(data[i].precio_c).replace('$','C$ ')+'</span><br>';
                    fila += '<span class="badge me-1 rounded-pill bg-success">'+formatMoney(data[i].precio_d)+'</span></td>';
                    fila += '<td class="text-right"><span class="badge me-1 rounded-pill bg-info">'+formatMoney(data[i].descuento_c).replace('$','C$ ')+'</span><br>';
                    fila += '<span class="badge me-1 rounded-pill bg-success">'+formatMoney(data[i].descuento_d)+'</span></td>';
                    fila += '<td class="text-right"><span class="badge me-1 rounded-pill bg-info">'+formatMoney(data[i].total_c).replace('$','C$ ')+'</span><br>';
                    fila += '<span class="badge me-1 rounded-pill bg-success">'+formatMoney(data[i].total_d)+'</span></td>';
                    fila += '<td>'+tipoOperacion[data[i].status]+'</td>';
                    fila += '<td>'+data[i].fecha+'</td>';
                    fila += '<td>'+((data[i].descripcion===null)?'':data[i].descripcion) +'</td>';
               <?php if(Roles::hasAdmin()){ ?>     fila += '<td><button type="button" onclick="eliminarRecord('+data[i].id+','+data[i].product_id+')" class="btn btn-danger text-white btn-xs">Eliminar</button>';<?php } ?>
                    var color = (data[i].tipo_operacion == "Salida")?"background:#f2dede":"background:#dff0d8";
                    $("#table-body").append('<tr style="'+color+'">'+fila+'</tr>');
            }
        }, 
        error: function(){
            alert("Ocurrió un error al cargar los detalles.");
        }
    });
}


function obtenerDatosGenerales(id){
    var url = "./index.php?action=producto/repuestos-controller&method=edit&id="+id;
    $.ajax({
        method: "GET",
        url: url,
        dataType: "json",
        success: function(data){
            
          var $title = data.categoria+' '+data.marca+' '+ data.modelo+' '+ data.color;
          $("#titles-product-top").empty().html($title);
          $("#titles-product-bottom").empty().html($title);
        },
        error: function(){
            alert("Ocurrió un error al cargar los detalles.");
        }
    });
}

function eliminarRecord(oid,pid){
  if (confirm('Esta seguro que desea eliminar este registro!!!') == true) {
      var request;
        if (request) {
          request.abort();
      }  
      request = $.ajax({
          url: "./index.php?action=historial/repuestos-controller",
          type: "post",
          data: {oid:oid,pid:pid,method:'delete-operation'}
      });
      request.done(function (data, textStatus, jqXHR){
       // initPage();
        toastr.success(data.msg, 'Exitoso', {timeOut: 3000});
        window.location.reload();
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

function initPage(){
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");
   llenarTabla(id);
   obtenerDatosGenerales(id);
   
}

$(document).ready(function() {
   
  initPage();
});

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>
