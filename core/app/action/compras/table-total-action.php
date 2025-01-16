<?php
$totalc = number_format(0,2,'.',',');
$totald = number_format(0,2,'.',',');
if(isset($_SESSION["reabastecer"])){
    $items = $_SESSION["reabastecer"];
    $tc = 0;
    $td = 0;
    foreach ($items as $v) {
        $tc = floatval($tc) + (floatval($v['pcc']) * intval($v['q']));
        $td = floatval($td) + (floatval($v['pcd']) * intval($v['q']));
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
            Compra Total
            </th>
            <td class="text-end">C$ <?php echo $totalc; ?></td>
        </tr>
        <tr class="bg-dark text-white">
            <td class="text-end">$ <?php echo $totald; ?></td>
        </tr>
        </table>
    </div>
</div>



