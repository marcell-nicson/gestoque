<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('status', 50)->default('ativo');
            $table->integer('valor')->default(0);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('marca_id')->nullable();
            $table->string('tipo', 50)->default('estoque');
            $table->string('link')->nullable();
            $table->date('data_validade')->nullable();
            $table->boolean('promocao')->default(false);
            $table->text('descricao')->nullable();
            $table->string('image')->nullable();
            $table->string('codigo_produto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
