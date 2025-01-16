<?php


class ProductoData extends Precios{
    public static $tableName = "product";
    public static $dirImg = "/sc/storage/products/";
    public $id;
    public $image;
    public $barcode;
    public $codigo;
    public $imei2;
    public $imeivarios;
    public $type;
    public $name;
    public $description;
    public $compatibilidad;
    public $inventary_min;
    public $price_in;
    public $price_in_d;
    public $price_out;
    public $price_out_d;
    public $price_out_es;
    public $price_out_es_d;
    public $unit;
    public $presentation;
    public $user_id;
    public $person_id;
    public $marca;
    public $modelo;
    public $color;
    public $calidad;
    public $category_id;
    public $ingresado_type;
    public $created_at;
    public $facturano;
    public $is_active;
    public $justificacion;

/*
    public function __construct(){

    $this->id = " ";
    $this->image = " ";
    $this->barcade = " ";
    $this->codigo = " ";
    $this->imei2 = " ";
    $this->imeivarios = " ";
    $this->type = " ";
    $this->name = " ";
    $this->description = " ";
    $this->compatibilidad = " ";
    $this->inventary_min = " ";
    $this->price_in = " ";
    $this->price_in_d = " ";
    $this->price_out = " ";
    $this->price_out_d = " ";
    $this->price_out_es = " ";
    $this->price_out_es_d = " ";
    $this->unit = " ";
    $this->presentation = " ";
    $this->user_id = " ";
    $this->person_id = " ";
    $this->marca = " ";
    $this->modelo = " ";
    $this->color = " ";
    $this->calidad = " ";
    $this->category_id = " ";
    $this->ingresado_type = " ";
    $this->created_at = " ";
    $this->facturano = " ";
    $this->is_active = " ";
    $this->justificacion = " ";

    }
*/

    public static function getAll() {
        $sql = "SELECT * FROM ".self::$tableName." WHERE type='3' Order BY id ASC";
        ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                $proveedor = ProveedorData::getById($row['person_id']);
                $categoria = CategoriaData::getById($row['category_id']);
           //     $array[$index]['image'] = $row['image'];
             //   $array[$index]['barcode'] = $row['barcode'];
               // $array[$index]['codigo'] = $row['codigo'];
               // $array[$index]['imei2'] = $row['imei2'];
               // $array[$index]['imeivarios'] = $row['imeivarios'];
               // $array[$index]['type'] = $row['type'];
              //  $array[$index]['name'] = $row['name'];
                $array[$index]['description'] = $row['description'];
                $array[$index]['compatibilidad'] = $row['compatibilidad'];
             //   $array[$index]['inventary_min'] = $row['inventary_min'];
                $array[$index]['costo_c'] = $row['price_in'];
                $array[$index]['costo_d'] = $row['price_in_d'];
                $array[$index]['precio_c'] = $row['price_out'];
                $array[$index]['precio_d'] = $row['price_out_d'];
               // $array[$index]['price_out_es'] = $row['price_out_es'];
               // $array[$index]['price_out_es_d'] = $row['price_out_es_d'];
                $array[$index]['unidades'] = $row['unit'];
                $array[$index]['presentation'] = $row['presentation'];
              //  $array[$index]['user_id'] = $row['user_id'];
               // $array[$index]['proveedor_id'] = $row['person_id'];
                $array[$index]['proveedor'] =  $proveedor['completo'];
                $array[$index]['marca'] = $row['marca'];
                $array[$index]['modelo'] = $row['modelo'];
                $array[$index]['color'] = $row['color'];
                //$array[$index]['calidad'] = $row['calidad'];
                //$array[$index]['category_id'] = $row['category_id'];
                $array[$index]['categoria'] = $categoria['name'];
                //$array[$index]['ingresado_type'] = $row['ingresado_type'];
                $array[$index]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
                //$array[$index]['facturano'] = $row['facturano'];
                //$array[$index]['is_active'] = $row['is_active'];
                //$array[$index]['justificacion'] = $row['justificacion'];
            }
        ExecutorPDO::closeCon();	
        return $array;        
}  

