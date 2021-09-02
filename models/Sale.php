<?php 

include_once(ROOT.'/components/Db.php');

class Sale
{

		public $product;
		public $price;

		public function __construct($product, $price){
			$this->product = $product;
			$this->price = $price;
		}
		public function saveSale()
		{
			if ($this->product && $this->price) {

				$db = Db::getConnection();

				$result = $db->query("INSERT INTO sales (product, price)
												VALUES $this->product, $this->price");

				return $result;
			}
		} 

}



?>