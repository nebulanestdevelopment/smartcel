
<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h3 class="card-title mb-0"><svg class="icon" style="width: 20px;height: 20px;"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use></svg> Historial de Compras o Reabastecimientos</h3>
                </div>
              </div>
              </br>
              <div class="row mt-4 ">
                <div class="col-12 alert alert-success pt-4">
                <form class="row g-3 pt-2">
                    <div class="col-auto">
                      <label for="staticEmail2" class="visually-hidden">Buscar por fechas:</label>
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Buscar por rango de fechas:">
                    </div>
                    <div class="col-auto">
                      <label for="inputPassword2" class="visually-hidden">Password</label>
                      <input type="date" class="form-control" id="fecha-inicio" name="fecha-inicio"  >
                    </div>
                    <div class="col-auto">
                      <label for="inputPassword2" class="visually-hidden">Password</label>
                      <input type="date" class="form-control" id="fecha-final" name="fecha-final"  >
                    </div>
                    <div class="col-auto">
                      <button type="button" class="btn btn-primary mb-3" onclick="drawTable()">Buscar</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="c-chart-wrapper" style="margin-top:60px;">
              <!-- table -->

                  <div id="table-compras-total" >
                  
                  </div>
              </div>
              <!-- ./table -->
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
  table += '<th>Total</th><th>Fecha</th><th>Accion</th></tr></thead><tbody></tbody></table></div>';
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
  window.location = './index.php?view=compras/historial-detalle&id='+id;
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

