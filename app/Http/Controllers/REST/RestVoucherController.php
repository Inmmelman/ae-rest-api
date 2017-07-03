<?php

namespace App\Http\Controllers\REST;

use App\DiscountTier;
use App\Http\Controllers\REST\Exceptions\IncorrectVoucherApiDataException;
use App\Http\Controllers\REST\Exceptions\ValidationException;
use App\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RestVoucherController extends BaseRestController
{
	protected $storeErrorMessages = [
		'date' => 'The :attribute is not a valid date. Must be Y-m-d H:i:s',
	];

	protected $storeRules = [
		'discount_tiers_id' => [
			'required'
		],
		'from' => 'required|date|date_format:Y-m-d H:i:s|before:to',
		'to' => 'required|date|date_format:Y-m-d H:i:s|after:from'
	];

	/**
	 * Get list of voucher with paging
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function index(Request $request)
	{
		return $this->responseWithPaginate(Voucher::query(), $request);
	}

	/**
	 * Save new voucher
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws IncorrectVoucherApiDataException
	 * @throws ValidationException
	 */
	public function store(Request $request)
	{
		$availableDiscounts = DiscountTier::all();
		if (!empty($availableDiscounts)) {
			$this->storeRules['discount_tiers_id'] =
				[
					'required',
					Rule::in($availableDiscounts->pluck('id')->toArray())
				];
			$this->storeErrorMessages = array_merge(
				$this->storeErrorMessages,
				[
					'in' => 'The selected discount tiers id is invalid. There are available discounts: ' . $availableDiscounts->map(
							function ($item) {
								/**
								 * @var DiscountTier $item
								 */
								return $item->showVariants();
							}
						),
				]
			);
		}
		if (!$request->has('voucher')) {
			throw new IncorrectVoucherApiDataException();
		}
		$voucher = $request->get('voucher');

		/**
		 * @var $validator \Illuminate\Validation\Validator
		 */
		$validator = Validator::make(
			$voucher,
			$this->storeRules,
			$this->storeErrorMessages
		);

		if ($validator->fails()) {
			throw new ValidationException($validator->getMessageBag());
		} else {
			$newVoucher = new Voucher($voucher);
			$newVoucher->save();

			return response(
				[
					'message' => 'Voucher created successfully with id: ' . $newVoucher->getAttribute('id'),
				]
			);
		}
	}
}
