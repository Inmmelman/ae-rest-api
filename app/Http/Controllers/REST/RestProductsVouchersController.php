<?php

namespace App\Http\Controllers\REST;

use App\Products;
use App\Http\Controllers\REST\Exceptions\BaseApiException;
use App\Http\Controllers\REST\Exceptions\CantFindVoucherException;
use App\Http\Controllers\REST\Exceptions\VoucherAlreadyAttached;
use App\Http\Controllers\REST\Exceptions\VoucherHasNotAlreadyAttached;
use App\Voucher;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RestProductsVouchersController extends BaseRestController
{
	/**
	 * Attach voucher to product by ids
	 * @param $productId
	 * @param $voucherId
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws BaseApiException
	 * @throws VoucherAlreadyAttached
	 */

	public function update($productId, $voucherId)
	{
		if (!empty($productId) && !empty($voucherId)) {
			list($voucher, $product) = $this->checkAndFind($productId, $voucherId);

			$productHasVoucher = $this->productHasVoucher($voucher, $productId);
			if ($productHasVoucher) {
				throw new VoucherAlreadyAttached();
			}
			/**
			 * @var Voucher $voucher
			 */
			$voucher->products()->attach($product->getAttribute('id'));

			return response(
				[
					'message' => 'Voucher with id ' . $voucherId . ' has been attached to product with id ' . $productId,
				]
			);
		}
		throw new BaseApiException('Incorrect product\'s or voucher\'s id');
	}

	/**
	 * Detach voucher from product
	 * @param $productId
	 * @param $voucherId
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 * @throws BaseApiException
	 * @throws VoucherHasNotAlreadyAttached
	 */
	public function destroy($productId, $voucherId)
	{
		if (!empty($productId) && !empty($voucherId)) {
			list($voucher, $product) = $this->checkAndFind($productId, $voucherId);
			$productHasVoucher = $this->productHasVoucher($voucher, $productId);
			if (!$productHasVoucher) {
				throw new VoucherHasNotAlreadyAttached();
			}
			$voucher->products()->detach($product->getAttribute('id'));

			return response(
				[
					'message' => 'Voucher with id ' . $voucherId . ' has been detach from product with id ' . $productId,
				]
			);
		}
		throw new BaseApiException('Incorrect product\'s or voucher\'s id');
	}

	/**
	 * Try to find product and voucher
	 * @param $productId
	 * @param $voucherId
	 * @return array
	 * @throws CantFindVoucherException
	 * @throws VoucherAlreadyAttached
	 */
	protected function checkAndFind($productId, $voucherId)
	{
		/**
		 * @var Voucher $voucher
		 */
		$voucher = Voucher::find($voucherId);
		if (is_null($voucher)) {
			throw new CantFindVoucherException();
		}
		/**
		 * @var Products $product
		 */
		$product = Products::find($productId);
		if (is_null($product)) {
			throw new CantFindVoucherException();
		}

		return array($voucher, $product);
	}

	/**
	 * Check if filled product contains voucher
	 * @param Voucher $voucher
	 * @param $productId
	 * @return bool
	 */
	protected function productHasVoucher(Voucher $voucher, $productId)
	{
		/**
		 * @var BelongsToMany $vouchersProdutcs
		 */
		$vouchersProducts = $voucher->products();
		$currentProductsList = $vouchersProducts->get();
		$vouchersProductIds = [];
		$currentProductsList->map(
			function ($item) use (&$vouchersProductIds) {
				$vouchersProductIds[] = $item->getAttribute('id');
			}
		);

		return in_array($productId, $vouchersProductIds);
	}
}
