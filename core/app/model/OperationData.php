<?php
class OperationData {
	public static $tablename = "operation";

	public $id;
	public $product_id;
	public $imei;
	public $color;
	public $q;
	public $price_in;
	public $price_in_d;
	public $price_out;
	public $price_out_d;
	public $price_out_es;
	public $price_out_es_d;
	public $operation_type_id;
	public $sell_id;
	public $discount;
	public $discount_d;
	public $descripcion;
	public $created_at;


	public function __construct(){
		
		$this->id = " ";
		$this->product_id = " ";
		$this->imei = " ";
		$this->color = " ";
		$this->q = 0.00;
		$this->price_in = " ";
		$this->price_in_d = " ";
		$this->price_out = " ";
		$this->price_out_d = " ";
		$this->price_out_es = " ";
		$this->price_out_es_d = " ";
		$this->operation_type_id = " ";
		$this->sell_id = " ";
		$this->discount = 0.00;
		$this->discount = 0.00;
		$this->descripcion = " ";
		$this->created_at = " ";
	}


	public static function  getAllDataByProductoId($id){
		$sql = "SELECT * FROM ".self::$tablename."  WHERE product_id='".$id."' ORDER BY created_at DESC";
		ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $index => $row) {
                $array[$index]['id'] = $row['id'];
                $array[$index]['product_id'] = $row['product_id'];
                $array[$index]['imei'] = $row['imei'];
                $array[$index]['color'] = $row['color'];
                $array[$index]['q'] = $row['q'];
				$array[$index]['costo_c'] = floatval($row['price_in']);
                $array[$index]['costo_d'] = floatval($row['price_in_d']);
                $array[$index]['precio_c'] = floatval($row['price_out']);
                $array[$index]['precio_d'] = floatval($row['price_out_d']);
                $array[$index]['precio_esp'] = floatval($row['price_out_es']);
                $array[$index]['precio_esp_d'] = floatval($row['price_out_es_d']);
                $array[$index]['operation_type_id'] = $row['operation_type_id'];
                $array[$index]['sell_id'] = $row['sell_id'];
                $array[$index]['discount'] = floatval($row['discount']);
                $array[$index]['discount_d'] = floatval($row['discount_d']);
				$array[$index]['descripcion'] =$row['descripcion'];
                $array[$index]['created_at'] = $row['created_at'];
            }
        ExecutorPDO::closeCon();
        return $array;
	}

	public static function  getEntradaTotalByProductoId($id){
		$sql = "SELECT SUM(q) AS total, product_id  FROM operation  WHERE product_id='".$id."' AND operation_type_id='1' ;";
		ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $row) {
                $array['product_id'] = $row['product_id'];
                $array['q'] = $row['total'];
            }
        ExecutorPDO::closeCon();
        return $array;
	}

	public static function  getSalidaTotalByProductoId($id){
		$sql = "SELECT SUM(q) AS total, product_id  FROM operation  WHERE product_id='".$id."' AND operation_type_id='2' ;";
		ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $row) {
                $array['product_id'] = $row['product_id'];
                $array['q'] = $row['total'];
            }
        ExecutorPDO::closeCon();
        return $array;
	}

	public static function  getUnitsTotalByProductoId($id){
		return  intval(self::getEntradaTotalByProductoId($id)['q']) - intval(self::getSalidaTotalByProductoId($id)['q']);
	}



	public static function  getOperationDataByProductId($id){
		$sql = "SELECT SUM(q) AS total, product_id  FROM operation  WHERE product_id='".$id."' AND operation_type_id='1' ;";
		ExecutorPDO::initCon();
        ExecutorPDO::initPreparate($sql);
        $array = array();
        ExecutorPDO::executeParams(array());
            foreach  (ExecutorPDO::fetchAll()  as $row) {
                $array['product_id'] = $row['product_id'];
                $array['q'] = $row['total'];
            }
        ExecutorPDO::closeCon();
        return $array;
	}
	



/*	public function add(){
		$sql = "insert into ".self::$tablename." (product_id,q,operation_type_id,sell_id,created_at) ";
		$sql .= "value (\"$this->product_id\",\"$this->q\",$this->operation_type_id,$this->sell_id,$this->created_at)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto OperationData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set product_id=\"$this->product_id\",q=\"$this->q\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new OperationData());
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());

	}



	public static function getAllByDateOfficial($start,$end){
 $sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" order by created_at desc";
		if($start == $end){
		 $sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getAllByDateOfficialBP($product, $start,$end){
 $sql = "select * from ".self::$tablename." where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and product_id=$product order by created_at desc";
		if($start == $end){
		 $sql = "select * from ".self::$tablename." where date(created_at) = \"$start\" order by created_at desc";
		}
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public function getProduct(){ return ProductData::getById($this->product_id);}
	public function getOperationtype(){ return OperationTypeData::getById($this->operation_type_id);}





	public static function getQYesF($product_id){
		$q=0;
		$operations = self::getAllByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
				if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
				else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}



	public static function getAllByProductIdCutId($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getAllByProductId($product_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id  order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}


	public static function getAllByProductIdCutIdOficial($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id order by created_at desc";
		return Model::many($query[0],new OperationData());
	}


	public static function getAllProductsBySellId($sell_id){
		$sql = "select * from ".self::$tablename." where sell_id=$sell_id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}


	public static function getAllByProductIdCutIdYesF($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id order by created_at desc";
		return Model::many($query[0],new OperationData());
		return $array;
	}

////////////////////////////////////////////////////////////////////
	public static function getOutputQ($product_id,$cut_id){
		$q=0;
		$operations = self::getOutputByProductIdCutId($product_id,$cut_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}

	public static function getOutputQYesF($product_id){
		$q=0;
		$operations = self::getOutputByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}

	public static function getInputQYesF($product_id){
		$q=0;
		$operations = self::getInputByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
		}
		// print_r($data);
		return $q;
	}



	public static function getOutputByProductIdCutId($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id and operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}


	public static function getOutputByProductId($product_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

////////////////////////////////////////////////////////////////////
	public static function getInputQ($product_id,$cut_id){
		$q=0;
		return Model::many($query[0],new OperationData());
		$operations = self::getInputByProductId($product_id);
		$input_id = OperationTypeData::getByName("entrada")->id;
		$output_id = OperationTypeData::getByName("salida")->id;
		foreach($operations as $operation){
			if($operation->operation_type_id==$input_id){ $q+=$operation->q; }
			else if($operation->operation_type_id==$output_id){  $q+=(-$operation->q); }
		}
		// print_r($data);
		return $q;
	}


	public static function getInputByProductIdCutId($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getInputByProductId($product_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

	public static function getInputByProductIdCutIdYesF($product_id,$cut_id){
		$sql = "select * from ".self::$tablename." where product_id=$product_id and cut_id=$cut_id and operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new OperationData());
	}

////////////////////////////////////////////////////////////////////////////
*/

}

?>