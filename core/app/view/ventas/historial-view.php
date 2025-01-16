
<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h3 class="card-title mb-0"><svg class="icon" style="width: 20px;height: 20px;"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cart"></use></svg> Lista de Ventas</h3>
                </div>
              </div>
              </br>
              
              <div class="c-chart-wrapper" style="margin-top:60px;">
              <!-- table -->
<!-- ./ tab-content -->
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link " id="nav-accesorios-tab" data-coreui-toggle="tab" data-coreui-target="#nav-accesorios" type="button" role="tab" aria-controls="nav-accesorios" aria-selected="true">Accesorios</button>
    <button class="nav-link " id="nav-accesorios-autos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-accesorios-autos" type="button" role="tab" aria-controls="nav-accesorios-autos" aria-selected="false">Accesorios de Autos</button>
    <button class="nav-link " id="nav-celulares-tab" data-coreui-toggle="tab" data-coreui-target="#nav-celulares" type="button" role="tab" aria-controls="nav-celulares" aria-selected="false">Celulares</button>
    <button class="nav-link " id="nav-repuestos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-repuestos" type="button" role="tab" aria-controls="nav-repuestos" aria-selected="false">Repuestos</button>
    <button class="nav-link active" id="nav-todos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-todos" type="button" role="tab" aria-controls="nav-todos" aria-selected="false">Todos</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade" id="nav-accesorios" role="tabpanel" aria-labelledby="nav-accesorios-tab" tabindex="0">
<!-- tab accesorios -->

<br></br>
    <h4>Accesorios vendidos</h4>
    </br>     
    <!-- table-->
    <div id="table-ventas-total-a" style="display: none;" >
                  
     </div>
    <!-- table-->
<!-- fin del tab accesorios -->
  </div>
  <div class="tab-pane fade" id="nav-accesorios-autos" role="tabpanel" aria-labelledby="nav-accesorios-autos-tab" tabindex="0">
    <!-- tab accesorios autos -->
    <br></br>
    <h4>Accesorios de autos vendidos</h4>
    </br>
               <!-- form-->
    <!-- table-->
    <div id="table-ventas-total-aa" style="display: none;" >
                  
     </div>
    <!-- table-->
  <!-- ./tab accesorios autos -->
  </div>
  <div class="tab-pane fade" id="nav-celulares" role="tabpanel" aria-labelledby="nav-celulares-tab" tabindex="0">
    <!-- tab celulares -->
    <br></br>
    <h4>Celulares vendidos</h4>
    </br>
    <!-- table-->
    <div id="table-ventas-total-c" style="display: none;" >
                  
     </div>
    <!-- table-->
    <!-- tab celulares -->
  </div>
  <div class="tab-pane fade " id="nav-repuestos" role="tabpanel" aria-labelledby="nav-repuestos-tab" tabindex="0">
    <!-- repuestos -->
    <br></br>
    <h4>Repuestos vendidos</h4>
    </br>
    <!-- table-->
    <div id="table-ventas-total-r" style="display: none;" >
                  
     </div>
    <!-- table-->
    <!-- ./repuestos -->
  </div>
  <div class="tab-pane fade  show active" id="nav-todos" role="tabpanel" aria-labelledby="nav-todos-tab" tabindex="0">
    <!-- todos -->
    </br> <!-- form-->
              
<?php
$data = SellData::getAllSells();
?>
<div class="row ">
  <div class="col-12 alert alert-success pt-4">
  <?php 
        echo '&nbsp;<strong>Total de registro encontrados: </strong> '.count($data).'</br></br>';
  ?>
  </div>
</div>    
<div class="table-responsive">
<table id="get-all" class="table table-striped table-bordered table-hover table-sm" >
    <thead class="table-dark">
        <tr>
            <th> Ver </th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Total Venta</th>
            <th>Fecha</th>
            <th>Accion</th>
        </tr>    
    </thead>      
    <tbody>
    <?php
     $total_c = 0;
     $total_d = 0;
        foreach($data as $v){
            $productos = json_decode($v['json']);
            $table = '<table class="table" style="border: 0px;background: white !important;" border="0"><tbody>';
            foreach ($productos as $p) {
                $table .= '<tr><td><strong>'.$p->codigo.'</strong>   '.$p->nombre.' <br> '.$p->q.' x C$ '.number_format(floatval($p->precio_c),2,'.',',').' = C$ '.number_format((floatval($p->precio_c) * intval($p->q)),2,'.',',')    .'<br> '.$p->q.' x $ '.number_format(floatval($p->precio_d),2,'.',',').' = $ '.number_format((floatval($p->precio_d) * intval($p->q)),2,'.',',').'</td><tr>';
            } 
            $table .= '</tbody></table>';
            echo '<tr>';
            echo '<td><button type="button" class="btn  btn-info text-white btn-xs" onclick="verDetalleVenta('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom-in"></use></svg></button>&nbsp;&nbsp;</td>';  
            echo '<td>'.$table.'</td>';
            echo '<td>'.$v['cliente'].'</td>';
            echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format(floatval($v['total_c']),2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format(floatval($v['total_d']),2,'.',',') .'</span/td>';
            echo '<td>'.$v['fecha'].'</td>';
            echo '<td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteVenta('.$v['id'].')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button></td>';
            echo '</tr>';
            $total_c += floatval($v['total_c']);
            $total_d += floatval($v['total_d']);
        }
    ?>
    </tbody>
</table>
</div>
<table class="table" style="width:100%;">
                <thead><tr>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Ingresos Generados en Cordobas (C$)</th>
                    <th class="text-center" style="font-size: 1.2rem;">Total de Ingresos Generados en Dolares ($)</th>
                </tr></thead>
                <tbody>
                    <tr>
                        <td class="text-center"><span class="cordoba moneda"><?php echo number_format($total_c,2,'.',','); ?></span></td>
                        <td class="text-center"><span class="dolar  moneda"><?php echo number_format($total_d,2,'.',','); ?></span></td>
                    </tr>
                </tbody>
              </table>
    <!-- ./todos -->
  </div>
</div>
<!-- ./ tab-content -->

                  
              </div>
              <!-- ./table -->
              </div>
            </div>
            <div class="card-footer">
              
            </div><!-- ./card-footer -->
          </div><!-- ./card -->


<style>
#nav-tab > .nav-link {
	display: block;
	padding: var(--cui-nav-link-padding-y) var(--cui-nav-link-padding-x);
	font-size: var(--cui-nav-link-font-size);
	font-weight: var(--cui-nav-link-font-weight);
	color: white !important;
	text-decoration: none;
	transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
	background: #337ab7;
	border-radius: 6px;
	margin-right: 4px;
}

