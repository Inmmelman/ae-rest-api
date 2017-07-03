<?php
namespace App\Http\Controllers\REST;

use App\DiscountTier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RestDiscountTiersController extends BaseRestController
{

	/**
	 * Responds to requests to GET /users
	 */
	public function index(Request $request)
	{
		/**
		 * @var $vouchers Collection
		 */
		$discounts = DiscountTier::all();

		return response(
			[
				'discounts' => $discounts->toArray(),
			]
		);
	}
}