public static  function getAllProductActive() {
    $sql = "SELECT p.id,p.image,p.codigo,p.name,p.description,p.price_in,p.price_in_d,p.price_out,p.price_out_d,p.price_out_es_d,p.price_out_es,p.presentation,p.marca,p.modelo,p.color,
    p.created_at,CONCAT('[ ',pe.razon_social,' ] ',pe.name,' ',pe.lastname) AS proveedor, c.name AS categoria,compatibilidad,
    barcode,imei2,type
    FROM product p 
    LEFT OUTER JOIN person pe ON p.person_id = pe.id 
    LEFT OUTER JOIN category c ON p.category_id = c.id
    WHERE p.type !='2'  Order BY p.type ASC;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $array = array();
    $index = 0;
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $row) {
            $units = OperationData::getUnitsTotalByProductoId($row['id']);
            if(intval($units) < 1){ continue;} 
            $array[$index]['description'] = $row['description'];            
            $array[$index]['compatibilidad'] = $row['compatibilidad'];
            $array[$index]['id'] = $row['id'];
            $array[$index]['type'] = $row['type'];
            $array[$index]['name'] = $row['name'];
            $array[$index]['image'] = $row['image'];
            $array[$index]['imei1'] = $row['barcode'];
            $array[$index]['imei2'] = $row['imei2'];
            $array[$index]['codigo'] = $row['codigo'];
            $array[$index]['costo_c'] = floatval($row['price_in']);
            $array[$index]['costo_d'] = floatval($row['price_in_d']);
            $array[$index]['precio_c'] = floatval($row['price_out']);
            $array[$index]['precio_d'] = floatval($row['price_out_d']);
            $array[$index]['precio_es_c'] = floatval($row['price_out_es']);
            $array[$index]['precio_es_d'] = floatval($row['price_out_es_d']);
            $array[$index]['unidades'] = $units;
            $array[$index]['presentation'] = $row['presentation'];
            $array[$index]['proveedor'] =  $row['proveedor'];
            $array[$index]['marca'] = $row['marca'];
            $array[$index]['modelo'] = (isset($row['modelo']))?$row['modelo']:"";
            $array[$index]['color'] = $row['color'];
            $array[$index]['categoria'] = $row['categoria'];
            $array[$index]['fecha'] = date('d/m/Y', strtotime($row['created_at']));
            $index++;
        }
    ExecutorPDO::closeCon();	
    return $array;        
  
}
  


public static  function getAllByProductoId($id) {
  $sql = "SELECT * FROM ".self::$tableName." WHERE id='".$id."' Order BY created_at DESC";
  ExecutorPDO::initCon();
  ExecutorPDO::initPreparate($sql);
  $array = array();
  ExecutorPDO::executeParams(array());
      foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
          $proveedor = ProveedorData::getById($row['person_id']);
          $categoria = CategoriaData::getById($row['category_id']);
          $array['image'] = $row['image'];
          $array['barcode'] = $row['barcode'];
          $array['codigo'] = $row['codigo'];
          $array['imei2'] = $row['imei2'];
          $array['imeivarios'] = $row['imeivarios'];
          $array['type'] = $row['type'];
          $array['name'] = $row['name'];
          $array['description'] = $row['description'];
          $array['compatibilidad'] = $row['compatibilidad'];
          $array['inventary_min'] = $row['inventary_min'];
          $array['costo_c'] = $row['price_in'];
          $array['costo_d'] = $row['price_in_d'];
          $array['precio_c'] = $row['price_out'];
          $array['precio_d'] = $row['price_out_d'];
          $array['price_out_es'] = $row['price_out_es'];
          $array['price_out_es_d'] = $row['price_out_es_d'];
          $array['unidades'] = $row['unit'];
          $array['presentation'] = $row['presentation'];
          $array['user_id'] = $row['user_id'];
          $array['proveedor_id'] = $row['person_id'];
          $array['proveedor'] =  $proveedor['completo'];
          $array['marca'] = $row['marca'];
          $array['modelo'] = $row['modelo'];
          $array['color'] = $row['color'];
          $array['calidad'] = $row['calidad'];
          $array['category_id'] = $row['category_id'];
          $array['categoria'] = $categoria['name'];
          $array['ingresado_type'] = $row['ingresado_type'];
          $array['fecha'] = date('d/m/Y', strtotime($row['created_at']));
          $array['facturano'] = $row['facturano'];
          $array['is_active'] = $row['is_active'];
          $array['justificacion'] = $row['justificacion'];
      }
  ExecutorPDO::closeCon();	
  return $array;     
}


