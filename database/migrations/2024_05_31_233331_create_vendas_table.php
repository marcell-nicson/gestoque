<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->integer('valor_venda');
            $table->unsignedBigInteger('produto_id')->nullable();
            $table->integer('desconto')->nullable();
            $table->integer('porcentagem')->nullable();
            $table->enum('tipo_pagamento', ['debito', 'credito', 'pix']);
            $table->boolean('troca')->default(false);
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}


