<?php

namespace Tests\Feature\Api;

use App\Products;
use App\Voucher;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductCreateTest extends TestCase
{
	use DatabaseMigrations;

	protected $defaultProduct = [
		'product' => [
			'title' => 'test product',
			'price' => 10
		]
	];

	/** @test */
	public function is_return_correct_message_on_create_product()
	{
		$response = $this->postJson('/api/products', $this->defaultProduct);
		$response->assertStatus(200)
			->assertJson(
				[
					"message" => "Product created successfully with id 1"
				]
			);
	}

	/** @test */
	public function is_return_correct_message_on_create_product_with_voucher()
	{
		$voucher = new Voucher(
			[
				'discount_tiers_id' => '1',
				'from' => '2017-07-04 02:34:43',
				'to' => '2017-07-04 02:50:43',
			]
		);
		$voucher->save();
		$product['product'] = array_merge($this->defaultProduct['product'], ['voucher_ids' => [$voucher->id]]);
		$response = $this->postJson('/api/products', $product);
		$response->assertStatus(200)
			->assertJson(
				[
					"message" => "Product created successfully with id 1"
				]
			);
	}
}
