<?php

$product_catalog_json = file_get_contents(dirname(__FILE__).'/product_catalog.json');

$product_catalog = json_decode($product_catalog_json, true);

// var_dump($product_catalog);
// exit();

function getTotalPrice($items){
   global $product_catalog;
   $total_items = count($items);
   $item_count = array_count_values($items);
   $unique_items = count($item_count);
   var_dump($item_count);
   $total_price = 0;
   foreach($item_count as $item => $value){

     $pricing_rules = $product_catalog['pricingRules'][$item]; 
     if($pricing_rules['IsBuyXGetYFree']){
     	$total_price += getBuyXGetYPrice($pricing_rules,$item,$value);
     }
     else if($pricing_rules['IsBulkQtyOffer']){
     	$total_price += getBulkItemsPrice($pricing_rules,$item,$value);
     }
     else{
     	$total_price += $value * $pricing_rules['Price'];
     }
   }
   return $total_price;
}

function getBuyXGetYPrice($pricing_rules,$item,$item_count){
   $offer_quantity = $pricing_rules['OfferQuantity'];
   $items_reminder = $item_count % $offer_quantity ;
   $items_actual = intdiv($item_count, $offer_quantity); 
   $items_total_price = ($items_actual + $items_reminder) * $pricing_rules['Price']; 
   echo $items_total_price;
  return $items_total_price;
}
function getBulkItemsPrice($pricing_rules,$item,$item_count){
   $bulk_qty_lower_limit = $pricing_rules['bulkQtyLowerLimit'];
   $price_reduction = (isset($pricing_rules['bulkQtyPriceReduction']))
   ? : 0;
   if($item_count >= $bulk_qty_lower_limit){
   	     $items_total_price = $item_count * ($pricing_rules['Price'] - $price_reduction);
   }
   else{
   	    $items_total_price = $item_count * $pricing_rules['Price']; 
   }
   return $items_total_price;
}


$buy_items = trim(fgets(STDIN));
var_dump($buy_items);
$buy_list = explode(" ",$buy_items);
var_dump($buy_list);
$final_price = getTotalPrice($buy_list);

echo "Total payable price of cart is $final_price";
?>