<div class="card mb-4 mt-1">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="card-title mb-0">Lista de accesorios de autos</h4>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <button type="button" class="btn btn-outline-dark" onclick="window.location.href = './index.php?view=producto/accesorios-autos-add';">Agregar accesorio nuevo</button>
                </div>
              </div>
              </br>
              <div class="row mt-4 ">
                <div class="col-12 alert alert-success pt-4">
                <form class="row g-3 pt-2">
                    <div class="col-auto">
                      <label for="staticEmail2" class="visually-hidden">Buscar por categoria:</label>
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Buscar por categoria:">
                    </div>
                    <div class="col-auto">
                      <label for="inputPassword2" class="visually-hidden">Password</label>
                      <select  class="form-select" id="categoria" name="categoria" >
                        <option value="0">Todas las Categorias</option>
                      </select>
                    </div>
                    <div class="col-auto">
                      <button type="button" class="btn btn-primary mb-3" onclick="getAllByCategory()">Buscar</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="c-chart-wrapper" style="margin-top:60px;">
              <!-- table -->

                  <div id="table-repuesto" >
                  
                  </div>
              </div>
              <!-- ./table -->
              </div>
            </div>
            <div class="card-footer">
              
            </div><!-- ./card-footer -->
          </div><!-- ./card -->


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


