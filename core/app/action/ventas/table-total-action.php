<?php
$totalc = number_format(0,2,'.',',');
$totald = number_format(0,2,'.',',');
if(isset($_SESSION["cart"])){
    $items = $_SESSION["cart"];
    $tc = 0;
    $td = 0;
    foreach ($items as $v) {
        $precio_c = ($v['is_esp'] == "true")?$v['pec']:$v['pvc'];
        $precio_d = ($v['is_esp'] == "true")?$v['ped']:$v['pvd'];
        $tc = floatval($tc) + ((floatval($precio_c) * intval($v['q'])) - floatval($v['desc_c']));
        $td = floatval($td) + ((floatval($precio_d) * intval($v['q'])) - floatval($v['desc_d']));
    }
    
    $totalc = number_format($tc,2,'.',',');
    $totald = number_format($td,2,'.',',');
    

}
?>


<div class="row mb-3">
    <div class="col-sm-3"></div>
    <div class="col-sm-5">
        <table class="table table-bordered">

        <tr class="bg-dark text-white">
            <th rowspan="2" align="center">
            Venta Total
            </th>
            <td class="text-end">C$ <?php echo $totalc; ?></td>
        </tr>
        <tr class="bg-dark text-white">
            <td class="text-end">$ <?php echo $totald; ?></td>
        </tr>
        </table>
    </div>
</div>



