<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Produto', function (Blueprint $table) {
            $table->unsignedInteger('idProduto')->autoIncrement();
            $table->string('nmProduto', 120)->unique();
            $table->string('dsProduto');
            $table->unsignedInteger('idCategoria');

            $table->foreign('idCategoria')->references('idCategoria')->on('Categoria');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Produto');
    }
}
