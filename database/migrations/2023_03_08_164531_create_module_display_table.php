<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleDisplayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_display', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('display_id');

            $table->foreign('display_id')->references('id')->on('displays')
                ->onDelete('cascade');

            $table->foreign('module_id')->references('id')->on('modules')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_display');
    }
}