#nav-tab > .nav-link.active {
	/* color: var(--cui-nav-tabs-link-active-color); */
	/* background-color: var(--cui-nav-tabs-link-active-bg); */
	border-color: #337ab7;
	background: white !important;
	color: #337ab7 !important;
	border-width: 2px;
	font-weight: 700;
}


</style>          
<link rel="stylesheet" href="./vendors/datatable/datatables.min.css">
<link rel="stylesheet" href="./vendors/datatable/dataTables.bootstrap5.min.css">
<script src="./vendors/datatable/jquery.js"></script>
<script src="./vendors/datatable/datatables.min.js"></script>
<script src="./vendors/datatable/dataTables.bootstrap5.min.js"></script>

<script>
  $('button.nav-link').on('click',function(e){
    e.preventDefault();
    hideAll();
  });

  function hideAll(){
    $("#table-ventas-total-r").empty();
    $("#table-ventas-total-c").empty();
    $("#table-ventas-total-aa").empty();
    $("#table-ventas-total-a").empty();
  }


$("#nav-repuestos-tab").on('click',function(e){  
e.preventDefault();
$('#table-ventas-total-r').css('display', 'block').css('text-align', 'center').empty().append('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width:500px;"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#FF156D"></stop><stop offset=".3" stop-color="#FF156D" stop-opacity=".9"></stop><stop offset=".6" stop-color="#FF156D" stop-opacity=".6"></stop><stop offset=".8" stop-color="#FF156D" stop-opacity=".3"></stop><stop offset="1" stop-color="#FF156D" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#FF156D" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>');

      var formData = new FormData();
      formData.append('type', 3);
      $.ajax({
        url: './index.php?action=ventas/get-all-sells-type',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#table-ventas-total-r').attr('style','').css('display', 'block').empty().append(data);      
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
});

$("#nav-celulares-tab").on('click',function(e){  
e.preventDefault();
$('#table-ventas-total-c').css('display', 'block').css('text-align', 'center').empty().append('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width:500px;"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#FF156D"></stop><stop offset=".3" stop-color="#FF156D" stop-opacity=".9"></stop><stop offset=".6" stop-color="#FF156D" stop-opacity=".6"></stop><stop offset=".8" stop-color="#FF156D" stop-opacity=".3"></stop><stop offset="1" stop-color="#FF156D" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#FF156D" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>');
      var formData = new FormData();
      formData.append('type', 2);

      $.ajax({
        url: './index.php?action=ventas/get-all-sells-type',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#table-ventas-total-c').attr('style','').css('display', 'block').empty().append(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
});


$("#nav-accesorios-autos-tab").on('click',function(e){  
e.preventDefault();
$('#table-ventas-total-aa').css('display', 'block').css('text-align', 'center').empty().append('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width:500px;"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#FF156D"></stop><stop offset=".3" stop-color="#FF156D" stop-opacity=".9"></stop><stop offset=".6" stop-color="#FF156D" stop-opacity=".6"></stop><stop offset=".8" stop-color="#FF156D" stop-opacity=".3"></stop><stop offset="1" stop-color="#FF156D" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#FF156D" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>');
      var formData = new FormData();
      formData.append('type', 4);

      $.ajax({
        url: './index.php?action=ventas/get-all-sells-type',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#table-ventas-total-aa').attr('style','').css('display', 'block').empty().append(data);
         },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
});

$("#nav-accesorios-tab").on('click',function(e){  
e.preventDefault();
$('#table-ventas-total-a').css('display', 'block').css('text-align', 'center').empty().append('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" style="width:500px;"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#FF156D"></stop><stop offset=".3" stop-color="#FF156D" stop-opacity=".9"></stop><stop offset=".6" stop-color="#FF156D" stop-opacity=".6"></stop><stop offset=".8" stop-color="#FF156D" stop-opacity=".3"></stop><stop offset="1" stop-color="#FF156D" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#FF156D" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>');
      var formData = new FormData();
      formData.append('type', 1);

      $.ajax({
        url: './index.php?action=ventas/get-all-sells-type',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#table-ventas-total-a').attr('style','').css('display', 'block').empty().append(data);
         },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      });
});

function verDetalleVenta(id){
  window.location = './index.php?view=ventas/historial-detalle&id='+id;
}


function deleteVenta(id){
  if (confirm('Esta seguro que desea eliminar esta venta') == true) {
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=ventas/ventas-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
         hideAll();
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

