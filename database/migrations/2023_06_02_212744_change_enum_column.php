<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function(Blueprint $table){
            $table->dropConstrainedForeignId('cliente_id');
        });

        Schema::table('pedido_itens', function(Blueprint $table){
            $table->dropConstrainedForeignId('pedido_id');
            $table->dropConstrainedForeignId('produto_id');
        });

        DB::table('pedido_itens')->truncate();
        DB::table('pedidos')->truncate();

        Schema::table('pedidos', function(Blueprint $table){
            $table->unsignedBigInteger('cliente_id')->after('id');
            
            $table->foreign('cliente_id')->references('id')->on('users');
        });

        Schema::table('pedido_itens', function(Blueprint $table){
            $table->unsignedBigInteger('pedido_id')->after('id');
            $table->unsignedBigInteger('produto_id')->after('pedido_id');
            
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });

        Schema::table('pedidos', function(Blueprint $table){
            $table->enum('forma_pagamento', ['dinheiro', 'debito', 'credito'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
