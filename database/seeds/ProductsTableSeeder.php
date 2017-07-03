<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$demoProducts = [
			[
				'title' => 'prod 1',
				'price' => 10
			],
			[
				'title' => 'prod 2',
				'price' => 20
			],
			[
				'title' => 'prod 3',
				'price' => 30
			],
			[
				'title' => 'prod 4',
				'price' => 40,
				'is_visible' => 0
			],
		];

		foreach ($demoProducts as $prod) {
			\App\Products::create($prod);
		}
	}
}
