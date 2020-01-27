<?php

declare(strict_types=1);

class Products
{
    private $product_catalog; // list of items available in ecommerce

	public function __construct(){
		$product_catalog_json = file_get_contents(dirname(__FILE__).'/product_catalog.json');

        $this->product_catalog = json_decode($product_catalog_json, true);
        //var_dump($this->product_catalog);
	}

	public function getCatalog(){
		return $this->product_catalog;
	}
}