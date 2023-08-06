<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id('id_material');
            $table->foreignId('id_module')->references('id_module')->on('learning_modules')->onDelete('cascade')->onUpdate('cascade');
            $table->text('title_material')->nullable();
            $table->text('content')->nullable();
            $table->text('tipe_material')->nullable();
            $table->text('file_material')->nullable();
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
        Schema::dropIfExists('learning_materials');
    }
}