<?php if(Roles::hasAdmin()){ ?>
  <script>
  var table = '<div class="table-responsive"><table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr>';
  table += '<th>Cod</th><th>Imagen</th><th>Categoria</th><th>Descripción</th>';
  table += '<th>Nombre</th><th>Costo</th><th>Precio</th><th>Precio Especial</th><th class="text-center">Qty</th>';
  table += '<th>Proveedor</th><th>Presentación</th><th>Fecha</th><th>Acciones</th><th>Historial</th></tr></thead>';
  table += '<tbody></tbody></table></div>';
function drawTable($url){
  $("#table-repuesto").empty().append(table); 
  new DataTable('#example', {
                
                ajax: "./index.php?action=producto/accesorios-autos-controller&method="+$url,
                columns: [  
        { data: 'codigo' },
        { data: null,
                  render: function(data,type){
                    if(data.image == '' || data.image == undefined){
                      return '';
                    }else{
                    //let img_tag = '<img src="./storage/products/'+data.image+'"  width="70" height="70" class="img-thumbnail" title="'+data.name+'"/>';
                    //return  '<a rel="popover" data-img="./storage/products/'+data.image+'" style="height:100px;width:200px;" data-toggle="lightbox" data-title="'+data.name+'"><div class="img-hover-zoom"><div class="hover-zoom-icon"><i class="fas fa-search-plus"></i></div></div>'+img_tag+'</a>';
                     return  '<a rel="popover" data-img="./storage/products/'+data.image+'" style="height:100px;width:200px;" data-toggle="lightbox" data-title="'+data.name+'"><img src="./storage/products/'+data.image+'"  width="70" height="70" class="img-thumbnail" title="'+data.name+'"/></a>';                
                    }
                  }
        },
        { data: 'categoria' },
        { data: 'description' },
        { data: 'name' },
       { data: null,
                render: function(data,type){
                   return  '<span class="badge me-1 rounded-pill bg-info">'+formatMoney(parseFloat(data.costo_c)).replace("$", "C$ ")+'</span><br><span class="badge me-1 rounded-pill bg-success">'+formatMoney(parseFloat(data.costo_d)).replace("$", "$ ")+'</span>';                
                }
        },
        { data: null,
                render: function(data,type){
                  return  '<span class="badge me-1 rounded-pill bg-info">'+formatMoney(parseFloat(data.precio_c)).replace("$", "C$ ")+'</span><br><span class="badge me-1 rounded-pill bg-success">'+formatMoney(parseFloat(data.precio_d)).replace("$", "$ ")+'</span>';   
                }
        },
        { data: null,
                render: function(data,type){
                  return  '<span class="badge me-1 rounded-pill bg-info">'+formatMoney(parseFloat(data.precio_es_c)).replace("$", "C$ ")+'</span><br><span class="badge me-1 rounded-pill bg-success">'+formatMoney(parseFloat(data.precio_es_d)).replace("$", "$ ")+'</span>';   
                }
        },
        { data: null,
                render: function(data,type){
                  return  '<a href="./index.php?view=historial/accesorios-autos&id='+data.id+'" class="btn btn-link" style="text-decoration-line: none;">'+data.unidades+'</a>';
                }
        },
        { data: 'proveedor' },
        { data: 'presentation' },
        { data: 'fecha' },
        { data: null,
                render: function(data,type){
                    let render = '<button type="button" class="btn  btn-warning text-white btn-xs" onclick="editarRepuesto('+data.id+')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-pencil"></use></svg></button>&nbsp;&nbsp;';
                        render += '<button type="button" class="btn  btn-danger text-white btn-xs" onclick="deleteRepuesto('+data.id+')"><svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-trash"></use></svg></button>';
                     return render;
                }
        },
        { data: null,
                render: function(data,type){
                  let render = '<a href="./index.php?view=historial/productos-historial&id='+data.id+'" type="button" class="btn  btn-success text-white btn-xs" ><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-magnifying-glass"></use></svg> ver historial de precios</a>';
                     return render;
                }
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },                
        createdRow: (row, data, index) => {
          row.querySelector(':nth-child(9)').classList.add('text-center');
            if (parseInt(data.unidades) === 0) {
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
</script>
<?php }else{ ?>
  <script>
  var table = '<div class="table-responsive"><table id="example" class="table table-striped table-bordered table-hover table-sm" >';
  table += '<thead class="table-dark"><tr>';
  table += '<th>Cod</th><th>Imagen</th><th>Categoria</th><th>Descripción</th>';
  table += '<th>Nombre</th><th>Precio</th><th>Precio Especial</th><th class="text-center">Qty</th>';
  table += '<th>Presentación</th><th>Fecha</th></tr></thead>';
  table += '<tbody></tbody></table></div>';
function drawTable($url){
  $("#table-repuesto").empty().append(table); 
  new DataTable('#example', {
                
                ajax: "./index.php?action=producto/accesorios-autos-controller&method="+$url,
                columns: [  
        { data: 'codigo' },
        { data: null,
                  render: function(data,type){
                    if(data.image == '' || data.image == undefined){
                      return '';
                    }else{
                    //let img_tag = '<img src="./storage/products/'+data.image+'"  width="70" height="70" class="img-thumbnail" title="'+data.name+'"/>';
                    //return  '<a rel="popover" data-img="./storage/products/'+data.image+'" style="height:100px;width:200px;" data-toggle="lightbox" data-title="'+data.name+'"><div class="img-hover-zoom"><div class="hover-zoom-icon"><i class="fas fa-search-plus"></i></div></div>'+img_tag+'</a>';
                     return  '<a rel="popover" data-img="./storage/products/'+data.image+'" style="height:100px;width:200px;" data-toggle="lightbox" data-title="'+data.name+'"><img src="./storage/products/'+data.image+'"  width="70" height="70" class="img-thumbnail" title="'+data.name+'"/></a>';                
                    }
                  }
        },
        { data: 'categoria' },
        { data: 'description' },
        { data: 'name' },
        { data: null,
                render: function(data,type){
                  return  '<span class="badge me-1 rounded-pill bg-info">'+formatMoney(parseFloat(data.precio_c)).replace("$", "C$ ")+'</span><br><span class="badge me-1 rounded-pill bg-success">'+formatMoney(parseFloat(data.precio_d)).replace("$", "$ ")+'</span>';   
                }
        },
        { data: null,
                render: function(data,type){
                  return  '<span class="badge me-1 rounded-pill bg-info">'+formatMoney(parseFloat(data.precio_es_c)).replace("$", "C$ ")+'</span><br><span class="badge me-1 rounded-pill bg-success">'+formatMoney(parseFloat(data.precio_es_d)).replace("$", "$ ")+'</span>';   
                }
        },
        { data: null,
                render: function(data,type){
                  return data.unidades;
                }
        },
        { data: 'presentation' },
        { data: 'fecha' }
      ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },                
        createdRow: (row, data, index) => {
          row.querySelector(':nth-child(8)').classList.add('text-center');
            if (parseInt(data.unidades) === 0) {
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
</script>

<?php } ?>



<script>
function formatMoney(amount) {
  return amount.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
}
function getAllByCategory(){
  var $id = parseInt($('#categoria').find(':selected').val()); 
  drawTable('get-all-by-category&category='+$id);
}
function getAllCategory(){
  $('#categoria').empty();
  $('#categoria').append('<option value="0" Selected>Todas las categorias</option>');
  $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=ACCESORIOS DE AUTOS", function(data, status){
      data.data.forEach(e => {
        $('#categoria').append('<option value="'+e.id+'" >'+e.name+'</option>');
      });
       $('#categoria').select2();
  });
}

function editarRepuesto(id){
  window.location = './index.php?view=producto/accesorios-autos-edit&id='+id;
}

function deleteRepuesto(id){
  if (confirm('Desea eliminar el accesorio de auto') == true) {
      var request;
        if (request) {
          request.abort();
      }
      request = $.ajax({
          url: "./index.php?action=producto/accesorios-autos-controller",
          type: "post",
          data: {id:id,method:'delete'}
      });
      request.done(function (data, textStatus, jqXHR){
        drawTable();
        toastr.success(data.msg, 'Exitoso', {timeOut: 3000})
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


$(document).ready(function() {

  drawTable('get-all');

  getAllCategory();
});

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
</script>

