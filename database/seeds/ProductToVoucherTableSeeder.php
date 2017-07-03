<?php

use Illuminate\Database\Seeder;

class ProductToVoucherTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$prodToVoucher = [
			[
				'product_id' => 1,
				'voucher_id' => 1
			],
			[
				'product_id' => 1,
				'voucher_id' => 2
			],
			[
				'product_id' => 3,
				'voucher_id' => 2
			],
			[
				'product_id' => 2,
				'voucher_id' => 2
			],
		];

		foreach ($prodToVoucher as $r) {
			DB::table('product_to_voucher')->insert($r);
		}
	}
}
