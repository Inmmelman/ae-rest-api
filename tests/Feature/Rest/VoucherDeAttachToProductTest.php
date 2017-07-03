<?php

namespace Tests\Feature\Api;

use App\Products;
use App\Voucher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoucherDeAttachToProductTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function is_return_correct_message_on_attach_voucher_to_product()
	{
		$voucherData = [
			'discount_tiers_id' => '1',
			'from' => '2017-07-04 02:34:43',
			'to' => '2017-07-04 02:50:43',
		];
		$voucher = new Voucher($voucherData);
		$voucher->save();

		$productData = [
			'title' => 'test product',
			'price' => 10
		];
		$prod = new Products($productData);
		$prod->save();

		$voucher->products()->attach($prod->id);

		$response = $this->deleteJson('/api/products/' . $prod->id . '/vouchers/' . $voucher->id);
		$response->assertStatus(200)
			->assertJson(
				[
					"message" => "Voucher with id 1 has been detach from product with id 1"
				]
			);
	}
}
