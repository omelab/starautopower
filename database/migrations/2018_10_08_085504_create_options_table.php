<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('size', 25);
            $table->string('color', 100);
            $table->float('rp');
            $table->float('sp');
            $table->mediumInteger('qty');
            $table->string('imgs', 100);
            $table->timestamps();
        });

        Schema::create('product_option', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('option_id');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
        Schema::dropIfExists('product_option');
    }
}
