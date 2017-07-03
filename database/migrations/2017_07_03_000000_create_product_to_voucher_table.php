<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductToVoucherTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('product_to_voucher');
		Schema::create(
			'product_to_voucher',
			function (Blueprint $table) {
				$table->increments('id');
				$table->integer('product_id');
				$table->integer('voucher_id');
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_to_voucher');
	}
}
