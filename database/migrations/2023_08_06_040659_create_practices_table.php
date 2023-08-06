<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->id('id_quiz');
            $table->foreignId('id_material')->references('id_material')->on('learning_materials')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title',50)->nullable();
            $table->text('quiz')->nullable();
            $table->text('answer_choices')->nullable();
            $table->char('correct_answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practices');
    }
}
