<?php

declare(strict_types=1);

require dirname(__FILE__).'/Products.class.php';

class Checkout
{
    private $items = array();
    private $total_items;
    private $checkout_price; 
    private $pricing_rules;
    private $catalog;

	public function __construct($pricing_rules){
       
       $this->pricing_rules = json_decode($pricing_rules);
       //var_dump($this->pricing_rules);
        
       $product = new Products();
       $this->catalog = $product->getCatalog();
       foreach ($this->catalog['items'] as $item => $value) {
       	  $this->items[$item] = 0;
       }
	}

	public function scanItem($item){
		$this->items[$item] += 1; 
	}

	private function __getDiscountRules(){
		$discountedItems = array();
		foreach ($this->pricing_rules->discountRules as $key => $value) {
			for ($i=0; $i < count($value->productCondition); $i++) { 
				$discountedItems[$value->productCondition[$i]] = $key;
			}
		}
		return $discountedItems;
	}
    
    public function getTotal(){
    	$discountedItems = $this->__getDiscountRules();
    	$total_price = 0;
		foreach($this->items as $item => $count){
			 $item_price = $this->catalog['items'][$item];
		     if(isset($discountedItems[$item])){

	             if($discountedItems[$item] == 'BOGO'){
			      $pricing_rules_item = $this->pricing_rules->discountRules->BOGO; 
			      $total_price += $this->__calculateBogoOffer($pricing_rules_item,$item,$item_price,$count);
			     }
			     else if($discountedItems[$item] == 'BULK'){
			      $pricing_rules_item = $this->pricing_rules->discountRules->BULK;
			      $total_price += $this->__calculateBulkOffer($pricing_rules_item,$item,$item_price,$count);
			     }
		     }
             else{
		      $total_price += $count * $item_price;
		     }
		}
       return $total_price;
    }

	private function __calculateBogoOffer($pricing_rules_item,$item,$item_price,$item_count){

	   $offer_quantity = $pricing_rules_item->maxLimit;
	   $items_reminder = $item_count % $offer_quantity;
	   $items_actual = intdiv($item_count, $offer_quantity); 
	   $items_total_price = ($items_actual + $items_reminder) * $item_price;  
	   var_dump($items_total_price);
	  return $items_total_price;
	}

	private function __calculateBulkOffer($pricing_rules_item,$item,$item_price,$item_count){

	   $bulk_qty_lower_limit = $pricing_rules_item->minLimit;
	   $price_reduction = (isset($pricing_rules_item->discountAmount))
	   ? : 0;
	   if($item_count >= $bulk_qty_lower_limit){
	      $items_total_price = $item_count * ($item_price - $price_reduction);
	   }
	   else{
	      $items_total_price = $item_count * $item_price; 
	   }

	   return $items_total_price;
	}

	public function getCartItems(){
		return $this->items;
	}

}
?>