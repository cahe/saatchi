<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForEloquent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cards', function(Blueprint $table)
		{
            $table->nullableTimestamps();
        });

        Schema::table('mcm_data', function(Blueprint $table)
        {
            $table->nullableTimestamps();
        });

        Schema::table('sets', function(Blueprint $table)
        {
            $table->nullableTimestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('cards', function(Blueprint $table)
        {
            $table->dropTimestamps();
        });

        Schema::table('mcm_data', function(Blueprint $table)
        {
            $table->dropTimestamps();
        });

        Schema::table('sets', function(Blueprint $table)
        {
            $table->dropTimestamps();
        });
	}

}