public static function eliminarOperacion($oid,$pid){
 
    try {
        $con = ExecutorPDO::initCon();
        $con->beginTransaction();

        $sql_o = "SELECT sell_id as idventa,q,price_in as costoc,price_in_d as costod,price_out as precioc,price_out_d as preciod,
                       price_out_es as precio_espc, price_out_es_d as precio_espd,discount as descc, discount_d as descd,operation_type_id as otid
                  FROM operation
                  WHERE id='".$oid."' and product_id='".$pid."';";        
        ExecutorPDO::initPreparate($sql_o);
        $o = array();
        ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            $o['idventa'] = $r['idventa'];
            $o['q']       = $r['q'];
            $o['costoc']  = floatval($r['costoc']);
            $o['costod']  = floatval($r['costod']);
            $o['precioc'] = floatval($r['precioc']);
            $o['preciod'] = floatval($r['precio']);
            $o['precio_espc'] = floatval($r['precio_espc']);
            $o['precio_espd'] = floatval($r['precio_espd']);
            $o['descc'] = floatval($r['descc']);
            $o['descd'] = floatval($r['descd']);
            $o['otid'] = intval($r['otid']);
        }
  
        $sql_s = "SELECT COUNT(id) AS total_records  FROM operation WHERE sell_id='".$o['idventa']."';";
        ExecutorPDO::initPreparate($sql_s);
        $ts = 0;
        ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            $ts = $r['total_records'];
        }

      
        $del_op = false;
        $upd_sell= false;
        if($ts > 1){
            if(intval($o['otid']) == 1){
                $sql_del_op = "DELETE FROM operation WHERE id= :id;";
                ExecutorPDO::initPreparate($sql_del_op);
                ExecutorPDO::bind(':id', intval($oid),PDO::PARAM_INT);
                $del_op = ExecutorPDO::execute();

                $comprac = floatval($o['costoc'] * $o['q']);
                $comprad = floatval($o['costod'] * $o['q']);
                $sql_upd_sell = "UPDATE sell set total= total - :total,total_d= total_d - :totald,discount= discount - :discount,discount_d= discount_d - :discountd WHERE id= :id;";      
                ExecutorPDO::initPreparate($sql_upd_sell);
                ExecutorPDO::bind(':total', $comprac ,PDO::PARAM_STR);
                ExecutorPDO::bind(':totald', $comprad ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discount', $o['descc'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discountd', $o['descd'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':id', $o['idventa'] ,PDO::PARAM_INT);
                $upd_sell = ExecutorPDO::execute();

            }else if(intval($o['otid']) == 2){
              
                $sql_del_op = "DELETE FROM operation WHERE id= :id;";
                ExecutorPDO::initPreparate($sql_del_op);
                ExecutorPDO::bind(':id', intval($oid),PDO::PARAM_INT);
                $del_op = ExecutorPDO::execute();
            
                $ventac = floatval((($o['precioc'] - $o['precio_espc']) * $o['q']) - $o['descc']);
                $ventad = floatval((($o['preciod'] - $o['precio_espd']) * $o['q']) - $o['descd']);        
                $sql_upd_sell = "UPDATE sell SET 
                                        total= total - :total,
                                        total_d= total_d - :totald,
                                        cash= cash - :cash,
                                        cash_d= cash_d - :cashd,
                                        discount= discount - :discount,
                                        discount_d= discount_d - :discountd WHERE id= :id;";    
                ExecutorPDO::initPreparate($sql_upd_sell);
                ExecutorPDO::bind(':total', $ventac ,PDO::PARAM_STR);
                ExecutorPDO::bind(':totald', $ventad ,PDO::PARAM_STR);
                ExecutorPDO::bind(':cash', $ventac ,PDO::PARAM_STR);
                ExecutorPDO::bind(':cashd', $ventad ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discount', $o['descc'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':discountd', $o['descd'] ,PDO::PARAM_STR);
                ExecutorPDO::bind(':id', intval($o['idventa']) ,PDO::PARAM_INT);
                $upd_sell = ExecutorPDO::execute();
            }
        }else{
                $sql_del_op = "DELETE FROM operation WHERE id= :id;";
                ExecutorPDO::initPreparate($sql_del_op);
                ExecutorPDO::bind(':id', intval($oid),PDO::PARAM_INT);
                $del_op = ExecutorPDO::execute();

                $sql_upd_sell = "DELETE FROM sell WHERE id= :id;";      
                ExecutorPDO::initPreparate($sql_upd_sell);
                ExecutorPDO::bind(':id', intval($o['idventa']) ,PDO::PARAM_INT);
                $upd_sell = ExecutorPDO::execute();
        }


        if($del_op && $upd_sell){
            $con->commit();
            ExecutorPDO::closeCon();
            return ["msg"=>"Datos de operacion  actualizados!!","code"=>true];
        }else{
            throw new PDOException("No se puede actualizar los datos de la operacion");
        }

    } catch (PDOException $ex) {
        $con->rollBack();
        ExecutorPDO::closeCon();
        return ["msg"=>$ex,"code"=>false];
    }	
}

