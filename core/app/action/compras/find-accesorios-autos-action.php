<?php

Session::isLogin();
if(isset($_POST['query'])){
    $data = ComprasData::getProducts($_POST['query'],'',4);
?>
<h4>Resultados de la Busqueda para Accesorios de Autos</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
    <thead style="background-color: #4e555a;color: #fff;">
        <th>Codigo</th>
        <th width="32%">Producto</th>
        <th>Costo Unitario</th>
        <th>Precio Unitario</th>
        <th>Precio Especial Unitario</th>
        <th>En Existencia</th>
        <th width="10%" style="min-width: 60px;">Cant.</th>
        <th width="30%" style="min-width: 100px;">Nuevo Costo</th>
        <th width="30%" style="min-width: 100px;">Nuevo Precio</th>
        <th width="30%" style="min-width: 100px;">Nuevo Precio Especial</th>
        <th width="10%" >-</th>
    </thead>
    <tbody>
        <?php
            foreach ($data as $i => $v) {
                echo '<tr>';
                echo '<td >'.$v['codigo'].' <input type="hidden" id="id'.$i.'" value="'.$v['id'].'"/></td>';
                echo '<td >'.$v['categoria'].' '. $v['name'].'</td>';              
                echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['costo_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['costo_d']),2,'.',',').'</span></td>';
                echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['precio_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['precio_d']),2,'.',',').'</span></td>';
                echo '<td  class="text-end"><span class="badge" style="color:blue;">C$ '.number_format(floatval($v['precioe_c']),2,'.',',').'</span><br><span class="badge" style="color:green;">$ '.number_format(floatval($v['precioe_d']),2,'.',',').'</span></td>';
                echo '<td  class="text-center">'.$v['unidades'].'</td>';
               
            echo '  
                            <td>
                                <input type="number" class="form-control" id="q'.$i.'" name="q'.$i.'"  onkeyup="validateFloat(event, this)" value="1" minvalue="1" maxvalue="9999" style="padding: 0px;padding-left: 5px;">
                             
                            </td>
                            <td>
                                <div class="input-group col">
                                    <span class="input-group-text" style="padding: 3px;font-size: 14px;">C$</span>
                                    <input type="text" class="form-control" id="pcc'.$i.'" name="pcc'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeDolar(`pcc'.$i.'`,`pcd'.$i.'`)" value="'.floatval($v['costo_c']).'" style="padding: 0px;padding-left: 5px;">
                                </div>
                                <br>
                                <div class="input-group col">
                                    <span class="input-group-text" style="padding: 5px;font-size: 14px;">$</span>
                                    <input type="text" class="form-control" id="pcd'.$i.'" name="pcd'.$i.'" placeholder="00.00" onkeyup="validateFloat(event, this),changeCordoba(`pcd'.$i.'`,`pcc'.$i.'`)" value="'.floatval($v['costo_d']).'" style="padding: 0px;padding-left: 5px;">
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
                            </td>
                            <td><button class="btn btn-primary" onclick="agregarAccesoriosAutosToCart('.$i.')">Agregar</button></td>
                    
           ';
                
                echo '</tr>';
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
        <th>Costo Unitario</th>
        <th>Precio Unitario</th>
        <th>Precio Especial Unitario</th>
        <th>En Inventario</th>
        <th width="40%"></th>
    </thead>
    <tbody>
        <tr><td colspan="7" class="text-center">No se encontraron resultados.</td></tr>
    </tbody>
</table>

<?php
}
?>