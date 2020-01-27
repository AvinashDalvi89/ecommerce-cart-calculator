<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require dirname(__FILE__).'/../'.'Ecommerce.class.php';

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


        $ecommerce = new Ecommerce($items,$pricing_rules);
        $total = $ecommerce->getTotal();
        $this->AssertEquals(81,$total);
    	//var_dump($total);
    	//var_dump($checkout->getCartItems());
    	return $total;
    }
}