public static function eliminarProducto($idProducto){
    
try {
        ProductoEliminadoData::save($idProducto);
        $con = ExecutorPDO::initCon();
        $con->beginTransaction();

        $sql_o = "SELECT GROUP_CONCAT(sell_id) AS total_sellid  FROM operation WHERE product_id='".$idProducto."';";
        ExecutorPDO::initPreparate($sql_o);
        $sellIdStringArray = "";
        ExecutorPDO::executeParams(array());
            foreach(ExecutorPDO::fetchAll()  as $r) {
                $sellIdStringArray = $r['total_sellid'];
            }

            $sellID = explode(",", $sellIdStringArray);

            foreach($sellID  as $sid) {
                $sql_s = "SELECT COUNT(id) AS total_records  FROM operation WHERE sell_id='".$sid."';";
                ExecutorPDO::initPreparate($sql_s);
                $ts = 0;
                ExecutorPDO::executeParams(array());
                foreach  (ExecutorPDO::fetchAll()  as $r) {
                    $ts = $r['total_records'];
                }

                $sql_od = "SELECT sell_id as idventa,q,price_in as costoc,price_in_d as costod,price_out as precioc,price_out_d as preciod,
                                price_out_es as precio_espc, price_out_es_d as precio_espd,discount as descc, discount_d as descd,operation_type_id as otid
                        FROM operation
                        WHERE product_id='".$idProducto."' and sell_id='".$sid."';";
                    ExecutorPDO::initPreparate($sql_od);
                    $o = array();
                    ExecutorPDO::executeParams(array());
                    foreach  (ExecutorPDO::fetchAll()  as $r) {
                        $o['idventa'] = $r['idventa'];
                        $o['q']       = $r['q'];
                        $o['costoc']  = floatval($r['costoc']);
                        $o['costod']  = floatval($r['costod']);
                        $o['precioc'] = floatval($r['precioc']);
                        $o['preciod'] = floatval($r['precio']);
                        $o['precio_espc'] = floatval($r['precio_espc']);
                        $o['precio_espd'] = floatval($r['precio_espd']);
                        $o['descc'] = floatval($r['descc']);
                        $o['descd'] = floatval($r['descd']);
                        $o['otid'] = intval($r['otid']);
                    }

                    if($ts > 1){
                        if(intval($o['otid']) == 1){
                            $comprac = floatval($o['costoc'] * $o['q']);
                            $comprad = floatval($o['costod'] * $o['q']);
                            $sql_upd_sell = "UPDATE sell set total= total - :total,total_d= total_d - :totald,discount= discount - :discount,discount_d= discount_d - :discountd WHERE id= :id;";      
                            ExecutorPDO::initPreparate($sql_upd_sell);
                            ExecutorPDO::bind(':total', $comprac ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':totald', $comprad ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':discount', $o['descc'] ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':discountd', $o['descd'] ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':id', $o['idventa'] ,PDO::PARAM_INT);
                            ExecutorPDO::execute();
            
                        }else if(intval($o['otid']) == 2){
                            $ventac = floatval((($o['precioc'] - $o['precio_espc']) * $o['q']) - $o['descc']);
                            $ventad = floatval((($o['preciod'] - $o['precio_espd']) * $o['q']) - $o['descd']);        
                            $sql_upd_sell = "UPDATE sell SET 
                                                    total= total - :total,
                                                    total_d= total_d - :totald,
                                                    cash= cash - :cash,
                                                    cash_d= cash_d - :cashd,
                                                    discount= discount - :discount,
                                                    discount_d= discount_d - :discountd WHERE id= :id;";    
                            ExecutorPDO::initPreparate($sql_upd_sell);
                            ExecutorPDO::bind(':total', $ventac ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':totald', $ventad ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':cash', $ventac ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':cashd', $ventad ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':discount', $o['descc'] ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':discountd', $o['descd'] ,PDO::PARAM_STR);
                            ExecutorPDO::bind(':id', intval($o['idventa']) ,PDO::PARAM_INT);
                            ExecutorPDO::execute();
                        }
                    }else{
                            $sql_upd_sell = "DELETE FROM sell WHERE id= :id;";
                            ExecutorPDO::initPreparate($sql_upd_sell);
                            ExecutorPDO::bind(':id', intval($o['idventa']) ,PDO::PARAM_INT);
                            ExecutorPDO::execute();
                    }
            


            }// foreach sellid

            $sql_del_op = "DELETE FROM operation WHERE product_id= :id;";
            ExecutorPDO::initPreparate($sql_del_op);
            ExecutorPDO::bind(':id', intval($idProducto),PDO::PARAM_INT);
            ExecutorPDO::execute();

            $sql_del_pro = "DELETE FROM product WHERE id= :id;";
            ExecutorPDO::initPreparate($sql_del_pro);
            ExecutorPDO::bind(':id', intval($idProducto),PDO::PARAM_INT);
            ExecutorPDO::execute();
    
    $con->commit();
    ExecutorPDO::closeCon();
    return ["msg"=>"Producto eliminado con exito!!","code"=>true];

  } catch (PDOException $ex) {
      $con->rollBack();
      ExecutorPDO::closeCon();
      return ["msg"=>$ex,"code"=>false];
  }	
}

