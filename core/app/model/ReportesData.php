<?php 

Class ReportesData {
    

    public static function getInventarios($tipo,$categoria,$inicio,$final){
        
        $cat = ($categoria != 0 )?" AND p.category_id='".$categoria."'":" ";
        $date = ($inicio != 0 AND $final !=0 )? " date(op.created_at) >='".$inicio."' AND date(op.created_at) <= '".$final."' AND ":" ";
        $con = ExecutorPDO::getConnection();
        try {
            $sql = "SELECT p.id,codigo,barcode,category_id,name, type, marca,modelo,p.color,description,p.price_in,p.price_out,p.price_out_es, op.product_id, op.q,op.created_at
                            from product p
                            INNER JOIN operation op ON p.id = op.product_id
                            WHERE ".$date." op.operation_type_id = 1 AND op.q != 0
                            AND p.type='".$tipo."'  ".$cat."
                            GROUP BY (product_id)
                            ORDER BY p.codigo, p.name ASC;";
            $query = $con->prepare($sql);
            $query->execute();
            $num = $query->rowCount();
            $result = array();
            if ($num > 0) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            $con = null;
            ExecutorPDO::closeConnection();
            return $result;
            

        } catch (\PDOException $ex) {
            $con = null;
            ExecutorPDO::closeConnection();
            return ['msg'=>$ex->getMessage(),'code'=>false];
        }
    }

    public static function CantidadRealxProducto($product_id){
            
            $sql = "SELECT * FROM operation WHERE product_id='".$product_id."' ORDER BY created_at DESC;";
            $con = ExecutorPDO::getConnection();
            $query = $con->prepare($sql);
            $query->execute();
            $num = $query->rowCount();
                $existencia=0;
                $qentradas = 0;
                $qvendidas = 0;
            if ($num > 0) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);                
                foreach($result as $operation){
                    if(intval($operation['operation_type_id']) == 1){
                            $existencia += $operation['q'];// suma las entradas
                            $qentradas = $existencia;
        
                    }else if(intval($operation['operation_type_id']) == 2){
                        $existencia+=(-$operation['q']); // resta las salidas
                        $qvendidas = $existencia;  // -cantidad encontrada ejemplo (-3)
                    }
                }
            }
            $con = null;
            ExecutorPDO::closeConnection();
            $existencia_real = $qentradas;
            return $existencia_real; 
 }
  
 public static function getVentas($tipo,$inicial,$final,$oventa,$contado,$cliente,$primerDia,$ultimoDia){
    $type = (intval($tipo) > 0)?" ='".$tipo."' AND ":" in(1,2,3,4) AND ";
    $person_id = (intval($cliente) > 0)? " s.person_id = '". $cliente ."' AND " : " "; 
    $sell_type = " AND s.sell_type='".$contado."' ";
    $inicial = ($primerDia != "")?$primerDia:$inicial;
    $final = ($ultimoDia != "")?$ultimoDia:$final;     
 
    $con = ExecutorPDO::getConnection();
    try {
            $sql = "SELECT p.id AS id_pro,p.codigo,p.barcode,p.name, p.type, p.marca,p.modelo,p.color,p.description,p.price_out_es,p.price_out_es_d,
                           s.person_id, op.price_in, op.price_in_d,op.price_out,op.price_out_d,p.category_id,op.q,op.discount as descuento, s.id,s.total,
                           s.discount,s.discount_d,s.sell_type, s.created_at  
                    FROM sell s
                    INNER JOIN operation op ON op.sell_id = s.id
                    INNER JOIN product p ON op.product_id = p.id
                    WHERE p.type ".$type." ".$person_id."  date(s.created_at) >= '".date('Y-m-d', strtotime($inicial))."'  AND date(s.created_at) <= '".date('Y-m-d', strtotime($final))."'
                    AND op.operation_type_id='".$oventa."' ".$sell_type." order by p.type, s.created_at desc";
                
                    $query = $con->prepare($sql);
                    $query->execute();
                    $num = $query->rowCount();
                    $result = array();
                    if ($num > 0) {
                        $result = $query->fetchAll(PDO::FETCH_ASSOC);  
                    }
                    $con = null;
                    ExecutorPDO::closeConnection();
                    return $result;

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
 }       
 
public static function getAllGanancias($tipo,$inicial,$final){   
    $con = ExecutorPDO::getConnection();
    try {
        $sql = "SELECT p.id,name, p.barcode, p.category_id,p.codigo, p.type, p.marca,p.modelo,p.color,
                       p.description,op.price_in,op.price_in_d,op.price_out,op.price_out_d,op.price_out_es,op.price_out_es_d, op.q, op.discount,op.discount_d,s.created_at
                FROM operation op
                INNER JOIN product p ON op.product_id = p.id
                INNER JOIN sell s ON op.sell_id = s.id
                WHERE date(s.created_at) >= '".$inicial."' AND date(s.created_at) <= '".$final."'
                      AND s.operation_type_id='2' AND s.sell_type='1'  AND p.type='".$tipo."' 
                      ORDER BY p.name,s.created_at DESC";
        $query = $con->prepare($sql);
        $query->execute();
        $num = $query->rowCount();
        $result = array();
        if ($num > 0) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $con = null;
        ExecutorPDO::closeConnection();
        return $result;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}



public static function getInventario($tipo){   
    $con = ExecutorPDO::getConnection();
    $arrayWhere  = [
                     1 => "WHERE type='1' ORDER BY codigo ASC;",
                     2 => "WHERE type='2' ORDER BY marca ASC;",
                     3 => "WHERE type='3' ORDER BY marca ASC;",
                     4 => "WHERE type='4' ORDER BY codigo ASC;"
    ];
    $arrayURL  = [
        1 => "./index.php?view=historial/accesorios&id=",
        2 => "./index.php?view=historial/celulares&id=",
        3 => "./index.php?view=historial/repuestos&id=",
        4 => "./index.php?view=historial/accesorios-autos&id="
];

    try {
        $sql = "SELECT id,price_out,price_out_d FROM product ".$arrayWhere[$tipo];
        $query = $con->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayData = [];
        $cnt = 0;
        foreach ($result as  $r) {
           $arrayData[$cnt]['codigo'] = ProductoData::getProductCode($r['id']);
           $arrayData[$cnt]['nombre'] = ProductoData::getProductName($r['id']);
           $arrayData[$cnt]['precio_c'] = number_format(floatval($r['price_out']), 2, '.', ',');
           $arrayData[$cnt]['precio_d'] = number_format(floatval($r['price_out_d']), 2, '.', ',');
           $arrayData[$cnt]['id'] = $r['id'];
           $q=0;
           $get_op = "SELECT operation_type_id as ot,q FROM  operation WHERE product_id=".$r['id']." order by created_at desc";
		   $query = $con->prepare($get_op);
           $query->execute();
           $operations = $query->fetchAll(PDO::FETCH_ASSOC);
           $q = 0;
            foreach($operations as $o){
              $q += (intval($o['ot']) == 1)?intval($o['q']):0; 
              $q -= (intval($o['ot']) == 2)?intval($o['q']):0; 
            }
            $arrayData[$cnt]['qty'] = $q;
            $arrayData[$cnt]['url'] = $arrayURL[$tipo].$r['id'] ;
            $cnt++;
        }
        
        $con = null;
        ExecutorPDO::closeConnection();
        return $arrayData;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}

public static function getInventarioItemCero($tipo){   
    $con = ExecutorPDO::getConnection();
    $arrayWhere  = [
                     1 => "WHERE type='1' ORDER BY codigo ASC;",
                     2 => "WHERE type='2' ORDER BY marca ASC;",
                     3 => "WHERE type='3' ORDER BY marca ASC;",
                     4 => "WHERE type='4' ORDER BY codigo ASC;"
    ];

    try {
        $sql = "SELECT id,price_in,price_in_d,price_out,price_out_d FROM product ".$arrayWhere[$tipo];
        $query = $con->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayData = [];
        $cnt = 0;
        foreach ($result as  $r) {
           
           $q=0;
           $get_op = "SELECT operation_type_id as ot,q FROM  operation WHERE product_id=".$r['id']." order by created_at desc";
		   $query = $con->prepare($get_op);
           $query->execute();
           $operations = $query->fetchAll(PDO::FETCH_ASSOC);
           $q = 0;
            foreach($operations as $o){
              $q += (intval($o['ot']) == 1)?intval($o['q']):0; 
              $q -= (intval($o['ot']) == 2)?intval($o['q']):0; 
            }
            
            if($q == 0){
                $arrayData[$cnt]['codigo'] = ProductoData::getProductCode($r['id']);
                $arrayData[$cnt]['nombre'] = ProductoData::getProductName($r['id']);
                $arrayData[$cnt]['costo_c'] = number_format(floatval($r['price_in']), 2, '.', ',');
                $arrayData[$cnt]['costo_d'] = number_format(floatval($r['price_in_d']), 2, '.', ',');
                $arrayData[$cnt]['precio_c'] = number_format(floatval($r['price_out']), 2, '.', ',');
                $arrayData[$cnt]['precio_d'] = number_format(floatval($r['price_out_d']), 2, '.', ',');
                $arrayData[$cnt]['id'] = $r['id'];
                $arrayData[$cnt]['qty'] = 0;
                $cnt++;
            }
           
        }
        
        $con = null;
        ExecutorPDO::closeConnection();
        return $arrayData;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}


public static function getInventarioCantidadMinima($tipo){   
    $con = ExecutorPDO::getConnection();
    $arrayWhere  = [
                     1 => "WHERE type='1' ORDER BY codigo ASC;",
                     2 => "WHERE type='2' ORDER BY marca ASC;",
                     3 => "WHERE type='3' ORDER BY marca ASC;",
                     4 => "WHERE type='4' ORDER BY codigo ASC;"
    ];

    try {
        $sql = "SELECT p.id, op.price_in,op.price_in_d,op.price_out,op.price_out_d,
                       op.price_out_es,op.price_out_es_d,op.q, p.inventary_min, s.created_at
                FROM operation op
                LEFT JOIN product p ON p.id = op.product_id
                LEFT JOIN sell s ON s.id = op.sell_id
                WHERE TYPE ='".$tipo."'  AND op.q < p.inventary_min AND s.status <> 3  GROUP BY p.id ORDER BY p.name ASC, s.created_at DESC;";
        $query = $con->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayData = [];
        $cnt = 0;
        foreach ($result as  $r) {
           
                $arrayData[$cnt]['codigo'] = ProductoData::getProductCode($r['id']);
                $arrayData[$cnt]['nombre'] = ProductoData::getProductName($r['id']);
                $arrayData[$cnt]['costo_c'] = number_format(floatval($r['price_in']), 2, '.', ',');
                $arrayData[$cnt]['costo_d'] = number_format(floatval($r['price_in_d']), 2, '.', ',');
                $arrayData[$cnt]['precio_c'] = number_format((floatval($r['price_out']) + floatval($r['price_out_es'])), 2, '.', ',');
                $arrayData[$cnt]['precio_d'] = number_format((floatval($r['price_out_d'])+ floatval($r['price_out_es_d'])), 2, '.', ',');
                $arrayData[$cnt]['id'] = $r['id'];
                $arrayData[$cnt]['invmin'] = $r['inventary_min'];
                $arrayData[$cnt]['qty'] = $r['q'];
                $cnt++;
           
           
        }
        
        $con = null;
        ExecutorPDO::closeConnection();
        return $arrayData;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}


public static function getInventarioItemNeutros($tipo,$dias = 90){   
    $con = ExecutorPDO::getConnection();
    $dias = $dias;
    $arrayWhere  = [
                     1 => "WHERE type='1' ORDER BY codigo ASC;",
                     2 => "WHERE type='2' ORDER BY marca ASC;",
                     3 => "WHERE type='3' ORDER BY marca ASC;",
                     4 => "WHERE type='4' ORDER BY codigo ASC;"
    ];

    try {
        $sql = "SELECT id,price_in, price_in_d,price_out,price_out_d,created_at FROM product ".$arrayWhere[$tipo];
        $query = $con->prepare($sql);
        $query->execute();
        $productos = $query->fetchAll(PDO::FETCH_ASSOC);
        $arrayData =[];
        $cnt = 0;
      
            $fecha_actual = date('Y-m-d');
            $sql_fecha_min = "SELECT MIN(created_at) as fechamin from operation limit 1;";
            $query = $con->prepare($sql_fecha_min);
            $query->execute();
            $fecha_inicial= $query->fetchAll(PDO::FETCH_ASSOC)[0]["fechamin"];              
         
            foreach($productos as $r){
               
               $sql_older = "SELECT count(id) as total 
                              FROM operation 
                              WHERE product_id ='".$r['id']."' AND operation_type_id = 2 
                              AND date(operation.created_at) >='".$fecha_inicial."' 
                              AND date(operation.created_at) <='".$fecha_actual."' ;";
                              $query = $con->prepare($sql_older);
                              $query->execute();   
                              $total_vendido= $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];  
                              
                              if(intval($total_vendido) == 0){
                               
                               $sql_dias_diff = "SELECT DATEDIFF(CURDATE() , created_at) as dias
                                                  FROM  operation 
                                                  WHERE product_id ='".$r['id']."' AND operation_type_id = 1;";
                                                  $query = $con->prepare($sql_dias_diff);
                                                  $query->execute();   
                                                  $dias_diff= $query->fetchAll(PDO::FETCH_ASSOC)[0]['dias'];  
                                                 
                                                  if(intval($dias_diff) >= $dias){
                                                       
                                                        $get_op = "SELECT operation_type_id as ot,q FROM  operation WHERE product_id=".$r['id']." order by created_at desc";
                                                        $query = $con->prepare($get_op);
                                                        $query->execute();
                                                        $operations = $query->fetchAll(PDO::FETCH_ASSOC);
                                                        $q = 0;
                                                            foreach($operations as $o){
                                                              $q += (intval($o['ot']) == 1)?intval($o['q']):0; 
                                                              $q -= (intval($o['ot']) == 2)?intval($o['q']):0; 
                                                            }
                                                        $arrayData[$cnt]['id'] = $r['id'];
                                                        $arrayData[$cnt]['codigo'] = ProductoData::getProductCode($r['id']);
                                                        $arrayData[$cnt]['nombre'] = ProductoData::getProductName($r['id']);
                                                        $arrayData[$cnt]['costo_c'] = number_format(floatval($r['price_in']),2,'.',',');
                                                        $arrayData[$cnt]['costo_d'] = number_format(floatval($r['price_in_d']),2,'.',',');
                                                        $arrayData[$cnt]['precio_c'] = number_format(floatval($r['price_out']),2,'.',',');
                                                        $arrayData[$cnt]['precio_d'] = number_format(floatval($r['price_out_d']),2,'.',',');
                                                        $arrayData[$cnt]['qty'] = $q;
                                                        $arrayData[$cnt]['dias']  = $dias_diff;
                                                        $arrayData[$cnt]['fecha'] = date('d/m/Y', strtotime($r['created_at']));                                                   
                                                        $cnt++;
                                                  }
                              }                             
            }
        
        $con = null;
        ExecutorPDO::closeConnection();
        return $arrayData;        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}


public static function getTop10ItemForType($type){
    $con = ExecutorPDO::getConnection();
    try {
        $sql = "SELECT op.product_id as id,COUNT(op.product_id) AS TotalVendido, 
                       SUM(op.q) as TotalCantidadVendida
                FROM operation op
                LEFT JOIN product p ON p.id = op.product_id
                LEFT JOIN sell s ON s.id = op.sell_id
                WHERE type ='".$type."' AND op.operation_type_id = 2
                AND s.status <> 3 GROUP by op.product_id ORDER BY TotalCantidadVendida DESC LIMIT 10;";
        $query = $con->prepare($sql);
        $query->execute();
        $num = $query->rowCount();
        $result = array();
        if ($num > 0) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $con = null;
        ExecutorPDO::closeConnection();
        return $result;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}

public static function getLast10ItemSellForType($type){
    $con = ExecutorPDO::getConnection();
    try {
        $sql = "SELECT op.product_id as id,op.q,op.price_in,op.price_in_d,op.price_out,op.price_out_d,op.price_out_es,op.price_out_es_d, s.created_at
                FROM operation op
                LEFT JOIN product p ON p.id = op.product_id
                LEFT JOIN sell s ON s.id = op.sell_id
                WHERE type ='".$type."' AND op.operation_type_id ='2'
                AND s.status <> 3 ORDER BY s.created_at DESC LIMIT 10;";
        $query = $con->prepare($sql);
        $query->execute();
        $num = $query->rowCount();
        $result = array();
        if ($num > 0) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $con = null;
        ExecutorPDO::closeConnection();
        return $result;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}


public static function getLast10ItemBuyForType($type){
    $con = ExecutorPDO::getConnection();
    try {
        $sql = "SELECT op.product_id as id,op.q,op.price_in,op.price_out, s.created_at
                FROM operation op
                LEFT JOIN product p ON p.id = op.product_id
                LEFT JOIN sell s ON s.id = op.sell_id
                WHERE type ='".$type."' AND op.operation_type_id ='1'
                AND s.status <> 3 ORDER BY s.created_at DESC LIMIT 10;";
        $query = $con->prepare($sql);
        $query->execute();
        $num = $query->rowCount();
        $result = array();
        if ($num > 0) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        $con = null;
        ExecutorPDO::closeConnection();
        return $result;
        

    } catch (\PDOException $ex) {
        $con = null;
        ExecutorPDO::closeConnection();
        return ['msg'=>$ex->getMessage(),'code'=>false];
    }
}









/*******-**-***-***-***-***-**-*/
}


?>