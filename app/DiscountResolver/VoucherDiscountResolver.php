<?php
namespace App\DiscountResolver;

use App\Contracts\DiscountResolverInterface;
use Illuminate\Database\Eloquent\Collection;

class VoucherDiscountResolver implements DiscountResolverInterface{
	
	/**
	 * @var Collection
	 */
	protected $vouchersCollections;
	
	/**
	 * VoucherDiscountResolver constructor.
	 * @param Collection $vouchersCollections
	 */
	public function __construct(Collection $vouchersCollections)
	{
		$this->vouchersCollections = $vouchersCollections;
	}
	
	/**
	 * Calc price for vouchers with discount tier
	 * @inheritdoc
	 * @param int $productPrice
	 * @return int
	 */
	public function resolver($productPrice = 0)
	{
		$price = 0;
		if ($this->hasDiscounts()) {
			$totalDiscount = 0;
			foreach ($this->vouchersCollections as $voucher) {
				$discounts = $voucher->discount()->get()->all();
				foreach ($discounts as $discount) {
					$totalDiscount += $discount->getAttribute('amount');
				}
			}
			if ($totalDiscount > 60) {
				$totalDiscount = 60;
			}
			
			$price = $productPrice - (($productPrice * $totalDiscount) / 100);
		}
		return $price;
	}
	
	/**
	 * Check if this voucher's collection has an items
	 * @return int
	 */
	protected function hasDiscounts(){
		return $this->vouchersCollections->count();
	}
	
}