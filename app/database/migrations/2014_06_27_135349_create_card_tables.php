<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('sets', function($table){
            $table->increments('id');
            $table->string('name');
            $table->string('mcm_name');
            $table->string('json_name');
        });

        Schema::create('cards', function($table){
            $table->increments('id');
            $table->string('name')->index();
            $table->string('text')->nullable();
            $table->string('rarity');
            $table->string('mana_cost')->nullable();
            $table->string('type');
            $table->integer('set')->unsigned()->index();
            $table->foreign('set')->references('id')->on('sets');
            $table->integer('multiverseid')->index();
        });

        Schema::create('mcm_data', function($table){
            $table->increments('id');
            $table->integer('card_id')->unsigned()->foreign()->references('id')->on('cards');
            $table->integer('metaproduct_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->float('price_low');
            $table->float('price_avg');
            $table->float('price_sell');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('mcm_data');
		Schema::drop('cards');
        Schema::drop('sets');
	}

}
