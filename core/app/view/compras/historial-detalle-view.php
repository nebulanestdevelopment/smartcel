<?php 
  if(!isset($_GET['id'])){
    header('location:  ./index.php?view=home');
  }
  $id=$_GET['id'];
  $sell_data = ComprasData::getCompraData($id);
  $sell_detail_data = ComprasData::getDetalleCompra($id);
?>
<div class="card mb-4 mt-1 p-3">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Resumen de Compra Realizada</h4>
                </div>
              </div>
              </br>
              
              <div class="c-chart-wrapper" style="margin-top:20px;">
              <!-- table -->

                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td style="width:150px;font-weight: 600;">Fecha</td>
                        <td><?php echo $sell_data['fecha']; ?></td>
                      </tr>
                      <tr>
                          <td style="width:150px;font-weight: 600;">Factura #</td>
                          <td><?php echo $sell_data['factura']; ?></td>
                      </tr>
                      <tr>
                          <td style="width:150px;font-weight: 600;">Proveedor</td>
                          <td><?php echo $sell_data['proveedor']; ?></td>
                      </tr>
                    </tbody>
                  </table>
              <!-- ./table -->
              </div>
              <!-- detalle -->
              <br>
              <br>
              <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>Codigo - IMEI</th>
                        <th>Cantidad</th>
                        <th>Nombre del Producto</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                  </thead>
                <tbody>
                  <?php 
                  $total_c = 0;
                  $total_d = 0;
                  foreach($sell_detail_data as $v){
                  ?>
                    <tr>
                      <td><?php echo $v['codigo'];?></td>
                      <td class="text-center"><?php echo $v['q'];?></td>
                      <td><?php echo $v['nombre'];?></td>
                      <td><span class="badge me-1 rounded-pill bg-info"><?php echo 'C$ '.number_format(floatval($v['costo_c']),2,'.',',');?> </span><br><span class="badge me-1 rounded-pill bg-success"><?php echo '$ '.number_format(floatval($v['costo_d']),2,'.',',');?></span></td>
                      <td><span class="badge me-1 rounded-pill bg-info"><?php echo 'C$ '.number_format(floatval($v['total_c']),2,'.',',');?></span><br><span class="badge me-1 rounded-pill bg-success"><?php echo 'C$ '.number_format(floatval($v['total_d']),2,'.',',');?></span></td>
                    </tr>
                  <?php 
                  $total_c += floatval($v['total_c']);
                  $total_d += floatval($v['total_d']);
                  
                  }
                  ?>
                </tbody>
              </table>


              <!-- detalle -->
              <br>
              <div class="row mb-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-5">
                    <table class="table table-bordered">

                    <tr class="bg-dark text-white">
                        <th rowspan="2" align="center">
                        Compra Total
                        </th>
                        <td class="text-end">C$ <?php echo number_format($total_c,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                        <td class="text-end">$ <?php echo number_format($total_d,2,'.',','); ?></td>
                    </tr>
                    </table>
                </div>
            </div>
            </div>

            <div class="card-footer">
              
            </div><!-- ./card-footer -->
          </div><!-- ./card -->


<link rel="stylesheet" href="./vendors/datatable/datatables.min.css">
<link rel="stylesheet" href="./vendors/datatable/dataTables.bootstrap5.min.css">
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/datatable/datatables.min.js"></script>
<script src="./vendors/datatable/dataTables.bootstrap5.min.js"></script>

<script>
function formatMoney(amount) {
  return amount.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
}

  var table = '<div class="table-responsive"><table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr>';
  table += '<th> Ver </th><th>Proveedor</th><th>Factura</th><th>Producto</th>';
  table += '<th>Total</th><th>Fecha</th><th>Accion</th><tbody></tbody></table></div>';
function drawTable(){
  $("#table-compras-total").empty().append(table); 
  var fechainicio = $('#fecha-inicio').val();
  var fechafinal = $('#fecha-final').val();
  var $url = '&fechainicio='+fechainicio+'&fechafinal='+fechafinal;
  new DataTable('#example', {
                responsive: true,
                "pageLength": 100,
                "aLengthMenu": [[10, 25, 50, 100], ["10 Per Page", "25 Per Page", "50 Per Page", "100 Per Page"]],
                columnDefs: [ {
                    targets: [2]
                } ],
                ajax: "./index.php?action=compras/compras-controller&method=get-all-compras"+$url,
                dom: "Bfrtip",
                columns: [  
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-info text-white btn-xs" onclick="verDetalleCompra('+data.id+')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom-in"></use></svg></button>&nbsp;&nbsp;';
                     return render;
                }
        },  
        { data: 'proveedor'},
        { data: 'factura'},
        { data: null,
                render: function(data,type){
                   var table = "";
                   var objData = JSON.parse(data.json);
                   table = '<table class="table" style="border: 0px;background: white !important;" border="0"><tbody>';
                   for (var i = 0;i < objData.length; i++ ){
                    table += '<tr><td><strong>'+objData[i].codigo+'</strong>   '+objData[i].nombre+' <br> '+objData[i].q+' x C$ '+objData[i].costo_c+' = C$ '+objData[i].total_c+'<br> '+objData[i].q+' x $ '+objData[i].costo_d+' = $ '+objData[i].total_d+'</td><tr>';
                   }
                   table += '</tbody></table>';
                   return table;
                 }
        },
        { data: null,
                render: function(data,type){
                   return  '<span class="badge me-1 rounded-pill bg-info">'+formatMoney(parseFloat(data.total_c)).replace("$", "C$ ")+'</span><br><span class="badge me-1 rounded-pill bg-success">'+formatMoney(parseFloat(data.total_d)).replace("$", "$ ")+'</span>';                
                }
        },
        { data: 'fecha' },
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteBuy('+data.id+')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button>';
                     return render;
                }
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },                
        createdRow: (row, data, index) => {
          
        },   
        language: {
            url: './vendors/datatable/es-ES.json'
        },
        buttons: []
            } );

}


function verDetalleCompra(id){
  window.location = './index.php?view=producto/accesorios-autos-edit&id='+id;
}


function deleteBuy(id){
  if (confirm('Esta seguro que desea eliminar esta compra') == true) {
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=compras/compras-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
        $("#table-compras-total").empty();
      });
      request.fail(function (jqXHR, textStatus, errorThrown){
          console.error(
              "The following error occurred: "+
              textStatus, errorThrown
          );
      });
  } 
}


$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>