public static function getLastCode($type = '') {
    $con = ExecutorPDO::getConnection();
    try {
        $where =($type != '')? "WHERE codigo != '' AND TYPE='".$type."' ORDER BY code DESC LIMIT 1":"WHERE codigo != '' ORDER BY code DESC LIMIT 1;";
        $sql = "SELECT id,convert(codigo, unsigned) AS code,codigo from product ".$where;
        $stmt = $con->prepare($sql);
        $stmt->execute(array());
        $data = array('code' => 0,'codigo'=> '0');
        foreach ($stmt->fetchAll() as $v) {
            $data['code'] = $v['code'];
            $data['codigo'] = $v['codigo'];
        }
        $stmt = null;
        $con = null;
        ExecutorPDO::closeConnection();
        return $data;
        

        
    } catch (\PDOException $e) {
        ExecutorPDO::closeConnection();
       return  ['msg'=>$e->getMessage(),'code'=>false];
    }
}
public static function validarCodigo($codigo,$type){
    $con = ExecutorPDO::getConnection(); 
    try {
       $stmt = $con->prepare("SELECT id from product where codigo='".$codigo."' AND type='".$type."';");
       $stmt->execute(array());
       $existe = false;
        foreach ($stmt->fetchAll() as $v) {
            $existe = true;
        }
        $stmt = null;
        $con = null;
        ExecutorPDO::closeConnection();
       return $existe;
    } catch (\PDOException $th) {
        $con = null;
        ExecutorPDO::closeConnection();
       return false;
    }
}


public static function getProductName($id) {    
    $sql = "SELECT p.name,c.name as cat,p.marca,p.modelo,p.color,p.description,p.type FROM ".self::$tableName." p LEFT OUTER JOIN category c ON p.category_id = c.id WHERE p.id='".$id."' ;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $name = '';
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            if(intval($r['type'] == 1)){
                $name = $r['cat']." ".$r['name'];
            }else if(intval($r['type'] == 2)){
                $name = $r['marca']." ".$r['modelo']." ".$r['color']." ".$r['cat'];   
            }else if(intval($r['type'] == 3)){
                $name = $r['cat']." ".$r['marca']." ".$r['modelo']." ".$r['color']." ".$r['description'];   
            }else if(intval($r['type'] == 4)){
                $name = $r['cat']." ".$r['name'];
            }
        }
    ExecutorPDO::closeCon();	
    return $name;        
}  

