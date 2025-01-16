<?php
$data = ProductoEliminadoData::getAll();
?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Historial de productos eliminados</h4>
    </div>
    <div class="card-body">
        
<div class="table-responsive">
<table class="table table-striped table-hover" id="example">
    <thead class="bg-dark text-white">
        <tr>
            <th>Codigo</th> 
            <th>Producto</th>
            <th>Descripcion</th>
            <th>Presentacion</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Activar</th>
            <th>Eliminar</th>
        </tr>  
    </thead>
    <tbody>
    <?php

        foreach ($data as $k => $v) {
            echo'<tr>';
                echo '<td>'.ProductoData::getProductCodeDelete($v['idproduct']).'</td>';
                echo '<td>'.ProductoData::getProductNameDelete($v['idproduct']).'</td>';
                echo '<td>'.$v['description'].'</td>';
                echo '<td>'.$v['presentation'].'</td>';
                echo '<td>'.$v['marca'].'</td>';
                echo '<td>'.$v['Modelo'].'</td>';
                echo '<td>'.$v['color'].'</td>';
                echo '<td><button type="button" class="btn btn-success btn-xs text-white" onclick="activarProducto(`'.$v['idproduct'].'`)">Activar Producto</button></td>';
                echo '<td><button type="button" class="btn btn-danger btn-xs text-white" onclick="eliminarProducto(`'.$v['idproduct'].'`)">Eliminar producto definitivo</button></td></td>';
            echo'</tr>';
            
        }
        ?>
    </tbody>
</table>
</div>




</div>
</div>
<link rel="stylesheet" href="./vendors/datatable/dataTables.dataTables.css">
<link rel="stylesheet" href="./vendors/datatable/buttons.dataTables.css">
<link rel="stylesheet" href="./vendors/toastr/toastr.min.css">

<script src="./vendors/datatable/jquery-3.7.1.js"></script>
<script src="./vendors/datatable/datatables.js"></script>
<script src="./vendors/datatable/dataTables.buttons.min.js"></script>
<script src="./vendors/datatable/jszip.min.js"></script>
<script src="./vendors/datatable/pdfmake.min.js"></script>
<script src="./vendors/datatable/vfs_fonts.js"></script>
<script src="./vendors/datatable/buttons.html5.min.js"></script>
<script src="./vendors/datatable/buttons.print.min.js"></script>
<script src="./vendors/toastr/toastr.min.js"></script>
<script src="./vendors/select2/select2.min.js"></script>
<script>

function activarProducto(id){
  if (confirm('Desea volver a agregar al inventario este producto') == true) {
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=historial/producto-eliminado-controller",
          type: "post",
          data: {id:id,method:'activar-producto'}
      });
      request.done(function (data, textStatus, jqXHR){
        toastr.success(data.msg, 'Exitoso', {timeOut: 1000});
        setTimeout(() => {
            window.location.reload();
        }, 1000);

      });
      request.fail(function (jqXHR, textStatus, errorThrown){
        toastr.error(jqXHR, 'Fallo', {timeOut: 3000});          
      });
  } 
}


function eliminarProducto(id){
  if (confirm('Desea eliminar este producto del baul de productos eliminados') == true) {
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=historial/producto-eliminado-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
        toastr.success(data.msg, 'Exitoso', {timeOut: 1000});
        setTimeout(() => {
            window.location.reload();
        }, 1000);
      });
      request.fail(function (jqXHR, textStatus, errorThrown){
        toastr.error(jqXHR, 'Fallo', {timeOut: 3000})
          
      });
  } 
}


$(document).ready(function() {
   
    new DataTable('#example', {
                
         
        select: {
            style: 'os',
            selector: 'td:first-child'
        }, 
        language: {
                url: './vendors/datatable/es-ES.json'
            },
        layout: {
            bottomStart: {
                buttons: ['csv', 'excel', 'pdf', 'print']
            }
        }
            } );
 });
 
 </script>