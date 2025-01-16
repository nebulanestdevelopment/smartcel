
<?php 
if(Roles::hasRepairMan()){
    header('location: ./index.php?view=repairman/home');
}

$accesorios = HomeData::getInvetarioTotalPorTipo(1);
$accesoriosAutos = HomeData::getInvetarioTotalPorTipo(4);
$repuestos = HomeData::getInvetarioTotalPorTipo(3);
$celulares = HomeData::getTotalCelulares();
$ventas_total = HomeData::getTotalSells();
$total_equipos = intval($accesorios) + intval($accesoriosAutos) + intval($repuestos) + intval($celulares)  ;
$total_clientes = HomeData::getTotalCustomers();

$top10Accesorios = ReportesData::getTop10ItemForType(1);
$top10AccesoriosAutos = ReportesData::getTop10ItemForType(4);
$top10Repuestos = ReportesData::getTop10ItemForType(3);

$top10VentaAccesorios = ReportesData::getLast10ItemSellForType(1);
$top10VentaAccesoriosAutos = ReportesData::getLast10ItemSellForType(4);
$top10VentaRepuestos = ReportesData::getLast10ItemSellForType(3);

$top10CompraAccesorios = ReportesData::getLast10ItemBuyForType(1);
$top10CompraAccesoriosAutos = ReportesData::getLast10ItemBuyForType(4);
$top10CompraRepuestos = ReportesData::getLast10ItemBuyForType(3);



?>

<div class="card">
    <div class="card-header">
        Menu Principal
    </div>
    <div class="card-body">
      

        <div class="row g-4">
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-usb"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-primary"><?php echo $accesorios; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">Inventario</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=producto/accesorios"><span class="small fw-semibold">Accesorios de Celulares</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-info text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-car-alt"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-info"><?php echo $accesoriosAutos; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">Inventario</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=producto/accesorios-autos"><span class="small fw-semibold">Accesorios de Autos</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-warning text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-warning"><?php echo $repuestos; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">Inventario</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=producto/celulares"><span class="small fw-semibold">Repuestos</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card">
                          <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-danger text-white p-3 me-3">
                              <svg class="icon icon-xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-screen-smartphone"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-danger"><?php echo $celulares; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small">Inventario</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=producto/repuestos"><span class="small fw-semibold">Celulares</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                    </div>
<hr>

<div class="row g-4">
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card border-primary">
                          <div class="card-body p-3 d-flex align-items-center bg-primary border-primary">
                            <div class=" text-white p-3 me-3">
                              <svg class="icon icon-3xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-primary text-white"><?php echo $ventas_total; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small text-white">Total</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2 bg-transparent border-primary"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=ventas/historial"><span class="small fw-semibold">Historial de Ventas</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card border-primary">
                          <div class="card-body p-3 d-flex align-items-center bg-primary">
                            <div class="bg-primary text-white p-3 me-3 border-primary">
                              <svg class="icon icon-3xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-white"><?php echo $total_equipos; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small text-white">Total</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2 border-primary bg-transparent"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=inventario/inventario&tipo=1"><span class="small fw-semibold">Inventario General</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card border-primary">
                          <div class="card-body p-3 d-flex align-items-center bg-primary border-primary">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-3xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-white"><?php echo $total_clientes; ?></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small text-white">Total</div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2 bg-transparent border-primary"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center text-decoration-none" href="./index.php?view=cliente/cliente"><span class="small fw-semibold">Clientes Registrados</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
                      <div class="col-12 col-sm-3 col-xl-3 col-xxl-3">
                        <div class="card border-primary">
                          <div class="card-body p-3 d-flex align-items-center border-primary bg-primary">
                            <div class="bg-primary text-white p-3 me-3">
                              <svg class="icon icon-3xl">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bar-chart"></use>
                              </svg>
                            </div>
                            <div>
                              <div class="fs-3 fw-semibold text-danger text-white"></div>
                              <div class="text-body-secondary text-uppercase fw-semibold small text-white"> - </div>
                            </div>
                          </div>
                          <div class="card-footer px-3 py-2 border-primary bg-transparent"><a class="btn-block text-body-secondary d-flex justify-content-between align-items-center" href="./index.php?view=reportes/ventas"><span class="small fw-semibold">Reportes Ventas</span>
                              <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-chevron-right"></use>
                              </svg></a></div>
                        </div>
                      </div>
                      <!-- /.col-->
</div>
<hr>
<!------------------------>     

<a href="./index.php?view=inventario/itemcero" class="btn btn-inline btn-danger" id="btnstat"><i class="fa fa-search fa-2"></i> Items con Cantidad en Cero</a>
<a href="./index.php?view=inventario/cantidad-minima" class="btn btn-inline btn-warning" id="btnstat1"><i class="fa fa-search fa-2"></i> Items con Cantidad Mínima en Alerta</a>
<a href="./index.php?view=inventario/items-neutro" class="btn btn-inline btn-success" id="btnstat2"><i class="fa fa-search fa-2"></i> Items Neutros más de 3 meses sin movimiento</a>

