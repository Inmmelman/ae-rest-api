<?php

namespace App;

use App\DiscountResolver\VoucherDiscountResolver;
use App\Helpers\ProductPriceResolverHelper;
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
	public function getPriceWithDiscounts()
	{
		$vouchers = $this->vouchers()->where('to', '>=', date('Y-m-d') . ' 00:00:00')->get();
		$voucherResolver = new VoucherDiscountResolver($vouchers);
		return ProductPriceResolverHelper::calcPrice($this, $voucherResolver);
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
