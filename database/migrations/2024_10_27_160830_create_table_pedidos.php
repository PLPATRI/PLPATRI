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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('razao_social');
            $table->string('cpf_cnpj');
            $table->decimal('desconto', 10, 2);
            $table->decimal('valor', 10, 2);

            $table->boolean('balcao')->default(false);
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('telefone')->nullable();
            $table->date('data');

            $table->enum('financeiro', ['deve', 'pago'])->default('deve');
            $table->enum('status', ['nao pronto', 'pronto'])->default('nao pronto');
            $table->enum('confirmacao', ['Ag Confirmacao', 'Ag Estoque', 'Confirmado'])->default('Ag Confirmacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
