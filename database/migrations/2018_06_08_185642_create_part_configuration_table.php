<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('part_id');
            $table->string('components','20');
            $table->string('connecting_element','30');
            $table->string('sez_components','30');
            $table->string('nr_strand','10');
            $table->string('height','10');
            $table->string('width','10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_configuration');
    }
}
