<script>

$('#btn-find-repuestos').on('click',function(e){
    e.preventDefault();
    $(this).html('Buscando....');
    $(this).attr('id','btn-find-repuestosd');
    $('#repuestos-content').css('display', 'none');
    var formData = new FormData();
    formData.append('categoria', $('#categoria-repuestos').find(':selected').val());
    formData.append('modelo', $('#modelo-repuestos').val().trim());
    $.ajax({
        url: './index.php?action=repairman/find-repuestos',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
    success: function(data, textStatus, jqXHR) {
        $('#show-find-repuestos-content').css('display', 'block').empty().append(data);
        $('#btn-find-repuestosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Repuesto');
        $('#btn-find-repuestosd').attr('id','btn-find-repuestos');
    },
    error: function(jqXHR, textStatus, errorThrown) {
        $('#btn-find-repuestosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Repuesto');
        $('#btn-find-repuestosd').attr('id','btn-find-repuestos');
    }
    });
});

function agregarRepuestosToCart($index){
      
      var formData = new FormData();
      formData.append('product_id', parseInt($('#id'+$index).val().trim()));
      formData.append('q', parseInt($('#q'+$index).val().trim()));      
      formData.append('venta_c', parseFloat($('#pvc'+$index).val().trim()));
      formData.append('venta_d', parseFloat($('#pvd'+$index).val().trim()));
      formData.append('desc_c', parseFloat($('#descc'+$index).val().trim()));
      formData.append('desc_d', parseFloat($('#descd'+$index).val().trim()));     

      $.ajax({
        url: './index.php?action=repairman/add-to-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
          $('#modelo-repuestos').val('');
          $('#show-find-repuestos-content').empty().css('display','none');
          loadCartVentas();
          loadTotalCosto();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      });
    }




function cargarCategoriaRepuestos(){
    $('#categoria-repuestos').empty();
    $('#categoria-repuestos').append('<option value="0" selected>Seleccione una categoria</option>');
    $.get("./index.php?action=categoria-controller&method=get-all-by-subcategory&subcategory=REPUESTOS", function(data, status){
        data.data.forEach(e => {
          $('#categoria-repuestos').append('<option value="'+e.id+'">'+e.name+'</option>');
        });
        $('#categoria-repuestos').select2();
    });
}


$(document).ready(function(){
    cargarCategoriaRepuestos();
});
</script>