<hr>

<div class="accordion " id="masVendidos"><!-- accordion -->
<!-- accordion -->
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed  bg-info text-white" type="button" data-coreui-toggle="collapse" data-coreui-target="#masVendidosContent" aria-expanded="true" aria-controls="masVendidosContent">
        Los 10 Items Mas Vendidos
      </button>
    </h2>
    <div id="masVendidosContent" class="accordion-collapse collapse " data-coreui-parent="#masVendidos">
      <div class="accordion-body">
<!-- acoordion body -->
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-coreui-toggle="tab" data-coreui-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Accesorios</button>
    <button class="nav-link" id="nav-profile-tab" data-coreui-toggle="tab" data-coreui-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Accesorios de Autos</button>
    <button class="nav-link" id="nav-contact-tab" data-coreui-toggle="tab" data-coreui-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Repuestos</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
  </br>
                  <h4>Los 10 Accesorios mas Vendidos </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Total Ventas</th>
                        <th>Cantidad Total</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10Accesorios as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['TotalVendido']),0,'.',',') .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['TotalCantidadVendida']),0,'.',',') .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                 </br>
                  <h4>Los 10 Accesorios de Autos mas Vendidos </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Total Ventas</th>
                        <th>Cantidad Total</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10AccesoriosAutos as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['TotalVendido']),0,'.',',') .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['TotalCantidadVendida']),0,'.',',') .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>
  </div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                  </br>
                  <h4>Los 10 Repuestos mas Vendidos </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Total Ventas</th>
                        <th>Cantidad Total</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10Repuestos as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['TotalVendido']),0,'.',',') .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['TotalCantidadVendida']),0,'.',',') .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>


  </div>
  <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
</div>
<!-- acoordion body -->
      </div>
    </div>
  </div> 
  <!-- accordion -->
</div><!-- accordion -->
<br>
<div class="accordion" id="accordionExample"><!-- accordion -->
<!-- accordion -->
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed  bg-info text-white" type="button" data-coreui-toggle="collapse" data-coreui-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Ultimas 10 Ventas Registradas
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" data-coreui-parent="#accordionExample">
      <div class="accordion-body">
<!-- acoordion body -->
<nav>
  <div class="nav nav-tabs" id="nav1-tab" role="tablist">
    <button class="nav-link active" id="nav1-home-tab" data-coreui-toggle="tab" data-coreui-target="#nav1-home" type="button" role="tab" aria-controls="nav1-home" aria-selected="true">Accesorios</button>
    <button class="nav-link" id="nav1-profile-tab" data-coreui-toggle="tab" data-coreui-target="#nav1-profile" type="button" role="tab" aria-controls="nav1-profile" aria-selected="false">Accesorios de Autos</button>
    <button class="nav-link" id="nav1-contact-tab" data-coreui-toggle="tab" data-coreui-target="#nav1-contact" type="button" role="tab" aria-controls="nav1-contact" aria-selected="false">Repuestos</button>
  </div>
