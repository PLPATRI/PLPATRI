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
    Schema::table('clientes', function (Blueprint $table) {
        if (!Schema::hasColumn('clientes', 'observacoes')) {
            $table->text('observacoes')->nullable()->after('numero_transportadora');
        }
    });
}

public function down(): void
{
    Schema::table('clientes', function (Blueprint $table) {
        if (Schema::hasColumn('clientes', 'observacoes')) {
            $table->dropColumn('observacoes');
        }
    });
}
};
