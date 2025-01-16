<?php

Session::isLogin();
$data= [];
if(isset($_POST)){   
    $data = ComprasData::getProducts($_POST['imei'],$_POST['modelo'],2);
?>
<h4>Resultados de la Busqueda para Celulares</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
    <thead style="background-color: #4e555a;color: #fff;">
        <th>Codigo</th>
        <th width="32%">Producto</th>
        <th>Costo</th>
        <th>Precio Venta</th>
        <th>Precio Especial</th>
        <th>En Existencia</th>
        <th width="10%" style="min-width: 60px;">Cant.</th>
        <th width="20%" style="min-width: 100px;">Descuento</th>
        <th width="20%" style="min-width: 100px;">Precio Especial</th>
        <th width="20%" style="min-width: 100px;">Precio Sugerido</th>
        <th width="10%" >-</th>
    </thead>
    <tbody>
        <?php
            $i = 0;
            foreach ($data as $v) {
                if(intval($v['unidades']) == 0){ continue;}
                echo '<tr>';
                echo '<td >'.$v['barcode'].' '.$v['imei2'].'  <input type="hidden" id="id'.$i.'" value="'.$v['id'].'"/></td>';
                echo '<td >'.$v['marca'].' '. $v['modelo'].' '. $v['color'].' '. $v['categoria'].'</td>';              
                echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['costo_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['costo_d']),2,'.',',').'</span></td>';
                echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['precio_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['precio_d']),2,'.',',').'</span></td>';
                echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['precioe_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['precioe_d']),2,'.',',').'</span></td>';
                echo '<td  class="text-center">'.$v['unidades'].'</td>';
               if(intval($v['unidades']) > 0){
                    echo '  
                                    <td>
                                        <input type="number" class="form-control cantidad" id="q'.$i.'" name="q'.$i.'"   value="1" min="1" step="1" max="'.intval($v['unidades']).'" onkeyup="onlyNumber(event, this)" style="padding: 0px;padding-left: 5px;">
                                    
                                    </td>
                                    <td>
                                        <div class="input-group col">
                                            <span class="input-group-text" style="padding: 3px;font-size: 14px;">C$</span>
                                            <input type="text" class="form-control" id="descc'.$i.'" name="descc'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar(`descc'.$i.'`,`descd'.$i.'`)" value="0" style="padding: 0px;padding-left: 5px;">
                                        </div>
                                        <br>
                                        <div class="input-group col">
                                            <span class="input-group-text" style="padding: 5px;font-size: 14px;">$</span>
                                            <input type="text" class="form-control" id="descd'.$i.'" name="descd'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba(`descd'.$i.'`,`descc'.$i.'`)" value="0" style="padding: 0px;padding-left: 5px;">
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="input-group col">
                                            <span class="input-group-text" style="padding: 3px;font-size: 14px;">C$</span>
                                            <input type="text" class="form-control" id="pec'.$i.'" name="pec'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar(`pec'.$i.'`,`ped'.$i.'`)" value="'.floatval($v['precioe_c']).'" style="padding: 0px;padding-left: 5px;">
                                        </div>
                                        <br>
                                        <div class="input-group col">
                                            <span class="input-group-text" style="padding: 5px;font-size: 14px;">$</span>
                                            <input type="text" class="form-control" id="ped'.$i.'" name="ped'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba(`ped'.$i.'`,`pec'.$i.'`)" value="'.floatval($v['precioe_d']).'" style="padding: 0px;padding-left: 5px;">
                                        </div>
                                        <br>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="false" id="is_e'.$i.'" name="is_e'.$i.'">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Usar Precio Especial
                                            </label>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="input-group col">
                                            <span class="input-group-text" style="padding: 3px;font-size: 14px;">C$</span>
                                            <input type="text" class="form-control" id="pvc'.$i.'" name="pvc'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar(`pvc'.$i.'`,`pvd'.$i.'`)" value="'.floatval($v['precio_c']).'" style="padding: 0px;padding-left: 5px;">
                                        </div>
                                        <br>
                                        <div class="input-group col">
                                            <span class="input-group-text" style="padding: 5px;font-size: 14px;">$</span>
                                            <input type="text" class="form-control" id="pvd'.$i.'" name="pvd'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba(`pvd'.$i.'`,`pvc'.$i.'`)" value="'.floatval($v['precio_d']).'" style="padding: 0px;padding-left: 5px;">
                                        </div>
                                    </td>
                                    <td><button class="btn btn-primary" onclick="agregarCelularesToCart('.$i.')">Agregar</button></td>
                            
                ';
            }
                echo '</tr>';
                $i++;
            }
        ?>
    </tbody>
</table>
</div>
<?php
}else{
?>
<table class="table table-bordered table-hover">
    <thead style="background-color: #4e555a;color: #fff;">
        <th>Codigo</th>
        <th width="32%">Producto</th>
        <th>Costo</th>
        <th>Precio Venta</th>
        <th>Precio Especial</th>
        <th>En Existencia</th>
        <th width="10%" style="min-width: 60px;">Cant.</th>
        <th width="30%" style="min-width: 100px;">Descuento</th>
        <th width="30%" style="min-width: 100px;">Precio Especial</th>
        <th width="30%" style="min-width: 100px;">Precio Sugerido</th>
        <th width="10%" >-</th>
    </thead>
    <tbody>
        <tr><td colspan="7" class="text-center">No se encontraron resultados.</td></tr>
    </tbody>
</table>

<?php
}
?>