<?php

require 'src/Checkout.class.php';

class Ecommerce{
  
  private $total;
  public function __construct($items,$pricing_rules){

	$checkout = new Checkout($pricing_rules);
	foreach ($items as $key => $item) {
	  $checkout->scanItem($item);
	}
	$this->total = $checkout->getTotal();
	echo "\nTotal Cart Price is $this->total";  
	return $this->total;	
  }
  
  public function getTotal(){
  	return $this->total;
  }

}



?>