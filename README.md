# ecommerc-cart-calculator

This is cart calculator which gives back final cart price after adding discount and offers

  - Configuration of pricing rules
  - Scan itesms at billing
  - Calculating Total price after adding discount rules

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

### Output

Output will final priced after addition of discounting rules : 
```
Total Cart Price is $81"
```
### Method 

Majorily used BOGO( Buy one get one) and Bulk Items offers:

* [calculateBogoOffer()] - if buy maxLimit then get one free or 50% discount on each item. 
* [calculateBulkOffer()] - if minLimit is cross or equal then calculate this offers

