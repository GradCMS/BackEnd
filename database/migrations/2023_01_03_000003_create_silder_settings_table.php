<?php


use App\Migrations\BaseMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSilderSettingsTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('slides_per_row');
            $table->integer('slides_per_column');
            $table->integer('total_slides');
            $table->float('slides_spacing');
            $table->boolean('center_slides');
            $table->boolean('loop_slides');
            $table->boolean('auto_height');
            $table->boolean('stretch_height');
            $table->boolean('auto_play');
            $table->boolean('arrows');
            $table->boolean('bullets');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('animation');
            $table->float('effect_speed_ms');
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('css_classes')
                ->onDelete('SET NULL');
        });
        $this->order(3);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('silder_settings');
    }
}
