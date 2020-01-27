# ecommerc-cart-calculator

This is cart calculator which gives back final cart price after adding discount and offers

  - Configuration of pricing rules
  - Scan items at billing
  - Calculating Total price after adding discount rules
  - Sales or marketing team easily add new products or modify existing product price
  - Billing team can pass pricing rules while doing checkout and its configuraable. 
  - If you want to introduce new discount rules then have to add function for that in Checkout.class.php
  - Can easily change percentage to fixed in BULK offers its dyanamic.
  - BOGO function only support now 50% discount with basic calculations
  - BOGO used reminder and divident method to get items and their pricing. 

### Library

  - PHPUnittest

### Input 
  - Pricing Rules
  - Items list
 

Input to test file : 

 ```php
 $items = ['TSHIRT', 'TSHIRT', 'TSHIRT', 'VOUCHER', 'TSHIRT'];
 $pricing_rules = '{
	"discountRules": {
		"BOGO": {   // Buy one get one
			"maxLimit": 2,
			"minLimit": 2,
			"discountAmount": 50,
			"discountType": "percentage",  // fixed or percentage
			"productCondition": ["VOUCHER"]  // list items which offer need to apply
		},
		"BULK": {  // Buy more than equal to X then get Y discount on each items
			"maxLimit": null,
			"minLimit": 3,
			"discountAmount": 1,
			"discountType": "fixed",
			"productCondition": ["TSHIRT"]
		}
	}
}';
```

product-catalog.json

```json
{
    "items" : {
    	"VOUCHER" : 5,
    	"TSHIRT" : 20,
    	"MUG": 7.50
    }
}
```
### Execution 

```php
$ecommerce = new Ecommerce($items,$pricing_rules);
$total = $ecommerce->getTotal();
```
### Run via Terminal 

```
./phpunit tests/CheckoutTest.php
```
### Output

Output will final priced after addition of discounting rules : 
```
Total Cart Price is $81
```
### Method 

Majorily used BOGO( Buy one get one) and Bulk Items offers:

* ```calculateBogoOffer()``` - if buy maxLimit then get one free or 50% discount on each item. 
* ```calculateBulkOffer()``` - if minLimit is cross or equal then calculate this offers

