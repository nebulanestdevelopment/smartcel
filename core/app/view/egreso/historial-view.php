<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Filtro de Busqueda</h4>
                </div>
              </div>  
                <div class="row mt-5">
                    <div class="col">
                        <label for="nombre" class="col-sm-3 col-form-label">Fecha Inicial</label>
                        <input type="date" class="form-control" id="inicial" name="inicial" >
                    </div>
                    <div class="col">
                        <label for="nombre" class="col-sm-3 col-form-label">Fecha Final</label>
                         <input type="date" class="form-control" id="final" name="final" >
                     </div>
</div>
<div class="row mt-4">
                    <div class="col text-center">
                        <button class="btn btn btn-outline-dark" id="btn-buscar" onclick="cargarHistorial()">Buscar Registros</button>
                
                        <button class="btn btn-secundary" id="btn-reset" onclick="limpiarView()">Limpiar Registros</button>
                    </div>

                </div>
              </div>              
            </div>
            
</div><!-- ./card -->

<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Historial de Gastos/Egresos</h4>
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

<link rel="stylesheet" href="./vendors/datatable/datatables.min.css">
<link rel="stylesheet" href="./vendors/datatable/dataTables.bootstrap5.min.css">
<style>
  .moneda {font-size: 1.5em;color: red;}
</style>
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/datatable/datatables.min.js"></script>
<script src="./vendors/datatable/dataTables.bootstrap5.min.js"></script>
<script>
  var table = '<table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr><th>Tipo de pago</th><th>Descripcion</th><th>Moneda (C$)</th><th>Moneda ($)</th><th>Fecha</th></tr></thead>';
  table += '<tbody></tbody></table>';

  function drawTable(data){
    

    $(".table-responsive").empty().append(table);    
    new DataTable('#example', {
    data: data,
    columns: [
        { data: 'name' },
        { data: 'descripcion' },
        { data: 'c' },
        { data: 'd' },
        { data: 'create' }
    ],
    /*search: {
        return: true
    },*/
    processing: true,
    paging: false,
    language: {
        url: './vendors/datatable/es-ES.json',
        searchPlaceholder:"Buscar...",
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

function cargarHistorial(){
    var $inicial = $('#inicial').val();
    var $final = $('#final').val();
  $.get('./index.php?action=egreso/pago-controller&method=get-historial-egresos&inicial='+$inicial+'&final='+$final, function(data, status){
      drawTable(data);   
  });
  $.get("./index.php?action=egreso/pago-controller&method=get-historial-egresos-total&inicial='+$inicial+'&final='+$final", function(data, status){
      $(".cordoba").empty().html(data.cordoba);
      $(".dolar").empty().html(data.dolar);      
    });
}

function limpiarView(){
  $(".table-responsive").empty();  
  $('#inicial').val("");
  $('#final').val("");
  $(".cordoba").empty();
  $(".dolar").empty();   
}

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>