<?php


use App\Migrations\BaseMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCssClassesTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('css_classes', function (Blueprint $table) {
            $table->id();
            $table->string('placeholder');
            $table->text('tags')->nullable();
            $table->string('reference_name');
            $table->json('json');
            $table->text('css');
            $table->text('custom_css');
            $table->timestamps();
        });
        $this->order(2);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('css_classes');
    }
}
