<?php

namespace App\Http\Controllers\REST;

use App\Products;
use App\Http\Controllers\REST\Exceptions\CantFindProductException;
use App\Http\Controllers\REST\Exceptions\CantFindVoucherException;
use App\Http\Controllers\REST\Exceptions\IncorrectProductApiDataException;
use App\Http\Controllers\REST\Exceptions\ProductAlreadyBoughtException;
use App\Http\Controllers\REST\Exceptions\ValidationException;
use App\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestProductsController extends BaseRestController
{

	protected $storeRules = [
		'title' => 'required|string',
		'price' => 'required|int',
		'voucher_ids' => 'array'
	];

	/**
	 * Show list of products
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function index(Request $request)
	{
		return $this->responseWithPaginate(Products::where('is_visible', '1'), $request);
	}

	/**
	 * Show products by id
	 * @param $id
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function show($id)
	{
		/**
		 * @var $products Collection
		 */
		$product = Products::where('id', $id)->get();

		return response(
			[
				'products' => $product->toArray(),
			]
		);
	}

	/**
	 * Add new product
	 * @param Request $request
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws CantFindVoucherException
	 * @throws IncorrectProductApiDataException
	 * @throws ValidationException
	 */
	public function store(Request $request)
	{
		if (!$request->has('product')) {
			throw new IncorrectProductApiDataException();
		}
		$product = $request->get('product');

		/**
		 * @var $validator \Illuminate\Validation\Validator
		 */
		$validator = Validator::make(
			$product,
			$this->storeRules
		);

		if ($validator->fails()) {
			throw new ValidationException($validator->getMessageBag());
		} else {
			$newProduct = new Products($product);
			$newProduct->save();
			$productId = $newProduct->getAttribute('id');
			if (isset($product['voucher_ids'])) {
				$voucherIds = $product['voucher_ids'];
				foreach ($voucherIds as $id) {
					/**
					 * @var Voucher $voucher
					 */
					$voucher = Voucher::find($id);
					if (is_null($voucher)) {
						throw new CantFindVoucherException();
					}
					$voucher->products()->attach($productId);
				}
			}

			return response(
				[
					'message' => 'Product created successfully with id ' . $productId,
				]
			);
		}
	}

	/**
	 * Buy a product
	 * @param Request $request
	 * @param $productId
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws CantFindProductException
	 * @throws ProductAlreadyBoughtException
	 */
	public function buy(Request $request, $productId)
	{
		/**
		 * @var Products $product
		 */
		$product = Products::find($productId);
		if (is_null($product)) {
			throw new CantFindProductException();
		}
		if ($product->isBought()) {
			throw new ProductAlreadyBoughtException();
		}

		$product->setBought();
		$product->save();

		return response(
			[
				'message' => 'Product with id ' . $productId . ' has been bought',
			]
		);
	}
}
