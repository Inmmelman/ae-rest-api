<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(DiscountTierTableSeeder::class);
		$this->call(ProductsTableSeeder::class);
		$this->call(ProductToVoucherTableSeeder::class);
		$this->call(VoucherTableSeeder::class);
	}
}
