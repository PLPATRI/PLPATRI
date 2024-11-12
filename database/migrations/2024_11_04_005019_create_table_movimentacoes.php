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
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->string('referencia');
            $table->string('modelo');
            $table->decimal('compra', 10, 2);
            $table->decimal('baixa', 10, 2)->nullable();
            $table->integer('estoque');
            $table->date('data_reposicao')->nullable();
            $table->date('data_baixa')->nullable();
            $table->string('fornecedor');
            $table->decimal('valor_unitario', 10, 2);
            $table->decimal('valor_total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_movimentacoes');
    }
};
