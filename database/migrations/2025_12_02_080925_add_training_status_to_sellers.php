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
        Schema::table('sellers', function (Blueprint $table) {
            $table->boolean('product_knowledge')->default(false);
            $table->boolean('skema_penjualan')->default(false);
            $table->boolean('mou')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['product_knowledge', 'skema_penjualan', 'mou']);
        });
    }
};
