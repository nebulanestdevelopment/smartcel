
<?php
$tasa_cambio = floatval((new SystemData)->obtenerTasaCambio());
$tasa_cambio = number_format($tasa_cambio, 2, '.', ',');
echo '<script>sessionStorage.setItem("tasaCambio",'.$tasa_cambio.');</script>';
?>

<div class="container-fluid bg-white">
    <br>
<h4>Items que están con Cantidad Mínima del Inventario Inicial</h4>
<br>
<br>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-accesorios-tab" data-coreui-toggle="tab" data-coreui-target="#nav-accesorios" type="button" role="tab" aria-controls="nav-accesorios" aria-selected="true">Accesorios</button>
    <button class="nav-link " id="nav-accesorios-autos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-accesorios-autos" type="button" role="tab" aria-controls="nav-accesorios-autos" aria-selected="false">Accesorios de Autos</button>
    <button class="nav-link " id="nav-celulares-tab" data-coreui-toggle="tab" data-coreui-target="#nav-celulares" type="button" role="tab" aria-controls="nav-celulares" aria-selected="false">Celulares</button>
    <button class="nav-link " id="nav-repuestos-tab" data-coreui-toggle="tab" data-coreui-target="#nav-repuestos" type="button" role="tab" aria-controls="nav-repuestos" aria-selected="false">Repuestos</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-accesorios" role="tabpanel" aria-labelledby="nav-accesorios-tab" tabindex="0">
 <!-- inicio del tab accesorios -->
 </br>
        <div id="accesorios-content"> 
        
        </div>
 </br>
<!-- fin del tab accesorios -->
  </div>
  <div class="tab-pane fade" id="nav-accesorios-autos" role="tabpanel" aria-labelledby="nav-accesorios-autos-tab" tabindex="0">
    <!-- tab accesorios autos -->
  </br>  
    <div id="accesorios-autos-content"> 
        
    </div>
  </br>
  <!-- ./tab accesorios autos -->
  </div>
  <div class="tab-pane fade" id="nav-celulares" role="tabpanel" aria-labelledby="nav-celulares-tab" tabindex="0">
    <!-- tab celulares -->
    </br>
      <div id="celulares-content" > 
          
      </div>
    </br>
    <!-- tab celulares -->
  </div>
  <div class="tab-pane fade " id="nav-repuestos" role="tabpanel" aria-labelledby="nav-repuestos-tab" tabindex="0">
    <!-- repuestos -->
    <br>
      <div id="repuestos-content" > 
          
      </div>
    <br> 
    <!-- ./repuestos -->
  </div>
</div>

<br>
</div>




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

    var tableAccesorios = '<div class="table-responsive"><table class="table table-bordered" id="table-accesorios" ><thead class="bg-dark text-white"><tr><th>Codigo</th><th>Nombre del Item</th><th>Costo</th><th>Precio</th><th>Cantidad Minima</th><th>Inventario Inicial</th></tr></thead></table></div>';
    var tableAccesoriosAutos = '<div class="table-responsive"><table class="table table-bordered" id="table-accesorios-autos" ><thead class="bg-dark text-white"><tr><th>Codigo</th><th>Nombre del Item</th><th>Costo</th><th>Precio</th><th>Cantidad Minima</th><th>Inventario Inicial</th></tr></thead></table></div>';
    var tableCelulares = '<div class="table-responsive"><table class="table table-bordered" id="table-celulares" ><thead class="bg-dark text-white"><tr><th>Codigo</th><th>Nombre del Item</th><th>Costo</th><th>Precio</th><th>Cantidad Minima</th><th>Inventario Inicial</th></tr></thead></table></div>';
    var tableRepuestos = '<div class="table-responsive"><table class="table table-bordered" id="table-repuestos" ><thead class="bg-dark text-white"><tr><th>Codigo</th><th>Nombre del Item</th><th>Costo</th><th>Precio</th><th>Cantidad Minima</th><th>Inventario Inicial</th></tr></thead></table></div>';
    function clearDiv(){
            $('#accesorios-content').empty();
            $('#accesorios-autos-content').empty();
            $('#celulares-content').empty();
            $('#repuestos-content').empty();

    }

    function drawTable($content,$table,$tableName,$tipo){
        $("#"+$content).empty().append($table); 
        new DataTable('#'+$tableName, {
                        
                        ajax: "./index.php?action=inventario-controller&method="+$tipo+"-inventario-minimo",
                        columns: [  
                { data: 'codigo' },                
                { data: 'nombre' },
                { data: null,
                    render: function(data,type){
                    return  '<span class="badge me-1 rounded-pill bg-info">C$ '+data.costo_c +'</span><br><span class="badge me-1 rounded-pill bg-success">$ '+ data.costo_d +'</span>';                
                    }
                },{ data: null,
                    render: function(data,type){
                    return  '<span class="badge me-1 rounded-pill bg-info">C$ '+data.precio_c +'</span><br><span class="badge me-1 rounded-pill bg-success">$ '+ data.precio_d +'</span>';                
                    }
                },
                { data: 'qty' },
                { data: 'invmin' }
                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },                
                createdRow: (row, data, index) => {
                     row.querySelector(':nth-child(5)').classList.add('text-center');
                     row.querySelector(':nth-child(6)').classList.add('text-center');
                            if (parseInt(data.qty) < 100) {
                                 $(row).css("background", "#ebcccc");
                             }
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
    }

    $("#nav-accesorios-tab").on('click',function(e){
        e.preventDefault();
        clearDiv();
        drawTable('accesorios-content',tableAccesorios,'table-accesorios','accesorios');
    });

    $("#nav-celulares-tab").on('click',function(e){
        e.preventDefault();
        clearDiv();
        drawTable('celulares-content',tableCelulares,'table-celulares','celulares');
    });

    $("#nav-repuestos-tab").on('click',function(e){
        e.preventDefault();
        clearDiv();
        drawTable('repuestos-content',tableRepuestos,'table-repuestos','repuestos');

    });

    $("#nav-accesorios-autos-tab").on('click',function(e){
        e.preventDefault();
        clearDiv();
        drawTable('accesorios-autos-content',tableAccesoriosAutos,'table-accesorios-autos','accesorios-autos');
    });




    $(document).ready(function(){

        var url = new URL(window.location.href);
        var params = new URLSearchParams(url.search);
        var $tipo = params.get("tipo");
        $("#nav-accesorios-tab").click();
       

     });
</script>
