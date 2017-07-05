<?php
namespace App\Contracts;

interface DiscountResolverInterface{
	
	/**
	 * Calc and return discount price for filler vouchers objects
	 * @param $price, products price without discount
	 * @return mixed
	 */
	public function resolver($price = 0);
}
