<?php


use App\Migrations\BaseMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisplaysTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('displays', function (Blueprint $table) {
            $table->id();
            $table->string('placeholder');
            $table->string('type');
            $table->string('display_template');
            $table->unsignedBigInteger('grid_settings_id')->nullable()->default(null);
            $table->unsignedBigInteger('slider_settings_id')->nullable()->default(null);
            $table->unsignedBigInteger('source_page_id');
            $table->timestamps();

            $table->foreign('source_page_id')->references('id')->on('pages')
            ->onDelete('cascade');

            $table->foreign('grid_settings_id')->references('id')->on('grid_settings')
            ->onDelete('SET NULL'); // set null

            $table->foreign('slider_settings_id')->references('id')->on('slider_settings')
            ->onDelete('SET NULL'); // set null
        });
        $this->order(6);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('displays');
    }
}
