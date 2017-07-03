<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
	public $timestamps = false;

	protected $fillable = ['discount_tiers_id', 'from', 'to'];

	protected $table = 'vouchers';

	public function products()
	{
		return $this->belongsToMany('App\Products', 'product_to_voucher', 'product_id', 'voucher_id');
	}

	public function discount()
	{
		return $this->hasOne('App\DiscountTier', 'id', 'discount_tiers_id');
	}
}
