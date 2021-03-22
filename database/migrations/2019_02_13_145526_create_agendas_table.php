<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->increments('id');

            $table->char('ativo', 1)->default('S')->nullable();
            $table->integer('order')->nullable();
            $table->text('data')->nullable();
            $table->string('title', 240);
            $table->string('cartola', 240)->nullable();
            $table->string('linha_apoio', 240)->nullable();
            $table->string('local', 240)->nullable();

            $table->integer('image')->nullable();
            $table->integer('galeria')->nullable();
            $table->string('evento_facebook', 240)->nullable();
            $table->string('tags', 240)->nullable();

            $table->text('text')->nullable();

            $table->timestamp('data_inicial')->nullable();
            $table->timestamp('data_final')->nullable();
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
        Schema::dropIfExists('agendas');
    }
}
