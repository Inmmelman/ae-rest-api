<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountTier extends Model
{
	protected $table = 'discount_tiers';

	/**
	 * Return available discounts
	 * @return string
	 */
	public function showVariants()
	{
		$values = $this->getAttributes();

		return 'id: ' . $values['id'] . ' amount: ' . $values['amount'];
	}
}
