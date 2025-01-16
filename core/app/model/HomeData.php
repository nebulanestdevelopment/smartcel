<?php

class HomeData{


    public static function getInvetarioTotalPorTipo($tipo){
        $con = ExecutorPDO::getConnection();
        $sql = "SELECT count(id) as total FROM product WHERE TYPE='".$tipo."';";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; 
        $con = null;
        ExecutorPDO::closeConnection();     
        return $result["total"];
    }

    public static function getTotalCelulares(){
        
        $con = ExecutorPDO::getConnection();
        $sql = "SELECT id  FROM product WHERE TYPE='2';";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $celulares = $stmt->fetchAll(PDO::FETCH_OBJ);
        $item_con_existencia = 0;
        foreach($celulares as $item){
                
                $sql_o = "SELECT id,operation_type_id as ot,q  FROM operation WHERE product_id='".$item->id."';";
                $stmt = $con->prepare($sql_o);
                $stmt->execute();
                $operations = $stmt->fetchAll(PDO::FETCH_OBJ);
                $q=0;
                foreach($operations as $o){
                  $q += (intval($o->ot)==1)?intval($o->q):0;
                  $q -= (intval($o->ot)==2)?intval($o->q):0;
                }	
                if($q > 0){
                    $item_con_existencia++;
                }
        }
        return $item_con_existencia;
      }

      public static function getTotalSells(){
        $sql = "SELECT count(id) as total from sell WHERE operation_type_id='2';";
        $con = ExecutorPDO::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; 
        $con = null;
        ExecutorPDO::closeConnection();     
        return $result["total"];
      }

      public static function getTotalCustomers(){
        $sql = "SELECT count(id) as total from person WHERE kind !='2';";
        $con = ExecutorPDO::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; 
        $con = null;
        ExecutorPDO::closeConnection();     
        return $result["total"];
      }



}

?>
