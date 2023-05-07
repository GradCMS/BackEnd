<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavbarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navbars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referenced_page');
            $table->text('name');
            $table->integer('priority');
            $table->unsignedBigInteger('parent_id')->nullable();


            $table->foreign('referenced_page')->references('id')->on('pages')
                ->onDelete('cascade');

            $table->foreign('parent_id')->references('id')->on('navbars')
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
        Schema::dropIfExists('navbars');
    }
}
