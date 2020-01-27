<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require dirname(__FILE__).'/../'.'src/Checkout.class.php';

final class CheckoutTest extends TestCase
{
	public function testFailure()
    {
        $this->assertEmpty(['Checkout']);
    }

    public function testSuccess(){
    	$items = ['TSHIRT', 'TSHIRT', 'TSHIRT', 'VOUCHER', 'TSHIRT'];
    	$pricing_rules = '{
							"discountRules": {
								"BOGO": {
									"maxLimit": 2,
									"minLimit": 2,
									"discountAmount": 50,
									"discountType": "percentage",
									"productCondition": ["VOUCHER"]
								},
								"BULK": {
									"maxLimit": null,
									"minLimit": 3,
									"discountAmount": 1,
									"discountType": "fixed",
									"productCondition": ["TSHIRT"]
								}
							}
						}';


    	$checkout = new Checkout($pricing_rules);
    	foreach ($items as $key => $item) {
    	  $checkout->scanItem($item);
    	}
    	$total = $checkout->getTotal();
    	var_dump($total);
    	//var_dump($checkout->getCartItems());
    }
}