<script>
    
    $('#btn-find-accesorios').on('click',function(e){

      e.preventDefault();
      $(this).html('Buscando....');
      $(this).attr('id','btn-find-accesoriosd');
      $('#accesorios-content').css('display', 'none');
      var formData = new FormData();
      formData.append('query', $('#query-accesorios').val().trim());
      $.ajax({
        url: './index.php?action=ventas/find-accesorios',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#show-find-accesorios-content').css('display', 'block').empty().append(data);
         $('#btn-find-accesoriosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio');
         $('#btn-find-accesoriosd').attr('id','btn-find-accesorios');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#btn-find-accesoriosd').html('<svg class="icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-zoom"></use></svg> Buscar Accesorio');
          $('#btn-find-accesoriosd').attr('id','btn-find-accesorios');
        }
      });
      

    });

    function agregarAccesorioToCart($index){
      var $is_esp = false;
      if (document.getElementById("is_e"+$index).checked) {
        $is_esp = true;
      }
      var formData = new FormData();
      formData.append('product_id', parseInt($('#id'+$index).val().trim()));
      formData.append('q', parseInt($('#q'+$index).val().trim()));      
      formData.append('venta_c', parseFloat($('#pvc'+$index).val().trim()));
      formData.append('venta_d', parseFloat($('#pvd'+$index).val().trim()));
      formData.append('is_esp', $is_esp);
      formData.append('esp_c',  parseFloat($('#pec'+$index).val().trim()));
      formData.append('esp_d',  parseFloat($('#ped'+$index).val().trim()));  
      formData.append('desc_c', parseFloat($('#descc'+$index).val().trim()));
      formData.append('desc_d', parseFloat($('#descd'+$index).val().trim()));    

      $.ajax({
        url: './index.php?action=ventas/add-to-cart',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, textStatus, jqXHR) {
         $('#query-accesorios').val('');
         $('#show-find-accesorios-content').empty().css('display','none');
         loadCartVentas();
         obtenerDescuento();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          
        }
      });
    }

 
 
  



  
</script>
