<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('vouchers');
		Schema::create(
			'vouchers',
			function (Blueprint $table) {
				$table->increments('id');
				$table->dateTime('from');
				$table->dateTime('to');
				$table->integer('discount_tiers_id');
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
		Schema::dropIfExists('vouchers');
	}
}
