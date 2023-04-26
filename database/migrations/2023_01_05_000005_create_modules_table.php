<?php


use App\Migrations\BaseMigration;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('placeholder');
            $table->string('animation_style');
            $table->string('title');
            $table->string('subtitle');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->longText('content');
            $table->integer('width');
            $table->timestamps();

            $table->foreign('class_id')->references('id')->on('css_classes')
                ->onDelete('SET NULL'); // set null
        });
        $this->order(5);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
