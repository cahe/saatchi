<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendJsonImportModel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function($table){
            $table->integer('cmc')->unsigned()->nullable();
            $table->string('flavor')->nullable();
            $table->string('artist')->nullable();
            $table->string('power')->nullable();
            $table->string('toughness')->nullable();
            $table->integer('number')->unsigned()->nullable();
            $table->string('layout')->nullable();
            $table->string('image_name')->nullable();
        });

        Schema::table('sets', function($table){
            $table->date('release_date');
            $table->string('gatherer_code')->nullable();
            $table->string('border');
            $table->string('type');
            $table->string('block')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards', function($table){
            $table->dropColumn('cmc');
            $table->dropColumn('flavor');
            $table->dropColumn('artist');
            $table->dropColumn('power');
            $table->dropColumn('toughness');
            $table->dropColumn('number');
            $table->dropColumn('layout');
            $table->dropColumn('image_name');
        });

        Schema::table('sets', function($table){
            $table->dropColumn('release_date');
            $table->dropColumn('gatherer_code');
            $table->dropColumn('border');
            $table->dropColumn('type');
            $table->dropColumn('block')->nullable();
        });
    }

}