</nav>
<div class="tab-content" id="nav1-tabContent">
  <div class="tab-pane fade show active" id="nav1-home" role="tabpanel" aria-labelledby="nav1-home-tab" tabindex="0">
  </br>
                  <h4>Los 10 Accesorios mas Vendidos </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Venta Total</th>
                        <th>Fecha</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10VentaAccesorios as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['q']),0,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format((floatval($r['price_out']) + floatval($r['price_out_es'])) ,2,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format(((floatval($r['price_out']) + floatval($r['price_out_es'])) * floatval($r['q']) ),2,'.',',') .'</td>';
                          echo '<td>'. date('d/m/Y H:m a', strtotime($r['created_at'])) .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>
  </div>
  <div class="tab-pane fade" id="nav1-profile" role="tabpanel" aria-labelledby="nav1-profile-tab" tabindex="0">
                 </br>
                  <h4>Los 10 Accesorios de Autos mas Vendidos </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Venta Total</th>
                        <th>Fecha</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10VentaAccesoriosAutos as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['q']),0,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format((floatval($r['price_out']) + floatval($r['price_out_es'])) ,2,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format(((floatval($r['price_out']) + floatval($r['price_out_es'])) * floatval($r['q']) ),2,'.',',') .'</td>';
                          echo '<td>'. date('d/m/Y H:m a', strtotime($r['created_at'])) .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>
  </div>
  <div class="tab-pane fade" id="nav1-contact" role="tabpanel" aria-labelledby="nav1-contact-tab" tabindex="0">
                  </br>
                  <h4>Los 10 Repuestos mas Vendidos </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Venta Total</th>
                        <th>Fecha</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10VentaRepuestos as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['q']),0,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format((floatval($r['price_out']) + floatval($r['price_out_es'])) ,2,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format(((floatval($r['price_out']) + floatval($r['price_out_es'])) * floatval($r['q']) ),2,'.',',') .'</td>';
                          echo '<td>'. date('d/m/Y H:m a', strtotime($r['created_at'])) .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>


  </div>
  <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
</div>
<!-- acoordion body -->
      </div>
    </div>
  </div>
  <!-- accordion -->
</div><!-- accordion -->

<br>
<div class="accordion" id="ultimasCompras"><!-- accordion -->
<!-- accordion -->
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed  bg-info text-white " type="button" data-coreui-toggle="collapse" data-coreui-target="#vistaCompras" aria-expanded="false" aria-controls="vistaCompras">
        Ultimas 10 Compras Registradas
      </button>
    </h2>
    <div id="vistaCompras" class="accordion-collapse collapse" data-coreui-parent="#ultimasCompras">
      <div class="accordion-body">
      <!-- acoordion body -->
<nav>
  <div class="nav nav-tabs" id="nav2-tab" role="tablist">
    <button class="nav-link active" id="nav2-home-tab" data-coreui-toggle="tab" data-coreui-target="#nav2-home" type="button" role="tab" aria-controls="nav1-home" aria-selected="true">Accesorios</button>
    <button class="nav-link" id="nav2-profile-tab" data-coreui-toggle="tab" data-coreui-target="#nav2-profile" type="button" role="tab" aria-controls="nav1-profile" aria-selected="false">Accesorios de Autos</button>
    <button class="nav-link" id="nav2-contact-tab" data-coreui-toggle="tab" data-coreui-target="#nav2-contact" type="button" role="tab" aria-controls="nav1-contact" aria-selected="false">Repuestos</button>
  </div>
</nav>
<div class="tab-content" id="nav2-tabContent">
  <div class="tab-pane fade show active" id="nav2-home" role="tabpanel" aria-labelledby="nav2-home-tab" tabindex="0">
  </br>
                  <h4>Los 10 Accesorios Ingresados Recientemente </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Costo Total</th>
                        <th>Fecha</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10CompraAccesorios as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['q']),0,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format(floatval($r['price_in']) ,2,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format((floatval($r['price_in']) * floatval($r['q']) ),2,'.',',') .'</td>';
                          echo '<td>'. date('d/m/Y H:m a', strtotime($r['created_at'])) .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>
  </div>
  <div class="tab-pane fade" id="nav1-profile" role="tabpanel" aria-labelledby="nav1-profile-tab" tabindex="0">
                 </br>
                  <h4>Los 10 Accesorios de Autos Ingresados Recientemente </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Costo Total</th>
                        <th>Fecha</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10CompraAccesoriosAutos as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['q']),0,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format(floatval($r['price_in']) ,2,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format((floatval($r['price_in']) * floatval($r['q']) ),2,'.',',') .'</td>';
                          echo '<td>'. date('d/m/Y H:m a', strtotime($r['created_at'])) .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>
  </div>
  <div class="tab-pane fade" id="nav1-contact" role="tabpanel" aria-labelledby="nav1-contact-tab" tabindex="0">
                  </br>
                  <h4>Los 10 Repuestos Ingresados Recientemente </h4>
                  <table class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Articulos</th>
                        <th>Cantidad</th>
                        <th>Costo Unitario</th>
                        <th>Costo Total</th>
                        <th>Fecha</th>
                      </tr>
                     </thead>
                    <tbody>
                      <?php 
                        foreach($top10CompraRepuestos as $r){
                          echo '<tr>';
                          echo '<td>'. ProductoData::getProductName($r['id']) .'</td>';
                          echo '<td class="text-center">'. number_format(intval($r['q']),0,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format(floatval($r['price_in']) ,2,'.',',') .'</td>';
                          echo '<td class="text-center">C$ '. number_format((floatval($r['price_in']) * floatval($r['q']) ),2,'.',',') .'</td>';
                          echo '<td>'. date('d/m/Y H:m a', strtotime($r['created_at'])) .'</td>';
                          echo '</tr>';
                        }
                      ?>                         
                    </tbody>
                  </table>


  </div>
  <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">...</div>
</div>
<!-- acoordion body -->
      </div>
    </div>
  </div>
  <!-- accordion -->
</div><!-- accordion -->
    </div><!-- ./ card-body -->
</div>

<style>
  #btnstat, #btnstat1, #btnstat2 {
	color: #fff;
	background-color: #a94442;
	border-color: #a94442;
}
</style>