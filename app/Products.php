<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
	protected $table = 'products';

	public $timestamps = false;

	protected $fillable = ['title', 'price', 'is_visible'];

	public function vouchers()
	{
		return $this->belongsToMany('App\Voucher', 'product_to_voucher', 'product_id', 'voucher_id');
	}

	public function products()
	{
		return $this->belongsToMany('App\Products');
	}

	/**
	 * Update product status is_visible
	 */
	public function setBought()
	{
		$this->update(['is_visible' => 0]);
	}

	/**
	 * Check if product has been bought
	 * @return bool
	 */
	public function isBought()
	{
		return $this->getAttribute('is_visible') === 0;
	}

	/**
	 * Calc discount price of product
	 * @return int|mixed
	 */
	//TODO: move in service with logic to calc discounts
	public function getPriceWithDiscounts()
	{
		$price = 0;
		$vouchers = $this->vouchers()->where('to', '>=', date('Y-m-d') . ' 00:00:00')->get();
		if ($this->hasDiscounts()) {
			$totalDiscount = 0;
			foreach ($vouchers as $voucher) {
				$discounts = $voucher->discount()->get()->all();
				foreach ($discounts as $discount) {
					$totalDiscount += $discount->getAttribute('amount');
				}
			}
			if ($totalDiscount > 60) {
				$totalDiscount = 60;
			}

			$currentPrice = $this->getAttribute('price');
			$price = $currentPrice - (($currentPrice * $totalDiscount) / 100);
		}

		return $price;
	}

	/**
	 * Check if current product has discounts
	 * @return bool
	 */
	public function hasDiscounts()
	{
		return $this->vouchers()->get()->count() != 0;
	}
}
