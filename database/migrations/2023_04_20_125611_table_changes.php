<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_id')->after('id');
         
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->string('descricao')->after('nome');
            $table->unsignedBigInteger('categoria_id')->after('valor');
         
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });

        Schema::table('pedido_itens', function (Blueprint $table) {
            $table->unsignedBigInteger('produto_id')->after('id');
            $table->unsignedBigInteger('pedido_id')->after('id');
         
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('pedido_id')->references('id')->on('pedidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']); // Remove a restrição da chave estrangeira
            $table->dropColumn('cliente_id'); // Remove a coluna adicionada na função up()
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']); // Remove a restrição da chave estrangeira
            $table->dropColumn('categoria_id'); // Remove a coluna adicionada na função up()
        });

        Schema::table('pedido_itens', function (Blueprint $table) {
            $table->dropForeign(['produto_id']); // Remove a restrição da chave estrangeira
            $table->dropForeign(['pedido_id']); // Remove a restrição da chave estrangeira
            
            $table->dropColumn('produto_id'); // Remove a coluna adicionada na função up()
            $table->dropColumn('pedido_id'); // Remove a coluna adicionada na função up()
        });
    }
};
