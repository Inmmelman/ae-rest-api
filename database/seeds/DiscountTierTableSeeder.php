<?php

use Illuminate\Database\Seeder;

class DiscountTierTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$discounts = [
			[
				'amount' => 10
			],
			[
				'amount' => 15
			],
			[
				'amount' => 20
			],
			[
				'amount' => 25,
			],
		];

		foreach ($discounts as $d) {
			DB::table('discount_tiers')->insert($d);
		}
	}
}
