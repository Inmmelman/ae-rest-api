<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoucherCreateTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function is_return_correct_message_on_create_voucher()
	{
		DB::table('discount_tiers')->insert(
			[
				'id' => 1,
				'amount' => 10
			]
		);
		$voucher = [
			'voucher' => [
				'discount_tiers_id' => '1',
				'from' => '2017-07-04 02:34:43',
				'to' => '2017-07-04 02:50:43',
			]
		];
		$response = $this->postJson('/api/vouchers', $voucher);
		$response->assertStatus(200)
			->assertJson(
				[
					"message" => "Voucher created successfully with id: 1"
				]
			);
	}
}
