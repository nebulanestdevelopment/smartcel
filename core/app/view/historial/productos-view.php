<?php
$data = ProductoData::getAllProductActive();

?>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Historial de precios</h4>
    </div>
    <div class="card-body">
        
<div class="table-responsive">
<table class="table table-striped table-hover" id="example">
    <thead  class="bg-dark text-white">
        <tr>
            <th>Codigo</th> 
            <th>Producto</th>
            <th>Tipo</th>
            <th>Precio de compra</th>
            <th>Precio de venta</th>
            <th>Precio de especial</th>            
            <th>Descripcion</th>
            <th>Presentacion</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Ver detalle</th>
        </tr>  
    </thead>
    <tbody>
    <?php

        foreach ($data as $k => $v) {
            $type =[0 => "",1 => "Accesorios",2=> "Celulares",3=> "Repuestos",4=> "Accesorios de Autos"];
            echo'<tr>';
                echo '<td>'.ProductoData::getProductCode($v['id']).'</td>';
                echo '<td>'.ProductoData::getProductName($v['id']).'</td>';
                echo '<td>'.$type[$v['type']].'</td>';
                echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($v['costo_c'],2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format($v['costo_d'],2,'.',',') .'</span></td>';
                echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($v['precio_c'],2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format($v['precio_d'],2,'.',',') .'</span></td>';
                echo '<td><span class="badge me-1 rounded-pill bg-info">C$ '. number_format($v['precio_es_c'],2,'.',',') .'</span><br><span class="badge me-1 rounded-pill bg-success">$ '. number_format($v['precio_es_d'],2,'.',',') .'</span></td>';
                echo '<td>'.$v['description'].'</td>';
                echo '<td>'.$v['presentation'].'</td>';
                echo '<td>'.$v['marca'].'</td>';
                echo '<td>'.$v['Modelo'].'</td>';
                echo '<td>'.$v['color'].'</td>';
                echo '<td><button type="button" class="btn  btn-info text-white btn-xs" onclick="verHistorial(`'.$v['id'].'`)"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-magnifying-glass"></use></svg> Ver detalle</button></td>';
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




function verHistorial(id){
    window.location.href = "./index.php?view=historial/productos-historial&id="+id;
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
