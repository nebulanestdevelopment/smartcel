<?php 
  if(!isset($_GET['id'])){
    header('location:  ./index.php?view=home');
  }
  $id=$_GET['id'];
  $sell_data = SellData::getVentaData($id);
  $sell_detail_data = SellData::getDetalleVenta($id);
?>
<div class="card mb-4 mt-1 p-3">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Resumen de Venta</h4>
                </div>
              </div>
              </br>
              
              <div class="c-chart-wrapper" style="margin-top:20px;">
              <!-- table -->

                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <td style="width:150px;font-weight: 600;">Fecha de Venta</td>
                        <td><?php echo $sell_data['fecha']; ?></td>
                      </tr>
                      <tr>
                          <td style="width:150px;font-weight: 600;">Cliente</td>
                          <td><?php echo (intval($sell_data['cliente_id']) == 0 || intval($sell_data['cliente_id']) == 1)?'Cliente anonimo':$sell_data['cliente']; ?></td>
                      </tr>
                      <tr>
                          <td style="width:150px;font-weight: 600;">Atendido por</td>
                          <td><?php echo $sell_data['vendedor']; ?></td>
                      </tr>
                      <tr>
                          <td style="width:150px;font-weight: 600;">Tipo de Venta</td>
                          <td><?php echo (intval($sell_data['venta']) == 1)?'Contado':'Credito';  ?></td>
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
                        <?php  if(Roles::hasAdmin()){ ?>
                        <th>Costo Unitario</th>
                        <?php  }?>
                        <th>Descuento</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <?php  if(Roles::hasAdmin()){ ?>
                        <th></th>
                        <?php  }?>
                    </tr>
                  </thead>
                <tbody>
                  <?php 
                  
                  $total_c = 0;
                  $total_d = 0;
                  $desc_c = 0;
                  $desc_d = 0;
                  $sub_c = 0;
                  $sub_d = 0;
                  $ganancia_c = 0;
                  $ganancia_d = 0;

                  foreach($sell_detail_data as $v){
                    $precio_c = floatval($v['esp_c']) + floatval($v['venta_c']);
                    $precio_d = floatval($v['esp_d']) + floatval($v['venta_d']);
                  ?>
                    <tr>
                      <td><?php echo $v['codigo'];?></td>
                      <td class="text-center"><?php echo $v['q'];?></td>
                      <td><?php echo $v['nombre'];?></td>
                      <?php  if(Roles::hasAdmin()){ ?>
                        <td><span class="badge me-1 rounded-pill bg-info"><?php echo 'C$ '.number_format(floatval($v['costo_c']),2,'.',',');?> </span><br><span class="badge me-1 rounded-pill bg-success"><?php echo '$ '.number_format(floatval($v['costo_d']),2,'.',',');?></span></td>
                      <?php  }?>
                      
                      <td><span class="badge me-1 rounded-pill bg-info"><?php echo 'C$ '.number_format(floatval($v['desc_c']),2,'.',',');?></span><br><span class="badge me-1 rounded-pill bg-success"><?php echo '$ '.number_format(floatval($v['desc_d']),2,'.',',');?></span></td>
                      <td><span class="badge me-1 rounded-pill bg-info"><?php echo 'C$ '.number_format(floatval($precio_c),2,'.',',');?></span><br><span class="badge me-1 rounded-pill bg-success"><?php echo '$ '.number_format(floatval($precio_d),2,'.',',');?></span><?php if(floatval($v['esp_c']) > 0){echo "<br><small>Precio Especial</small>";} ?></td>
                      <td><span class="badge me-1 rounded-pill bg-info"><?php echo 'C$ '.number_format(floatval($v['total_c']),2,'.',',');?></span><br><span class="badge me-1 rounded-pill bg-success"><?php echo '$ '.number_format(floatval($v['total_d']),2,'.',',');?></span></td>
                      <?php  if(Roles::hasAdmin()){ ?>
                        <td><button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteSell(<?php echo $v['id'] ; ?>)"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button></td>
                      <?php  }?>
                    </tr>
                  <?php 
                  $total_c += floatval($v['total_c']);
                  $total_d += floatval($v['total_d']);
                  $desc_c  += floatval($v['desc_c']);
                  $desc_d  += floatval($v['desc_d']);
                  $sub_c   += floatval($precio_c);
                  $sub_d   += floatval($precio_d);
                  $ganancia_c += (floatval($precio_c) - floatval($v['desc_c'])) - floatval($v['costo_c']);
                  $ganancia_d += (floatval($precio_d) - floatval($v['desc_d'])) - floatval($v['costo_d']);

                  
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
                        <th align="center" rowspan="2">
                         Descuento
                        </th>
                        <td class="text-end text-info">C$ <?php echo number_format($desc_c,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                     <td class="text-end text-success">$ <?php echo number_format($desc_d,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white" rowspan="2"  >
                        <th align="center" rowspan="2">
                          Subtotal
                        </th>
                          <td class="text-end text-info">C$ <?php echo number_format($sub_c,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                         <td class="text-end text-success">$ <?php echo number_format($sub_d,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                        <th align="center" rowspan="2">
                          Total
                        </th>
                        <td class="text-end text-info">C$ <?php echo number_format($total_c,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                        <td class="text-end text-success">$ <?php echo number_format($total_d,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                        <th align="center" rowspan="2">
                          Ganancia
                        </th>
                        <td class="text-end text-info">C$ <?php echo number_format($ganancia_c,2,'.',','); ?></td>
                    </tr>
                    <tr class="bg-dark text-white">
                       
                        <td class="text-end text-success">$ <?php echo number_format($ganancia_d,2,'.',','); ?></td>
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
function deleteSell(id){
  if (confirm('Esta seguro que desea eliminar este articulo de la venta') == true) {
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=ventas/ventas-controller",
          type: "post",
          data: {id:id,method:'delete-item'}
      });
      request.done(function (data, textStatus, jqXHR){
        if(parseInt(data.total) == 0 ){
          window.location.href = './index.php?view=ventas/historial';
        }else if(parseInt(data.total) == 1 ){
          window.location.reload(); 
        }
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

