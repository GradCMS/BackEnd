<?php


use App\Migrations\BaseMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGridSettingsTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('blocks_count');
            $table->integer('blocks_per_row');
            $table->float('blocks_spacing');
            $table->unsignedBigInteger('class_id')->nullable(); // can be nullable?
            $table->string('blocks_animation');
            $table->string('horizontal_alignment');
            $table->string('vertical_alignment');
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('css_classes')
                ->onDelete('SET NULL');
        });
        $this->order(4);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grid_settings');
    }
}
