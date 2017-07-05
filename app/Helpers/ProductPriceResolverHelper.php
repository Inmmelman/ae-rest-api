<?php
namespace App\Helpers;
use App\Contracts\DiscountResolverInterface;
use App\Products;

class ProductPriceResolverHelper {
	public static function calcPrice(Products $product, DiscountResolverInterface $discountResolver){
		return $discountResolver->resolver($product->price);
	}
}