public static function getProductNameDelete($id) {    
    $sql = "SELECT p.name,c.name as cat,p.marca,p.modelo,p.color,p.description,p.type FROM product_delete p LEFT OUTER JOIN category c ON p.category_id = c.id WHERE p.id_product='".$id."' ;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $name = '';
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            if(intval($r['type'] == 1)){
                $name = $r['cat']." ".$r['name'];
            }else if(intval($r['type'] == 2)){
                $name = $r['marca']." ".$r['modelo']." ".$r['color']." ".$r['cat'];   
            }else if(intval($r['type'] == 3)){
                $name = $r['cat']." ".$r['marca']." ".$r['modelo']." ".$r['color']." ".$r['description'];   
            }else if(intval($r['type'] == 4)){
                $name = $r['cat']." ".$r['name'];
            }
        }
    ExecutorPDO::closeCon();	
    return $name;        
}  

public static function getProductNameHistory($id) {    
    $sql = "SELECT p.name,c.name as cat,p.marca,p.modelo,p.color,p.description,p.type FROM product_history p LEFT OUTER JOIN category c ON p.category_id = c.id WHERE p.id_product='".$id."' ;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $name = '';
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            if(intval($r['type'] == 1)){
                $name = $r['cat']." ".$r['name'];
            }else if(intval($r['type'] == 2)){
                $name = $r['marca']." ".$r['modelo']." ".$r['color']." ".$r['cat'];   
            }else if(intval($r['type'] == 3)){
                $name = $r['cat']." ".$r['marca']." ".$r['modelo']." ".$r['color']." ".$r['description'];   
            }else if(intval($r['type'] == 4)){
                $name = $r['cat']." ".$r['name'];
            }
        }
    ExecutorPDO::closeCon();	
    return $name;        
}  

public static function getProductCode($id) {    
    $sql = "SELECT p.barcode,p.codigo,p.imei2,p.type FROM ".self::$tableName." p WHERE p.id='".$id."' ;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $name = '';
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            if(intval($r['type'] == 1)){
                $name = $r['codigo'];
            }else if(intval($r['type'] == 2)){
                $name = $r['barcode'].' - '.$r['imei2'] ;   
            }else if(intval($r['type'] == 3)){
                $name = ' ' ;
            }else if(intval($r['type'] == 4)){
                $name = $r['codigo'];
            }
        }
    ExecutorPDO::closeCon();	
    return $name;        
}  

public static function getProductCodeDelete($id) {    
    $sql = "SELECT p.barcode,p.codigo,p.imei2,p.type FROM product_delete p WHERE p.id_product='".$id."' ;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $name = '';
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            if(intval($r['type'] == 1)){
                $name = $r['codigo'];
            }else if(intval($r['type'] == 2)){
                $name = $r['barcode'].' - '.$r['imei2'] ;   
            }else if(intval($r['type'] == 3)){
                $name = ' ' ;
            }else if(intval($r['type'] == 4)){
                $name = $r['codigo'];
            }
        }
    ExecutorPDO::closeCon();	
    return $name;        
}  
public static function getProductCodeHistory($id) {    
    $sql = "SELECT p.barcode,p.codigo,p.imei2,p.type FROM product_history p WHERE p.id_product='".$id."' ;";
    ExecutorPDO::initCon();
    ExecutorPDO::initPreparate($sql);
    $name = '';
    ExecutorPDO::executeParams(array());
        foreach  (ExecutorPDO::fetchAll()  as $r) {
            if(intval($r['type'] == 1)){
                $name = $r['codigo'];
            }else if(intval($r['type'] == 2)){
                $name = $r['barcode'].' - '.$r['imei2'] ;   
            }else if(intval($r['type'] == 3)){
                $name = ' ' ;
            }else if(intval($r['type'] == 4)){
                $name = $r['codigo'];
            }
        }
    ExecutorPDO::closeCon();	
    return $name;        
}  









}
?>
