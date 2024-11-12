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
        schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('referencia');
            $table->string('modelo');
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->onDelete('cascade'); // Usando foreignId
            $table->decimal('preco_unitario', 10, 2);
            $table->date('data');
            $table->integer('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_produtos');
    }
};