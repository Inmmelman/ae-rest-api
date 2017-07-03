<?php

namespace Tests\Feature\Api;

use App\Products;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductBuyTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function is_return_correct_message_on_buy_product()
	{
		$data = [
			'title' => 'test product',
			'price' => 10
		];

		$prod = new Products($data);
		$prod->save();
		$response = $this->patchJson('/api/products/' . $prod->id . '/buy');
		$response->assertStatus(200)
			->assertJson(
				[
					"message" => "Product with id 1 has been bought"
				]
			);
	}
}
