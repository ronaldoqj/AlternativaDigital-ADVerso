<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
          $table->increments('id');
          $table->char('ativo', 1)->default('N');
          $table->string('type', 50)->default('normal');
          $table->string('assunto', 240);
          $table->string('title', 240);
          $table->string('subtitle', 240);
          $table->integer('backgroundbanner')->nullable();
          $table->text('text1')->nullable();
          $table->integer('image')->nullable();
          $table->text('text2')->nullable();
          $table->integer('colunista')->nullable();
          $table->integer('jornalista')->nullable();
          $table->string('tags', 240)->nullable();
          $table->integer('video')->nullable();
          $table->integer('galeria')->nullable();
          $table->integer('file')->nullable();
          $table->integer('audio')->nullable();
          $table->integer('category')->nullable();
          $table->integer('extra_integer')->nullable();
          $table->string('extra_string', 240)->nullable();
          $table->text('extra_text')->nullable();
          $table->text('facebook')->nullable();
          $table->text('twitter')->nullable();
          $table->text('whatsapp')->nullable();
          $table->integer('criador')->nullable();
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
        Schema::dropIfExists('materias');
    }
}
