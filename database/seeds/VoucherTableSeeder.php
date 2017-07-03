<?php

use Illuminate\Database\Seeder;

class VoucherTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$vouchers = [
			[
				'to' => '2017-07-07 02:34:43',
				'from' => '2017-07-03 02:34:43',
				'discount_tiers_id' => 1
			],
			[
				'to' => '2017-07-07 02:34:43',
				'from' => '2017-07-03 02:34:43',
				'discount_tiers_id' => 2
			],
			[
				'to' => '2017-07-07 02:34:43',
				'from' => '2017-07-03 02:14:43',
				'discount_tiers_id' => 3
			],
			[
				'to' => '2017-07-03 01:34:43',
				'from' => '2017-07-02 02:34:43',
				'discount_tiers_id' => 4
			],

		];

		foreach ($vouchers as $voucher) {
			DB::table('vouchers')->insert($voucher);
		}
	}
}
