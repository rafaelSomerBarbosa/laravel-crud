<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Image extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Imagem', function (Blueprint $table) {
            $table->id('idImagem');
            $table->string('dsImagem');
            $table->string('nomeDoArquivo', 120)->unique();
            $table->unsignedInteger('idProduto');

            $table->foreign('idProduto')->references('idProduto')->on('Produto');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Imagem');
    }
}
